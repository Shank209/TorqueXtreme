<?php
	session_start();
	
	require 'mysqlCon.inc.php';
	
	require 'midSignedInCheck.inc.php';

	if(isset($_GET['name']))
	{
		$tagName = $_GET['name'];
	}
	else
	{
		header('Location:pageUnavailable.php');

		die();
	}

	if(isset($_GET['sort']))
	{
		$sort = $_GET['sort'];

		if($sort!='recent' && $sort!='highest' && $sort!='unanswered')
		{
			$sort == 'recent';
		}
	}
	else
	{
		$sort = 'recent';
	}
	
	if($sort=='unanswered')
	{
		$query = 'SELECT id FROM questions INNER JOIN tags ON tags.questionId=questions.id WHERE questions.answers=0 AND tags.name="'.$tagName.'"';
	}
	else
	{
		$query = 'SELECT id FROM questions INNER JOIN tags ON tags.questionId=questions.id WHERE tags.name="'.$tagName.'"';
	}

	$query_run = mysql_query($query);

	$numRows = mysql_num_rows($query_run);

	if(isset($_GET['pn']))
	{
		$pageNum = preg_replace('#[^0-9]#i', '', $_GET['pn']);
	}
	else
	{
		$pageNum = 1;
	}

	$itemsPerPage = 7;

	$lastPage = ceil($numRows/$itemsPerPage); 

	if($lastPage<1)
	{
		$lastPage=1;
	}

	if($pageNum < 1 )
	{
		$pageNum = 1;
	}
	else if($pageNum > $lastPage)
	{
		$pageNum = $lastPage;
	}									//echo '<script>alert("'.$pageNum.'");</script>';

	if($sort=='recent')
	{
		$query = 'SELECT id, title, userId, votes, answers FROM questions INNER JOIN tags ON tags.questionId = questions.id WHERE tags.name="'.$tagName.'" ORDER BY id DESC LIMIT '.($pageNum-1)*$itemsPerPage.', '.$itemsPerPage;
	}
	else if($sort=='highest')
	{
		$query = 'SELECT id, title, userId, votes, answers FROM questions INNER JOIN tags ON tags.questionId = questions.id WHERE tags.name="'.$tagName.'" ORDER BY votes DESC, id DESC LIMIT '.($pageNum-1)*$itemsPerPage.', '.$itemsPerPage;
	}
	else
	{ 
		$query = 'SELECT id, title, userId, votes, answers FROM questions INNER JOIN tags ON tags.questionId = questions.id WHERE answers=0 AND tags.name="'.$tagName.'" ORDER BY id DESC LIMIT '.($pageNum-1)*$itemsPerPage.', '.$itemsPerPage;
	}

	$query_run = mysql_query($query);
?>

<!doctype html>

<html lang="en">
	<head>
		<meta charset="utf-8" />
	
		<title><?php echo $tagName; ?> - Questions | Torque Xtreme</title>

		<meta name="description" content="Questions tagged with <?php echo $tagName; ?>" />
		
		<script src="jquery.js"></script>
		
		<link rel="stylesheet" type="text/css" href="taggedQuestions.css?<?php echo time();?>" />
		
		<meta name="keywords" content="automobiles, bikes, motorcycles, cars, parts, automotive, questions, answers, reviews" />
		
		<link rel="shortcut icon" href="favicon.png" type="image/x-icon" />

		<link rel="icon" href="favicon.png" type="image/x-icon" />
	</head>
	
	<body>
		<div id="topStripe"></div>
		
		<div id="bottomStripe"></div>
		
		<input type="hidden" id="sort" value="<?php echo $sort;?>" />

		<input type="hidden" id="tagName" value="<?php echo $tagName; ?>" />

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
				<p id="taggedHeader">Questions tagged with <span><?php echo $tagName; ?></span>:</p>

				<?php
					if(mysql_num_rows($query_run)==0)
					{
						echo '<br /><br /><p style="font-family:Armata;text-align:center;">No questions under this tag right now.</p> <br />';
					}

					else
					{
						while($row = mysql_fetch_assoc($query_run))
						{
							$userId = $row['userId'];
				
							$query = 'SELECT username, points FROM users WHERE id='.$userId;
							
							$run = mysql_query($query);
							
							echo '
								<div class="question">
									<p class="title"> <a href="question.php?id='.$row['id'].'">'.$row['title'].'</a> </p>
									
									<p class="info"> Answers <span class="num">'.$row['answers'].'</span> &nbsp;|&nbsp; Gear <span class="num">'.$row['votes'].'</span> &nbsp;|&nbsp; Asked by <a href="" class="userLink">'.mysql_result($run, 0, 'username').' ('.mysql_result($run, 0, 'points').')</a></p>
								</div>
								
								<hr />
							';
						}
					}
				?>

				<br />

				<div id="pagination">
					<?php
						echo '<p>Page '.$pageNum.' of '.$lastPage.'&nbsp;&nbsp;';

						if($pageNum==1 && $pageNum==$lastPage)
						{
							echo '</p>';
						}
						else if($pageNum==1)
						{
							$nextNum = $pageNum+1;

							echo '|&nbsp;&nbsp;<a href="taggedQuestions.php?name='.$tagName.'&pn='.$nextNum.'&sort='.$sort.'">Next &gt;</a>&nbsp;&nbsp; | &nbsp;&nbsp; Go to page: <input type="text" id="pageNumInput" placeholder="'.$lastPage.'" /> &nbsp;&nbsp; <input type="button" id="goToPage" value="Go" /></p>';
						}
						else if($pageNum==$lastPage)
						{
							$prevNum = $pageNum-1;

							echo '|&nbsp;&nbsp;<a href="taggedQuestions.php?name='.$tagName.'&pn='.$prevNum.'&sort='.$sort.'">&lt; Prev</a>&nbsp;&nbsp; | &nbsp;&nbsp; Go to page: <input type="text" id="pageNumInput" placeholder="'.$lastPage.'" /> &nbsp;&nbsp; <input type="button" id="goToPage" value="Go" /></p>';
						}
						else
						{
							$nextNum = $pageNum+1;

							$prevNum = $pageNum-1;

							echo '|&nbsp;&nbsp;<a href="taggedQuestions.php?name='.$tagName.'&pn='.$prevNum.'&sort='.$sort.'">&lt; Prev</a>&nbsp;&nbsp; |&nbsp;&nbsp;<a href="taggedQuestions.php?name='.$tagName.'&pn='.$nextNum.'&sort='.$sort.'">Next &gt;</a>&nbsp;&nbsp; | &nbsp;&nbsp; Go to page: <input type="text" id="pageNumInput" placeholder="'.$lastPage.'" /> &nbsp;&nbsp; <input type="button" id="goToPage" value="Go" /></p>';
						}
					?>
				</div>

				<br />
			</div>
			
			<div id="left">
				<p><a href="askQuestion.php">Ask a Question</a></p>
			
				<p><a href="taggedQuestions.php?name=<?php echo $tagName; ?>" id="recent">Most Recent</a></p>
				
				<p><a href="taggedQuestions.php?name=<?php echo $tagName; ?>&sort=highest" id="highest">Top-Geared</a></p>
				
				<p><a href="taggedQuestions.php?name=<?php echo $tagName; ?>&sort=unanswered" id="unanswered">Unanswered</a></p>
				
				<p><a href="allQuestionTags.php">All Tags</a></p>
			</div>

			<div style="clear:both;"></div> <br /><br />
		</div>
		
		<?php
			echo '
				<script>
					$("#'.$sort.'").css("color", "#c92828");
				</script>
			';
		?>

		<script type="text/javascript" src="taggedQuestions.js"></script>

		<div id="footer">
			<p>&copy; Torque Xtreme 2014 &nbsp;&nbsp; | &nbsp;&nbsp; <a href="about.php">About</a> &nbsp;&nbsp; | &nbsp;&nbsp; <a href="contact.php">Contact</a> &nbsp;&nbsp; | &nbsp;&nbsp; <a href="sitemap.xml">Sitemap</p>
		</div>
	</body>
</html>