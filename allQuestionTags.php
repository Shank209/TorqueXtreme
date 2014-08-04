<?php
	session_start();
	
	require 'mysqlCon.inc.php';
	
	require 'midSignedInCheck.inc.php';

	$query = 'SELECT name FROM storedTags';

	$query_run = mysql_query($query);
?>

<!doctype html>

<html lang="en">
	<head>
		<meta charset="utf-8" />
	
		<title>All Tags - Questions | Torque Xtreme</title>
		
		<meta name="description" content="All tags of the questions on the site. Use this page to find questions from the field you are most familiar with." />

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
				<a href="questions.php"><span>Questions</span></a>
				
				<a href="reviews.php">Reviews</a>
				
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
							echo '<p style="text-align:center; font-family:Armata;">There are no tags yet</p>';
						}

						else
						{
							while($row = mysql_fetch_assoc($query_run))
							{
								echo '<a href="taggedQuestions.php?name='.$row['name'].'">'.$row['name'].'</a>';
							}	
						}
					?>
				</p>
				
				<br />
			</div>
			
			<div id="left">
				<p><a href="askQuestion.php">Ask a Question</a></p>
			
				<p><a href="questions.php">Most Recent</a></p>
				
				<p><a href="questions.php?sort=highest">Top-Geared</a></p>
				
				<p><a href="questions.php?sort=unanswered">Unanswered</a></p>
				
				<p><a href="allQuestionTags.php"><span style="color:#c92828;">All Tags</span></a></p>
			</div>

			<div style="clear:both;"></div> <br /><br />
		</div>
		
		<script type="text/javascript" src="allQuestionTags.js"></script>

		<div id="footer">
			<p>&copy; Torque Xtreme 2014 &nbsp;&nbsp; | &nbsp;&nbsp; <a href="about.php">About</a> &nbsp;&nbsp; | &nbsp;&nbsp; <a href="contact.php">Contact</a> &nbsp;&nbsp; | &nbsp;&nbsp; <a href="sitemap.xml">Sitemap</a></p>
		</div>
	</body>
</html>