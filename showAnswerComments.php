<?php
	session_start();
	
	require 'mysqlCon.inc.php';
	
	require 'midSignedInCheck.inc.php';
	
	if(isset($_POST['id']))
	{
		$answerId = $_POST['id'];
		
		$query = 'SELECT id, userId, comment, username FROM answerComments WHERE answerId='.$answerId;
		
		$query_run = mysql_query($query);

		echo '<script> $("#answerComments'.$answerId.'").html("';
		
		if(mysql_num_rows($query_run)==0)
		{
			echo '<p>No Comments Yet.</p> <br />';
		}
		else
		{
			echo '<p style=\"text-decoration:underline\">Comments:</p> <br />';

			while($row = mysql_fetch_assoc($query_run))
			{
				if(!isset($_SESSION['id']))
				{
					echo '<p><a href=\"user.php?id='.$row['userId'].'\">'.$row['username'].'</a>: '.$row['comment'].'</p> <br />';	
				}
				else if($row['userId'] != $_SESSION['id'])
				{
					echo '<p><a href=\"user.php?id='.$row['userId'].'\">'.$row['username'].'</a>: '.$row['comment'].'</p> <br />';
				}
				else
				{
					echo '<p class=\"answerCommentDelete\" id=\"'.$row['id'].'\"><a href=\"user.php?id='.$row['userId'].'\">'.$row['username'].'</a>: '.$row['comment'].' &nbsp;&nbsp; <img style=\"width:12px;cursor:pointer\" src=\"deleteIcon.png\" /> </p> <br />';
				}
			}
		}
		
		echo '"); 
		
		$("#answerComment'.$answerId.'").show();
		
		$("#answerCommentButton'.$answerId.'").show();
		
		</script>';
	}
	else
	{
		echo '<p>OOPS! Something went wrong.</p>'; //user has not come through showQuestionComments option
		
		die();
	}
?>