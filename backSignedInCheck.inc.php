<?php
	if(!isset($_SESSION['username']))
	{
		if(isset($_COOKIE['key']))
		{
			$key = $_COOKIE['key'];
			
			$query = 'SELECT id FROM rememberMe WHERE rememberMeKey="'.$key.'"';
			
			$query_run = mysql_query($query);
			
			if(mysql_num_rows($query_run)==1)
			{
				$id = mysql_result($query_run, 0, 'id');
				
				$query = 'SELECT username FROM users WHERE id="'.$id.'"';
				
				$query_run = mysql_query($query);
				
				$username = mysql_result($query_run, 0, 'username');
				
				$_SESSION['id'] = $id;
				
				$_SESSION['username'] = $username;
			}
			else
			{
				header('Location:signOut.php'); //invalid key set in rememberMe cookie. So delete it.
				
				die();
			}
		}
		else
		{
			require 'fbGetUser.inc.php';
			
			if($user)
			{
				require 'fbGetUserInfo.inc.php';
				
				$query = 'SELECT id, username FROM users WHERE fbId="'.$fbId.'"';
				
				$query_run = mysql_query($query);
				
				if(mysql_num_rows($query_run)==1)
				{
					$_SESSION['id'] = mysql_result($query_run, 0, 'id');
				
					$_SESSION['username'] = mysql_result($query_run, 0, 'username');
				}
				else
				{
					header('Location:index.php'); //user is authnticated through fb, but not added to database.
					
					die();
				}
			}
			else
			{
				header('Location:needAuthentication.php'); //user is not logged in through fb either. So redirect to index.
				
				die();
			}
		}
	}
?>