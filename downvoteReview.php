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
				
				$("#downvoteReview").val("Gear Down");

				$("#upvoteReview").attr(\'disabled\', false);

				$("#downvoteReview").attr(\'disabled\', false);
			</script>
		';

		die();
	}
	
	if(isset($_POST['id']))
	{
		$reviewId = $_POST['id'];
		
		$query = 'SELECT type FROM reviewVotes WHERE reviewId='.$reviewId.' AND userId='.$_SESSION['id'];
	
		$query_run = mysql_query($query);
		
		if(mysql_num_rows($query_run)==0)
		{
			$query = 'SELECT userId FROM reviews WHERE id='.$reviewId;
			
			$query_run = mysql_query($query);

			if(mysql_num_rows($query_run)==1)
			{				
				$update = 'UPDATE users SET points=points-2 WHERE id='.mysql_result($query_run, 0, 'userId');
			
				mysql_query($update);
			}
			
			$insert = 'INSERT INTO reviewVotes VALUES("down", '.$reviewId.', '.$_SESSION['id'].')';
			
			mysql_query($insert);
			
			$update = 'UPDATE reviews SET votes=votes-1 WHERE id='.$reviewId;
			
			mysql_query($update);
			
			echo '
				<script type="text/javascript">
					var curr = $("#reviewVotes").text();
					
					curr = parseInt(curr);
					
					curr--;
					
					$("#reviewVotes").text(curr);
					
					$("#downvoteReview").val("Undo Gear Down");

					$("#upvoteReview").attr(\'disabled\', false);

					$("#downvoteReview").attr(\'disabled\', false);
				</script>
			';
		}
		else
		{
			if(mysql_result($query_run, 0, 'type')=='up')
			{
				$query = 'SELECT userId FROM reviews WHERE id='.$reviewId;
			
				$query_run = mysql_query($query);

				if(mysql_num_rows($query_run)==1)
				{					
					$update = 'UPDATE users SET points=points-12 WHERE id='.mysql_result($query_run, 0, 'userId');
				
					mysql_query($update);
				}
				
				$update = 'UPDATE reviewVotes SET type="down" WHERE userId='.$_SESSION['id'].' AND reviewId='.$reviewId;
				
				mysql_query($update);
				
				$update = 'UPDATE reviews SET votes=votes-2 WHERE id='.$reviewId;
			
				mysql_query($update);
				
				echo '
					<script type="text/javascript">
						var curr = $("#reviewVotes").text();
						
						curr = parseInt(curr);
						
						curr = curr-2;
						
						$("#reviewVotes").text(curr);
						
						$("#downvoteReview").val("Undo Gear Down");
						
						$("#upvoteReview").val("Gear Up");

						$("#upvoteReview").attr(\'disabled\', false);

						$("#downvoteReview").attr(\'disabled\', false);
					</script>
				';
			}
			else
			{
				$query = 'SELECT userId FROM reviews WHERE id='.$reviewId;
			
				$query_run = mysql_query($query);

				if(mysql_num_rows($query_run)==1)
				{				
					$update = 'UPDATE users SET points=points+2 WHERE id='.mysql_result($query_run, 0, 'userId');
				
					mysql_query($update);
				}
				
				$delete = 'DELETE FROM reviewVotes WHERE userId='.$_SESSION['id'].' AND reviewId='.$reviewId;
				
				mysql_query($delete);
				
				$update = 'UPDATE reviews SET votes=votes+1 WHERE id='.$reviewId;
			
				mysql_query($update);
				
				echo '
					<script type="text/javascript">
						var curr = $("#reviewVotes").text();
						
						curr = parseInt(curr);
						
						curr++;
						
						$("#reviewVotes").text(curr);
						
						$("#downvoteReview").val("Gear Down");

						$("#upvoteReview").attr(\'disabled\', false);

						$("#downvoteReview").attr(\'disabled\', false);
					</script>
				';
			}
		}
	}
	else
	{
		echo '<script type="text/javascript">alert("OOPS! Something went wrong.");</script>';
		
		die();
	}
?>