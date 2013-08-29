<?php

/**
 * Nuova classse per la connessione al db tramite mysql usando PDO
 * 
 * 
 * @author asterix
 *
 */

class Web_Connector {
	
	private static $LAST_INSERTED_ID = 0;
	private static $NUM_COLUMNS = 0;
	private static $NUM_ROWS=0;
	private static $COLUMN_NAME=array();
	
	public static function getColumnName(){
		return Web_Connector::$COLUMN_NAME;
	}
	
	public static function getNumberOfColumn(){
		return Web_Connector::$NUM_COLUMNS;	
	} 
	
	public static function getNumberRows(){
		return Web_Connector::$NUM_ROWS;
	}
	
	/**
	 * Esegue query di Update,Insert e Delete
	 * 
	 * Ritorna il numero delle righe su cui ha avuto effetto la query
	 * 
	 * @param String $query
	 * @return boolean $isExecuted
	 */
	public static function Execute($query){
		
		$affected_rows = 0;
		
		try{

			$link = new PDO('mysql:host='.HOST.';dbname='.DBNAME,USER ,PWD);
			$affected_rows = $link->exec($query);
			$link = null;
			
			if(strpos($query, 'INSERT')){
				Web_Connector::$LAST_INSERTED_ID = $link->lastInsertId(); 
			}
			
		} catch(Exception $ex){
			print('<pre>PDOException: '.$ex->getMessage().'</pre>');
		}

		return $affected_rows;
	}
	
	public static function GetLastID(){
		return Web_Connector::$LAST_INSERTED_ID;
	}
	
	/**
	 * Esegue una query sul database e ritorna il risultato o null se ci sono stati errori nell'esecuzione
	 * 
	 * 
	 * @param String $query
	 * @return PDOStatement <NULL, PDOStatement>
	 */
	public static function Query($query){
		
		$result_set = null;
		try{
		$link = new PDO('mysql:host='.HOST.';dbname='.DBNAME,USER ,PWD);

		$result = $link->query($query);
		
		if($result){
			
			Web_Connector::$NUM_COLUMNS = $result->columnCount();
			Web_Connector::$NUM_ROWS = $result->rowCount();
			
			for($i=0;$i<Web_Connector::$NUM_COLUMNS;$i++){
				$meta_column = $result->getColumnMeta($i);
				Web_Connector::$COLUMN_NAME[$i] = $meta_column['name'];
				
			}
			
			$result_set = $result->fetchAll(PDO::FETCH_ASSOC);
			
		} else {
			print('<pre> Error on Executing a query ['.$query.'] </pre>');
		}
		}catch(Exception $ex){
			print('<pre>PDOException: '.$ex->getMessage().'</pre>');
		}
		
		return $result_set;
	}
	
	public function logError($error,$code){
		
		mail(MAIL_ERROR, 'Installation ' . uuid_create(), $error,$code);
		
	}
	
	public static function ExecuteScalar($query,$scalar_label){
		$result = Web_Connector::Query($query);
		return $result[0][$scalar_label];
	}
	
}