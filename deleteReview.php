<?php
	session_start();
	
	require 'mysqlCon.inc.php';
	
	require 'backSignedInCheck.inc.php';
	
	if(isset($_GET['id']))
	{
		$reviewId = $_GET['id'];
		
		$query = 'SELECT userId FROM reviews WHERE id='.$reviewId;
		
		$query_run = mysql_query($query);

		if(mysql_num_rows($query_run)==0)
		{
			header('Location:pageUnavailable.php');

			die();
		}
		
		if($_SESSION['id'] == mysql_result($query_run, 0, 'userId'))
		{
			$delete = 'DELETE FROM reviews WHERE id='.$reviewId;
			
			mysql_query($delete);
			
			$delete = 'DELETE FROM reviewVotes WHERE reviewId='.$reviewId;
			
			mysql_query($delete);
			
			$delete = 'DELETE FROM reviewComments WHERE reviewId='.$reviewId;
			
			mysql_query($delete);
			
			$delete = 'DELETE FROM reviewsTags WHERE reviewId='.$reviewId;
			
			mysql_query($delete); //REMOVE FROM STORED TAGS
			
			header('Location:reviews.php');
			
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