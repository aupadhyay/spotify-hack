<?php 
	if(isset($_COOKIE['access-token'])){
		$final_access = $_COOKIE['access-token'];
	}else if(isset($_GET['code'])){
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
	}else{
		$errorMsg = "Invalid code. Make sure you log in through Spotify!";
	}

	setcookie("access-token",$final_access,time()+36000);


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
<head>
	<title>SPOTIFY WEB HACK - GONE WRONG</title>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

	<style>
	@import url('https://fonts.googleapis.com/css?family=Montserrat:300,600,700|Muli:200,300,400');
		body{
			background-color: rgba(1,1,1,0.87);
		}

		.title{
			color:white;
			font-family: "Montserrat";
			font-weight:600;
			letter-spacing: 2.5px;
			margin-top: 50px;
			margin-bottom:30px;
		}

		.album-image{
			margin-top: 20px;
			transition: 0.3s;
			width:150px;
			height:150px;
		}
		.album-image:hover{
			opacity: 0.3;
		}

		.container{
			background-color: rgba(1,1,1,0.4);
		}

		.album-name{
			font-family: "Muli";
			font-weight:200;
			color:white;
			font-size: 20px;
			padding:10px;
			letter-spacing: 0.5px

		}

		.spotifyhr{
			width:100px;
			border-width:2.5px;
			border-color:#1ed760;
			margin-top: -10px;
		}

		.col-md-2-y{
			width:16%;
			display: inline-block;
		}

		th{
			font-family: "Montserrat";
			font-weight: 600;
			font-size:16;
			color:white;
		}

	</style>
</head>
<body>
	<script src="js/jquery.js"></script>
	<link rel="stylesheet" href="css/jquery-confirm.min.css">
	<script src="js/jquery-confirm.min.js"></script>
	<?php if(isset($errorMsg)){ ?>
		<script>
			$.alert({
			    title: 'Alert!',
			    content: '<?php echo $errorMsg; ?>',
			});
		</script>
	<?php } ?>
	<div class = "">
		<center><img src = "http://www.chapelroswell.com/wp-content/uploads/2016/07/6274-spotify-logo-horizontal-white-rgb.png" style = "width:25%;margin-top:100px">
		<h1 class = "title">CHOOSE YOUR PLAYLIST</h1></center>
		<hr class = "spotifyhr">
	</div>

		<div class = "container">

			<div class = "row"><center>
			<?php for($j=0; $j < count($playlists); $j++){ ?>
				<div class = "col-md-2-y">
					
					<div class = "playlist-holder">
						<center>
							<a class="album-image" href = "download.php?id=<?php echo $playlists[$j][1];?>&aid=<?php echo $final_access; ?>" style="display:block; width: 150px; height: 150px; background-image: url(<?php echo $playlists[$j][2]; ?>); background-size: cover;background-position: center;" ></a>

						</center>

					</div>
					
				</div>

				<?php } ?><br>
				<div>
					<?php for($j=0; $j < count($playlists); $j++){ ?>
					<div style="vertical-align: top;" class = "col-md-2-y">
						
						<div class = "playlist-holder">
							<center>
								<p class = "album-name"><?php echo $playlists[$j][0]; ?></p>
							</center>

						</div>
						
					</div>
					<?php } ?></center>
				</div>
			</div>
		</div>

		<div class = "container">
		 	<table style="width:100%">
			  <tr>
			    <th>Song Name</th>
			    <th>Artist</th> 
			  </tr>
			  <tr>
			    <td>PassionFruit</td> 
			    <td>Drake</td>
			  </tr>

			</table>
		</div>

		
	</div>
</body>
</html>
