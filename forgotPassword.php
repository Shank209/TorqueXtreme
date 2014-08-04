<?php
	session_start();
	
	require 'mysqlCon.inc.php';

	require 'frontSignedInCheck.inc.php';
?>

<!doctype html>

<html lang="en">
	<head>
		<meta charset="utf-8" />
	
		<title>Forgot Password | Torque Xtreme</title>
		
		<script src="jquery.js"></script>
		
		<link rel="stylesheet" type="text/css" href="forgotPassword.css?<?php echo time();?>" />
		
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
			</div>
		</div>
		
		<div id="container">
			<div id="right">
				<?php
					if(isset($_POST['recEmail']))
					{
						$email = $_POST['recEmail'];

						$email = mysql_real_escape_string($email);

						if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
						{
							echo '
								<form action="" method="POST" id="rec">
									<p>Please submit the Email Id that you used while registering. A mail will be sent to that ID which will guide you further.</p> <br />

									<div style="text-align:center;"><input type="text" name="recEmail" placeholder="Email Id"/> &nbsp;&nbsp;&nbsp;&nbsp;

									<input type="submit" value="Send" /></div> <br />

									<p style="font-family:Armata; font-size:14px; color:#c92828; text-align:center;">Please enter a valid Email ID.</p>
								</form>
							';
						}
						else
						{
							$query = 'SELECT id FROM users WHERE BINARY email="'.$email.'"';

							$query_run = mysql_query($query);

							if(mysql_num_rows($query_run)==0)
							{
								echo '
									<form action="" method="POST" id="rec">
										<p>Please submit the Email Id that you used while registering. A mail will be sent to that ID which will guide you further.</p> <br />

										<div style="text-align:center;"><input type="text" name="recEmail" placeholder="Email Id"/> &nbsp;&nbsp;&nbsp;&nbsp;

										<input type="submit" value="Send" /></div> <br />

										<p style="font-family:Armata; font-size:14px; color:#c92828; text-align:center;">The email ID you entered is not registered on this site.</p>
									</form>
								';
							}
							else
							{
								$userId = mysql_result($query_run, 0, 'id');

								$query = 'SELECT userId FROM newPassword WHERE userId='.$userId;

								$query_run = mysql_query($query);

								$key = bin2hex(openssl_random_pseudo_bytes(16));

								if(mysql_num_rows($query_run)==0)
								{
									$insert = 'INSERT INTO newPassword VALUES('.$userId.', "'.$key.'")';

									mysql_query($insert);
								}
								else
								{
									$update = 'UPDATE newPassword SET `key`="'.$key.'" WHERE userId='.$userId;

									mysql_query($update);
								}

								$to = $email;
								
								$from = "admin@torquextreme.com";
								
								$headers ="From: $from\n";
								
								$headers .= "MIME-Version: 1.0\n";
								
								$headers .= "Content-type: text/html; charset=iso-8859-1 \n";
								
								$subject ="Forgot your Xtreme Torque account's password? ";
								
								$msg = '
									Hi there. You have let us know that you don\'t remember your Xtreme Torque account\'s password. Please click the link below to set a new password. This link is valid only for one use. If you haven\'t requested a new password, please ignore this mail. <br /> http://www.torquextreme.com/newPassword.php?key='.$key.'&id='.$userId;
								
								if(mail($to,$subject,$msg,$headers)) 
								{
									echo '
										<p style="font-family:Armata;text-align:center;">Successfully sent. Please check your email.</p>
									';
								} 
								else 
								{
									echo '
										<p style="font-family:Armata;text-align:center;">Sorry something went wrong. Please try again later.</p>
									';
								}
							}
						}
					}
					else
					{
						echo '
							<form action="" method="POST" id="rec">
								<p>Please submit the Email Id that you used while registering. A mail will be sent to that ID which will guide you further.</p> <br />

								<div style="text-align:center;"><input type="text" name="recEmail" placeholder="Email Id"/> &nbsp;&nbsp;&nbsp;&nbsp;

								<input type="submit" value="Send" /></div>
							</form>
						';
					}
				?>

				
			</div>
			
			<div id="left">
			
			</div>

			<div style="clear:both;"></div> <br /><br />
		</div>
		
		<script type="text/javascript" src="question.js">
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