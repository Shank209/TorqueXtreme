<?php
	session_start();

	require 'mysqlCon.inc.php';
	
	require 'frontSignedInCheck.inc.php';
	
	if(isset($_POST['signInUsername']))
	{
		$username = $_POST['signInUsername'];
		
		$username = mysql_real_escape_string($username);
		
		$pass = $_POST['signInPass'];

		$pass = mysql_real_escape_string($pass);
		
		if($username!='' && $pass!='')
		{
			$query = 'SELECT id, salt, pass FROM users WHERE BINARY username="'.$username.'"'; 
			
			$query_run = mysql_query($query); 
			
			if(mysql_num_rows($query_run)==1)
			{
				$salt = mysql_result($query_run, 0, 'salt');
				
				$pass = hash('sha256', $pass);
				
				$pass = hash('sha256', $pass.$salt);
				
				if($pass==mysql_result($query_run, 0, 'pass'))
				{
					if(isset($_POST['rememberMe']))
					{
						$key = bin2hex(openssl_random_pseudo_bytes(16));
						
						$id = mysql_result($query_run, 0, 'id');
						
						$insert = 'INSERT INTO rememberMe VALUES("'.$key.'", "'.$id.'")';
						
						mysql_query($insert);
						
						setcookie('key', $key, time()+60*60*24*30);
						
						$_SESSION['username'] = $username;
						
						$_SESSION['id'] = $id;
						
						header('Location:questions.php');
					}
					else
					{
						$id = mysql_result($query_run, 0, 'id');
					
						$_SESSION['username'] = $username;
						
						$_SESSION['id'] = $id;
						
						header('Location:questions.php');
					}
				}
				else
				{
					$_SESSION['eOne'] = 1;
					
					$_SESSION['signInUsername'] = $_POST['signInUsername'];
					
					$_SESSION['signInPass'] = $_POST['signInPass'];
					
					header('Location:index.php'); //password is incorrect
					
					die();
				}
			}
			else
			{
				$_SESSION['eOne'] = 1;
				
				$_SESSION['signInUsername'] = $_POST['signInUsername'];
					
				$_SESSION['signInPass'] = $_POST['signInPass'];
			
				header('Location:index.php'); //username doesn't exist
			
				die();
			}
		}
		else
		{
			$_SESSION['eOne'] = 1;
			
			$_SESSION['signInUsername'] = $_POST['signInUsername'];
					
			$_SESSION['signInPass'] = $_POST['signInPass'];
		
			header('Location:index.php'); //user hasn't entered all fields
			
			die();
		}
	}
	else
	{
		header('Location:pageUnavailable.php'); //user hasn't come here through the sign in form
		
		die();
	}
?>