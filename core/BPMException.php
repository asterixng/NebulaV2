<?php

class BPMException extends Exception {
	
	function __construct($message=null,$code=null,$previous=null){
		parent::__construct($message,$code,$previous);
		$this->logException($message);
	}
	
	protected function logException($message){

			$query = "UPDATE ws_stealth SET exception = CONCAT(exception,' ','$message' WHERE id = " . WSProcess::getStealthExecution();
			Connector::Execute($query);
		
	}
	
}