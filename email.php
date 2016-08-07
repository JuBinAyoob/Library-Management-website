<?php
	require_once 'Mail.php'; 
	function sendemail($username, $password, $to, $subject, $msg)
	{
		$host = 'mail.smtp2go.com'; 
		$port = "2525";

		$from = "SiMat Library<library@simat.ac.in>";
		


		$headers = array ('From' => $from,
							'To' => $to,
							'Subject' => $subject);
	
		$smtp = Mail::factory('smtp',
						array ('host' => $host,
								'port' => $port,
								'auth' => true,
								'username' => $username,
								'password' => $password));

		$mail = $smtp->send($to, $headers, $msg);

		if (PEAR::isError($mail)) 
			echo '<p>' . $mail->getMessage() . '</p>';
		else 
			echo '<br><p>Message successfully sent to'.$to.'</p>';
	}
?>