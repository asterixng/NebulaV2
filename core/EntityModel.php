<?php

/**
 * Entity Class
 * 
 * any entity class must inherit this class
 * 
 * @author asterixng
 *
 */
class EntityModel {
	
	protected $_entity;
	protected $_pkfield;
	
	public function __construct(){}
	
	/**
	 * Save entity on DB
	 */
	public function save(){
		
		$prop_list = $this->getEntityFields();
		
		$qry = "INSERT INTO " . $this->_entity . " VALUES(";
		
		$values = "";
		
		foreach($prop_list as $prop){
			
			if($values == ""){
				$values .= "'".mysql_escape_string($this->$prop)."'";
			} else {
				$values .= ",'".mysql_escape_string($this->$prop)."'";
			}
			
			
			
		}
		
		$query = $qry . $values . ')';
		
		Connector::Execute($query);
		
	}
	
	/**
	 * Update entity on DB
	 */
	public function update(){}

	/**
	 * Delete entity on BD
	 */
	public function delete(){}
	
	/**
	 * Return list of entity property 
	 * 
	 * @return multitype:NULL
	 */
	public function getEntityFields(){
		
		$reflect_field = new ReflectionClass($this);
		$fields = $reflect_field->getProperties(ReflectionProperty::IS_PUBLIC);
		
		$fields_class = array();
		
		if(is_array($fields)){
			foreach($fields as $field) $fields_class[] = $field->name;
		}
		
		return $fields_class;
	}
	
	private function setProperty($name,$value){
		
		$this->$name = $value;
		
	}
	
	
	/**
	 * Set value of entity property
	 * 
	 * @param unknown $values
	 */
	public function setProperties($values){
		
		$fields = array_keys($values);
		$reflect_field = new ReflectionClass($this);
		foreach($fields as $field){
			if($reflect_field->hasProperty($field)){
				$prop_reflected = $reflect_field->getProperty($field);
				if(is_object($values[$field])){
					//$this->setProperty($field,serialize($values[$field]));
					$prop_reflected->setValue($this, serialize($values[$field]));
				} else {
					$prop_reflected->setValue($this, $values[$field]);
					//$this->setProperty($field,$values[$field]);
				} 
			}
		}
		/** SET PK VALUE **/
		
		$prop_reflected = $reflect_field->getProperty($this->_pkfield);
		$prop_reflected->setValue($this, $values[$this->_pkfield]);
		//$this->setProperty($this->_pkfield,$values[$this->_pkfield]);
	}
	
	/**
	 * Get the primary key value
	 * 
	 * @return mixed
	 */
	protected function getID(){
		
		$reflect_field = new ReflectionClass($this);
		$prop_reflected = $reflect_field->getProperty($this->_pkfield);
		return $prop_reflected->getValue($this);
		
	}
	
	/**
	 * Return the name of Primary Key Field
	 * @return String $_pkfield
	 */
	protected function getPKField(){return $this->_pkfield;}
	
	/**
	 * set the primary key field name
	 * 
	 * @param string $pk
	 */
	protected function setPKField($pk=null){
		if(is_null($pk)){
			$this->_pkfield = 'id';	
		} else {
			$this->_pkfield = $pk;
		}
	}
	
	/**
	 * Set the name of entity (table)
	 */
	protected function setEntity(){
		$this->_entity = strtolower(get_class($this));
	}
	

}