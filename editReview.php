<?php
	session_start();
	
	require 'mysqlCon.inc.php';
	
	require 'backSignedInCheck.inc.php';
	
	if(isset($_GET['id']))
	{
		$reviewId = $_GET['id'];

		$reviewId = preg_replace('#[^0-9]#i', '', $reviewId);
		
		$query = 'SELECT userId, title, `desc` FROM reviews WHERE id='.$reviewId;
		
		$query_run = mysql_query($query);

		if(mysql_num_rows($query_run)==0)
		{				
			header('Location:pageUnavailable.php');

			die();
		}
		
		$writerId = mysql_result($query_run, 0, 'userId');
		
		if($writerId != $_SESSION['id'])
		{
			header('Location:pageUnavailable.php'); //user is trying to change someone else's question
			
			die();
		}
	}
	else
	{
		header('Location:pageUnavailable.php'); //question id is not set
		
		die();
	}
?>

<!doctype html>

<html lang="en">
	<head>
		<meta charset="utf-8" />
	
		<title>Edit Review | Torque Xtreme</title>
		
		<meta name="description" content="Edit your review." />

		<script src="jquery.js"></script>
		
		<link rel="stylesheet" type="text/css" href="editReview.css?<?php echo time();?>" />
		
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
				<h1>Edit your Review:</h1>
				
				<hr /> <br />
			
				<form action="updateReview.php?id=<?php echo $reviewId; ?>" method="POST" enctype="multipart/form-data">
					<p>Title:</p>
					
					<br />
					
					<input type="text" name="title" value="<?php echo mysql_result($query_run, 0, 'title');?>" style="width:690px;padding:5px;"/>
					
					<br /><br />
					
					<p>Details:</p>
					
					<br />
					
					<textarea rows="10" cols="50" name="desc" style="width:683px;"><?php echo mysql_result($query_run, 0, 'desc');?></textarea>
					
					<br /><br />

					<?php
						$query = 'SELECT reviewId FROM reviewImages WHERE reviewId='.$reviewId;

						$query_run = mysql_query($query);

						if(mysql_num_rows($query_run)==1)
						{
							echo '<p style="color:black;">Change image: &nbsp;&nbsp;&nbsp;&nbsp; <input type="file" name="image" /> </p>';
						}
						else
						{
							echo '<p style="color:black;">Attach image: &nbsp;&nbsp;&nbsp;&nbsp; <input type="file" name="image" /> </p>';
						}
					?>
					
					<br />
					
					<input type="submit" value="Submit" />
				</form>
			</div>
			
			<div id="left">
				<p><a href="writeReview.php">Write a Review</a></p>
			
				<p><a href="reviews.php">Most Recent</a></p>
				
				<p><a href="reviews.php?sort=highest">Top-Geared</a></p>
				
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