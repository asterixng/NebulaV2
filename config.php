<?php
ini_set('display_errors', '1');

define('HOST','localhost');

define('DBNAME','nebula');

define('USER','root');

define('PWD','');

define('SERVER_ERROR','dev.ngopen.com');
define('MAIL_ERROR','error@ngopen.com');
define('DEBUG',false);

require_once 'core/raintpl/rain.tpl.class.php';

raintpl::$tpl_dir = "app/tpl/"; // template directory
raintpl::$cache_dir = "app/tmp/"; // cache directory


function autoload($class){
	
	$class = str_ireplace('_', '/', $class);
	
	require_once './core/'.$class.'.php';
	
}

spl_autoload_register("autoload");
