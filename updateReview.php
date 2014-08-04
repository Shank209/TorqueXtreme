<?php
	session_start();
	
	require 'mysqlCon.inc.php';
	
	require 'backSignedInCheck.inc.php';
	
	if(!isset($_GET['id']))
	{
		header('Location:pageUnavailable.php');
		
		die();
	}
	
	$reviewId = $_GET['id'];
	
	if(!isset($_POST['title']))
	{
		header('Location:pageUnavailable.php');
		
		die();
	}
	
	$title = $_POST['title'];
	
	$desc = $_POST['desc'];
	
	$title = mysql_real_escape_string($title);
	
	$desc = mysql_real_escape_string($desc);
	
	$title = strip_tags($title);
	
	$desc = strip_tags($desc);
	
	if($title=='' || $desc=='')
	{
		header('Location:reviewEmpty.php');
	}

	$query = 'SELECT userId FROM reviews WHERE id='.$reviewId;

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

	$update = 'UPDATE reviews SET title="'.$title.'", `desc`="'.$desc.'" WHERE id='.$reviewId;
	
	mysql_query($update);

	if($_FILES['image']['size']>0)
	{
		if($_FILES['image']['size']>3100*1024)
		{
			header('Location:reviewEmpty.php');

			die();
		}

		$image = $_FILES['image']['tmp_name'];

		if(!getimagesize($image))
		{
			header('Location:reviewEmpty.php');

			die();
		}

		$image = addslashes(file_get_contents($image));

		$query = 'SELECT reviewId FROM reviewImages WHERE reviewId='.$reviewId;

		$query_run = mysql_query($query);

		if(mysql_num_rows($query_run)==0)
		{
			$insert = 'INSERT INTO reviewImages VALUES('.$reviewId.', "'.$image.'")';

			mysql_query($insert);
		}
		else
		{
			$update = 'UPDATE reviewImages SET image="'.$image.'" WHERE reviewId='.$reviewId;

			mysql_query($update);
		}
	}
	
	header('Location:review.php?id='.$reviewId);
?>