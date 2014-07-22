<?php

class WSProcessLogger {
	
	
	private static $_memconsuption = array();
	
	public static function registerMemoryConsuption($idProcExecution){
		
		$memory = memory_get_usage();
		
		WSProcessLogger::$_memconsuption[] = array('idproc'=>$idProcExecution,'mem' => $memory,'time'=>time());	
		
	}
	
	public static function saveMemoryUsage(){
		
		foreach(WSProcessLogger::$_memconsuption as $rescons){
			
			$query = "INSERT INTO ws_resource_consumption VALUES(NULL,".$rescons['time'].",".$rescons['idproc'].",".$rescons['mem'].")";
			
			Connector::Execute($query);
		}
		
		WSProcessLogger::$_memconsuption = array();
		
	}
	
}