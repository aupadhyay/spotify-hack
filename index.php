
<!DOCTYPE html>

<html>
	<head>
		<script
  src="https://code.jquery.com/jquery-2.2.4.js"
  integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI="
  crossorigin="anonymous"></script>
	<link rel="stylesheet" href="css/jquery-confirm.min.css">
	<script src="js/jquery-confirm.min.js"></script>
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
		.spotifyhr{
			width:100px;
			border-width:2.5px;
			border-color:#1ed760;
			margin-top: -10px;
		}

		.downloadbtn{
			font-family: "Montserrat";
			font-weight: 700;
			letter-spacing: 1px;
			background-color:#1ABD55;
			color:white !important;
			border-radius: 25px;
			padding:18px;
			transition: 0.3s ;
			text-decoration: none !important;

		}
		.downloadbtn:hover{
			background-color:#0C5727;
			text-decoration: none;
			color:white;
			transition: 0.3s ;
		}
		.downloadbtn:target{
			background-color:#0C5727;
			text-decoration: none;
			color:white;
			transition: 0.3s ;
		}
		</style>
	</head>

	<body>
	<div class = "">
		<center><img src = "http://www.chapelroswell.com/wp-content/uploads/2016/07/6274-spotify-logo-horizontal-white-rgb.png" style = "width:25%;margin-top:100px">
		<h1 class = "title">START</h1>
		<hr class = "spotifyhr">
	
		<a style="text-align:center; display: inline-block;" id="download_button" class = "downloadbtn" href="https://accounts.spotify.com/authorize/?client_id=a800171b426d44a4b01da7d38e9970b4&response_type=code&redirect_uri=http%3A%2F%2F198.199.95.116%2Fdashboard.php&scope=user-read-private%20user-read-email">LOG IN WITH SPOTIFY</a>
		</center>
	</div>

	</body>

</html>