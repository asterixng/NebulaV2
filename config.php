<?php
/**
 * The config.php file will be deleted on the beta release
 * Use Web_Configuration::getProperty(key); to retrive  a value of a configuration property
 * Use Web_Configutation::setProperty(key,value) to set an property 
 * 
 * on this file will remain only row from //stable to the end of file
 * 
 * 
 */
date_default_timezone_set('Europe/London');
ini_set('display_errors', '1');

define('HOST','localhost');

define('DBNAME','nebula');

define('USER','root');

define('PWD','');

define('SERVER_ERROR','');
define('MAIL_ERROR','');
define('DEBUG',false);

//stable
require_once 'core/raintpl/rain.tpl.class.php';

raintpl::$tpl_dir = "app/tpl/"; // template directory
raintpl::$cache_dir = "app/tmp/"; // cache directory


function autoload($class){
	
	$class = str_ireplace('_', '/', $class);
	
	require_once './core/'.$class.'.php';
	
}

spl_autoload_register("autoload");
