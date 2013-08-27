<?php

class WSProcess {
	
	private static $_process_execution_id = 0;
	private static $_stealth_id_execution = 0;
	
	private static $_actual_task_execution = 0;
	
	public static function InitStealthProcess($idStealthExecutionID){
		
		WSProcess::$_stealth_id_execution = $idStealthExecutionID;
		
	}
	
	public static function InitProcessExecution($idProcessExecution){
	
		WSProcess::$_process_execution_id = $idProcessExecution;
	
	}
	
	public static function setActualTaskID($idTaskExecution){
	
		WSProcess::$_actual_task_execution = $idTaskExecution;
	
	}
	
	public static function getProcessExecutionID(){
		return WSProcess::$_process_execution_id;
	}
	
	public static function getActualProcessTaskExecution(){
		return WSProcess::$_actual_task_execution;
	}
	
	
	public static function getStealthExecution(){
		return WSProcess::$_stealth_id_execution;
	}
	
	public static function ChangeProcessStatus($status){
		
		if($status == 1){
			Connector::Execute("UPDATE ws_stealth SET status = 'Active' WHERE id = " . WSProcess::$_stealth_id_execution);
			Connector::Execute("UPDATE process_execution SET status = 'Active' WHERE idprocexec = " . WSProcess::$_process_execution_id);
		} else if($status == 2){
			Connector::Execute("UPDATE ws_stealth SET status = 'Running' WHERE id = " . WSProcess::$_stealth_id_execution);
			Connector::Execute("UPDATE process_execution SET status = 'Running' WHERE idprocexec = " . WSProcess::$_process_execution_id);
		} else if($status == 3){
			Connector::Execute("UPDATE ws_stealth SET status = 'Processed' WHERE id = " . WSProcess::$_stealth_id_execution);
			Connector::Execute("UPDATE process_execution SET status = 'Processed' WHERE idprocexec = " . WSProcess::$_process_execution_id);
		} else if($status == 4) {
			Connector::Execute("UPDATE ws_stealth SET status = 'Terminated' WHERE id = " . WSProcess::$_stealth_id_execution);
			Connector::Execute("UPDATE process_execution SET status = 'Terminated' WHERE idprocexec = " . WSProcess::$_process_execution_id);
		} else {
			Connector::Execute("UPDATE ws_stealth SET status = 'NS' WHERE id = " . WSProcess::$_stealth_id_execution);
			Connector::Execute("UPDATE process_execution SET status = 'NS' WHERE idprocexec = " . WSProcess::$_process_execution_id);
		}
		
	}
	
	/**
	 * Change the status of task in execution
	 * 
	 * @param unknown $status
	 */
	public static function ChangeTaskStatus($status){
	
		if($status == 1){
			Connector::Execute("UPDATE activity_execution SET status = 'Active' WHERE id = " . WSProcess::$_actual_task_execution);
			
		} else if($status == 2){
			Connector::Execute("UPDATE activity_execution SET status = 'Running' WHERE id = " . WSProcess::$_actual_task_execution);
			
		} else if($status == 3){
			Connector::Execute("UPDATE activity_execution SET status = 'Processed' WHERE id = " . WSProcess::$_actual_task_execution);
			
		} else if($status == 4) {
			Connector::Execute("UPDATE activity_execution SET status = 'Terminated' WHERE id = " . WSProcess::$_actual_task_execution);
			
		} else {
			Connector::Execute("UPDATE activity_execution SET status = 'NS' WHERE id = " . WSProcess::$_actual_task_execution);
			
		}
	
	}
	
	
	
}