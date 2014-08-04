<?php
	session_start();
	
	require 'mysqlCon.inc.php';
	
	require 'midSignedInCheck.inc.php';

	if(isset($_SESSION['shareName']))
	{
		unset($_SESSION['shareName']);

		unset($_SESSION['shareTitle']);

		unset($_SESSION['shareDesc']);

		unset($_SESSION['shareId']);
	}
	
	if(isset($_GET['id']))
	{
		$reviewId = $_GET['id'];
		
		$reviewId = preg_replace('#[^0-9]#i', '', $reviewId);

		$query = 'SELECT * FROM reviews WHERE id='.$reviewId;
		
		$query_run = mysql_query($query);

		if(mysql_num_rows($query_run)==0)
		{				
			header('Location:pageUnavailable.php');

			die();
		}
		
		$title = mysql_result($query_run, 0, 'title');
		
		$desc = mysql_result($query_run, 0, 'desc');
		
		$votes = mysql_result($query_run, 0, 'votes');
		
		$writerId = mysql_result($query_run, 0, 'userId');

		$time = mysql_result($query_run, 0, 'time');
		
		$query = 'SELECT username, points FROM users WHERE id='.$writerId;
		
		$query_run = mysql_query($query);
		
		$writerName = mysql_result($query_run, 0, 'username');
		
		$writerPoints = mysql_result($query_run, 0, 'points');
	}
	else
	{
		header('Location:pageUnavailable.php'); //question id not set. so redirect to index 
		
		die();
	}
?>

<!doctype html>

<html lang="en">
	<head>
		<meta charset="utf-8" />
	
		<title>
			<?php
				if(strlen($title)>70)
				{
					echo substr($title, 0, 70);
				}
				else
				{
					echo $title;
				}
			?>
		</title>
		
		<meta name="description" content="<?php echo $title; ?>" />
		
		<meta name="keywords" content="automobiles, bikes, motorcycles, cars, parts, automotive, questions, answers, reviews" />
		
		<link rel="shortcut icon" href="favicon.png" type="image/x-icon" />

		<link rel="icon" href="favicon.png" type="image/x-icon" />

		<script src="jquery.js"></script>
		
		<link rel="stylesheet" type="text/css" href="review.css?<?php echo time();?>" />
		
		<script type="text/javascript">
			$(document).ready(function() {
				$('#upvoteReview').click(function() {
					$.ajax({
						type:'post',
						url:'upvoteReview.php',
						data:'id='+<?php echo $reviewId;?> ,
						cache:'false',
						
						success:function(response)
						{
							$('#ajax').html(response);
						}
					});

					$(this).val('shifting...');

					$(this).attr('disabled', true);

					$('#downvoteReview').attr('disabled', true);
				});
		
				$('#downvoteReview').click(function() {
					$.ajax({
						type:'post',
						url:'downvoteReview.php',
						data:'id='+<?php echo $reviewId;?> ,
						cache:'false',
						
						success:function(response)
						{
							$('#ajax').html(response);
						}
					});

					$(this).val('shifting...');

					$(this).attr('disabled', true);

					$('#downvoteReview').attr('disabled', true);
				});
				
				$('#showReviewComments').click(function() {
					$.ajax({
						type:'post',
						url:'showReviewComments.php',
						data:'id='+<?php echo $reviewId;?>,
						cache:'false',
						
						success:function(response)
						{
							$('#reviewComments').html(response);
							
							$('#reviewComment').show();
							
							$('#reviewCommentButton').show();
						}
					});

					$(this).val('loading...');

					$(this).attr('disabled', true);
				});
				
				$('#reviewCommentButton').click(function() {
					$.ajax({
						type:'post',
						url:'addReviewComment.php',
						data:{'id':<?php echo $reviewId;?>, 'comment':$('#reviewComment').val()},
						cache:'false',
						
						success:function(response)
						{
							$('#ajax').html(response);
						}
					});

					$(this).attr('disabled', true);

					$(this).val('posting...');
				});

				$('#reviewComments').on('click', '.reviewCommentDelete img', function() {
					$.ajax({
						type:'post',
						url:'deleteReviewComment.php',
						data:'id='+$(this).parent().attr('id'),
						cache:'false',

						success:function(response)
						{
							$('#ajax').html(response);
						}
					});
				});
			});
		</script>
	</head>
	
	<body>
		<div id="dark"></div>

		<div id="alertBox">
			<p>You must be signed in to do that.</p>

			<input type="button" value="Sign In" onclick="redirect()"/> <br />

			<input type="button" value="Cancel" onclick="hideAlertBox()"/>
		</div>

		<div id="topStripe"></div>
		
		<div id="bottomStripe"></div>
		
		<div id="nav">
			<a href="home.php"><img id="logo" src="logoSmall.png" /></a>
			
			<div id="navLinks">
				<a href="questions.php">Questions</a>
				
				<a href="reviews.php"><span>Reviews</span></a>
				
				<?php if(isset($_SESSION['id'])): ?>
					<a href="user.php?id=<?php echo $_SESSION['id']; ?>">Account</a>
					
					<a href="signOut.php">Sign Out</a>
				<?php endif; ?>
			</div>
		</div>
		
		<div id="container">
			<div id="right">
				<h1 id="title"><?php echo $title;?></h1>
				
				<hr /> <br />
				
				<p id="desc"><?php echo $desc;?></p>
				
				<?php 
					$query = 'SELECT image FROM reviewImages WHERE reviewId='.$reviewId;

					$run = mysql_query($query); 

					if(mysql_num_rows($run) == 1)
					{
						$image = mysql_result($run, 0, 'image');

						echo '<br /> <br /> <div style="text-align:center;"><a href="showReviewImage.php?id='.$reviewId.'" target="_blank"><img style="width:300px;border:10px solid #2b2b2b;" src="data:image/jpeg;base64,'.base64_encode($image).'" /></a></div> <br /> <br />';
					}

					$query = 'SELECT name FROM reviewsTags WHERE reviewId='.$reviewId; 
				
					$run = mysql_query($query);
					
					echo '<p id="tags">';
					
					while($row  = mysql_fetch_assoc($run))
					{
						echo '
							<a href="taggedReviews.php?name='.$row['name'].'">'.$row['name'].'</a> &nbsp;&nbsp;
						';
					}
					
					echo '</p>';
				?>
				
				<br />
				
				<?php
					if(!(isset($_SESSION['id'])))
					{
						echo '
							<p class="info">Gear <span class="num"> <span id="reviewVotes">'.$votes.'</span> </span> &nbsp;|&nbsp; <input type="button" id="upvoteReview" value="Gear Up" /> &nbsp;|&nbsp; <input type="button" id="downvoteReview" value="Gear Down" /> &nbsp;|&nbsp; Written By <a href="user.php?id='.$writerId.'" class="userLink">'.$writerName.' ('.$writerPoints.')</a> &nbsp;|&nbsp; '.$time.'</p>
						';
					}
					else if($writerId != $_SESSION['id'])
					{
						echo '
							<p class="info">Gear <span class="num"> <span id="reviewVotes">'.$votes.'</span> </span> &nbsp;|&nbsp; <input type="button" id="upvoteReview" value="" /> &nbsp;|&nbsp; <input type="button" id="downvoteReview" value="" /> &nbsp;|&nbsp; Written By <a href="user.php?id='.$writerId.'" class="userLink">'.$writerName.' ('.$writerPoints.')</a> &nbsp;|&nbsp; '.$time.'</p>
						';
						
						$query = 'SELECT type FROM reviewVotes WHERE reviewId='.$reviewId.' AND userId='.$_SESSION['id'];
					
						$run = mysql_query($query);
						
						echo '<script type="text/javascript">';
						
						if(mysql_num_rows($run)==0)
						{
							echo '
								$("#upvoteReview").val("Gear Up");
								
								$("#downvoteReview").val("Gear Down");
							'; 
						}
						else
						{
							if(mysql_result($run, 0, 'type')=='up')
							{
								echo '
									$("#upvoteReview").val("Undo Gear Up");
								
									$("#downvoteReview").val("Gear Down");
								'; 
							}
							else
							{
								echo '
									$("#upvoteReview").val("Gear Up");
								
									$("#downvoteReview").val("Undo Gear Down");
								'; 
							}
						}
						
						echo '</script>';
					}
					else
					{
						echo '
							<p class="info">Gear <span class="num">'.$votes.'</span> &nbsp;|&nbsp; <span class="controls"><a href="editReview.php?id='.$reviewId.'">Edit</a> &nbsp;|&nbsp; <a href="deleteReview.php?id='.$reviewId.'">Delete</a></span> &nbsp;|&nbsp; Written By <a href="user.php?id='.$writerId.'" class="userLink">'.$writerName.' ('.$writerPoints.')</a> &nbsp;|&nbsp; '.$time.'</p>
						';
					}
				?>
				
				<br />
				
				<div id="reviewComments">
					<input type="button" id="showReviewComments" value="Show comments / Add a comment">
				</div>
				
				<input class="hide" type="text" id="reviewComment" maxlength="200"/> &nbsp;&nbsp;

				<input class="hide" type="button" id="reviewCommentButton" value="Comment" />
				
				<br />
			</div>
			
			<div id="left">
				<p><a href="writeReview.php">Write a Review</a></p>
			
				<p><a href="reviews.php">Most Recent</a></p>
				
				<p><a href="reviews.php?sort=highest">Top-Geared</a></p>
				
				<p><a href="allReviewTags.php">All Tags</a></p>
			</div>

			<div style="clear:both;"></div> <br /><br />
		</div>

		<div id="ajax"></div>
		
		<script type="text/javascript" src="review.js"></script>

		<div id="footer">
			<p>&copy; Torque Xtreme 2014 &nbsp;&nbsp; | &nbsp;&nbsp; <a href="about.php">About</a> &nbsp;&nbsp; | &nbsp;&nbsp; <a href="contact.php">Contact</a> &nbsp;&nbsp; | &nbsp;&nbsp; <a href="sitemap.xml">Sitemap</a></p>
		</div>
	</body>
</html>

<div id="ajax"></div>