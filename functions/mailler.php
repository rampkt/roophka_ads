<?php
class mailler {
	
	function sendmail($to = array(),$from = '', $subject = '', $msg = '', $cc = array(), $bcc = array()) {
		
		$tomail = implode(',',$to);
		//$subject = 'Test mail Ram';
		
		$message = '<html><head><title>Mail from Roophka.com</title></head><body>';
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
		if(@mail($tomail, $subject, $message, $headers)) {
			return true;
		} else {
			return false;
		}
		
	}
	
	function sendmail_attachment($file_name,$temp_name,$file_type, $path, $mailto, $from, $from_name, $replyto, $subject, $msg) {
		
		$to = implode(',',$mailto);
		//$subject = 'Test mail Ram';
		
		$message = '<html><head><title>Mail from Roophka.com</title></head><body>';
		$message .= $msg;
		$message .= '</body></html>';
		
		//things u need
       $file = $temp_name;
       $content = chunk_split(base64_encode(file_get_contents($file)));
       $uid = md5(uniqid(time()));  //unique identifier

       //standard mail headers
       $header = "From: ".$from."\r\n";
       $header .= "Reply-To: ".$replyto. "\r\n";
       $header .= "MIME-Version: 1.0\r\n";


       //declare multiple kinds of email (plain text + attch)
       $header .="Content-Type: multipart/mixed; boundary=\"".$uid."\"\r\n\r\n";
       $header .="This is a multi-part message in MIME format.\r\n";

       //plain txt part

       $header .= "--".$uid."\r\n";
       $header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
       $header .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
       $header .= $message. "\r\n\r\n";


       //attch part
       $header .= "--".$uid."\r\n";
       $header .= "Content-Type: ".$file_type."; name=\"".$file_name."\"\r\n";
       $header .= "Content-Transfer-Encoding: base64\r\n";
       $header .= "Content-Disposition: attachment; filename=\"".$file_name."\"\r\n\r\n";
       $header .= $content."\r\n\r\n";  //chucked up 64 encoded attch


       //sending the mail - message is not here, but in the header in a multi part

       if(mail($to, $subject, "", $header)) {
       echo "success";
       }else {
           echo "fail";
       }
 
}
	
}
?>