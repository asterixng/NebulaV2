<?php

class Plugin_Resource {
	
	
	public static function getErrorDatabase(){
		
		$num_error = Web_Connector::ExecuteScalar("SELECT count(id) as error FROM ws_connector_log", 'error');
		
		$num_task = Web_Connector::ExecuteScalar("SELECT count(id) as tasks FROM activity_execution", 'tasks');
		
		$perc = $num_error / (($num_task * 5) / 100);
		
		$perc = round($perc,0);
		
		return $perc;
	}
	
	public static function getTaskExecuted(){
		$aborted = Web_Connector::ExecuteScalar("SELECT count(id) as abort FROM activity_execution WHERE status NOT LIKE('%Processed%')",'abort');
		$total = Web_Connector::ExecuteScalar("SELECT count(id) as task FROM activity_execution",'task');
		$perc = round(($aborted / ($total/100)),0);
	
		return 100 - $perc;
	}
	
	public static function getTaskAborted(){
		$aborted = Web_Connector::ExecuteScalar("SELECT count(id) as abort FROM activity_execution WHERE status NOT LIKE('%Processed%')",'abort');
		$total = Web_Connector::ExecuteScalar("SELECT count(id) as task FROM activity_execution",'task');
		$perc = round(($aborted / ($total/100)),0);
		
		return $perc;
	} 
	
	public static function getProcessTerminated(){
		
		$terminated = Web_Connector::ExecuteScalar("SELECT count(idprocexec) as ok FROM process_execution WHERE status LIKE('%Processed%')",'ok');
		$total = Web_Connector::ExecuteScalar("SELECT count(idprocexec) as proc FROM process_execution",'proc');
		
		
		
		$perc = round(($terminated / ($total/100)),0);
		
		return $perc;
	} 
	
	public static function averageTime(){
		
		$avg = Web_Connector::Query("SELECT avg(time) as media, max(time) as massimo, min(time) as mintime FROM `ws_task_time_exec`");
		
		$media = $avg[0]['media'];
		$max_time = $avg[0]['massimo'];
		$min_time = $avg[0]['mintime'];
		
		$base_time = $max_time - $min_time;
		
		$perc = round( ($media / ($base_time / 100)) ,0);
		
		return $perc;
	}
	
	
	public static function averageMemory(){
		
		$avg = Web_Connector::Query("SELECT avg(memory) as media, max(memory) as massimo, min(memory) as mintime FROM `ws_resource_consumption`");
		
		$media = $avg[0]['media'];
		$max_m = $avg[0]['massimo'];
		$min_m = $avg[0]['mintime'];
		
		$base_m = $max_m - $min_m;
		
		$perc = round( (($media - $min_m) / ($base_m / 100)) ,0);
		
		//print($media .' - ' . $max_m .' - ' .$min_m .' => ' . $perc);
		
		return $perc;
		
	}
}