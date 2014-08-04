<?php
	session_start();
	
	require 'mysqlCon.inc.php';
	
	require 'backSignedInCheck.inc.php';
	
	if(!isset($user))
	{
		require 'fbGetUser.inc.php';
	}
?>

<!doctype html>

<html lang="en">
	<head>
		<meta charset="utf-8" />
	
		<title>Delete Account | Torque Xtreme</title>

		<meta name="description" content="Delete your account." />
		
		<script src="jquery.js"></script>
		
		<link rel="stylesheet" type="text/css" href="deleteAccount.css?<?php echo time();?>" />
		
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
				
				<a href="reviews.php">Reviews</a>
				
				<a href="user.php?id=<?php echo $_SESSION['id']; ?>">Account</a>
				
				<a href="signOut.php">Sign Out</a>
			</div>
		</div>
		
		<div id="container">
			<div id="right">
				<?php if($user): ?>
					<p>Are you sure you want to delete your account?</p>
					
					<br />
					
					<a href="removeUser.php">Yes</a>
				<?php else: ?>
					<form action="removeUser.php" method="POST">
						<p>Enter your password to continue: <input type="password" name="pass" /></p>
						
						<br />
						
						<input type="submit" value="Submit" />
					</form>
				<?php endif; ?>
				
				<br />
				
				<p id="delError"></p>
			</div>
			
			<div id="left">

			<div style="clear:both;"></div> <br /><br />
				
			</div>
		</div>
		
		<?php 
			if(isset($_SESSION['delError']))
			{
				if($_SESSION['delError']==1)
				{
					$_SESSION['delError']=0;
								
					echo '
						<script type="text/javascript">
							$("#delError").text("Pasword is incorrect");		
						</script>
					';
				}
				else
				{
					echo '
						<script type="text/javascript">
							$("#delError").text("");		
						</script>
					';
				}
			}
			else
			{
				echo '
					<script type="text/javascript">
						$("#delError").text("");		
					</script>
				';
			}
		?>
		
		<script type="text/javascript" src="deleteAccount.js"></script>

		<div id="footer">
			<p>&copy; Torque Xtreme 2014 &nbsp;&nbsp; | &nbsp;&nbsp; <a href="about.php">About</a> &nbsp;&nbsp; | &nbsp;&nbsp; <a href="contact.php">Contact</a> &nbsp;&nbsp; | &nbsp;&nbsp; <a href="sitemap.xml">Sitemap</a></p>
		</div>
	</body>
</html>