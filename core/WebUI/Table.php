<?php


class WebUI_Table extends WebUI_Component {
	
	
	private $_visible_row = 0;
	
	public function __construct($name,$params){
		
		$this->_component_name = $name;
		
		if(isset($params['css_class'])) { $this->_css_class = $params['css_class'];}else{$this->_css_class='table table-hover  table-bordered';}
		if(isset($params['visible_row'])) $this->_visible_row = $params['visible_row'];
		if(isset($params['style'])) $this->_style = $params['style'];
		
		$this->_component_name = $name;
		
		$this->_close_tag = '</table>';
		$this->initTagTable($name);
		
	}
	
	private function initTagTable($name){
		
		$tag = '<table class=datatable" id="'.$name.'"';
		if(!is_null($this->_css_class)){$tag .= ' class="'.$this->_css_class.'"';}
		if(!is_null($this->_style)){$tag .= ' style="'.$this->_style.'"';}
		$this->_open_tag = $tag .='>';
	}
	
	protected function setHeader($headers=null){
		$col_number = 0;
		
		$header_html_table = '<thead><tr  style="background:#eeeeee;">';
		
		if(is_null($headers)){
			
		} else {
			
			foreach($headers as $key => $val){
				$col_number++;
				$header_html_table .= '<th class="'.$key.'">'.ucfirst($val).'</th>';
			}
				
		}
		
		
		$this->addHtmlText($header_html_table . '</tr></thead>');
		return $col_number;
	}
	
	protected function designRow($rows,$link,$page,$count=0){
		
		if($link){
			
			if(array_key_exists('id', $rows)){
				$row_html = '<tr class="page page-'.$page.' '.$this->_component_name.'_tr" data-link="'.$rows['id'].'">';
			} else {
				$row_html = '<tr class="page page-'.$page.' '.$this->_component_name.'_tr" data-link="'.$this->_component_name.'-'.$count.'">';
			}
			
		} else {
			$row_html = '<tr class="'.$this->_component_name.'_tr">';
		}
		
		
		//print('<pre>');print_r($rows);print('</pre>');
		
		foreach($rows as $key => $val){

			if($link){			
				$row_html .= '<td class="'.$key.'">'.$val.'</td>';
			} else {
				$row_html .= '<td class="'.$key.'">'.$val.'</td>';
			}
			
		}
		
		$this->addHtmlText($row_html . '</tr>');
		
	}
	
	public function getTableFromQuery($query,$link=true){
		
		$count = 0;
		$page = 1;
		$paginator = 0;
		$result = Web_Model::Query($query);
		
		$cols = $this->setHeader(Web_Model::getColumnName());
		
		$this->addHtmlText('<tbody>');
		
		foreach($result as $rows){
			
			$paginator++;
			if($paginator > 10){
				$page++;
				$paginator = 1;
			}
			
			if($link){
				$count++;
				$this->designRow($rows,$link,$page,$count);
			} else {
				$this->designRow($rows,$link,$page);
			}
			
		}
		
		$footer = $this->addFooterTable($page,$cols);
		$this->addHtmlText('</tbody>' . $footer);
	}
		
	public function addFooterTable($page,$col){
		
		$footer = '<tfoot><tr><td colspan="'.$col.'"><div class="pagination"><ul>';
			
		for($i=1;$i < ($page+1);$i++){
			$footer .= '<li><a href="'.$i.'">'.$i.'</a>';
		}
		
		return $footer . '</ul></div></tfoot>';
		
	}
	
	public function getOrizontalTableFromQuery($name,$query,$header){

	}
	

}