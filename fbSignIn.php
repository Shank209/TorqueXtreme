<?php
	session_start();

	require 'mysqlCon.inc.php';

	$fbId = $_GET['fbId'];
	
	$email = $_GET['fbEmail'];
	
	$fbName = $_GET['fbName'];
	
	$query = 'SELECT id, username FROM users WHERE fbId="'.$fbId.'"';
	
	$query_run = mysql_query($query);
	
	if(mysql_num_rows($query_run)==1)
	{
		$_SESSION['id'] = mysql_result($query_run, 0, 'id');
		
		$_SESSION['username'] = mysql_result($query_run, 0, 'username');
		
		header('Location:home.php');
	}
	else
	{
		$query = 'SELECT id FROM users';
		
		$query_run = mysql_query($query);
		
		$username = 'User'.(mysql_num_rows($query_run)+1);
		
		$insert = 'INSERT INTO users VALUES("", "'.$email.'", "'.$username.'", "0", "0", "'.$fbId.'", "'.$fbName.'", 0, "N/A", "N/A", "N/A")';
		
		mysql_query($insert);
		
		$query = 'SELECT id FROM users WHERE username="'.$username.'"';
		
		$query_run = mysql_query($query);
		
		$id = mysql_result($query_run, 0, 'id');
		
		$_SESSION['id'] = $id;
		
		$_SESSION['username'] = $username;
		
		header('Location:home.php');
	}
?>