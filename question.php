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
		$questionId = $_GET['id'];

		$questionId = preg_replace('#[^0-9]#i', '', $questionId);
		
		$query = 'SELECT * FROM questions WHERE id='.$questionId;
		
		$query_run = mysql_query($query);

		if(mysql_num_rows($query_run)==0)
		{				
			header('Location:pageUnavailable.php');

			die();
		}
		
		$title = mysql_result($query_run, 0, 'title');
		
		$desc = mysql_result($query_run, 0, 'desc');
		
		$votes = mysql_result($query_run, 0, 'votes');
		
		$answers = mysql_result($query_run, 0, 'answers');
		
		$askerId = mysql_result($query_run, 0, 'userId');

		$time = mysql_result($query_run, 0, 'time');
		
		$query = 'SELECT username, points FROM users WHERE id='.$askerId;
		
		$query_run = mysql_query($query);
		
		$askerName = mysql_result($query_run, 0, 'username');
		
		$askerPoints = mysql_result($query_run, 0, 'points');
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
		
		<meta name="description" content="<?php echo $title; ?>" />

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
		
		<meta name="keywords" content="automobiles, bikes, motorcycles, cars, parts, automotive, questions, answers, reviews" />
		
		<link rel="shortcut icon" href="favicon.png" type="image/x-icon" />

		<link rel="icon" href="favicon.png" type="image/x-icon" />
		
		<script src="jquery.js"></script>
		
		<link rel="stylesheet" type="text/css" href="question.css?<?php echo time();?>" />
		
		<script type="text/javascript">
			$(document).ready(function() {
				$('#upvoteQuestion').click(function() {
					$.ajax({
						type:'post',
						url:'upvoteQuestion.php',
						data:'id='+<?php echo $questionId;?> ,
						cache:'false',
						
						success:function(response)
						{
							$('#ajax').html(response);
						}
					});

					$(this).attr('disabled', true);

					$(this).val('shifting...');

					$('#downvoteQuestion').attr('disabled', true);
				});
		
				$('#downvoteQuestion').click(function() {
					$.ajax({
						type:'post',
						url:'downvoteQuestion.php',
						data:'id='+<?php echo $questionId;?> ,
						cache:'false',
						
						success:function(response)
						{
							$('#ajax').html(response);
						}
					});

					$(this).attr('disabled', true);

					$(this).val('shifting...');

					$('#upvoteQuestion').attr('disabled', true);
				});
				
				$('#showQuestionComments').click(function() {
					$.ajax({
						type:'post',
						url:'showQuestionComments.php',
						data:'id='+<?php echo $questionId;?>,
						cache:'false',
						
						success:function(response)
						{
							$('#questionComments').html(response);
							
							$('#questionComment').show();
							
							$('#questionCommentButton').show();
						}
					});

					$(this).val('loading...');

					$(this).attr('disabled', true);
				});
				
				$('#questionCommentButton').click(function() {
					$.ajax({
						type:'post',
						url:'addQuestionComment.php',
						data:{'id':<?php echo $questionId;?>, 'comment':$('#questionComment').val()},
						cache:'false',
						
						success:function(response)
						{
							$('#ajax').html(response);
						}
					});

					$(this).val('posting...');

					$(this).attr('disabled', true);
				});
				
				$('.upvoteAnswer').click(function() {
					$.ajax({
						type:'post',
						url:'upvoteAnswer.php',
						data:'id='+$(this).attr('answerId') ,
						cache:'false',
						
						success:function(response)
						{
							$('#ajax').html(response);
						}
					});

					$(this).val('shifting...');

					$(this).attr('disabled', true);

					$('#downvoteAnswer'+$(this).attr('answerId')).attr('disabled', true);
				});
				
				$('.downvoteAnswer').click(function() {
					$.ajax({
						type:'post',
						url:'downvoteAnswer.php',
						data:'id='+$(this).attr('answerId') ,
						cache:'false',
						
						success:function(response)
						{
							$('#ajax').html(response);
						}
					});

					$(this).val('shifting...');

					$(this).attr('disabled', true);

					$('#upvoteAnswer'+$(this).attr('answerId')).attr('disabled', true);
				});

				$('.showAnswerComments').click(function() {
					$.ajax({
						type:'post',
						url:'showAnswerComments.php',
						data:'id='+$(this).attr('answerId'),
						cache:'false',
						
						success:function(response)
						{
							$('#ajax').html(response);
						}
					});

					$(this).val('loading...');

					$(this).attr('disabled', true);
				});
				
				$('.answerCommentButton').click(function() {
					$.ajax({
						type:'post',
						url:'addAnswerComment.php',
						data:{'id':$(this).attr('answerId'), 'comment':$('#answerComment'+$(this).attr('answerId')).val()},
						cache:'false',
						
						success:function(response)
						{
							$('#ajax').html(response);
						}
					});

					$(this).val('posting...');

					$(this).attr('disabled', true);
				});

				$('#questionComments').on('click', '.questionCommentDelete img', function() {
					$.ajax({
						type:'post',
						url:'deleteQuestionComment.php',
						data:'id='+$(this).parent().attr('id'),
						cache:'false',

						success:function(response)
						{
							$('#ajax').html(response);
						}
					});
				});

				$('.answerComments').on('click', '.answerCommentDelete img', function() {
					$.ajax({
						type:'post',
						url:'deleteAnswerComment.php',
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
		<div id="alertBox">
			<p>You must be signed in to do that.</p>

			<input type="button" value="Sign In" onclick="redirect()"/> <br />

			<input type="button" value="Cancel" onclick="hideAlertBox()"/>
		</div>

		<div id="dark"></div>

		<div id="topStripe"></div>
		
		<div id="bottomStripe"></div>
		
		<div id="nav">
			<a href="home.php"><img id="logo" src="logoSmall.png" /></a>
			
			<div id="navLinks">
				<a href="questions.php"><span>Questions</span></a>
				
				<a href="reviews.php">Reviews</a>
				
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
					$query = 'SELECT image FROM questionImages WHERE questionId='.$questionId;

					$run = mysql_query($query); 

					if(mysql_num_rows($run) == 1)
					{
						$image = mysql_result($run, 0, 'image');

						echo '<br /> <br /> <div style="text-align:center;"><a href="showQuestionImage.php?id='.$questionId.'" target="_blank"><img style="width:300px;border:10px solid #2b2b2b;" src="data:image/jpeg;base64,'.base64_encode($image).'" /></a></div> <br /> <br />';
					}

					$query = 'SELECT name FROM tags WHERE questionId='.$questionId; 
				
					$run = mysql_query($query);
					
					echo '<p id="tags">';
					
					while($row  = mysql_fetch_assoc($run))
					{
						echo '
							<a href="taggedQuestions.php?name='.$row['name'].'">'.$row['name'].'</a> &nbsp;&nbsp;
						';
					}
					
					echo '</p>';
				?>
				
				<br />
				
				<?php
					if(!isset($_SESSION['id']))
					{
						echo '
							<p class="info">Gear <span class="num"> <span id="questionVotes">'.$votes.'</span> </span> &nbsp;|&nbsp; <input type="button" id="upvoteQuestion" value="Gear Up" /> &nbsp;|&nbsp; <input type="button" id="downvoteQuestion" value="Gear Down" /> &nbsp;|&nbsp; Asked By <a href="user.php?id='.$askerId.'" class="userLink">'.$askerName.' ('.$askerPoints.')</a> &nbsp;|&nbsp; '.$time.'</p>
						';
					}
					else if($askerId != $_SESSION['id'])
					{
						echo '
							<p class="info">Gear <span class="num"> <span id="questionVotes">'.$votes.'</span> </span> &nbsp;|&nbsp; <input type="button" id="upvoteQuestion" value="" /> &nbsp;|&nbsp; <input type="button" id="downvoteQuestion" value="" /> &nbsp;|&nbsp; Asked By <a href="user.php?id='.$askerId.'" class="userLink">'.$askerName.' ('.$askerPoints.')</a> &nbsp;|&nbsp; '.$time.'</p>
						';
						
						$query = 'SELECT type FROM questionVotes WHERE questionId='.$questionId.' AND userId='.$_SESSION['id'];
					
						$run = mysql_query($query);
						
						echo '<script type="text/javascript">';
						
						if(mysql_num_rows($run)==0)
						{
							echo '
								$("#upvoteQuestion").val("Gear Up");
								
								$("#downvoteQuestion").val("Gear Down");
							'; 
						}
						else
						{
							if(mysql_result($run, 0, 'type')=='up')
							{
								echo '
									$("#upvoteQuestion").val("Undo Gear Up");
								
									$("#downvoteQuestion").val("Gear Down");
								'; 
							}
							else
							{
								echo '
									$("#upvoteQuestion").val("Gear Up");
								
									$("#downvoteQuestion").val("Undo Gear Down");
								'; 
							}
						}
						
						echo '</script>';
					}
					else
					{
						echo '
							<p class="info">Gear <span class="num">'.$votes.'</span> &nbsp;|&nbsp; <span class="controls"><a href="editQuestion.php?id='.$questionId.'">Edit</a> &nbsp;|&nbsp; <a href="deleteQuestion.php?id='.$questionId.'">Delete</a></span> &nbsp;|&nbsp; Asked By <a href="user.php?id='.$askerId.'" class="userLink">'.$askerName.' ('.$askerPoints.')</a> &nbsp;|&nbsp; '.$time.'</p>
						';
					}
				?>
				
				<br />
				
				<div id="questionComments" style="word-spacing:5px;">
					<input type="button" id="showQuestionComments" value="Show comments / Add a comment">
				</div>
				
				<input class="hide" type="text" id="questionComment" maxlength="200"/> &nbsp;&nbsp;

				<input class="hide" type="button" id="questionCommentButton" value="Comment" />
				
				<br /><br />
				
				<p style="font-size:28px;">Answers :</p>
				
				<?php
					$query = 'SELECT * FROM answers WHERE questionId='.$questionId;

					$query_run = mysql_query($query);
					
					if(mysql_num_rows($query_run)==0)
					{
						echo '<br /> <br /><p style="color:#c92828;">No Answers Yet.</p> <br /> <br />';
					}
					
					while($row = mysql_fetch_assoc($query_run))
					{
						echo '<div class="answer"> <hr /> <br />';
						
						echo '<p class="answerDesc">'.$row['answer'].'</p>';

						$query = 'SELECT image FROM answerImages WHERE answerId='.$row['id'];

						$run = mysql_query($query);

						if(mysql_num_rows($run)==1)
						{
							$image = mysql_result($run, 0, 'image');

							echo '<br /> <br /> <div style="text-align:center;"><a href="showAnswerImage.php?id='.$row['id'].'" target="_blank"><img style="width:300px;border:10px solid #2b2b2b;" src="data:image/jpeg;base64,'.base64_encode($image).'" /></a></div> <br /> <br />';
						}
						
						$query = 'SELECT username, points FROM users WHERE id='.$row['userId'];
						
						$run = mysql_query($query);
						
						if(!isset($_SESSION['id']))
						{
							echo '
								<p class="info">Gear <span class="num"> <span id="answerVotes'.$row['id'].'">'.$row['votes'].'</span> </span> &nbsp;|&nbsp; <input type="button" class="upvoteAnswer" id="upvoteAnswer'.$row['id'].'" answerId="'.$row['id'].'" value="Gear Up" /> &nbsp;|&nbsp; <input type="button" class="downvoteAnswer" id="downvoteAnswer'.$row['id'].'" answerId="'.$row['id'].'" value="Gear Down" /> &nbsp;|&nbsp; Answered By <a href="user.php?id='.$row['userId'].'" class="userLink">'.mysql_result($run, 0, 'username').' ('.mysql_result($run, 0, 'points').')</a> &nbsp;|&nbsp; '.$row['time'].'</p>
							';
						}
						else if($_SESSION['id'] != $row['userId'])
						{
							echo '
								<p class="info">Gear <span class="num"> <span id="answerVotes'.$row['id'].'">'.$row['votes'].'</span> </span> &nbsp;|&nbsp; <input type="button" class="upvoteAnswer" id="upvoteAnswer'.$row['id'].'" answerId="'.$row['id'].'" value="" /> &nbsp;|&nbsp; <input type="button" class="downvoteAnswer" id="downvoteAnswer'.$row['id'].'" answerId="'.$row['id'].'" value="" /> &nbsp;|&nbsp; Answered By <a href="user.php?id='.$row['userId'].'" class="userLink">'.mysql_result($run, 0, 'username').' ('.mysql_result($run, 0, 'points').')</a> &nbsp;|&nbsp; '.$row['time'].'</p>
							';
							
							$query = 'SELECT type FROM answerVotes WHERE answerId='.$row['id'].' AND userId='.$_SESSION['id'];
							
							$run = mysql_query($query);
							
							echo '<script type="text/javascript">';
							
							if(mysql_num_rows($run)==0)
							{
								echo '
									$("#upvoteAnswer'.$row['id'].'").val("Gear Up");
								
									$("#downvoteAnswer'.$row['id'].'").val("Gear Down");
								';
							}
							else
							{
								if(mysql_result($run, 0, 'type') == 'up')
								{
									echo '
										$("#upvoteAnswer'.$row['id'].'").val("Undo Gear Up");
								
										$("#downvoteAnswer'.$row['id'].'").val("Gear Down");
									';
								}
								else
								{
									echo '
										$("#upvoteAnswer'.$row['id'].'").val("Gear Up");
								
										$("#downvoteAnswer'.$row['id'].'").val("Undo Gear Down");
									';
								}
							}
							
							echo '</script>';
						}
						else
						{
							echo '
								<p class="info">Gear <span class="num">'.$row['votes'].'</span> &nbsp;|&nbsp; <span class="controls"><a href="editAnswer.php?id='.$row['id'].'">Edit</a> &nbsp;|&nbsp; <a href="deleteAnswer.php?id='.$row['id'].'">Delete</a></span> &nbsp;|&nbsp; Answered By <a href="user.php?id='.$row['userId'].'" class="userLink">'.mysql_result($run, 0, 'username').' ('.mysql_result($run, 0, 'points').')</a> &nbsp;|&nbsp; '.$row['time'].'</p>
							';
						}
						
						echo '<br />';
						
						echo '
							<div class="answerComments" id="answerComments'.$row['id'].'" style="word-spacing:5px;">
								<input type="button" class="showAnswerComments" answerId="'.$row['id'].'" value="Show comments / Add a comment">
							</div>
							
							<input type="text" class="answerComment" id="answerComment'.$row['id'].'" maxlength="200"/> &nbsp;&nbsp;
							
							<input type="button" class="answerCommentButton" id="answerCommentButton'.$row['id'].'" answerId="'.$row['id'].'" value="Comment" />
						';
						
						echo '<br /> <br /> </div>';
					}
				?>
				
				<?php
					$allowToAnswer = true;
					
					if(!isset($_SESSION['id']))
					{
						$allowToAnswer = false;
					}
					else if($askerId == $_SESSION['id'])
					{
						$allowToAnswer = false;
					}
					else
					{
						$query = 'SELECT id FROM answers WHERE questionId='.$questionId.' AND userId='.$_SESSION['id'];
						
						$query_run = mysql_query($query);
						
						if(mysql_num_rows($query_run)==1)
						{
							$allowToAnswer = false;
						}
					}
				?>

				<?php if($allowToAnswer):?>
					<p style="font-size:28px;">Write an Answer :</p>
					
					<hr /> <br />
					
					<form action="addAnswer.php?questionId=<?php echo $questionId; ?>" method="POST" enctype="multipart/form-data">
						<textarea style="font-family:Armata; width:690px; padding:5px;" rows="10" cols="50" name="answer" maxlength="1000"></textarea>
						
						<br /><br />

						<p style="color:black;">Attach image: &nbsp;&nbsp;&nbsp;&nbsp; <input type="file" name="image" /></p>

						<br /><input id="submitAnswer" type="submit" value="Submit" />
					</form>
				<?php endif; ?>

				<?php
					if(!isset($_SESSION['id']))
					{
						echo '<p><a href="index.php" style="text-decoration:none; color:#c92828;">Sign In</a> to write an answer.</p>';
					}
				?>
			</div>
			
			<div id="left">
				<p><a href="askQuestion.php">Ask a Question</a></p>
			
				<p><a href="questions.php">Most Recent</a></p>
				
				<p><a href="questions.php?sort=highest">Top-Geared</a></p>
				
				<p><a href="questions.php?sort=unanswered">Unanswered</a></p>
				
				<p><a href="allQuestionTags.php">All Tags</a></p>
			</div>

			<div style="clear:both;"></div> <br /><br />
		</div>

		<div id="ajax"></div>
		
		<script type="text/javascript" src="question.js"></script>

		<div id="footer">
			<p>&copy; Torque Xtreme 2014 &nbsp;&nbsp; | &nbsp;&nbsp; <a href="about.php">About</a> &nbsp;&nbsp; | &nbsp;&nbsp; <a href="contact.php">Contact</a> &nbsp;&nbsp; | &nbsp;&nbsp; <a href="sitemap.xml">Sitemap</a></p>
		</div>
	</body>
</html>

<div id="ajax"></div>