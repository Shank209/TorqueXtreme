<?php
	session_start();
	
	require 'mysqlCon.inc.php';
	
	require 'backSignedInCheck.inc.php';
	
	if(isset($_GET['id']))
	{
		$questionId = $_GET['id'];
		
		$query = 'SELECT userId FROM questions WHERE id='.$questionId;
		
		$query_run = mysql_query($query);

		if(mysql_num_rows($query_run)==0)
		{
			header('Location:pageUnavailable.php');

			die();
		}
		
		if($_SESSION['id'] == mysql_result($query_run, 0, 'userId'))
		{
			$delete = 'DELETE FROM questions WHERE id='.$questionId;
			
			mysql_query($delete);
			
			$delete = 'DELETE FROM questionVotes WHERE questionId='.$questionId;
			
			mysql_query($delete);
			
			$delete = 'DELETE FROM questionComments WHERE questionId='.$questionId;
			
			mysql_query($delete);
			
			$delete = 'DELETE FROM tags WHERE questionId='.$questionId;
			
			mysql_query($delete); //REMOVE FROM STORED TAGS
			
			$query = 'SELECT id FROM answers WHERE questionId='.$questionId;
			
			$query_run = mysql_query($query);
			
			while($row = mysql_fetch_assoc($query_run))
			{
				$answerId = $row['id'];
				
				$delete = 'DELETE FROM answerVotes WHERE answerId='.$answerId;
				
				mysql_query($delete);
				
				$delete = 'DELETE FROM answerComments WHERE answerId='.$answerId;
				
				mysql_query($delete);
			}
			
			$delete = 'DELETE FROM answers WHERE questionId='.$questionId;
			
			mysql_query($delete);
			
			header('Location:index.php');
			
			die();
		}
		else
		{
			header('Location:pageUnavailable.php'); //question id is not set
		
			die();
		}
	}
	else
	{
		header('Location:pageUnavailable.php'); //question id is not set
		
		die();
	}
?>