<?php
/**
 * Interface for the event dispatched from the server to the client
 * 
 * all event could be used in javascript 
 * 
 * 
 * @todo Must be implemented yet for an complete MVC pattern
 * 
 * @author bruben
 *
 */
interface IEventProcess {
	
	public function StartProcessEvent();
	public function EndProcessEvent();
	
	public function ExceptionProcessEvent();
	public function RecoveryProcessEvent();
	
	public function StartProcessTaskEvent();
	public function EndProcessTaskEvent();
	
}