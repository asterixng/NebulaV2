<?php
/**
 * 
 * @author asterix
 * @todo sostituire il vecchio codice di nizializzazione con il nuovo codice OOP
 */
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
		$this->initMapper();
	}
	
	
	/**
	 * Ritorna la mappatura della vista
	 * 
	 * @param unknown $view
	 * @return string
	 */
	public function getMappedView($view=""){
		
		$mapped ="";
		
		if(array_key_exists(Web_View::$_ContextView, Web_ApplicationMapper::getInstanceMapper()->_map_views)){
			$mapped = Web_ApplicationMapper::getInstanceMapper()->_map_views[Web_View::$_ContextView];
		} else {
			$mapped = 'index';
		}
		
		return $mapped;

	}
	
	/**
	 * Ritorna la mappatura del controller
	 * 
	 * @param unknown $request
	 * @return Ambigous <string, unknown>
	 */
	public function getMappedController($request){
	
		$mapped ="";
		
		if(array_key_exists($request, Web_ApplicationMapper::getInstanceMapper()->_map_request)){
			$mapped = Web_ApplicationMapper::getInstanceMapper()->_map_request[$request];
		} else {
			$mapped = $request;
		}
		
		return $mapped;
	
	}
	
	/**
	 *Ritorna la mappatura della action
	 *
	 * @param unknown $action
	 * @return string
	 */
	public function getMappedAction($controller,$action){
	
		$mapped ="";
		
		if(array_key_exists($controller, Web_ApplicationMapper::getInstanceMapper()->_map_action)){
			
			
			if(array_key_exists($action, Web_ApplicationMapper::getInstanceMapper()->_map_action[$controller])){
				$mapped = Web_ApplicationMapper::getInstanceMapper()->_map_action[$controller][$action];
		
			} else {
		
				$mapped = 'Action' . ucfirst($action);
			}
			 
		} else {
		
				$mapped = 'Action' . ucfirst($action);
		}
		return $mapped;
	
	}
	
	/**
	 *Innizializza il mapper
	 */
	private function initMapper(){
		try{
			$mapper_controller = new Mapper_Controller();
			Web_ApplicationMapper::getInstanceMapper()->_map_request = $mapper_controller->getMap();
/* mappatura delle viste */

			/*** NEW CODE patch 24/08/2013 ***/
			$mapper = new Mapper_View();
			Web_ApplicationMapper::getInstanceMapper()->_map_views = $mapper->getMap();
				

/* mappatura delle action */
			
			/*** NEW CODE patch 24/08/2013 ***/
			$mapper = new Mapper_Action();
			Web_ApplicationMapper::getInstanceMapper()->_map_action = $mapper->getMap();
			
		}catch(Exception $ex){
			print($ex->getMessage());
		}
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