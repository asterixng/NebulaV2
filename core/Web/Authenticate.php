<?php

class Web_Authenticate {
	
	public static function Authenticate(&$user){
		
		$isAuth = false;
		
		$user_name = $user->_username;
		$password = $user->_pwd;
		
		$user->_pwd = "";
		$auth_query = "SELECT * from user WHERE username='$user_name' AND `password` = MD5('$password')";
		$result = Connector::Query($auth_query);
		
		if(count($result) == 1){
			$user->_email = $result[0]['email'];
			$user->_created_data = $result[0]['created_data'];
			$user->_idrole = $result[0]['idRole'];
			$user->_rolename = $result[0]['rolename'];
			$user->_role_context = $result[0]['role_context']; 
			$user->_id = $result[0]['id'];
			$isAuth = true;
			
			Web_Authenticate::StartUserSession($result[0]['id']);
			Web_Authenticate::RegisterUserOnSession($user);
		} else {
			$isAuth = false;
		}
		
		return $isAuth;
	}
	
	public static function RegisterUserOnSession($user){
		$_SESSION['user'] = $user;
	}
	
	public static function StartUserSession($uid){
		
			$_SESSION['uid'] = $uid;
		
		
	}
	
	public static function EndUserSession(){
		session_destroy();
	} 
}