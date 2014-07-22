<?php

class Controller_ApplicationIndex extends Web_Controller {
	
	public function __construct(){

		$this->set_auth('ActionIndex');
		
	}
	
	
	
	 public function ActionIndex(){
		 
		$data = Connector::Query("SELECT name, count(idprocess) as msgnum FROM process GROUP BY name");
	 	
		$cols = CloudDB::getCollections();
		
		$this->getViewer()->setVariable("process",$data);
		$this->getViewer()->setVariable("cols",$cols);
		$this->getViewer()->setVariable("sessid",session_id());
	 	
	 }
	
} 