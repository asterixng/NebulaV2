<?php

class Web_Context {
	
	
	private $_context = "";
	private $_user_in_context = "";
	
	/**
	 * Controlla se la risorsa indicata è nel context corrente
	 * 
	 * @param unknown $context
	 */
	public function isOnContext($resource){
		
		
	}
	
	/**
	 * Ritorna l'utente eventualmente loggato all'interno del sistema
	 * 
	 * @return string
	 */
	
	public function userInContext(){
		
		if(isset($_SESSION['uid'])){
			return $_SESSION['user'];
		} else {
			return new Web_User();
		}
		
		
	}
	
	/**
	 * Viene richiamata da View per generare il context corrente
	 */
	public function createContext(){

		if(!isset($_SERVER['PATH_INFO'])){
			$this->_context = 'home:view';
		} else {
			$splitted_pinfo = explode("/", $_SERVER['PATH_INFO']);
			
			if(count($splitted_pinfo) > 1){
				$this->_context = $splitted_pinfo[1];
				if(count($splitted_pinfo) > 2){
					$action = $splitted_pinfo[2];
					$this->_context .= ':' . $action;
				} else {
					$this->_context .= ':view';
				}
					
			}
		}
		
		/** Create a user context **/
		if(isset($_SESSION['uid'])){
			$this->_user_in_context = $_SESSION['user'];
		} else {
			$this->_user_in_context = "guest";
		}
		
	}
	
	/**
	 * Ritorna il context corrente
	 * @return string
	 */
	public function getContext(){
		return $this->_context;
	} 

	/**
	 * Aggiunge al context attuale un context supplementare
	 * 
	 * 
	 * @param unknown $new_context
	 */
	public function modifyContext($new_context){
		$this->_context .= ':' . $new_context;
	}
}