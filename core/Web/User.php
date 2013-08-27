<?php

class Web_User {
	
	public $_id = 0;
	public $_username = "Guest";
	public $_email = "guest@localdomain";
	public $_created_data = "";
	public $_idrole = 0;
	public $_rolename ="";
	public $_role_context =""; 
	public $_pwd="";
	
	private $_isAuth = false;
	
	public function __construct(){
		
	}
	
	public function authenticate_user($user,$password){
		
		
		$this->_username = Connector::escapeString($user);
		$this->_pwd = Connector::escapeString($password);
		
		$this->_isAuth = Web_Authenticate::Authenticate($this);
		
		return $this->_isAuth;
	}
	
	
	
}