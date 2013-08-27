<?php

class Mapper_Action extends Mapper_Map{
	
	
	protected $_map = array (
		
		'Controller_Login' => array(
					'auth'	=> 'ActionLogin',
					'logout' => 'ActionLogout'
				),
	);
	
	
}