<?php
	session_start();
	
	require 'mysqlCon.inc.php';
	
	require 'backSignedInCheck.inc.php';
	
	if(!isset($_FILES['image']['tmp_name']))
	{
		header('Location:user.php?id='.$_SESSION['id']);
		
		die();
	}
	
	$image = $_FILES['image']['tmp_name'];
	
	if($_FILES['image']['size']>3100*1024)
	{
		$_SESSION['error']=1;
		
		header('Location:user.php?id='.$_SESSION['id']);
		
		die();
	}
	
	if(!getimagesize($image))
	{
		$_SESSION['error']=1;
		
		header('Location:user.php?id='.$_SESSION['id']);
		
		die();
	}
	
	$image = addslashes(file_get_contents($image));
	
	$query = 'SELECT userId FROM userImages WHERE userId='.$_SESSION['id'];
	
	$query_run = mysql_query($query);
	
	if(mysql_num_rows($query_run)==0)
	{
		$insert = 'INSERT INTO userImages VALUES('.$_SESSION['id'].', "'.$image.'")';
		
		mysql_query($insert);
	}
	else
	{
		$update = 'UPDATE userImages SET image="'.$image.'" WHERE userId='.$_SESSION['id'];
		
		mysql_query($update);
	}
	
	header('Location:user.php?id='.$_SESSION['id']);
?>