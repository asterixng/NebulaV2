<?php

class Mapper_Action extends Mapper_Map{
	
	/**
	 * Map a function to an action
	 * 
	 * @var unknown
	 */
	protected $_map = array (
		
		'Controller_Login' => array(
					'auth'	=> 'ActionLogin',
					'logout' => 'ActionLogout'
				),
	);
	
	
}