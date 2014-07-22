<?php

class Mapper_Action extends Mapper_Map{
	
	
	protected $_map = array (
		
		'Controller_Login' => array(
					'name'	=> 'auth',
					'auth'	=> 'ActionLogin',
					'logout' => 'ActionLogout'
		
				),
		'Controller_task' => array(
					
					'getproperty' => 'ActionGetProperty',
				
				),
		
	);
	
	
}