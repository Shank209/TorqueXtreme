<?php
	session_start();
	
	require 'mysqlCon.inc.php';
	
	require 'midSignedInCheck.inc.php';

	if(!isset($_GET['id']))
	{
		header('Location:pageUnavailable.php');

		die();
	}

	$userId = $_GET['id'];

	$userId = preg_replace('#[^0-9]#i', '', $userId);

	$query = 'SELECT id FROM questions WHERE userId='.$userId;

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

	$query = 'SELECT id, title, votes, answers FROM questions WHERE userId='.$userId.' ORDER BY id DESC LIMIT '.($pageNum-1)*$itemsPerPage.', '.$itemsPerPage;

	$query_run = mysql_query($query); 
?>

<!doctype html>

<html lang="en">
	<head>
		<meta charset="utf-8" />
	
		<title>Questions | Torque Xtreme</title>

		<meta name="description" content="Questions asked by this user." />
		
		<script src="jquery.js"></script>
		
		<link rel="stylesheet" type="text/css" href="userQuestions.css?<?php echo time();?>" />
		
		<meta name="keywords" content="automobiles, bikes, motorcycles, cars, parts, automotive, questions, answers, reviews" />
		
		<link rel="shortcut icon" href="favicon.png" type="image/x-icon" />

		<link rel="icon" href="favicon.png" type="image/x-icon" />
	</head>
	
	<body>
		<div id="topStripe"></div>
		
		<div id="bottomStripe"></div>

		<input type="hidden" id="userId" value="<?php echo $userId;?>" />

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
				<?php
					if(mysql_num_rows($query_run)==0)
					{
						echo '<br /><br /><p style="font-family:Armata;text-align:center;">This user has not asked any questions yet.</p> <br />';
					}

					else
					{
						$query = 'SELECT username, points FROM users WHERE id='.$userId;
							
						$run = mysql_query($query);

						echo '<p id="header">Questions asked by <span>'.mysql_result($run, 0, 'username').'</span></p> <br />';

						while($row = mysql_fetch_assoc($query_run))
						{	
							echo '
								<div class="question">
									<p class="title"> <a href="question.php?id='.$row['id'].'">'.$row['title'].'</a> </p>
									
									<p class="info"> Answers <span class="num">'.$row['answers'].'</span> &nbsp;|&nbsp; Gear <span class="num">'.$row['votes'].'</span> &nbsp;|&nbsp; Asked by <a href="user.php?id='.$userId.'" class="userLink">'.mysql_result($run, 0, 'username').' ('.mysql_result($run, 0, 'points').')</a></p>
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

							echo '|&nbsp;&nbsp;<a href="userQuestions.php?pn='.$nextNum.'&id='.$userId.'">Next &gt;</a>&nbsp;&nbsp; | &nbsp;&nbsp; Go to page: <input type="text" id="pageNumInput" placeholder="'.$lastPage.'" /> &nbsp;&nbsp; <input type="button" id="goToPage" value="Go" /></p>';
						}
						else if($pageNum==$lastPage)
						{
							$prevNum = $pageNum-1;

							echo '|&nbsp;&nbsp;<a href="userQuestions.php?pn='.$prevNum.'&id='.$userId.'">&lt; Prev</a>&nbsp;&nbsp; | &nbsp;&nbsp; Go to page: <input type="text" id="pageNumInput" placeholder="'.$lastPage.'" /> &nbsp;&nbsp; <input type="button" id="goToPage" value="Go" /></p>';
						}
						else
						{
							$nextNum = $pageNum+1;

							$prevNum = $pageNum-1;

							echo '|&nbsp;&nbsp;<a href="userQuestions.php?pn='.$prevNum.'&id='.$userId.'">&lt; Prev</a>&nbsp;&nbsp; |&nbsp;&nbsp;<a href="userQuestions.php?pn='.$nextNum.'&id='.$userId.'">Next &gt;</a>&nbsp;&nbsp; | &nbsp;&nbsp; Go to page: <input type="text" id="pageNumInput" placeholder="'.$lastPage.'" /> &nbsp;&nbsp; <input type="button" id="goToPage" value="Go" /></p>';
						}
					?>
				</div>

				<br />
			</div>
			
			<div id="left">
	
			</div>

			<div style="clear:both;"></div> <br /><br />
		</div>

		<script type="text/javascript" src="userQuestions.js"></script>

		<div id="footer">
			<p>&copy; Torque Xtreme 2014 &nbsp;&nbsp; | &nbsp;&nbsp; <a href="about.php">About</a> &nbsp;&nbsp; | &nbsp;&nbsp; <a href="contact.php">Contact</a> &nbsp;&nbsp; | &nbsp;&nbsp; <a href="sitemap.xml">Sitemap</p>
		</div>

	</body>
</html>