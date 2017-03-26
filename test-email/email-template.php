<html>
<head>
    <title>Spotify Download</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

    <style>

        @font-face{
            font-family: "Montserrat";
            src : url("http://198.199.95.116/fonts/Montserrat/Montserrat-Bold.ttf")
        }
         @font-face{
            font-family: "Muli";
            src : url("http://198.199.95.116/fonts/Muli/Muli-ExtraBold.ttf");
            font-weight: 800;
        }
        @font-face{
            font-family: "Muli";
            src : url("http://198.199.95.116/fonts/Muli/Muli-Light.ttf");
            font-weight: 300;
        }
        @font-face{
            font-family: "Muli";
            src : url("http://198.199.95.116/fonts/Muli/Muli-Regular.ttf");
            font-weight: 400;
        }

        
        .logo{
            width:150px;
        }
        .emailheader{
            font-family: "Montserrat", arial;
            font-weight: 700;
            opacity: 0.74;

        }

        h2{
            font-family: "Muli", arial;
            font-weight: 300;
            font-size:18px;
        }

        .footer{
            background-color:rgba(1,1,1,0.07);
            padding:50px;
            margin-top: 80px
        }

        a{
            font-family: "Muli", arial;
            font-weight: 800;
            color:rgba(1,1,1,0.54);
        }

        p{
            font-family: "Muli", arial;
            font-weight: 400;
            color:rgba(1,1,1,0.54);
            line-height: 2em

        }

        h1{
            margin-bottom:  50px
        }
    </style>
</head>
<body>
    <div class = "container">
        <div class = "row">
            <div class = "col-md-2">
            </div>
            <div class = "col-md-8" id="col8">
                
                    <img src = "http://198.199.95.116/green.png" class = "logo">
                    <center> 
                    <h1 class = "emailheader"> Your Spotify Playlist is here!</h1>
                    <div id = "thedate">
                    </div>
                    <script>
                        var today = new Date();
                        var dd = today.getDate();
                        var mm = today.getMonth()+1; //January is 0!
                        var yyyy = today.getFullYear();

                        if(dd<10) {
                            dd='0'+dd
                        } 

                        if(mm<10) {
                            mm='0'+mm
                        } 

                        today = mm+'/'+dd+'/'+yyyy;
                        var todaydate = document.createElement("h2")
                        todaydate.innerHTML = today;
                        document.getElementById("thedate").appendChild(todaydate);

                    </script>
                        
                       
                        <h2>Download $playlist_name <a href = "$finalLink">here</a></h2>
                        <h2>Notice: This link will expire within 24 hours</h2>

                        <div class = "footer">
                        <img src="http://198.199.95.116/black.png" width="100px" style="display:block; opacity: 0.4; filter:alpha(opacity=50);">
                        <hr style="border-color: rgba(1,1,1, 0.1); width: 25%; border-width: 2px;">
                            <p style="display:block">This email was sent to <a href = "mailto:$email">$email</a> <br>If you have questions or complaints, please <a href = "mailto:spotifyhackslol@gmail.com">contact us.</a></p>

                        </div>




                    </center>
         
            </div>
            <div class = "col-md-2">
            </div>
        </div>
        
    </div>
    
</body>
</html>