<?php 
	$access_token = $_GET['aid'];
	$playlist_id = $_GET['id'];


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
	  $username = $responseJSON->id;
	}


	$curl = curl_init();

	curl_setopt_array($curl, array(
	  CURLOPT_URL => "https://api.spotify.com/v1/users/". $username ."/playlists/". $playlist_id ."/tracks",
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
		$response = json_decode($response);
		$totalTracks = $response->total;

		for ($i=0; $i < $totalTracks; $i++) { 
			$tracks[$i][0] = $response->items[$i]->track->album->artists[0]->name;
			$tracks[$i][1] = $response->items[$i]->track->album->name;

		    $artistName = $tracks[$i][0];
		    $songName = $tracks[$i][1];
		    $searchString   = $artistName . " - " . $songName;
		    $correctString  = str_replace(" ","+",$searchString);
		    $youtubeUrl = "https://www.youtube.com/results?search_query=". $correctString;
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

		    print_r($output);

		}

		//print_r($tracks);
	}

?><!DOCTYPE html>


<html>
	<head></head>
	<body>
		
	</body>
</html>