<?php
	session_start();
	
	require 'mysqlCon.inc.php';

	require 'fbGetUser.inc.php';
	
	session_destroy();
	
	if(isset($_COOKIE['key']))
	{
		$key = mysql_real_escape_string($_COOKIE['key']);
		
		setcookie('key', '0', time()-10);
		
		$delete = 'DELETE FROM rememberMe WHERE rememberMeKey="'.$key.'"';
		
		mysql_query($delete);
	}
	
	if($user)
	{
		require 'fbGetUrls.inc.php';
	
		header('Location:'.$signOutUrl);
		
		die();
	}
	
	header('Location:index.php');
?>

