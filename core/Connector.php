<?php

//require_once './config.php';
require_once getcwd().'/config.php';

class Connector {
	
	public static $LAST_ID;
	public static $LAST_ERROR_MESSAGE;
	public static $LAST_ERROR_NUM;
	
	public static $NUM_ROWS = 0;
	
	public static function Execute($query){
		
		$execution = false;
		
		Connector::$LAST_ID = null;
		Connector::$LAST_ERROR_MESSAGE = null;
		Connector::$LAST_ERROR_NUM = null;
		
		$connection = mysql_connect(HOST,USER,PWD);
		mysql_select_db(DBNAME);
		
		$result = mysql_query($query);
		
		if($result){
			
			Connector::$LAST_ID = mysql_insert_id();
			mysql_close($connection);
			$execution = true;
			
		} else {
			
			Connector::$LAST_ERROR_MESSAGE = mysql_error();
			Connector::$LAST_ERROR_NUM = mysql_errno();
			mysql_close($connection);
			Connector::logQueryError($query, Connector::$LAST_ERROR_MESSAGE,Connector::$LAST_ERROR_NUM);
			
		}
		
		return $execution;
	}
	
	public static function Query($query){
	
		Connector::$LAST_ID = null;
		Connector::$LAST_ERROR_MESSAGE = null;
		Connector::$LAST_ERROR_NUM = null;
		
		$resultSet = array();
		
		$connection = mysql_connect(HOST,USER,PWD);
		mysql_select_db(DBNAME);
		
		$result = mysql_query($query);
		
		if($result){
			
			Connector::$NUM_ROWS = mysql_num_rows($result);
			
			while($row=mysql_fetch_assoc($result))$resultSet[] = $row;
			
			mysql_free_result($result);
			mysql_close($connection);
			
		} else {
			
			Connector::$LAST_ERROR_MESSAGE = mysql_error();
			Connector::$LAST_ERROR_NUM = mysql_errno();
			mysql_close($connection);
			Connector::logQueryError($query, Connector::$LAST_ERROR_MESSAGE,Connector::$LAST_ERROR_NUM);
			//mysql_free_result($result);
			
			
		}

		return $resultSet;
	}
	
	private static function logQueryError($query,$message,$code){
		
		$query = mysql_escape_string($query);
		$message = mysql_escape_string($message);
		$my = mysql_connect(HOST,USER,PWD);
		mysql_select_db(DBNAME);
		mysql_query("INSERT INTO ws_connector_log VALUES(NULL,'$query','$message','$code')",$my);
		mysql_close($my);
		
		
		//mail(MAIL_ERROR, 'installation test', $message . ' Exedcuted Query ['.$query.']');
		
	}
	
	public static function logQuery($query,$message="",$code=""){
		
		$query = mysql_escape_string($query);
		$message = mysql_escape_string($message);
		
		Connector::Execute("INSERT INTO ws_connector_log VALUES(NULL,'$query','$message','$code')");
		
		
	}
	
	
	/**
	 * Escape String
	 * 
	 * @param string $unescaped_string
	 * @return string
	 */
	public static function escapeString($unescaped_string){
		return mysql_escape_string($unescaped_string);
	} 
}