<?php
	session_start();
	
	require 'mysqlCon.inc.php';
	
	require 'backSignedInCheck.inc.php';
	
	if(!isset($user))
	{
		require 'fbGetUser.inc.php';
	}
	
	$query = 'SELECT name, place, about, vehicles FROM users WHERE id='.$_SESSION['id'];
	
	$query_run = mysql_query($query);

	if(mysql_num_rows($query_run)==0)
	{				
		header('Location:pageUnavailable.php');

		die();
	}
	
	$name = mysql_result($query_run, 0, 'name');
	
	$place = mysql_result($query_run, 0, 'place');

	$about = mysql_result($query_run, 0, 'about');
?>

<!doctype html>

<html lang="en">
	<head>
		<meta charset="utf-8" />
	
		<title>Edit Info | Torque Xtreme</title>

		<meta name="description" content="Edit your profile information." />
		
		<script src="jquery.js"></script>
		
		<link rel="stylesheet" type="text/css" href="editInfo.css?<?php echo time();?>" />
		
		<meta name="keywords" content="automobiles, bikes, motorcycles, cars, parts, automotive, questions, answers, reviews" />
		
		<link rel="shortcut icon" href="favicon.png" type="image/x-icon" />

		<link rel="icon" href="favicon.png" type="image/x-icon" />
		
		<script type="text/javascript">
			$(document).ready(function() {
				<?php if(!$user): ?>
					$('#submit').click(function() {
						$.ajax({
							type:'POST',
							url:'updateInfo.php',
							data:{
								'username': $("#username").val(), 
								'name': $("#name").val(), 
								'place': $("#place").val(), 
								'newPass': $("#newPass").val(), 
								'conNewPass': $("#conNewPass").val(), 
								'currPass': $("#currPass").val(),
								'about': $("#about").val(),
								'vehicles': $("#vehicles").val()},
							cache:'false',
							
							success:function(response)
							{
								$("#ajax").html(response);
							}
						});
					});
				<?php else: ?>
					$('#submit').click(function() {
						$.ajax({
							type:'POST',
							url:'updateInfo.php',
							data:{
								'username': $("#username").val(), 
								'name': $("#name").val(), 
								'place': $("#place").val(),
								'about': $("#about").val(),
								'vehicles': $("#vehicles").val()}, 
							cache:'false',
							
							success:function(response)
							{
								$("#ajax").html(response);
							}
						});
					});
				<?php endif; ?>
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
				
				<a href="user.php?id=<?php echo $_SESSION['id']; ?>"><span>Account</span></a>
				
				<a href="signOut.php">Sign Out</a>
			</div>
		</div>
		
		<div id="container">
			<div id="right">
				<table cellspacing="40px">
				<tr> <td>Username:</td> 
				
				<td><input type="text" id="username" value="<?php echo $_SESSION['username'];?>" maxlength="17"/></td> </tr>
				
				<tr><td>Name:</td>
				
				<td><input type="text" id="name" value="<?php echo $name;?>" maxlength="50"/></td> </tr>
				
				<tr><td>Place:</td>
				
				<td><input type="text" id="place" value="<?php echo $place;?>" maxlength="50"/></td> </tr>

				<tr><td>About Yourself:</td>
				
				<td><input type="text" id="about" value="<?php echo $about;?>" maxlength="200"/></td> </tr>

				<tr><td>Vehicles Owned:</td>
				
				<td><textarea rows="5" id="vehicles" placeholder="Enter the names seperated by commas. Eg: FZ, Bullet 350, i20" maxlength="500"></textarea></td> </tr>
				
					<?php if(!$user): ?>
						<tr><td>New Password (optional):</td>
						
						<td><input type="password" id="newPass" maxlength="15"/></td> </tr>
						
						<tr><td>Re-enter New Password:</td>

						<td><input type="password" id="conNewPass" maxlength="15"/></td> </tr>
						
						<tr><td>Current Password:</td>
						
						<td><input type="password" id="currPass" maxlength="15"/></td> </tr>
					<?php endif; ?>
				</table>
				
				<input type="button" id="submit" value="Submit" />
				
				<br />
				
				<p id="error"></p>
			</div>
			
			<div id="left">
				<p><a href="deleteAccount.php">Delete Account</a></p>
			</div>

			<div style="clear:both;"></div> <br /><br />
		</div>
		
		<script type="text/javascript" src="editInfo.js"></script>
		
		<div id="ajax"></div>

		<div id="footer">
			<p>&copy; Torque Xtreme 2014 &nbsp;&nbsp; | &nbsp;&nbsp; <a href="about.php">About</a> &nbsp;&nbsp; | &nbsp;&nbsp; <a href="contact.php">Contact</a> &nbsp;&nbsp; | &nbsp;&nbsp; <a href="sitemap.xml">Sitemap</a></p>
		</div>
	</body>
</html>