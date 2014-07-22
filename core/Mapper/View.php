<?php

/**
 * 
 * Mappa le viste sul Context corrente
 * 
 * @author Bentenuto Bruno
 *
 */

class Mapper_View extends Mapper_Map {
	
	protected $_map = array(

			'login:auth' => 'login',  // Mappa il template login sul context login:auth ovvero chiama Cotroller_Login e l'azione Auth su di esso
			
			'process:view' => 'process',
			'task:view' => 'task',
			'sysman:view' => 'sysman',
			
			'process:tasks' => 'process/tasks',
			'process:test' => 'process/test',
			'process:logs' => 'process/log_processi',
			'process:calls' => 'process/log_chiamate',
			'process:procexec' => 'process/log_procexec',
			
			'sysman:entity'		=>	'sysman/entity',
			'sysman:mongo'		=>	'mongo/index',
			'sysman:category'		=>	'sysman/category',
			
			'arianna:view'	=> 'arianna/home',
			'arianna:viewbook'	=> 'arianna/home_book',
			'arianna:mapcat'	=> 'arianna/mapcat',
			'arianna:attrib'	=> 'arianna/attrib',
			
			'arianna:file'	=> 'arianna/file',
			'arianna:categorie'	=> 'arianna/categorie',
			'arianna:libri'	=> 'arianna/libri',
			
			'wsprinter:view' => 'wsprinter/home',
			
	);
	
}