<?php
	session_start();
	
	require 'mysqlCon.inc.php';
	
	require 'backSignedInCheck.inc.php';
	
	if(!isset($_GET['id']))
	{
		header('Location:pageUnavailable.php');
		
		die();
	}
	
	$answerId = $_GET['id'];
	
	if(!isset($_POST['answer']))
	{
		header('Location:pageUnavailable.php');
		
		die();
	}
	
	$answer = $_POST['answer'];
	
	$answer = mysql_real_escape_string($answer);
	
	$answer = strip_tags($answer);

	$answer = trim($answer);

	if($answer=='')
	{
		header('Location:answerEmpty.php');

		die();
	}
	
	$query = 'SELECT userId, questionId FROM answers WHERE id='.$answerId;

	$query_run = mysql_query($query);

	if(mysql_num_rows($query_run)==0)
	{
		header('Location:pageUnavailable.php');
	}
	
	if($_SESSION['id']!=mysql_result($query_run, 0, 'userId'))
	{
		header('Location:pageUnavailable.php');
		
		die();
	}
	
	if(strpos($answer, '[Edited]') === false)
	{
		$answer = $answer.' [Edited]';
	}

	$update = 'UPDATE answers SET answer="'.$answer.'" WHERE id='.$answerId;
	
	mysql_query($update);

	if($_FILES['image']['size']>0)
	{
		if($_FILES['image']['size']>3100*1024)
		{
			header('Location:answerEmpty.php');

			die();
		}

		$image = $_FILES['image']['tmp_name'];

		if(!getimagesize($image))
		{
			header('Location:answerEmpty.php');

			die();
		}

		$image = addslashes(file_get_contents($image));

		$query = 'SELECT answerId FROM answerImages WHERE answerId='.$answerId;

		$run = mysql_query($query);

		if(mysql_num_rows($run)==1)
		{
			$update = 'UPDATE answerImages SET image="'.$image.'" WHERE answerId='.$answerId;

			mysql_query($update);
		}
		else
		{
			$insert = 'INSERT INTO answerImages VALUES ('.$answerId.', "'.$image.'")';

			mysql_query($insert);
		}
	}
	
	header('Location:question.php?id='.mysql_result($query_run, 0, 'questionId'));
?>