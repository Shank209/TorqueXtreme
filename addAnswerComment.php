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
		$answerId = $_POST['id'];
		
		$comment = $_POST['comment'];
		
		$comment = mysql_real_escape_string($comment);
		
		$comment = strip_tags($comment);

		$comment = trim($comment);
		
		if($comment!='')
		{
			$insert = 'INSERT INTO answerComments VALUES ("", '.$answerId.', '.$_SESSION['id'].', "'.$_SESSION['username'].'", "'.$comment.'")';
			
			mysql_query($insert);
			
			echo '
			<script>
				$("#answerComments'.$answerId.'").append("<p class=\"answerCommentDelete\" id=\"'.mysql_insert_id().'\"> <a href=\"user.php?id='.$_SESSION['id'].'\">'.$_SESSION['username'].'</a>: '.$comment.' &nbsp;&nbsp; <img style=\"width:12px;cursor:pointer\" src=\"deleteIcon.png\" /> </p> <br />");
			
				$("#answerCommentButton'.$answerId.'").attr(\'disabled\', false);

				$("#answerCommentButton'.$answerId.'").val("Comment");
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