<?php



class MongoStealthImport {

	private $handle = 'ftpdata/stealth/onix3.xml';
	
	public function readftpdata(){
		
		return true;
		
	}
	
	public function readDataToMongo(){
		
		$this->import_xml_data($this->handle);
		
	}
	
	

	function import_xml_data($file){
	
		$data = simplexml_load_file($file);
		//print_r(analyze_element($data->Header));
	
		$id_time = explode(" ", microtime());
		$time_start = $id_time[1] + $id_time[0];
	
		foreach($data->Product as $key => $element){
	
			$arrprop = array();
			if(is_object($element)){ // è un oggetto
				if(get_class($element) == "SimpleXMLElement"){ // l'oggetto è un SimpleXMLElement
					$attr = get_object_vars($element);
					if(count($attr)>0){
						foreach($attr as $k => $v){
							if(is_object($v)){
								$arrprop[$key][$k] = $this->analyze_element($v);
							}elseif(is_array($v)){
								$arrprop[$k] = $this->analyze_array($v);
							} else {
								//echo $v;
								$arrprop[$key][$k] = $v;
							}
						}
					} else {
						$arrprop[$key] = $this->analyze_element($element);
					}
					//$arrprop[$key] = analyze_element($element); //riciclo sull'elemento per estrarre la struttura
				}
	
			} else if(is_array($element)){ //l'elemento contiene un array
				foreach ($element as $ke => $ve){//ciclo sui valori
					if(is_object($ve)){// se è un oggetto ricorsivamente entro in elm
						$arrprop[$key][$ke] = $this->analyze_element($ve);
					} elseif(is_array($ve)) {
	
						$arrprop[$key][$ke] = $this->analyze_array($ve);// Da correggere entrare ricorsivamente
					} else {
						$arrprop[$key][$ke] = $ve;
					}
				}
			} else {
				$arrprop[$key] = $element;
				print("$key => $element");
			}
			// salva su mongo
			$book['isbn']=[$arrprop['Product']['ProductIdentifier']['IDValue']] ;
			$book['data'] = $arrprop['Product'];
			//$book[$arrprop['Product']['ProductIdentifier']['IDValue']]['Product']['ProductIdentifier']['IDValue'] = $arrprop['Product']['ProductIdentifier']['IDValue'] . "-ZZZZ";
			 
			$this->upsert2mongo(array('isbn'=>$book['isbn']),$book);
			 
			unset($book);
			unset($arrprop);
		}
	
		$id_time = explode(" ", microtime());
		$end_start = $id_time[1] + $id_time[0];
		$fileupd = $fl['stealth_xml'] = array(
				'startelab' => $time_start,
				'endelab' => $end_start,
				'data' => $this->analyze_element($data->Header)
		);
		$this->save2mongo($fileupd,"xmlimport");
	
		echo "<h1>Impiegato :" .($end_start - $time_start) ." sec</h1>";
	}
	
	/**
	 *
	 * @param type $array
	 * @return type
	 */
	function analyze_array($array){
	
		$data = array();
	
		foreach($array as $k => $v){
	
			if(is_array($v)){
				$data[$k] = $this->analyze_array($v);
			} elseif(is_object($v)){
				$data[$k] = $this->analyze_element($v);
			} else {
				$data[$k] = $v;
			}
	
		}
	
		return $data;
	
	}
	
	
	/**
	 *
	 * L'elemento ha tre poszibilità
	 * 1) il contenuto è un'altro element
	 * 2) il contenuto è un array
	 * 3) il contenuto è un valore
	 * @param type $element
	 */
	function analyze_element($element){
	
		$arrprop = null;
	
		if(is_object($element)){ // è un oggetto
			if(get_class($element) == "SimpleXMLElement"){ // l'oggetto è un SimpleXMLElement
				$attr = get_object_vars($element);
				if(count($attr)>0){
					foreach($attr as $k => $v){
						if(is_object($v)){
							$arrprop[$k] = $this->analyze_element($v);
						} elseif(is_array($v)){
							$arrprop[$k] = $this->analyze_array($v);
						} else {
							$arrprop[$k] = $v;
						}
					}
				} else {
					$arrprop = (string)$element;//$arrprop = //analyze_element($element);
				}
				//$arrprop[$key] = analyze_element($element); //riciclo sull'elemento per estrarre la struttura
			}
	
		} else if(is_array($element)){ //l'elemento contiene un array
			foreach ($element as $keyel => $valueelm){//ciclo sui valori
				if(is_object($valueelm)){// se è un oggetto ricorsivamente entro in elm
					$arrprop[$keyel] = $this->analyze_element($valueelm);
				} elseif(is_array($valueelm)) {
					$arrprop[$keyel] = $this->analyze_array($valueelm); // Da correggere entrare ricorsivamente
				} else {
					$arrprop[$keyel] = $valueelm;
				}
			}
		} else {
			$arrprop = $element;
		}
	
		return $arrprop;
	
	}
	
	function upsert2mongo($criteria,$data_to_save,$collection="ebook"){
	
		try{
	
			$mongo = new Mongo(MONGOLAB);
			$db = $mongo->selectDB(MONGO_DB);
			$collection = $db->selectCollection($collection);
			$collection->update($criteria,$data_to_save,array("upsert" => true));
			$mongo->close();
		}catch(Exception $ex){echo '<br/>{upsert}:'.$ex->getMessage();}
	
	
	}
	
	function save2mongo($data_to_save,$collection="ebook"){
	
		try{
	
			$mongo = new Mongo(MONGOLAB);
			$db = $mongo->selectDB(MONGO_DB);
			$collection = $db->selectCollection($collection);
			$collection->save($data_to_save);
			$mongo->close();
		}catch(Exception $ex){echo '<br/>{save}:'.$ex->getMessage();}
	
	}
	
	function testMongo(){
		try{
			echo "<br/>Connecting on " . MONGOLAB;
			$mongo = new Mongo(MONGOLAB);
			$db = $mongo->selectDB("stealth");
			$collection = $db->selectCollection('ebook');
			print_r($mongo);
			$mongo->close();
		}catch(Exception $ex){echo '<br/>'.$ex->getMessage();}
	}
	
	
	public function getDocuments($extracttype="all"){
		
		header("Content-type:text/json");
		
		try{
			//echo "{'ebooks':"
			$t = time();
			$mongo = new Mongo(MONGOLAB);
			$db = $mongo->selectDB("stealth");
			$collection = $db->selectCollection('ebook');
			$cursor = $collection->find();
			while ($cursor->hasNext()){
				$task = $cursor->getNext();
				print(json_encode($task));
			}
			$mongo->close();
			print("{'process':{'start':'$t','end':".time()."'}");
				
		} catch (Exception $ex){
			
			print("{'error_connection':'".$ex->getMessage()."'}");
			
		}
		
	}
	
}