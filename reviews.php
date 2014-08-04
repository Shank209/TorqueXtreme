<?php
	session_start();
	
	require 'mysqlCon.inc.php';
	
	require 'midSignedInCheck.inc.php';
	
	$query = 'SELECT id FROM reviews';

	$query_run = mysql_query($query);

	$numRows = mysql_num_rows($query_run);

	if(isset($_GET['sort']))
	{
		$sort = $_GET['sort'];

		if($sort!='recent' && $sort!='highest')
		{
			$sort = 'recent';
		}
	}
	else
	{
		$sort = 'recent';
	}

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
		$query = 'SELECT id, title, userId, votes FROM reviews ORDER BY id DESC LIMIT '.($pageNum-1)*$itemsPerPage.', '.$itemsPerPage;
	}
	else
	{
		$query = 'SELECT id, title, userId, votes FROM reviews ORDER BY votes DESC, id DESC LIMIT '.($pageNum-1)*$itemsPerPage.', '.$itemsPerPage;
	}
	
	$query_run = mysql_query($query);
?>

<!doctype html>

<html lang="en">
	<head>
		<meta charset="utf-8" />
	
		<title>Reviews | Torque Xtreme</title>

		<meta name="description" content="Reviews on automobiles. Anyone can write and let the world know how you feel about your motorcycle, car, etc. Share your automotive experiences." />
		
		<script src="jquery.js"></script>
		
		<link rel="stylesheet" type="text/css" href="reviews.css?<?php echo time();?>" />
		
		<meta name="keywords" content="automobiles, bikes, motorcycles, cars, parts, automotive, questions, answers, reviews" />
		
		<link rel="shortcut icon" href="favicon.png" type="image/x-icon" />

		<link rel="icon" href="favicon.png" type="image/x-icon" />
	</head>
	
	<body>
		<div id="topStripe"></div>
		
		<div id="bottomStripe"></div>

		<input type="hidden" id="sort" value="<?php echo $sort; ?>" />
		
		<div id="nav">
			<a href="home.php"><img id="logo" src="logoSmall.png" /></a>
			
			<div id="navLinks">
				<a href="questions.php">Questions</a>
				
				<a href="reviews.php"><span>Reviews</span></a>
				
				<?php if(isset($_SESSION['id'])): ?>
					<a href="user.php?id=<?php  echo $_SESSION['id']; ?>">Account</a>
					
					<a href="signOut.php">Sign Out</a>
				<?php endif; ?>
			</div>
		</div>
		
		<div id="container">
			<div id="right">
				<?php
					if(mysql_num_rows($query_run)==0)
					{
						echo '<br /><br /><p style="font-family:Armata;text-align:center;">No Reviews yet.</p> <br />';
					}

					else
					{
						while($row = mysql_fetch_assoc($query_run))
						{
							$userId = $row['userId'];
				
							$query = 'SELECT username, points FROM users WHERE id='.$userId;
							
							$run = mysql_query($query);
							
							echo '
								<div class="review">
									<p class="title"> <a href="review.php?id='.$row['id'].'">'.$row['title'].'</a> </p>
									
									<p class="info"> Gear <span class="num">'.$row['votes'].'</span> &nbsp;|&nbsp; Written by <a href="" class="userLink">'.mysql_result($run, 0, 'username').' ('.mysql_result($run, 0, 'points').')</a></p>
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

							echo '|&nbsp;&nbsp;<a href="reviews.php?pn='.$nextNum.'&sort='.$sort.'">Next &gt;</a>&nbsp;&nbsp; | &nbsp;&nbsp; Go to page: <input type="text" id="pageNumInput" placeholder="'.$lastPage.'" /> &nbsp;&nbsp; <input type="button" id="goToPage" value="Go" /></p>';
						}
						else if($pageNum==$lastPage)
						{
							$prevNum = $pageNum-1;

							echo '|&nbsp;&nbsp;<a href="reviews.php?pn='.$prevNum.'&sort='.$sort.'">&lt; Prev</a>&nbsp;&nbsp; | &nbsp;&nbsp; Go to page: <input type="text" id="pageNumInput" placeholder="'.$lastPage.'" /> &nbsp;&nbsp; <input type="button" id="goToPage" value="Go" /></p>';
						}
						else
						{
							$nextNum = $pageNum+1;

							$prevNum = $pageNum-1;

							echo '|&nbsp;&nbsp;<a href="reviews.php?pn='.$prevNum.'&sort='.$sort.'">&lt; Prev</a>&nbsp;&nbsp; |&nbsp;&nbsp;<a href="questions.php?pn='.$nextNum.'&sort='.$sort.'">Next &gt;</a>&nbsp;&nbsp; | &nbsp;&nbsp; Go to page: <input type="text" id="pageNumInput" placeholder="'.$lastPage.'" /> &nbsp;&nbsp; <input type="button" id="goToPage" value="Go" /></p>';
						}
					?>
				</div>

				<br />
			</div>
			
			<div id="left">
				<p><a href="writeReview.php">Write A Review</a></p>
			
				<p><a href="reviews.php" id="recent">Most Recent</a></p>
				
				<p><a href="reviews.php?sort=highest" id="highest">Top-Geared</a></p>
				
				<p><a href="allReviewTags.php">All Tags</a></p>
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
		
		<script type="text/javascript" src="reviews.js"></script>

		<div id="footer">
			<p>&copy; Torque Xtreme 2014 &nbsp;&nbsp; | &nbsp;&nbsp; <a href="about.php">About</a> &nbsp;&nbsp; | &nbsp;&nbsp; <a href="contact.php">Contact</a> &nbsp;&nbsp; | &nbsp;&nbsp; <a href="sitemap.xml">Sitemap</a></p>
		</div>
	</body>
</html>