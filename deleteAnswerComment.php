<?php
	session_start();

	require 'mysqlCon.inc.php';

	require 'backSignedInCheck.inc.php';

	if(!isset($_POST['id']))
	{
		echo '<script type="text/javascript">OOPS! Something went wrong.</script>';

		die();
	}

	$commentId = $_POST['id'];

	$query = 'SELECT userId FROM answerComments WHERE id='.$commentId;

	$query_run = mysql_query($query);

	if(mysql_num_rows($query_run)==0)
	{
		echo '<script type="text/javascript">OOPS! Something went wrong.</script>';

		die();
	}

	if(mysql_result($query_run, 0, 'userId') != $_SESSION['id'])
	{
		echo '<script type="text/javascript">OOPS! Something went wrong.</script>';

		die();
	}

	$delete = 'DELETE FROM answerComments WHERE id='.$commentId;

	mysql_query($delete);

	echo '
		<script type="text/javascript">
			$(\'.answerCommentDelete[id="'.$commentId.'"]\').remove();
		</script>
	';
?>