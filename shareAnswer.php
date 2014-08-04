<?php
	session_start();

	require 'mysqlCon.inc.php';

	require 'backSignedInCheck.inc.php';

	if(!isset($_SESSION['shareName']))
	{
		header('Location:askQuestion.php');

		die();
	}
?>

<html lang="en">
	<head>
		<meta charset="utf-8" />
	
		<title>Share Your Answer | Torque Xtreme</title>

		<mate name="description" content="Share your answer with your friends on facebook." />

		<script src="jquery.js" type="text/javascript"></script>
		
		<meta name="keywords" content="automobiles, bikes, motorcycles, cars, parts, automotive, questions, answers, reviews" />
		
		<link rel="shortcut icon" href="favicon.png" type="image/x-icon" />

		<link rel="icon" href="favicon.png" type="image/x-icon" />

		<style type="text/css">
			@font-face
			{
				font-family:'Armata';
				src:url('armata.otf');
			}

			body
			{
				background-image:url('whiteGrid.png');
				padding-top:50px;
			}

			p
			{
				font-family:Armata;
				text-align:center;
			}
		</style>
	</head>

	<body>
		<script type="text/javascript">
		$(document).ready(function(){
			window.fbAsyncInit = function() {
				FB.init({
					appId      : '501151410018317',
					xfbml      : true,
				    version    : 'v2.0'
				});

				FB.ui(
				{
					method: 'feed',
					name: $('#caption').val(),
					caption: ' ',
					description: (
						$('#desc').val()
					),
					link: 'http://www.torquextreme.com/question.php?id=<?php echo $_SESSION['shareId']; ?>',
					picture: 'http://www.torquextreme.com/icon.png'
					}, function(response) {
						window.location="http://www.torquextreme.com/question.php?id=<?php echo $_SESSION['shareId']; ?>";
					}
				);
			};

			(function(d, s, id){
				var js, fjs = d.getElementsByTagName(s)[0];
				if (d.getElementById(id)) {return;}
				js = d.createElement(s); js.id = id;
				js.src = "http://connect.facebook.net/en_US/sdk.js";
				fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));
		});
		</script>

		<input type="hidden" id="caption" value="<?php echo $_SESSION['shareName'] ?> answered a question on Torque Xtreme" />

		<input type="hidden" id="desc" value="<?php echo $_SESSION['shareDesc']; ?>" />

		<p id="message">Your answer has been posted. Would you like to share this on Facebook? (Must have popups enabled)</p>
		
		<p><a href="question.php?id=<?php echo $_SESSION['shareId']; ?>" style="text-decoration:none;color:#c92828;font-size:14px;">No, take me to the answer.</a></p>
	</body>
</html>