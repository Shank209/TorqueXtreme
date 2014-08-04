<?php
	session_start();
	
	require 'mysqlCon.inc.php';
	
	require 'backSignedInCheck.inc.php';

	$query = 'SELECT name FROM storedReviewsTags';

	$query_run = mysql_query($query);
?>

<!doctype html>

<html lang="en">
	<head>
		<meta charset="utf-8" />
	
		<title>All Tags - Reviews | Torque Xtreme</title>

		<meta name="description" content="All tags of the reviews on the site. Use this page to find reviews from the field you are most interested in." />
		
		<script src="jquery.js"></script>
		
		<link rel="stylesheet" type="text/css" href="allQuestionTags.css?<?php echo time();?>" />
		
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
				
				<?php if(isset($_SESSION['id'])): ?>
					<a href="user.php?id=<?php echo $_SESSION['id']; ?>">Account</a>
					
					<a href="signOut.php">Sign Out</a>
				<?php endif; ?>
			</div>
		</div>
		
		<div id="container">
			<div id="right">
				<p id="header">All tags of present questions:</p>

				<br /> <br />

				<p id="tags">
					<?php
						if(mysql_num_rows($query_run)==0)
						{
							echo '<p style="text-align:center; font-family:Armata;">There are no tags yet.</p>';
						}

						else
						{
							while($row = mysql_fetch_assoc($query_run))
							{
								echo '<a href="taggedReviews.php?name='.$row['name'].'">'.$row['name'].'</a>';
							}
						}
					?>
				</p>
				
				<br />
			</div>
			
			<div id="left">
				<p><a href="writeReview.php">Write A Review</a></p>
			
				<p><a href="reviews.php">Most Recent</a></p>
				
				<p><a href="reviews.php?sort=highest">Top-Geared</a></p>
				
				<p><a href="allReviewTags.php"><span style="color:#c92828;">All Tags</span></a></p>
			</div>

			<div style="clear:both;"></div> <br /><br />
		</div>
		
		<script type="text/javascript" src="allQuestionTags.js"></script>

		<div id="footer">
			<p>&copy; Torque Xtreme 2014 &nbsp;&nbsp; | &nbsp;&nbsp; <a href="about.php">About</a> &nbsp;&nbsp; | &nbsp;&nbsp; <a href="contact.php">Contact</a> &nbsp;&nbsp; | &nbsp;&nbsp; <a href="sitemap.xml">Sitemap</a></p>
		</div>
	</body>
</html>