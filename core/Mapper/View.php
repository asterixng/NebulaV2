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
			
	);
	
}