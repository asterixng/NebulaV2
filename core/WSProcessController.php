<?php
/**
 * Class WSProcessController
 * 
 * manage the running process
 * 
 * @todo must be reimplemented
 * @author bruben
 *
 */
class WSProcessController {
	
	private $_idprocexec = 0;
	private $_idproc = 0;
	
	public function startProcessByID($id){
		
		$this->_idproc = $id;
		
		$this->ProcessStart($this->_idproc);
		
		// call a task $this->callProcessTask($task['id'],$task['class'], $task['method']);
		
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
				
			} catch(Exception $ex){
				throw new BPMException('Error on lunching process');
			}
			
		} else {
			throw new BPMException('Task on container don\'t exist'');
		}
		$this->ProcessTaskEnd($idtask,$id_activity);
	}
	
	/**
	 * Process TASK execution start event
	 * 
	 * @param integer $idproc
	 */
	private function ProcessTaskStart($idproc){
		
		
	}
	
	
	/**
	 * Process Task execution end event
	 * 
	 * @param integer $idtask
	 * @param integer $idtaskexec
	 */
	private function ProcessTaskEnd($idtask,$idtaskexec){
		
	}
	
	/**
	 * Process Start event
	 * 
	 * @param unknown $idproc
	 */
	private function ProcessStart($idproc){
		
	}
	
	/**
	 * Process END event
	 * 
	 * @param string $idproc
	 */
	private function ProcessEnd($idproc=null){
		
	}

	

}