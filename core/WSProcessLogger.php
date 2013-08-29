<?php
/**
 * Manage the process execution log
 * 
 * @todo must be reimplemnted
 * 
 * @author asterixng
 *
 */
class WSProcessLogger {
	
	
	private static $_memconsuption = array();
	
	public static function registerMemoryConsuption($idProcExecution){
		
		
	}
	
	public static function saveMemoryUsage(){
		
		foreach(WSProcessLogger::$_memconsuption as $rescons){
			
			
		}
		
		WSProcessLogger::$_memconsuption = array();
		
	}
	
}