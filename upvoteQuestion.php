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
				
				$("#upvoteQuestion").val("Gear Up");

				$("#upvoteQuestion").attr(\'disabled\', false);

				$("#downvoteQuestion").attr(\'disabled\', false);
			</script>
		';

		die();
	}

	else if(isset($_POST['id']))
	{
		$questionId = $_POST['id'];
		
		$query = 'SELECT type FROM questionVotes WHERE questionId='.$questionId.' AND userId='.$_SESSION['id'];
	
		$query_run = mysql_query($query);
		
		if(mysql_num_rows($query_run)==0)
		{
			$query = 'SELECT userId FROM questions WHERE id='.$questionId;
			
			$query_run = mysql_query($query);
			
			$update = 'UPDATE users SET points=points+10 WHERE id='.mysql_result($query_run, 0, 'userId');
			
			mysql_query($update);
			
			$insert = 'INSERT INTO questionVotes VALUES("up", '.$_SESSION['id'].', '.$questionId.')';
			
			mysql_query($insert);
			
			$update = 'UPDATE questions SET votes=votes+1 WHERE id='.$questionId;
			
			mysql_query($update);
			
			echo '
				<script type="text/javascript">
					var curr = $("#questionVotes").text();
					
					curr = parseInt(curr);
					
					curr++;
					
					$("#questionVotes").text(curr);
					
					$("#upvoteQuestion").val("Undo Gear Up");

					$("#upvoteQuestion").attr(\'disabled\', false);

					$("#downvoteQuestion").attr(\'disabled\', false);
				</script>
			';
		}
		else
		{
			if(mysql_result($query_run, 0, 'type')=='up')
			{
				$query = 'SELECT userId FROM questions WHERE id='.$questionId;
			
				$query_run = mysql_query($query);
				
				$update = 'UPDATE users SET points=points-10 WHERE id='.mysql_result($query_run, 0, 'userId');
				
				mysql_query($update);
				
				$delete = 'DELETE FROM questionVotes WHERE userID='.$_SESSION['id'].' AND questionId='.$questionId;
				
				mysql_query($delete);
				
				$update = 'UPDATE questions SET votes=votes-1 WHERE id='.$questionId;
			
				mysql_query($update);
				
				echo '
					<script type="text/javascript">
						var curr = $("#questionVotes").text();
						
						curr = parseInt(curr);
						
						curr--;
						
						$("#questionVotes").text(curr);
						
						$("#upvoteQuestion").val("Gear Up");

						$("#upvoteQuestion").attr(\'disabled\', false);

						$("#downvoteQuestion").attr(\'disabled\', false);
					</script>
				';
			}
			else
			{
				$query = 'SELECT userId FROM questions WHERE id='.$questionId;
			
				$query_run = mysql_query($query);
				
				$update = 'UPDATE users SET points=points+12 WHERE id='.mysql_result($query_run, 0, 'userId');
				
				mysql_query($update);
				
				$update = 'UPDATE questionVotes SET type="up" WHERE userId='.$_SESSION['id'].' AND questionId='.$questionId;
				
				mysql_query($update);
				
				$update = 'UPDATE questions SET votes=votes+2 WHERE id='.$questionId;
			
			mysql_query($update);
				
				echo '
					<script type="text/javascript">
						var curr = $("#questionVotes").text();
						
						curr = parseInt(curr);
						
						curr = curr+2;
						
						$("#questionVotes").text(curr);
						
						$("#upvoteQuestion").val("Undo Gear Up");
						
						$("#downvoteQuestion").val("Gear Down");

						$("#upvoteQuestion").attr(\'disabled\', false);

						$("#downvoteQuestion").attr(\'disabled\', false);
					</script>
				';
			}
		}
	}
	else
	{
		echo '<p>OOPS! Something went wrong.</p>'; //question id is not set
		
		die();
	}
?>