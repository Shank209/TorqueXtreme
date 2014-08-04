<?php
	session_start();
	
	require 'mysqlCon.inc.php';
	
	require 'frontSignedInCheck.inc.php';

	if(isset($_GET['id'])&&isset($_GET['key']))
	{
		$userId = $_GET['id'];

		$userId = preg_replace('#[^0-9]#i', '', $userId);

		$key = $_GET['key'];

		$key = mysql_real_escape_string($key);

		$query = 'SELECT userId FROM newPassword WHERE userId='.$userId.' AND `key`="'.$key.'"';

		$query_run = mysql_query($query);

		if(mysql_num_rows($query_run)==0)
		{
			header('Location:pageUnavailable.php');

			die();
		}
	}
	else
	{
		header('Location:pageUnavailable.php');

		die();
	}
?>

<!doctype html>

<html lang="en">
	<head>
		<meta charset="utf-8" />
	
		<title>Questions | Torque Xtreme</title>
		
		<script src="jquery.js"></script>
		
		<meta name="keywords" content="automobiles, bikes, motorcycles, cars, parts, automotive, questions, answers, reviews" />
		
		<link rel="shortcut icon" href="favicon.png" type="image/x-icon" />

		<link rel="icon" href="favicon.png" type="image/x-icon" />
		
		<style type="text/css">
			@font-face
			{
				font-family:'Armata';
				src:url('armata.otf');
			}

			@font-face
			{
				font-family:'Yukari';
				src:url('yukari.ttf');
			}

			*
			{
				margin:0px;
				padding:0px;
			}

			html, body
			{
				min-height:100%;
				min-width:100%;
				position:absolute;
			}

			body
			{
				background-color:#ffffff;
				background-image:url('whiteGrid.png');
			}

			#right input[type="button"]
			{
				font-family:Armata;
				padding:5px;
				border:none;
				background-color:#c92828;
				color:#f2f2f2;
				cursor:pointer;
			}

			#topStripe
			{
				width:100%;
				position:absolute;
				top:0px;
				height:50px;
				background-color:#2b2b2b;
				z-index:1;
			}

			#bottomStripe
			{
				width:100%;
				position:absolute;
				bottom:0px;
				height:5px;
				background-color:#c92828;
			}

			#nav
			{
				width:960px;
				display:block;
				margin:auto;
				height:50px;
				z-index:10;
				position:relative;
			}

			#logo
			{
				width:200px;
				float:left;
				padding:5px;
				background-color:#f2f2f2;
				border:10px solid #2b2b2b;
				background-image:url('whiteGrid.png');
			}

			#navLinks
			{
				float:right;
				margin-top:10px;
			}

			#navLinks a
			{
				color:#f2f2f2;
				margin:25px;
				font-family:Yukari;
				text-decoration:none;
				font-size:20px;
			}

			#navLinks a span
			{
				color:#c92828;
			}

			#container
			{
				width:960px;
				display:block;
				margin:auto;
				margin-top:85px;
			}

			#right
			{
				width:740px;
				float:right;
				padding:10px;
				padding-top:0px;
			}

			#left
			{
				width:180px;
				float:left;
				padding:10px;
				padding-top:0px;
				line-height:50px;
			}
			
			#footer
			{
				text-align:center;
				font-family:Armata;
				font-size:12px;
				opacity:0.5;
				position:absolute;
				bottom:10px;
				width:100%;
			}

			#footer a
			{
				text-decoration:none;
				color:black;
			}
		</style>

		<script type="text/javascript">
			$(document).ready(function() {
				$('#submit').click(function() {
					$.ajax({
						type:'post',
						url:'updateNewPassword.php',
						data:{'userId':<?php echo $userId;?>, 'key':"<?php echo $key;?>", 'newPass':$('#newPass').val(), 'conNewPass':$('#conNewPass').val()},
						cache:'false',
						
						success:function(response)
						{
							$('#ajax').html(response);
						}
					});

					$(this).attr('disabled', true);

					$(this).val('processing...');
				});
			});
		</script>
	</head>
	
	<body>
		<div id="topStripe"></div>
		
		<div id="bottomStripe"></div>
		
		<div id="nav">
			<a href="home.php"><img id="logo" src="logoSmall.png" /></a>
			
			<div id="navLinks">
				<a href="questions.php">Questions</a>
				
				<a href="reviews.php">Reviews</a>
			</div>
		</div>
		
		<div id="container">
			<div id="right" style="text-align:center;">
				<p style="font-family:Armata;">Enter a new password:</p> <br />
					<input type="password" id="newPass" placeholder="Password" maxlength="15"/> <br /> <br />

					<input type="password" id="conNewPass" placeholder="Confirm Password" maxlength="15"/> <br /> <br />

					<input type="button" value="Submit" id="submit" /> <br /> <br />

					<p id="error" style="font-family:Armata;font-size:14px;color:#c92828;"></p>
			</div>
			
			<div id="left">
				
			</div>

			<div style="clear:both;"></div> <br /><br />
		</div>
		
		<script type="text/javascript" src="newPassword.js"></script>

		<div id="ajax"></div>

		<div id="footer">
			<p>&copy; Torque Xtreme 2014 &nbsp;&nbsp; | &nbsp;&nbsp; <a href="about.php">About</a> &nbsp;&nbsp; | &nbsp;&nbsp; <a href="contact.php">Contact</a> &nbsp;&nbsp; | &nbsp;&nbsp; <a href="sitemap.xml">Sitemap</a></p>
		</div>
	</body>
</html>