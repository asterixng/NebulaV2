<?php

class WSProcessEvent {
	
	private static $_events = array();
	
	public static function RegisterEvent($event,$function){
		
		WSProcessEvent::$_events[] = array('event'=>$event,'delegate'=>$function);
		
	}
	
	
	
}