<?php
	if(isset($_SESSION['username']))
	{
		header('Location:questions.php'); //user is logged in. So redirect to home
		
		die();
	}
	else
	{
		if(isset($_COOKIE['key']))
		{
			$key = mysql_real_escape_string($_COOKIE['key']);
		
			$query = 'SELECT id FROM rememberMe WHERE rememberMeKey="'.$key.'"';
			
			$query_run = mysql_query($query);
			
			if(mysql_num_rows($query_run)==1)
			{	
				$id = mysql_result($query_run, 0, 'id');
				
				$query = 'SELECT username FROM users WHERE id="'.$id.'"';
				
				$query_run = mysql_query($query);
				
				$username = mysql_result($query_run, 0, 'username');
				
				$_SESSION['username'] = $username;
				
				$_SESSION['id'] = $id;
				
				header('Location:questions.php'); //regenerate user session with rememberMe cookie and redirect to home
				
				die();
			}
			else
			{
				header('Location:signOut.php'); //invalid key set in cookie. So delete the cookie
				
				die();
			}
		}
		else
		{
			require 'fbGetUser.inc.php';
			
			if($user)
			{
				require 'fbGetUserInfo.inc.php';
		
				header('Location:fbSignIn.php?fbId='.$fbId.'&fbEmail='.$fbEmail.'&fbName='.$fbName); //user is authenticated through fb. So redirect to fbSignin
			}
			else
			{
				require 'fbGetUrls.inc.php';
			}
		}
	}
?>