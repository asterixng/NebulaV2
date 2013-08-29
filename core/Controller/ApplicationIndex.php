<?php

class Controller_ApplicationIndex extends Web_Controller {
	
	/**
	 * to avoid the guest access add action thrught $this->set_auth('action name');
	 * 
	 */
	public function __construct(){

		$this->set_auth('ActionIndex');
		
	}
	
	 public function ActionIndex(){
	 	
	 }
	
} 