<?php

/**
 * 
 * Class for manage mail send
 * @todo must be implemented
 * 
 * @author asterixng
 *
 */
class Mailer {
	
	public function logOnMail($message,$to){
		$isAccepted = mail($to, "Log Execution Stealth", $message);
		return $isAccepted;
	}
	
}