<?php
	session_start();

	require 'mysqlCon.inc.php';

	require 'midSignedInCheck.inc.php';

	if(!isset($_GET['id']))
	{
		header('Locaation:pageUnavailable.php');

		die();
	}

	$reviewId = $_GET['id'];

	$query = 'SELECT image FROM reviewImages WHERE reviewId='.$reviewId;

	$query_run = mysql_query($query);

	if(mysql_num_rows($query_run)==0)
	{
		header('Location:pageUnavailable.php');

		die();
	}

	$image = mysql_result($query_run, 0, 'image');

	echo '<img src="data:image/jpeg;base64,'.base64_encode($image).'" />';
?>