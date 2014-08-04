<?php
	session_start();

	require 'mysqlCon.inc.php';

	require 'frontSignedInCheck.inc.php';
?>

<!doctype html>

<html lang="en">
	<head>
		<meta charset="utf-8" />
		
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />

		<meta name="description" cotent="A Question & Answer and Review site for the automotive addicts. Ask questions, answer others questions and write Reviews. It's all about motorcycles, cars and automobiles in general." />

		<title>Torque Xtreme</title>
		
		<meta name="keywords" content="automobiles, bikes, motorcycles, cars, parts, automotive, questions, answers, reviews" />
		
		<link rel="shortcut icon" href="favicon.png" type="image/x-icon" />

		<link rel="icon" href="favicon.png" type="image/x-icon" />
		
		<script src="jquery.js"></script>
		
		<meta name="keywords" content="automobiles, bikes, motorcycles, cars, parts, automotive, questions, answers, reviews" />
		
		<link rel="shortcut icon" href="favicon.png" type="image/x-icon" />

		<link rel="icon" href="favicon.png" type="image/x-icon" />
		
		<link rel="stylesheet" href="index.css?<?php echo time();?>" />
	</head>
	
	<?php
		if(isset($_SESSION['eOne']))
		{
			echo '
				<script>
					$(document).ready(function() {
						$("#dark").show();
							
						$("#signInBox").show();
							
						positionSignInBox();
							
						$("#eOne").show();
						
						$("#signInUsername").val("'.$_SESSION['signInUsername'].'");
						
						$("#signInPass").val("'.$_SESSION['signInPass'].'");
					});
				</script>
			';
			
			session_destroy();
		}
		else if(isset($_SESSION['eTwo']))
		{
			echo '
				<script>
					$(document).ready(function() {
						$("#dark").show();
							
						$("#signUpBox").show();
							
						positionSignUpBox();
							
						$("#eTwo").show();
						
						$("#username").val("'.$_SESSION['errorUsername'].'");
						
						$("#email").val("'.$_SESSION['email'].'");
						
						$("#pass").val("'.$_SESSION['pass'].'");
						
						$("#conPass").val("'.$_SESSION['conPass'].'");
					});
				</script>
			';
			
			session_destroy();
		}
		else if(isset($_SESSION['eThree']))
		{
			echo '
				<script>
					$(document).ready(function() {
						$("#dark").show();
							
						$("#signUpBox").show();
							
						positionSignUpBox();
							
						$("#eThree").show();
						
						$("#username").val("'.$_SESSION['errorUsername'].'");
						
						$("#email").val("'.$_SESSION['email'].'");
						
						$("#pass").val("'.$_SESSION['pass'].'");
						
						$("#conPass").val("'.$_SESSION['conPass'].'");
					});
				</script>
			';
			
			session_destroy();
		}
		else if(isset($_SESSION['eFour']))
		{
			echo '
				<script>
					$(document).ready(function() {
						$("#dark").show();
							
						$("#signUpBox").show();
							
						positionSignUpBox();
							
						$("#eFour").show();
						
						$("#username").val("'.$_SESSION['errorUsername'].'");
						
						$("#email").val("'.$_SESSION['email'].'");
						
						$("#pass").val("'.$_SESSION['pass'].'");
						
						$("#conPass").val("'.$_SESSION['conPass'].'");
					});
				</script>
			';
			
			session_destroy();
		}
		else if(isset($_SESSION['eFive']))
		{
			echo '
				<script>
					$(document).ready(function() {
						$("#dark").show();
							
						$("#signUpBox").show();
							
						positionSignUpBox();
							
						$("#eFive").show();
						
						$("#username").val("'.$_SESSION['errorUsername'].'");
						
						$("#email").val("'.$_SESSION['email'].'");
						
						$("#pass").val("'.$_SESSION['pass'].'");
						
						$("#conPass").val("'.$_SESSION['conPass'].'");
					});
				</script>
			';
			
			session_destroy();
		}
		else if(isset($_SESSION['eSix']))
		{
			echo '
				<script>
					$(document).ready(function() {
						$("#dark").show();
							
						$("#signUpBox").show();
							
						positionSignUpBox();
							
						$("#eSix").show();
						
						$("#username").val("'.$_SESSION['errorUsername'].'");
						
						$("#email").val("'.$_SESSION['email'].'");
						
						$("#pass").val("'.$_SESSION['pass'].'");
						
						$("#conPass").val("'.$_SESSION['conPass'].'");
					});
				</script>
			';
			
			session_destroy();
		}
		else if(isset($_SESSION['eSeven']))
		{
			echo '
				<script>
					$(document).ready(function() {
						$("#dark").show();
							
						$("#signUpBox").show();
							
						positionSignUpBox();
							
						$("#eSeven").show();
						
						$("#username").val("'.$_SESSION['errorUsername'].'");
						
						$("#email").val("'.$_SESSION['email'].'");
						
						$("#pass").val("'.$_SESSION['pass'].'");
						
						$("#conPass").val("'.$_SESSION['conPass'].'");
					});
				</script>
			';
			
			session_destroy();
		}
		else if(isset($_SESSION['eEight']))
		{
			echo '
				<script>
					$(document).ready(function() {
						$("#dark").show();
							
						$("#signUpBox").show();
							
						positionSignUpBox();
							
						$("#eEight").show();
						
						$("#username").val("'.$_SESSION['errorUsername'].'");
						
						$("#email").val("'.$_SESSION['email'].'");
						
						$("#pass").val("'.$_SESSION['pass'].'");
						
						$("#conPass").val("'.$_SESSION['conPass'].'");
					});
				</script>
			';

			session_destroy();
		}
		else if(isset($_SESSION['eNine']))
		{
			echo '
				<script>
					$(document).ready(function() {
						$("#dark").show();
									
						$("#signUpBox").show();
									
						positionSignUpBox();
									
						$("#eNine").show();
								
						$("#username").val("'.$_SESSION['errorUsername'].'");
								
						$("#email").val("'.$_SESSION['email'].'");
								
						$("#pass").val("'.$_SESSION['pass'].'");
								
						$("#conPass").val("'.$_SESSION['conPass'].'");
					});
				</script>
			';

			session_destroy();
		}
		else if(isset($_SESSION['eTen']))
		{
			echo '
				<script>
					$(document).ready(function() {
						$("#dark").show();
								
						$("#signUpBox").show();
								
						positionSignUpBox();
								
						$("#eTen").show();
							
						$("#username").val("'.$_SESSION['errorUsername'].'");
							
						$("#email").val("'.$_SESSION['email'].'");
							
						$("#pass").val("'.$_SESSION['pass'].'");
							
						$("#conPass").val("'.$_SESSION['conPass'].'");
					});
				</script>
			';
			
			session_destroy();
		}
	?>
	
	<body>
		<span id="topStripe"></span>
		
		<span id="bottomStripe"></span>

		<div id="footer">
			<p>&copy; Torque Xtreme 2014 &nbsp;&nbsp; | &nbsp;&nbsp; <a href="about.php">About</a> &nbsp;&nbsp; | &nbsp;&nbsp; <a href="contact.php">Contact</a> &nbsp;&nbsp; | &nbsp;&nbsp; <a href="sitemap.xml">Sitemap</a></p>
		</div>
		
		<div id="container">
			<img id="logo" src="logoBig.png" />
			
			<br /><br />
			
			<p id="desc">A Question &amp; Answer and Review site for the <b>automotive</b> addicts</p>
			
			<br /><br />
			
			<div id="boxContainer">
				<div class="box">
					<p class="heading">Ask Questions:</p> <br /> <p>Need some info. about a bike or a car? Just post it here and the community will answer it.</p>
				</div>
				
				<div class="box">
					<p class="heading">Answer Questions:</p> <br /> <p>Share that immense automobile knowledge knowledge that's just piled up in your head.</p>
				</div>
				
				<div class="box">
					<p class="heading">Write Reviews:</p> <br /> <p>Put your thoughts and opinions out and let the world know what you think about your rides.</p>
				</div>
				
				<div class="clear"></div>
			</div>
			
			<br /><br />
			
			<div id="signBox">
				<span id="signIn">Sign In</span>

				<span id="signUp">Sign Up</span>

				<span id="browse"><a href="questions.php" style="text-decoration:none;color:#f2f2f2;">Browse</a></span>
				
				<div class="clear"></div>
			</div>
			
			<br />
			
			<p id="or">[OR]</p>
			
			<br />
			
			<span id="fbSignIn"><a href="<?php echo $signInUrl; ?>">Sign In with Facebook</a></span> <br /> <br />

		</div>
		
		<div id="dark"></div>
		
		<div id="signInBox">
			<form action="signIn.php" method="POST">
				<p><input type="text" name="signInUsername" id="signInUsername" placeholder="Username" maxlength="17"/></p>
				
				<p><input type="password" name="signInPass" id="signInPass" placeholder="Password" maxlength="15"/></p>
				
				<p id="eOne" class="error" style="margin-bottom:-10px">Username or Password is incorrect</p>
				
				<div style="line-height:35px;margin-bottom:20px;">
					<p><span>Remember Me</span> &nbsp;&nbsp; <input type="checkbox" name="rememberMe" /></p>

					<a href="forgotPassword.php" style="text-decoration:none;color:#f2f2f2;font-size:12px;margin-top:-35px;">Forgot Password?</a>


				</div>

				<p class="formButtons"><input type="button" value="Back" class="back" style="color:#ffffff; font-size:16px; font-family:Yukari;"/> 
				
				<input type="submit" value="Submit" class="submit" style="color:#ffffff; font-size:16px; font-family:Yukari;"/></p>
			
				<div class="clear"></div>
			</form>
		</div>
		
		<div id="signUpBox">
			<form action="signUp.php" method="POST">
				<P><input type="text" name="username" placeholder="Username" id="username" maxlength="17"/></p>
				
				<p id="eTwo" class="error">Username already exists</p>
				
				<p id="eSix" class="error">Username can only contain alphanumeric characters, _ and -</p>

				<p id="eNine" class="error">Username must not be longer than 17 characters.</p>

				<P><input type="text" name="email" placeholder="Email Id" id="email" /></p>
				
				<p id="eThree" class="error">This Id is already in use. Use a different one.</p>

				<p id="eEight" class="error">Please enter a valid Email ID</p>
				
				<P><input type="password" name="pass" placeholder="Password" id="pass" maxlength="15"/></p>
				
				<p><input type="password" name="conPass" placeholder="Confirm Password" id="conPass" maxlength="15"/></p>
				
				<p id="eFour" class="error">Passwords don't match</p>
				
				<p id="eFive" class="error">Please fill all the fields</p>
				
				<p id="eSeven" class="error">Password must be atleast 6 characters long</p>
				
				<p id="eTen" class="error">Password is too long. Must be only 6-15 characters long</p>

				<p class="formButtons" style="margin-top:10px"><input type="button" value="Back" class="back" style="color:#ffffff; font-size:16px; font-family:Yukari;"/> 
				
				<input type="submit" value="Submit" class="submit" style="color:#ffffff; font-size:16px; font-family:Yukari;"/></p>
			</form>
		</div>
		
		<script src="index.js"></script>
	</body>
</html>