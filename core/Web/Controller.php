<?php

class Web_Controller {
	
	function __construct(){}
	
	private static $_instance = null;
	private static $_modeler = null;
	private static $_viewer =null;

	private $_action_mapped = array();
	
	private $_auth = null;
	
	/**
	 * Setta l'autenticazione neccesaria per una determinata action
	 * 
	 * @param unknown $action
	 * @param string $command
	 */
	protected function set_auth($action,$command=""){
		
		$this->_auth[$action] = $command;
		
	}
	
	/**
	 * Setta la mappatura della action su una vista
	 * 
	 * @param unknown $action
	 * @param unknown $map
	 */
	protected function mapAction($action,$map){
		
		
		
	}
	
	/**
	 * Ritorna l'istanza del controller; 
	 * 
	 */
	public static function getInstance(){
		
		if(is_null(Controller::$_instance)){
			/**
			 * ritornare l'istance di un oggetto relativo al controller
			 */
			return Controller::$_instance;
		} else {
			return Controller::$_instance;
		}
		
	}
	
	/**
	 * ritorna il modelere eventualmente associato con il controller
	 */
	protected function getModeler(){
		return Web_Controller::$_modeler;
	}
	
	/**
	 * ritorna la view associata con  il controller in modo da poter essere invocato direttamente all'interno del Controller
	 */
	protected function getViewer(){
		return Web_Controller::$_viewer;
	}
	
	/**
	 * Controlla se l'utente attuale puo lavorare con il context corrente con il ruole che possiede
	 */
	protected function isUserInRoleContext(){
		
	}
	
	/**
	 * Ritorna il context dell'applicazione
	 * @deprecated
	 */
	protected function getContext(){
		
	}
	
	/**
	 * Ritorna l'istanza di un controller di nome $ControllerName
	 * 
	 * @param unknown $controllerName
	 * @return object
	 */
	public static function getInstanceOfController($controllerName){
		
		$mapper = new Web_ApplicationMapper();
		
		$reflected_controller = new ReflectionClass('Controller_' . ucfirst($mapper->getMappedController($controllerName)));
		
		return $reflected_controller->newInstance(array());
	}
	
	/**
	 * Setta il l'oggetto View nel controller
	 * 
	 * @param unknown $viewer
	 */
	public function setViewer($viewer){
		Web_Controller::$_viewer = $viewer;
	}
	
	/**
	 * Setta l'oggettto Model nel controller
	 */
	public function setModeler(){
		$model = new Web_Model();
		Web_Controller::$_viewer->setVariable('model',$model);
	}
	
	public function __call($method,$arguments){
		echo '<font color="red">Action ' . $method .' Do not exist on ' . get_class($this) .'<br/>Try to map in Application.xml with <code><br/><br/>&lt;MapActions&gt; <blockquote>&lt;Action name="index" action="ActionIndex" /&gt;</blockquote>&lt;/MapActions&gt;</code>';
		exit;
	}
	
	/**
	 * Invoca l'azione sul controller 
	 * 
	 * @param unknown $action
	 */
	public function invokeAction($action){
		
		
		
		$mapper = new Web_ApplicationMapper();
		
		$action_method = $mapper->getMappedAction(get_class($this),$action);
		/** Controllo le autorizzazioni sulla action da chiamare **/
		// var_dump($this->_auth);
		//print('action_method' . $action_method);
		if(!$this->getAuthorizationController($action_method)){
			/** provide auth **/
			$this->_authProcess();
			//throw new Exception('Authorization not grant on ' . $action_method);
		} else {

			$reflect_class = new ReflectionClass(get_class($this));
			
			if($reflect_class->hasMethod($action_method)){
				try{
					$reflected_method = new ReflectionMethod(get_class($this),$action_method);
						
					$reflected_method->invoke($this);
				}catch(Exception $ex){
					print('<font color="red">'.$ex->getMessage().' on '. get_class($this) .' </font>');
					exit;
				}
			} else {
				print('<font color="red">Method ['.$action_method.'] not exist in '. get_class($this) .' </font>');
				exit;
			}
			
		}
			
	}
	
	/**
	 * Metodo predefinito quando non ci sono azioni da eseguire
	 * Puo essere effettuato l'override del metodo per personalizzare il suo comportamento 
	 */
	public function ActionIndex(){
		
	}
	
	/**
	 * Controlla se è possibile accedere alla risorsa con le credenziali che si hanno
	 * Se l'utente non è in context viene lanciato un messaggio
	 * Se l'utente non è loggato viene proposta la pagina di autenticazione
	 *  
	 */
	public function getAuthorizationController($action){
		
		$goto = true;
		
		if(isset($_SESSION['uid'])){
			$goto = true;
		} else {
			if(is_null($this->_auth)){
				$goto = true;	
				//print('is null _auth');
			} else {
				//print('controllo se ' . $action .' e presente in _auth');
				if(array_key_exists($action, $this->_auth)){
					$goto = false;
					//print('action exist on _auth');
				} else {
					//print('action not exist on _auth no authorization required');
				}
			}
		}
		return $goto;
	}
	
	/** 
	 * Inizia il processo di autenticazione 
	 * 
	 * 
	 **/
	protected function _authProcess(){

		Web_Application::$_page_next_login = $_SERVER['REQUEST_URI'];
		Web_Application::redirect('login/auth');	
	}
	
}