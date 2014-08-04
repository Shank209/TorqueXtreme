<?php
	session_start();

	require 'mysqlCon.inc.php';
	
	require 'frontSignedInCheck.inc.php';

	if(isset($_POST['username']))
	{
		$username = $_POST['username'];
		
		$username = strip_tags($username);
		
		$username = mysql_real_escape_string($username);
		
		$email = $_POST['email'];
		
		$email = mysql_real_escape_string($email);
		
		$pass = $_POST['pass'];
		
		$conPass = $_POST['conPass'];
		
		if($username!='' && $email!='' && $pass!='' && $conPass!='')
		{
			$query = 'SELECT id FROM users WHERE BINARY username="'.$username.'"';
			
			$query_run = mysql_query($query);
			
			if(mysql_num_rows($query_run)!=0)
			{
				$_SESSION['eTwo'] = 1;
				
				$_SESSION['errorUsername'] = $_POST['username'];
				
				$_SESSION['email'] = $_POST['email'];
				
				$_SESSION['pass'] = $_POST['pass'];
				
				$_SESSION['conPass'] = $_POST['conPass'];
			
				header('Location:index.php'); //username already exists
			
				die();
			}
			
			$query = 'SELECT id FROM users WHERE email="'.$email.'"';
			
			$query_run = mysql_query($query);
			
			if(mysql_num_rows($query_run)!=0)
			{
				
				$_SESSION['eThree'] = 1;
				
				$_SESSION['errorUsername'] = $_POST['username'];
				
				$_SESSION['email'] = $_POST['email'];
				
				$_SESSION['pass'] = $_POST['pass'];
				
				$_SESSION['conPass'] = $_POST['conPass'];
				
				header('Location:index.php'); //email already exists
			
				die();
			}
			
			if($pass!=$conPass)
			{
				$_SESSION['eFour'] = 1;
				
				$_SESSION['errorUsername'] = $_POST['username'];
				
				$_SESSION['email'] = $_POST['email'];
				
				$_SESSION['pass'] = $_POST['pass'];
				
				$_SESSION['conPass'] = $_POST['conPass'];
				
				header('Location:index.php'); //passwords don't match
				
				die();
			}

			if(preg_match('/[^a-z_\-0-9]/i', $_POST['username']))
			{
				$_SESSION['eSix'] = 1;
				
				$_SESSION['errorUsername'] = $_POST['username'];
				
				$_SESSION['email'] = $_POST['email'];
				
				$_SESSION['pass'] = $_POST['pass'];
				
				$_SESSION['conPass'] = $_POST['conPass'];

			    header('Location:index.php'); //username has illegal characters
				
				die();
			}

			if(strlen($_POST['pass'])<6)
			{
				$_SESSION['eSeven'] = 1;
				
				$_SESSION['errorUsername'] = $_POST['username'];
				
				$_SESSION['email'] = $_POST['email'];
				
				$_SESSION['pass'] = $_POST['pass'];
				
				$_SESSION['conPass'] = $_POST['conPass'];

			    header('Location:index.php'); //password is too short
				
				die();
			}
			
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
			{
   				$_SESSION['eEight'] = 1;
				
				$_SESSION['errorUsername'] = $_POST['username'];
				
				$_SESSION['email'] = $_POST['email'];
				
				$_SESSION['pass'] = $_POST['pass'];
				
				$_SESSION['conPass'] = $_POST['conPass'];

			    header('Location:index.php'); //password is too short
				
				die();	
			}

			if(strlen($_POST['username'])>17)
			{
				$_SESSION['eNine'] = 1;
				
				$_SESSION['errorUsername'] = $_POST['username'];
				
				$_SESSION['email'] = $_POST['email'];
				
				$_SESSION['pass'] = $_POST['pass'];
				
				$_SESSION['conPass'] = $_POST['conPass'];

			    header('Location:index.php'); //password is too short
				
				die();
			}

			if(strlen($_POST['pass'])>15)
			{ 
				$_SESSION['eTen'] = 1;
				
				$_SESSION['errorUsername'] = $_POST['username'];
				
				$_SESSION['email'] = $_POST['email'];
				
				$_SESSION['pass'] = $_POST['pass'];
				
				$_SESSION['conPass'] = $_POST['conPass'];

			    header('Location:index.php'); //password is too short
				
				die();
			}

			$pass = mysql_real_escape_string($pass);

			$pass = hash('sha256', $pass);
			
			$salt = bin2hex(openssl_random_pseudo_bytes(16));
			
			$pass = hash('sha256', $pass.$salt);
			
			$insert = 'INSERT INTO users VALUES("","'.$email.'", "'.$username.'", "'.$pass.'", "'.$salt.'", "0", "N/A", 0, "N/A", "N/A", "N/A")';
			
			mysql_query($insert);
			
			$query = 'SELECT id FROM users WHERE username="'.$username.'"';
			
			$query_run = mysql_query($query);
			
			$id = mysql_result($query_run, 0, 'id');
			
			$_SESSION['id'] = $id;
			
			$_SESSION['username'] = $username;
			
			header('Location:questions.php');
		}
		else
		{
			$_SESSION['eFive'] = 1;
				
			$_SESSION['errorUsername'] = $_POST['username'];
				
			$_SESSION['email'] = $_POST['email'];
				
			$_SESSION['pass'] = $_POST['pass'];
				
			$_SESSION['conPass'] = $_POST['conPass'];
		
			header('Location:index.php'); //user hasn't filled all the fields
			
			die();
		}
	}
	else
	{
		header('Location:pageUnavailable.php'); //user hasn't came to this page through the sign up form
		
		die();
	}
?>