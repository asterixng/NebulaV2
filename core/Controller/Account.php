<?php
use Zend\Mvc\Application;

class Controller_Account extends Web_Controller{
	
	function __construct(){
		
	}
	
	public function ActionAccount(){
		
		$this->getViewer()->disableOutput();
		$formFactory = new WebUI_BootstrapForm("Account Utente");
		$form = $formFactory->createForm("Salva",array(
			array(
					'type'	=>	'text',
					'id' 	=>	'username',
					'title'	=>	'Username',
					'placeholder'		=> 	'username'
			),
			array(
				'type' => 'password',
				'id'	=>	'pwd',
				'title'	=> 	'Password'
			),
			
		));
		
		echo WebUI_BootstrapPanel::getWarningPanel("Dati Utente",$form);
	}
	
	public function ActionMessage(){
	
		$this->getViewer()->disableOutput();
		echo WebUI_BootstrapPanel::getWarningPanel("Gestione Messaggi","GEstione dei messaggi della piattaforma");
	}
	
	public function ActionTicket(){
	
		$this->getViewer()->disableOutput();
		echo WebUI_BootstrapPanel::getWarningPanel("Ticketing di sistema",'Apertura ticket di supporto');
	}
	
	
}