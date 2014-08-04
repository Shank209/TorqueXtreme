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
	
		<title>Share Your Review | Torque Xtreme</title>

		<meta name="description" content="Share your review with your friends on facebook." />

		<script src="jquery.js" type="text/javascript"></script>

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

			#message
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
					appId      : '770760852955644',
					xfbml      : true,
				    version    : 'v2.0'
				});

				FB.ui(
				{
					method: 'feed',
					name: $('#caption').val(),
					caption: $('#title').val(),
					description: (
						$('#desc').val()
					),
					link: 'http://localhost/project/XT/review.php?id=<?php echo $_SESSION['shareId']; ?>',
					picture: 'http://s28.postimg.org/gn1vf06r1/post.jpg'
					}, function(response) {
						window.location="http://localhost/project/XT/review.php?id=<?php echo $_SESSION['shareId']; ?>";
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

		<input type="hidden" id="caption" value="<?php echo $_SESSION['shareName'] ?> wrote a review on Xtreme Torque" />

		<input type="hidden" id="title" value="<?php echo $_SESSION['shareTitle'] ;?>" />

		<input type="hidden" id="desc" value="<?php echo $_SESSION['shareDesc']; ?>" />

		<p id="message">Your review has been posted. Would you like to share this on Facebook?</p>
	</body>
</html>