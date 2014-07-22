<?php

class Controller_Login extends Web_Controller{
	
	public function __construct(){}
	
	public function ActionLogin(){
		if(isset($_POST['username'])){
			$user = new Web_User();
			$pre_resource = $_POST['resource'];
			$isAuth = $user->authenticate_user($_POST['username'], $_POST['password']);
			
			if($isAuth){
				Web_Application::redirect($pre_resource);
			} else {
				$this->getViewer()->setVariable('message','Username o Password Errati');
			}	
		} else {
			$this->getViewer()->setVariable('message','');
		}
		
	}
	
	public function ActionIndex(){
		if(isset($_POST['username'])){
			$this->ActionLogin();
		} else {
			print('home login');
		}
		
		
	}
	
	public function ActionLogout(){
		
		Web_Authenticate::EndUserSession();
		$view = $this->getViewer()->disableOutput();
		Web_Application::redirect('');
		
	}
}
