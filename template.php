<?php
	session_start();
	
	require 'mysqlCon.inc.php';
	
	require 'backSignedInCheck.inc.php';
?>

<!doctype html>

<html lang="en">
	<head>
		<meta charset="utf-8" />
	
		<title>Questions | Torque Xtreme</title>
		
		<script src="jquery.js"></script>
		
		<link rel="stylesheet" type="text/css" href="question.css?<?php echo time();?>" />

		<link rel="stylesheet" src="template.css?<?php echo time();?>" />
		
		<meta name="keywords" content="automobiles, bikes, motorcycles, cars, parts, automotive, questions, answers, reviews" />
		
		<link rel="shortcut icon" href="favicon.png" type="image/x-icon" />

		<link rel="icon" href="favicon.png" type="image/x-icon" />
	</head>
	
	<body>
		<div id="topStripe"></div>
		
		<div id="bottomStripe"></div>
		
		<div id="nav">
			<a href="home.php"><img id="logo" src="logoSmall.png" /></a>
			
			<div id="navLinks">
				<a href="questions.php"><span>Questions</span></a>
				
				<a href="reviews.php">Reviews</a>
				
				<a href="user.php?id=<?php echo $_SESSION['id']; ?>">Account</a>
				
				<a href="signOut.php">Sign Out</a>
			</div>
		</div>
		
		<div id="container">
			<div id="right">
				
			</div>
			
			<div id="left">
				
			</div>

			<div style="clear:both;"></div> <br /><br />
		</div>
		
		<script type="text/javascript" src="question.js"></script>

		<div id="footer">
			<p>&copy; Torque Xtreme 2014 &nbsp;&nbsp; | &nbsp;&nbsp; <a href="about.php">About</a> &nbsp;&nbsp; | &nbsp;&nbsp; <a href="contact.php">Contact</a> &nbsp;&nbsp; | &nbsp;&nbsp; <a href="sitemap.xml">Sitemap</p>
		</div>
	</body>
</html>