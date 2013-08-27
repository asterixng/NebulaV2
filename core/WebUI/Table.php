<?php


class WebUI_Table extends WebUI_Component {
	
	
	private $_visible_row = 0;
	
	public function __construct($name,$params){
		
		$this->_component_name = $name;
		
		if(isset($params['css_class'])) { $this->_css_class = $params['css_class'];}else{$this->_css_class='table table-hover';}
		if(isset($params['visible_row'])) $this->_visible_row = $params['visible_row'];
		if(isset($params['style'])) $this->_style = $params['style'];
		
		$this->_component_name = $name;
		
		$this->_close_tag = '</table>';
		$this->initTagTable($name);
		
	}
	
	private function initTagTable($name){
		
		$tag = '<table id="'.$name.'"';
		if(!is_null($this->_css_class)){$tag .= ' class="'.$this->_css_class.'"';}
		if(!is_null($this->_style)){$tag .= ' style="'.$this->_style.'"';}
		$this->_open_tag = $tag .='>';
	}
	
	protected function setHeader($headers=null){
		
		
		$header_html_table = '<thead><tr  style="background:#eeeeee;">';
		
		if(is_null($headers)){
			
		} else {
			
			foreach($headers as $key => $val){
				$header_html_table .= '<th class="'.$key.'">'.ucfirst($val).'</th>';
			}
				
		}
		
		
		$this->addHtmlText($header_html_table . '</tr></thead>');
		
	}
	
	protected function designRow($rows){
		
		$row_html = "<tr>";
		
		//print('<pre>');print_r($rows);print('</pre>');
		
		foreach($rows as $key => $val){

			$row_html .= '<td class"'.$key.'">'.$val.'</td>';
			
		}
		
		$this->addHtmlText($row_html . '</tr>');
		
	}
	
	public function getTableFromQuery($query){
		
		$result = Web_Model::Query($query);
		
		$this->setHeader(Web_Model::getColumnName());
		
		$this->addHtmlText('<tbody>');
		
		foreach($result as $rows){
			$this->designRow($rows);
		}
		
		$this->addHtmlText('</tbody>');
	}
		
}