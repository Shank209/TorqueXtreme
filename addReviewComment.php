<?php
	session_start();
	
	require 'mysqlCon.inc.php';
	
	require 'midSignedInCheck.inc.php';

	if(!isset($_SESSION['id']))
	{
		echo '
			<script type="text/javascript">
				$("#dark").show();

				$("#alertBox").show();

				positionAlertBox();
			</script>
		';

		die();
	}
	
	if(isset($_POST['id']))
	{
		$reviewId = $_POST['id'];
		
		$comment = $_POST['comment'];
		
		$comment = mysql_real_escape_string($comment);
		
		$comment = strip_tags($comment);

		$comment = trim($comment);
		
		if($comment!='')
		{
			$insert = 'INSERT INTO reviewComments VALUES ("", '.$reviewId.', '.$_SESSION['id'].', "'.$_SESSION['username'].'", "'.$comment.'")';
			
			mysql_query($insert);
			
			echo '
			<script>
				$("#reviewComments").append("<p class=\"reviewCommentDelete\" id=\"'.mysql_insert_id().'\"> <a href=\"user.php?id='.$_SESSION['id'].'\">'.$_SESSION['username'].'</a>: '.$comment.' &nbsp;&nbsp; <img style=\"width:12px;cursor:pointer\" src=\"deleteIcon.png\" /> </p> <br />");
			
				$("#reviewCommentButton").attr(\'disabled\', false);

				$("#reviewCommentButton").val(\'Comment\');
			</script>
			';
		}
		else
		{
			echo '
			<script>alert("Comment cannot be empty");</script>
			';
		}
	}
	else
	{
		echo '<script type="text/javascript">alert("OOPS! Something went wrong.");</script>'; //user hasn't come through the comment button
		
		die();
	}
?>