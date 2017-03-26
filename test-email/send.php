<?php 
		require ('../PHPMailer-master/PHPMailerAutoload.php');
		//SEND EMAIL WITH THIS LINK 
		$finalLink = "http://198.199.95.116/audio/test-email";
		$email = "yash0314@gmail.com";
		$playlist_name = "abhi's cool moosik";

		$body = file_get_contents('email-template.php');
		$body = str_replace('$finalLink', $finalLink, $body);
		$body = str_replace('$email', $email, $body);
		$body = str_replace('$playlist_name', $playlist_name, $body);

		$body = preg_replace('/\\\\/','', $body);



		echo $body;

		$mail = new PHPMailer;


		//$mail->SMTPDebug = 3;                               // Enable verbose debug output

		$mail->isSMTP();                                      // Set mailer to use SMTP
		$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
		$mail->SMTPAuth = true;                               // Enable SMTP authentication
		$mail->Username = 'spotifyhacksLOL@gmail.com';                 // SMTP username
		$mail->Password = 'thisismypass';                           // SMTP password
		$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
		$mail->Port = 587;                                    // TCP port to connect to

		$mail->setFrom('spotifyhacksLOL@gmail.com', 'Spotify Hacks');
		$mail->addAddress($email, 'Our friend');     // Add a recipient
		$mail->addReplyTo('spotifyhacksLOL@gmail.com', 'Spotify Hacks');

		$mail->isHTML(true);                                  // Set email format to HTML

		$mail->Subject = 'Download Complete: Spotify Hacks - ' . $playlist_name;
		$mail->Body = $body;
		//$mail->Body    = 'Here\'s your link to download your <a href="'.$finalLink.'">playlist</a>' ;
		$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

		if(!$mail->send()) {
		    echo 'Message could not be sent.';
		    echo 'Mailer Error: ' . $mail->ErrorInfo;
		} else {
		    echo 'Message has been sent';
		}


?>