<?php
	session_start();
	
	require 'mysqlCon.inc.php';
	
	require 'backSignedInCheck.inc.php';
	
	if(!isset($_GET['id']))
	{
		header('Location:pageUnavailable.php');
		
		die();
	}
	
	$questionId = $_GET['id'];
	
	if(!isset($_POST['title']))
	{
		header('Location:pageUnavailable.php');
		
		die();
	}
	
	$title = $_POST['title'];
	
	$desc = $_POST['desc'];
	
	$title = mysql_real_escape_string($title);
	
	$title = strip_tags($title);
	
	$desc = mysql_real_escape_string($desc);
	
	$desc = strip_tags($desc);
	
	$title = trim($title);

	if($title=='')
	{
		header('Location:questionEmpty.php');

		die();
	}
	
	$query = 'SELECT userId FROM questions WHERE id='.$questionId;

	$query_run = mysql_query($query);

	if(mysql_num_rows($query_run)==0)
	{
		header('Location:pageUnavailable.php');

		die();
	}
	
	if($_SESSION['id']!=mysql_result($query_run, 0, 'userId'))
	{
		header('Location:pageUnavailable.php');
		
		die();
	}

	if(strpos($desc, '[Edited]') === false)
	{
		$desc = $desc.' [Edited]';
	}
	
	$update = 'UPDATE questions SET title="'.$title.'", `desc`="'.$desc.'" WHERE id='.$questionId;
	
	mysql_query($update);

	if($_FILES['image']['size']>0)
	{
		if($_FILES['image']['size']>3100*1024)
		{
			header('Location:questionEmpty.php');

			die();
		}

		$image = $_FILES['image']['tmp_name'];

		if(!getimagesize($image))
		{
			header('Location:questionEmpty.php');

			die();
		}

		$image = addslashes(file_get_contents($image));

		$query = 'SELECT questionId FROM questionImages WHERE questionId='.$questionId;

		$query_run = mysql_query($query);

		if(mysql_num_rows($query_run)==0)
		{
			$insert = 'INSERT INTO questionImages VALUES('.$questionId.', "'.$image.'")';

			mysql_query($insert);
		}
		else
		{
			$update = 'UPDATE questionImages SET image="'.$image.'" WHERE questionId='.$questionId;

			mysql_query($update);
		}
	}
	
	header('Location:question.php?id='.$questionId);
?>