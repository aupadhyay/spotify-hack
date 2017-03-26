<?php 
	$access = $_GET['code'];

	$curl = curl_init();

	curl_setopt_array($curl, array(
	  CURLOPT_URL => "https://accounts.spotify.com/api/token",
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => "",
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 30,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => "POST",
	  CURLOPT_POSTFIELDS => "code=". $access ."&grant_type=authorization_code&redirect_uri=http:%2F%2F198.199.95.116%2Fdashboard.php&client_id=a800171b426d44a4b01da7d38e9970b4&client_secret=17a413563313492c9180eb350a46f881",
	  CURLOPT_HTTPHEADER => array(
	    "cache-control: no-cache",
	    "content-type: application/x-www-form-urlencoded",
	  ),
	));

	$response = curl_exec($curl);
	$err = curl_error($curl);

	curl_close($curl);

	if ($err) {
	  echo "cURL Error #:" . $err;
	} else {
		
		$final_access = json_decode($response);
		$final_access = $final_access->access_token;
	}


	$getPlaylistsCURL = curl_init();
	curl_setopt_array($getPlaylistsCURL, array(
	  CURLOPT_URL => "https://api.spotify.com/v1/me/playlists",
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => "",
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 30,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => "GET",
	  CURLOPT_HTTPHEADER => array(
	    "cache-control: no-cache",
	    "content-type: application/x-www-form-urlencoded",
	    "Authorization: Bearer " . $final_access
	  ),
	));

	$response = curl_exec($getPlaylistsCURL);
	$err = curl_error($getPlaylistsCURL);

	curl_close($getPlaylistsCURL);

	if ($err) {
	  echo "cURL Error #:" . $err;
	} else {
		$response = json_decode($response);
		$total = intval($response->total);

		$playlists = array();

		for ($i=0; $i < $total; $i++) {
			$playlists[$i][0] = $response->items[$i]->name;
			$playlists[$i][1] = $response->items[$i]->id;
			$playlists[$i][2] = $response->items[$i]->images[0]->url;
			//echo "Playlist Name: " . $response->items[$i]->name . "<br>";
		}


	  //print_r(json_decode($response)->items[0]);
	}

	
?><!DOCTYPE html>

<html>
	<head></head>

	<body>
		<?php for($j=0; $j < count($playlists); $j++){ ?>
			<a href="download.php?id=<?php echo $playlists[$j][1];?>&aid=<?php echo $final_access; ?>"><?php echo $playlists[$j][0]; ?></a>
		<?php } ?>
	</body>
</html>