<?php
class Mailer {
	
	public function logOnMail($message,$to){
		$isAccepted = mail($to, "Log Execution Stealth", $message);
		return $isAccepted;
	}
	
}