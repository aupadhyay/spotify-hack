<<<<<<< HEAD
<?php 
	$access_token = $_GET['aid'];
	$playlist_id = $_GET['id'];
	$spot_id = $_GET['spot'];
	$playlist_name = $_GET['playlistname'];
	//$email = $_GET['email'];

	require("../configs/spotify.php");
	require ('PHPMailer-master/PHPMailerAutoload.php');
	$profilecURL = curl_init();

	curl_setopt_array($profilecURL, array(
		CURLOPT_URL => "https://api.spotify.com/v1/me",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "GET",
		CURLOPT_HTTPHEADER => array(
		"cache-control: no-cache",
		"content-type: application/x-www-form-urlencoded",
		"Authorization: Bearer " . $access_token
		),
	));

	$responseProfile = curl_exec($profilecURL);
	$errProfile = curl_error($profilecURL);
	curl_close($profilecURL);

	if ($errProfile) {
	  echo "cURL Error #:" . $errProfile;
	} else {
	  $responseJSON = json_decode($responseProfile);
	  $email = $responseJSON->email;
	  //print_r($responseJSON);
	  //$username = $responseJSON->id;
	}


	$curl = curl_init();

	curl_setopt_array($curl, array(
	  CURLOPT_URL => "https://api.spotify.com/v1/users/". $spot_id ."/playlists/". $playlist_id ."/tracks",
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => "",
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 30,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => "GET",
	  CURLOPT_HTTPHEADER => array(
	    "authorization: Bearer " . $access_token ,
	    "cache-control: no-cache",
	  ),
	));

	$response = curl_exec($curl);
	$err = curl_error($curl);

	curl_close($curl);
	$tracks = array();
	if ($err) {
	  echo "cURL Error #:" . $err;
	} else {
		$uniqueID = uniqid();
		//echo $uniqueID;
		mkdir("audio/" . $uniqueID, 0777);
		$rootPath = realpath('audio/' . $uniqueID);
		$response = json_decode($response);
		$totalTracks = intval($response->total);
		chdir('audio');
		chdir($uniqueID );

		for ($i=0; $i < $totalTracks; $i++) { 
			$tracks[$i][0] = $response->items[$i]->track->artists[0]->name;
			$tracks[$i][1] = $response->items[$i]->track->name;

		    $artistName = $tracks[$i][0];
		    $songName = $tracks[$i][1];
		    $searchString   = $artistName . " - " . $songName;
		    //echo $searchString;
		    $correctString  = str_replace(" ","+",$searchString);
		    $youtubeUrl = "https://www.youtube.com/results?search_query=". $correctString . "&sp=EgIQAQ%253D%253D";
		    $getHTML = file_get_contents($youtubeUrl);
		    $pattern = '/<a href="\/watch\?v=(.*?)"/i';

		    if(preg_match($pattern, $getHTML, $match)){
		    	$videoID = $match[1];
		    } else {
		    	echo "Something went wrong!";
		    	exit;
		    }


		    $tracks[$i][2] = "http://youtube.com/watch?v=" . $videoID;
		    $output = shell_exec('youtube-dl --extract-audio --audio-format mp3 ' . $tracks[$i][2]);

		    //print_r($output);

		}

		
		$insertSQL = "INSERT INTO `users` (`email`, `folder_name`, `playlist_name`) VALUES ('". $email ."','". $uniqueID ."','". $playlist_id ."')";

		$result = mysqli_query($GLOBALS['con'], $insertSQL);

		// Initialize archive objects
		$zip = new ZipArchive();
		$zip->open($playlist_name . '.zip', ZipArchive::CREATE | ZipArchive::OVERWRITE);

		// Create recursive directory iterator
		/** @var SplFileInfo[] $files */
		$files = new RecursiveIteratorIterator(
	    	new RecursiveDirectoryIterator($rootPath),
	    	RecursiveIteratorIterator::LEAVES_ONLY
		);

		foreach ($files as $name => $file){
	    // Skip directories (they would be added automatically)
		    if (!$file->isDir()){
		        // Get real and relative path for current file
		        $filePath = $file->getRealPath();
		        $relativePath = substr($filePath, strlen($rootPath) + 1);

		        // Add current file to archive
		        $zip->addFile($filePath, $relativePath);
		    }
		}

		// Zip archive will be created only after closing object
		$zip->close();

		$file = $playlist_name . '.zip';

		//SEND EMAIL WITH THIS LINK 
		$finalLink = "http://198.199.95.116/audio/" . $uniqueID . "/" . $file;



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

		$mail->Subject = 'Download Complete: Spotify Hacks';
		$mail->Body    = 'Here\'s your link to download your <a href="'.$finalLink.'">playlist</a>' ;
		$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

		if(!$mail->send()) {
		    //echo 'Message could not be sent.';
		    //echo 'Mailer Error: ' . $mail->ErrorInfo;
		} else {
		    //echo 'Message has been sent';
		}



		if (file_exists($file)) {
		    header('Content-Description: File Transfer');
		    header('Content-Type: application/octet-stream');
		    header('Content-Disposition: attachment; filename="'.basename($file).'"');
		    header('Expires: 0');
		    header('Cache-Control: must-revalidate');
		    header('Pragma: public');
		    header('Content-Length: ' . filesize($file));
		    readfile($file);
		    exit;
		}

		
	}


?>