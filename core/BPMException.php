<?php

/** 
 * A exception class that is thow when an error in the bpm occur
 * 
 * @author bruben
 *
 */
class BPMException extends Exception {
	
	function __construct($message=null,$code=null,$previous=null){
		parent::__construct($message,$code,$previous);
		$this->logException($message);
	}
	
	protected function logException($message){

		
	}
	
}