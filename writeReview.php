<?php
	session_start();
	
	require 'mysqlCon.inc.php';
	
	require 'backSignedInCheck.inc.php';
?>

<!doctype html>

<html lang="en">
	<head>
		<meta charset="utf-8" />
	
		<title>Write a Review | Torque Xtreme</title>

		<meta name="description" content="Write a review of your sweet ride and share with other auto-enthusiasts your views and opinions." />
		
		<script src="jquery.js"></script>
		
		<link rel="stylesheet" type="text/css" href="writeReview.css?<?php echo time();?>" />
		
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
				<a href="questions.php">Questions</a>
				
				<a href="reviews.php"><span>Reviews</span></a>
				
				<a href="user.php?id=<?php echo $_SESSION['id']; ?>">Account</a>
				
				<a href="signOut.php">Sign Out</a>
			</div>
		</div>
		
		<div id="container">
			<div id="right">
				<h1>Write a Review:</h1>
				
				<p id="message" style="color:black;margin-top:10px;">Review any vehicle that you've used and share your views and opinions with the other enthusiasts. It doesn't necessarily have to be a review. You can also share your experiences like a long ride you just went on, etc.</p>

				<br /><hr /> <br />
				
				<form action="addReview.php" method="POST" enctype="multipart/form-data">
					<p>Title:</p>
					
					<br />
					
					<input style="width:690px;padding:5px;" type="text" name="title" maxlength="150"/>
					
					<br /> <br />
					
					<p>Content:</p>
					
					<br />
					
					<textarea rows="10" cols="61" name="desc" maxlength="5000" style="width:683px;"></textarea>
					
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
				<p><a href="writeReview.php"><span style="color:#c92828;">Write a Review</span></a></p>
			
				<p><a href="reviews.php"  id="recent">Most Recent</a></p>
				
				<p><a href="reviews.php?sort=highest" id="highest">Top-Geared</a></p>
				
				<p><a href="allReviewTags.php">All Tags</a></p>
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