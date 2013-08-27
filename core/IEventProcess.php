<?php

interface IEventProcess {
	
	public function StartProcessEvent();
	public function EndProcessEvent();
	
	public function ExceptionProcessEvent();
	public function RecoveryProcessEvent();
	
	public function StartProcessTaskEvent();
	public function EndProcessTaskEvent();
	
}