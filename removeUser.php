<?php
	session_start();
	
	require 'mysqlCon.inc.php';
	
	require 'backSignedInCheck.inc.php';
	
	$userId = $_SESSION['id'];
	
	$query = 'SELECT pass, salt, fbId FROM Users WHERE id='.$userId;
			
	$query_run = mysql_query($query);

	if(mysql_num_rows($query_run)==0)
	{				
		header(Location:pageUnavailable.php);

		die();
	}
			
	$salt = mysql_result($query_run, 0, 'salt');
			
	$fbId = mysql_result($query_run, 0, 'fbId');
			
	if($fbId == 0)
	{
		if(isset($_POST['pass']))
		{
			$pass = $_POST['pass'];

			$pass = mysql_real_escape_string($pass);
					
			$pass = hash('sha256', $pass);
					
			$pass = hash('sha256', $pass.$salt);
				
			if($pass == mysql_result($query_run, 0, 'pass'))
			{
				$delete = 'DELETE FROM users WHERE id='.$userId;
						
				mysql_query($delete);
						
				header('Location:signOut.php');
			}
			else
			{
				$_SESSION['delError']=1;
			
				header('Location:deleteAccount.php');
						
				die();
			}
		}
		else
		{
			header('Location:index.php');
					
			die();
		}
	}
	else
	{
		$delete = 'DELETE FROM users WHERE id='.$userId;
						
		mysql_query($delete);
						
		header('Location:signOut.php');
	}
?>