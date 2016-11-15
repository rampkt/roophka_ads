<?php
class mailler {
	
	function sendmail($to = array(),$from = '', $subject = '', $msg = '', $cc = array(), $bcc = array()) {
		
		$tomail = implode(',',$to);
		//$subject = 'Test mail Ram';
		
		$message = '<html><head><title>Mail from Roophka.in</title></head><body>';
		$message .= $msg;
		$message .= '</body></html>';
		
		// To send HTML mail, the Content-type header must be set
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		
		// Additional headers
		$headers .= 'To: ';
		$i=1;
		foreach($to as $m) {
			if($i==1)
			$headers .= '<'.$m.'>';
			else
			$headers .= ', <'.$m.'>';
		}
		$headers .= "\r\n";
		$headers .= 'From: Roophka | <'.$from.'>' . "\r\n";
		//$headers .= 'Cc: birthdayarchive@example.com' . "\r\n";
		//$headers .= 'Bcc: birthdaycheck@example.com' . "\r\n";
		
		// Mail it
		@mail($tomail, $subject, $message, $headers);
		
	}
}
?>