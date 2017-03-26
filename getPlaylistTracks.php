<?php
	$username = $_POST['username'];
	$playlistID = $_POST['playlist_ID'];
	$curl = curl_init();

	curl_setopt_array($curl, array(
	  CURLOPT_URL => "https://api.spotify.com/v1/users/". $username ."/playlists/". $playlistID ."/tracks",
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => "",
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 30,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => "GET",
	  CURLOPT_HTTPHEADER => array(
	    "authorization: Bearer " . $_COOKIE['access-token'],
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
		$totalTracks = intval($response->total);
		if($totalTracks > 100){
			$totalTracks = 100;
		}
		for ($i=0; $i < $totalTracks; $i++) { 
			$tracks[$i][0] = $response->items[$i]->track->artists[0]->name;
			$tracks[$i][1] = $response->items[$i]->track->name;
		}
	}

	echo json_encode($tracks);

?>