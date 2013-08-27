<?php

class WSProcessController {
	
	private $_idprocexec = 0;
	private $_idproc = 0;
	
	public function startProcessByID($id){
		
		$this->_idproc = $id;
		
		$this->ProcessStart($this->_idproc);
		
		$processTask = Connector::Query("SELECT * FROM process_activity WHERE idprocess = $id ORDER BY callorder");
		
		foreach($processTask as $task){
			try{
			$this->callProcessTask($task['id'],$task['class'], $task['method']);
			}catch(Exception $ex){
				print($ex->getMessage());
			}
		}
		
		$this->ProcessEnd();
		
	}
	
	/**
	 * Call a task on process
	 * 
	 * @param integer $idtask
	 * @param String $class
	 * @param String $method
	 */
	private function callProcessTask($idtask,$class,$method){
		
		/** try to load a process task variable **/
		
		$id_activity = $this->ProcessTaskStart($idtask);
		$reflect_task = new ReflectionClass($class);

		if($reflect_task->hasMethod($method)){
			try{
				$reflect_method = new ReflectionMethod($class, $method);
				
				$reflect_method->invokeArgs($reflect_task->newInstance(array()), array());
				
				Connector::Execute("INSERT INTO ws_log VALUES(NULL,".WSProcess::getProcessExecutionID().",now(),'Call Task $method on $class')");
			} catch(Exception $ex){
				Connector::Execute("INSERT INTO ws_log VALUES(NULL,".WSProcess::getProcessExecutionID().",now(),'".$ex->getMessage()."')");
				Connector::Execute("UPDATE activity_execution SET message = concat(message,' ', '".$ex->getMessage()."') WHERE id = " . WSProcess::getActualProcessTaskExecution());
			}
			
		} else {
			Connector::Execute("INSERT INTO ws_log VALUES(NULL,".WSProcess::getProcessExecutionID().",now(),'Task $class::$method Not exist')");
		}
		$this->ProcessTaskEnd($idtask,$id_activity);
	}
	
	/**
	 * Process TASK execution start event
	 * 
	 * @param integer $idproc
	 */
	private function ProcessTaskStart($idproc){
		
		Connector::Execute("INSERT INTO activity_execution VALUES(NULL,$idproc,now(),null,'Active','')");
		WSProcess::setActualTaskID(Connector::$LAST_ID);
		Connector::Execute("INSERT INTO ws_log VALUES(NULL,".$this->_idprocexec.",now(),'Start Task Process ID:" . $idproc ." TaskIDExec:" . Connector::$LAST_ID."')");
		
		if(DEBUG){
			print('<br>Start Task Process ID:' . $idproc .' TaskIDExec:' . Connector::$LAST_ID);
		}
		
		WSProcess::ChangeTaskStatus(WSProcessStatus::$RUNNING);				
		return WSProcess::getActualProcessTaskExecution();
	}
	
	
	/**
	 * Process Task execution end event
	 * 
	 * @param integer $idtask
	 * @param integer $idtaskexec
	 */
	private function ProcessTaskEnd($idtask,$idtaskexec){
		Connector::Execute("INSERT INTO ws_log VALUES(NULL,".WSProcess::getProcessExecutionID().",now(),'End Task Process ID:" . $idtask." TaskIDExec:" . WSProcess::getActualProcessTaskExecution()."')");
			
		if(DEBUG){
			print('<br>End Task Process ID:' . $idtask . ' TaskID: ' .$idtaskexec);
		}
		
		Connector::Execute("UPDATE activity_execution SET end=now() WHERE id = " . WSProcess::getActualProcessTaskExecution());
		WSProcess::ChangeTaskStatus(WSProcessStatus::$PROCESSED);
	}
	
	/**
	 * Process Start event
	 * 
	 * @param unknown $idproc
	 */
	private function ProcessStart($idproc){
		
		Connector::Execute("INSERT INTO process_execution VALUES(NULL,$idproc,now(),null,null,'Active')");
		$this->_idprocexec = Connector::$LAST_ID;
		WSProcess::InitProcessExecution(Connector::$LAST_ID);
		if(DEBUG){
			print('<br>Start Process ID:' . $idproc .'ExecID:'. $this->_idprocexec);
				
		}
		Connector::Execute("INSERT INTO ws_log VALUES(NULL,".$this->_idprocexec.",now(),'Start Process ID:" . $idproc ." Process Execution ID:" . $this->_idprocexec."')");	
		WSProcess::ChangeProcessStatus(WSProcessStatus::$RUNNING);
	}
	
	/**
	 * Process END event
	 * 
	 * @param string $idproc
	 */
	private function ProcessEnd($idproc=null){
		if(DEBUG){
			print('<br>End Process ID:' . $this->_idprocexec);
				
		}
		Connector::Execute("UPDATE process_execution SET timestop=now() WHERE idprocexec =".WSProcess::getProcessExecutionID());
		Connector::Execute("INSERT INTO ws_log VALUES(NULL,".WSProcess::getProcessExecutionID().",now(),'End Process ID:" . $idproc ." Process Execution ID:" . $this->_idprocexec."')");
		WSProcess::ChangeProcessStatus(WSProcessStatus::$PROCESSED);
	}

	

}