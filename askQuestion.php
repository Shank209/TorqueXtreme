<?php
	session_start();
	
	require 'mysqlCon.inc.php';
	
	require 'backSignedInCheck.inc.php';
?>

<!doctype html>

<html lang="en">
	<head>
		<meta charset="utf-8" />
	
		<title>Ask a question | Torque Xtreme</title>

		<meta name="description" content="Have a doubt related to automobiles? Need to get something clarified? Just post it here and other users will help you out." />
		
		<script src="jquery.js"></script>
		
		<link rel="stylesheet" type="text/css" href="askQuestion.css?<?php echo time();?>" />
		
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
				<h1>Ask a Question:</h1>
				
				<p id="message" style="color:black;margin-top:10px;">Feel free to ask any question you'd like to. But please make sure that the same question hasn't been asked already and that the question is automotive-related. That's what this site is all about afterall.</p>

				<br /><hr /> <br />
				
				<form action="addQuestion.php" method="POST" enctype="multipart/form-data">
					<p>Title:</p>
					
					<br />
					
					<input style="width:690px;padding:5px; font-family:Armata; word-spacing:5px; line-height:23px;" type="text" name="title" maxlength="250"/>
					
					<br /> <br />
					
					<p>Details:</p>
					
					<br />
					
					<textarea rows="10" cols="60" name="desc" maxlength="1000" style="width:683px; font-family:Armata; word-spacing:5px; line-height:23px;"></textarea>
					
					<br /> <br />

					<p style="color:black;">Attach image: &nbsp;&nbsp;&nbsp;&nbsp; <input type="file" name="image"/> </p>

					<br />
					
					<p>Tags:</p>
					
					<br /> 
					
					<input type="text" name="tagList" placeholder="Enter tags seperated by commas. Eg: Yamaha, R15, Delhi"  style="width:500px;padding:5px;"/>
					
					<br /> <br />
					
					<input type="submit" value="Submit" />

					<br /> <br />
				</form>
			</div>
			
			<div id="left">
				<p><a href="askQuestion.php"><span style="color:#c92828;">Ask a Question</span></a></p>
			
				<p><a href="questions.php">Most Recent</a></p>
				
				<p><a href="questions.php?sort=highest">Top-Geared</a></p>
				
				<p><a href="questions.php?sort=unanswered">Unanswered</a></p>
				
				<p><a href="allQuestionTags.php">All Tags</a></p>
			</div>

			<div style="clear:both;"></div> <br /><br />
		</div>
		
		<script type="text/javascript">
			$('#navLinks a, #left p a').hover(function() {
				$(this).css('color','#c92828');
			}, function() {
				$(this).css('color','#f2f2f2');
			});
		</script>

		<div id="footer">
			<p>&copy; Torque Xtreme 2014 &nbsp;&nbsp; | &nbsp;&nbsp; <a href="about.php">About</a> &nbsp;&nbsp; | &nbsp;&nbsp; <a href="contact.php">Contact</a> &nbsp;&nbsp; | &nbsp;&nbsp; <a href="sitemap.xml">Sitemap</a></p>
		</div>
	</body>
</html>