<?php
	session_start();
	
	require 'mysqlCon.inc.php';
	
	require 'midSignedInCheck.inc.php';

	if(!isset($user))
	{
		require 'fbGetUser.inc.php';
	}

	if(!isset($fbName))
	{
		require 'fbGetUserInfo.inc.php';
	}
	
	if(isset($_GET['id']))
	{
		$userId = $_GET['id'];

		$userId = preg_replace('#[^0-9]#i', '', $userId);
		
		$query = 'SELECT fbId, username, name, place, points, about, vehicles FROM users WHERE id='.$userId;
		
		$query_run = mysql_query($query);

		if(mysql_num_rows($query_run)==0)
		{
			header('Location:userUnavailable.php');
		}
		
		$username = mysql_result($query_run, 0, 'username');
		
		$name = mysql_result($query_run, 0, 'name');
		
		$place = mysql_result($query_run, 0, 'place');
		
		$points = mysql_result($query_run, 0, 'points');
		
		$fbId = mysql_result($query_run, 0, 'fbId');
		
		$about = mysql_result($query_run, 0, 'about');

		$vehiclesList = mysql_result($query_run, 0, 'vehicles');

		$query = 'SELECT id FROM questions WHERE userId='.$userId;
		
		$query_run = mysql_query($query);
		
		$questions = mysql_num_rows($query_run);
		
		$query = 'SELECT id FROM answers WHERE userId='.$userId;
		
		$query_run = mysql_query($query);
		
		$answers = mysql_num_rows($query_run);
		
		$query = 'SELECT id FROM reviews WHERE userId='.$userId;
		
		$query_run = mysql_query($query);
		
		$reviews = mysql_num_rows($query_run);
		
		$query = 'SELECT image FROM userImages WHERE userId='.$userId;
		
		$query_run = mysql_query($query);
		
		if(mysql_num_rows($query_run)==0)
		{
			if($fbId==0)
			{
				$imageUrl = 'defaultImage.png';
			}
			else
			{
				$imageUrl = 'http://graph.facebook.com/'.$fbId.'/picture?type=large';
			}
		}
		else
		{
			$image = mysql_result($query_run, 0, 'image');
			
			$imageUrl = 'data:image/jpeg;base64,'.base64_encode($image);
		}
	}
	else
	{
		header('Location:home.php'); //user id is not set_error_handler
		
		die();
	}
?>

<!doctype html>

<html lang="en">
	<head>
		<meta charset="utf-8" />
	
		<title>
			<?php
				if($name=='N/A')
				{
					echo 'User ';
				}
				else
				{
					echo $name.' ';
				}
			?>
		    
		    | Torque Xtreme
		</title>

		<meta name="description" content="User's profile information" />
		
		<script src="jquery.js"></script>
		
		<link rel="stylesheet" type="text/css" href="user.css?<?php echo time();?>" />
		
		<meta name="keywords" content="automobiles, bikes, motorcycles, cars, parts, automotive, questions, answers, reviews" />
		
		<link rel="shortcut icon" href="favicon.png" type="image/x-icon" />

		<link rel="icon" href="favicon.png" type="image/x-icon" />
		
		<style type="text/css">
			#innerLeft #picture
			{
				background: url('<?php echo $imageUrl;?>') no-repeat center center;
				width:202px;
				height:202px;
				background-size:cover;
				border:10px solid #2b2b2b;
				display:block;
				margin:auto;
			}
		</style>
	</head>
	
	<body>
		<div id="topStripe"></div>
		
		<div id="bottomStripe"></div>
		
		<div id="nav">
			<a href="home.php"><img id="logo" src="logoSmall.png" /></a>
			
			<div id="navLinks">
				<a href="questions.php">Questions</a>
				
				<a href="reviews.php">Reviews</a>
				
				<?php if(isset($_SESSION['id'])): ?>
					<a href="user.php?id=<?php echo $_SESSION['id']; ?>"><span>Account</span></a>
					
					<a href="signOut.php">Sign Out</a>
				<?php endif; ?>
			</div>
		</div>
		
		<div id="container">
			<div id="right">
				<div id="innerLeft">
					<div id="picture"> </div>

					<br />

					<p id="about"><?php echo $about; ?></p> <br />

					<?php 
						if($fbId!=0)
						{
							echo '<a style="font-family:Armata;color:#3b5998;font-size:14px;text-decoration:none;" href="'.$fbLink.'" target="_blank">Find on Facebook</a>';
						}
					?>
				</div>
				
				<div id="innerRight">
					<?php 
						echo '<h1>'.$username.'</h1> <br />'; 
					
						echo '<p><span>Name:</span> '.$name.'</p> <br />';
						
						echo '<p><span>Lives In:</span> '.$place.'</p> <br />';
						
						echo '<p><span>Torque:</span> <br /> <span style="color:#2b2b2b; font-size:66px;">'.$points.'</span></p>';
						
						echo '<p><a href="userQuestions.php?id='.$userId.'"><span>Questions:</span> <span style="color:#2b2b2b; font-size:26px;">'.$questions.'</span></a></p><br />';
						
						echo '<p><a href="userAnswers.php?id='.$userId.'"><span>Answers:</span> <span style="color:#2b2b2b; font-size:26px;">'.$answers.'</span></a></p><br />';
						
						echo '<p><a href="userReviews.php?id='.$userId.'"><span>Reviews:</span> <span style="color:#2b2b2b; font-size:26px;">'.$reviews.'</span></a></p><br />';

						echo '<p><span>Vehicles Owned:</span></p><br />';

						echo '<div id="vehicles">';

						$vehicles = explode(',', $vehiclesList);

						foreach($vehicles as $vehicle)
						{
							$vehicle = trim($vehicle);

							echo '<p>'.$vehicle.'</p>';
						}

						echo '</div> <br />';
					?>
				</div>
			</div>
			
			<div id="left">
				<?php 
					if(isset($_SESSION['id']))
					{
						if($userId == $_SESSION['id'])
						{
							echo '
								<p id="editPicture">Edit Picture</p>
								
								<form id="uploadControls" action="updateImage.php" method="POST" enctype="multipart/form-data">
									<input type="file" name="image"/> <br />
								
									<input type="submit" name="submit" value="Upload" />
								</form>
								
								<span id="error">Invalid file selected or image is larger than 3 MB.</span>
								
								<p><a href="editInfo.php">Edit Info.</a></p>
							';
						}
					}
				?>
			</div>

			<div style="clear:both;"></div> <br /><br />
		</div>
		
		<?php
			if(isset($_SESSION['error']))
			{
				if($_SESSION['error']==1)
				{
					echo '<script type="text/javascript">
						$("#uploadControls").show();
					
						$("#error").show();
					</script>';
					
					$_SESSION['error']=0;
				}
			}
		?>
		
		<script type="text/javascript" src="user.js"></script>

		<div id="footer">
			<p>&copy; Torque Xtreme 2014 &nbsp;&nbsp; | &nbsp;&nbsp; <a href="about.php">About</a> &nbsp;&nbsp; | &nbsp;&nbsp; <a href="contact.php">Contact</a> &nbsp;&nbsp; | &nbsp;&nbsp; <a href="sitemap.xml">Sitemap</p>
		</div>
	</body>
</html>