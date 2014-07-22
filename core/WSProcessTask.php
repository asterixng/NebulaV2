<?php
class WSProcessTask {
	
	public static function logTaskExecution($message_log){
		$idExecution = WSProcess::getActualProcessTaskExecution();
		Connector::Execute("UPDATE activity_execution SET message = CONCAT( message,  ' ',  '$message_log' ) WHERE id = $idExecution");
	}
	
	
}