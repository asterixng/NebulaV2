<?php

/**
 * 
 * @author Bentenut Bruno
 *
 *@todo sviluppare interamente secondo connector e incapsulalrlo
 */
class Web_Model extends Web_Connector {

	
	public function getResultSet($query){
		
		$result_set = Web_Connector::Query($query);
		
		$result = new Web_ResultSet();
		
		$result->_num_row = Connector::$NUM_ROWS;
		
		$result->_data = $result_set;
		
		return $result_set;
		
	}
	
	public function getXmlResultSet($query){
		
		$this->getResultSet($query);
		
	}
	
	public function getColumnHeaders(){
		
		
		
	}
}


class Web_ResultSet {
	
	public $_data = array();
	public $_num_row = 0;
	public $_is_in_error = false;
	
	public function getRowAt($index){
		
		if(array_key_exists($index, $this->_data)){
			return  $this->_data[$index];
		} else {
			return null;
		}
		
	}
	
	public function getColumnData($column_name){
		
		if(count($this->_data)>0 && is_array($this->_data)){
			$data_column = array();
			foreach($this->_data as $row){
				$data_column[] = $row[$column_name];
			}
			
			return $data_column;
			
		} else {
			return null;
		}
		
	}
}