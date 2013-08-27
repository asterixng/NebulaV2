<?php

class Web_ApplicationMapper {
	
	private $_application_settings_map = array();
	private $_map_views = array();
	private $_map_action = array();
	private $_map_property = array();
	private $_map_action_event = array();
	private $_map_request = array();
	
	private static $_instance_mapper = null;
	
	public function __construct(){
		Web_ApplicationMapper::getInstanceMapper();
		
	}
	
	/**
	 * Ritorna l'istanza del mapper gia inizializzato
	 *
	 * @return ApplicationMapper $mapper
	 */
	protected function getInstanceMapper(){
	
		if(is_null(Web_ApplicationMapper::$_instance_mapper)){
			Web_ApplicationMapper::$_instance_mapper = $this;
			return Web_ApplicationMapper::$_instance_mapper;
		} else {
			return Web_ApplicationMapper::$_instance_mapper;
		}
			
	}
	
}