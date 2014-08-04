<?php
	session_start();
	
	require 'mysqlCon.inc.php';
	
	require 'backSignedInCheck.inc.php';
	
	if(isset($_GET['id']))
	{
		$answerId = $_GET['id'];
		
		$query = 'SELECT userId, questionId FROM answers WHERE id='.$answerId;
		
		$query_run = mysql_query($query);

		if(mysql_num_rows($query_run)==0)
		{
			header('Location:pageUnavailable.php');

			die();
		}
		
		$questionId = mysql_result($query_run, 0, 'questionId');
		
		if($_SESSION['id'] == mysql_result($query_run, 0, 'userId'))
		{
			$delete = 'DELETE FROM answerVotes WHERE answerId='.$answerId;
			
			mysql_query($delete);
			
			$delete = 'DELETE FROM answerComments WHERE answerId='.$answerId;
			
			mysql_query($delete);
			
			$delete = 'DELETE FROM answers WHERE id='.$answerId;
			
			mysql_query($delete);
			
			$update = 'UPDATE questions SET answers=answers-1 WHERE id='.$questionId;
			
			mysql_query($update);
			
			header('Location:question.php?id='.$questionId);
		}
		else
		{
			header('Location:pageUnavailable.php'); //user is trying to delete someone else's answer
		
			die();
		}
	}
	else
	{
		header('Location:pageUnavailable.php'); //answer id is not set
		
		die();
	}
?>