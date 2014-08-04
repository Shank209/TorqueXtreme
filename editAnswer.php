<?php
	session_start();
	
	require 'mysqlCon.inc.php';
	
	require 'backSignedInCheck.inc.php';
	
	if(isset($_GET['id']))
	{
		$answerId = $_GET['id'];

		$answerId = preg_replace('#[^0-9]#i', '', $answerId);
		
		$query = 'SELECT userId, answer FROM answers WHERE id='.$answerId;
		
		$query_run = mysql_query($query);

		if(mysql_num_rows($query_run)==0)
		{				
			header('Location:pageUnavailable.php');

			die();
		}
		
		$answererId = mysql_result($query_run, 0, 'userId');
		
		if($answererId != $_SESSION['id'])
		{
			header('Location:answers.php'); //user is trying to change someone else's question
			
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
	
		<title>Edit Answer | Torque Xtreme</title>

		<meta name="description" content="Edit your answer." />
		
		<script src="jquery.js"></script>
		
		<link rel="stylesheet" type="text/css" href="editAnswer.css?<?php echo time();?>" />
		
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
				<h1>Edit your Answer:</h1>
				
				<hr /> <br />
			
				<form action="updateAnswer.php?id=<?php echo $answerId; ?>" method="POST" enctype="multipart/form-data">
					<textarea rows="10" cols="50" name="answer" maxlength="1000" style="width:683px; padding:5px;"><?php echo mysql_result($query_run, 0, 'answer');?></textarea>
					
					<br /><br />
					
					<?php
						$query = 'SELECT answerId FROM answerImages WHERE answerId='.$answerId;

						$query_run = mysql_query($query);

						if(mysql_num_rows($query_run)==1)
						{
							echo '<p style="color:black;">Change image: &nbsp;&nbsp;&nbsp;&nbsp; <input type="file" name="image" /> </p>';
						}
						else
						{
							echo '<p style="color:black;">Attach image: &nbsp;&nbsp;&nbsp;&nbsp; <input type="file" name="image" /> </p>';
						}

						echo '<br />'
					?>

					<input type="submit" value="Submit" />
				</form>
			</div>
			
			<div id="left">
				<p><a href="askQuestion.php">Ask a Question</a></p>
			
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