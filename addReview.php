<?php
	session_start();
	
	require 'mysqlCon.inc.php';
	
	require 'backSignedInCheck.inc.php';

	function limitText($text, $limit) {
     	if (str_word_count($text, 0) > $limit) {

            $words = str_word_count($text, 2);
            
            $pos = array_keys($words);
            
            $text = substr($text, 0, $pos[$limit]) . '...';
        }
        
        return $text;
    }
	
	if(isset($_POST['title']))
	{
		$title = $_POST['title'];
		
		$desc = $_POST['desc'];
		
		$tagList = $_POST['tagList'];
		
		$title = trim($title);

		$desc = trim($desc);

		if($title!=''&&$desc!='')
		{
			$_SESSION['shareTitle'] = $title;

			$_SESSION['shareDesc'] = $desc;
			
			$title = mysql_real_escape_string($title);
			
			$desc = mysql_real_escape_string($desc);
			
			$tagList = mysql_real_escape_string($tagList);
			
			$title = strip_tags($title);
			
			$desc = strip_tags($desc);
			
			$tagList = strip_tags($tagList);
			
			$tagList = trim($tagList);

			date_default_timezone_set('Asia/Kolkata');

			$time = date('dS M y h:i A');

			$insert = 'INSERT INTO reviews VALUES("", "'.$title.'", "'.$desc.'", "'.$_SESSION['id'].'", 0, "'.$time.'")';
			
			mysql_query($insert);
			
			$reviewId = mysql_insert_id();

			if($_FILES['image']['size']>0)
			{
				if($_FILES['image']['size']>3100*1024)
				{
					header('Location:reviewEmpty.php');

					die();
				}

				$image = $_FILES['image']['tmp_name'];

				if(!getimagesize($image))
				{
					header('Location:reviewEmpty.php');

					die();
				}

				$image = addslashes(file_get_contents($image));

				$insert = 'INSERT INTO reviewImages VALUES('.$reviewId.', "'.$image.'")';

				mysql_query($insert);
			}
			
			if($tagList != '')
			{
				$tags = explode(',', $tagList);
			
				foreach($tags as $tag)
				{
					$tag = trim($tag);

					if($tag != '')
					{
						$query = 'SELECT * FROM storedReviewsTags WHERE name="'.$tag.'"';
					
						$query_run = mysql_query($query);
						
						if(mysql_num_rows($query_run)==0)
						{
							$insert = 'INSERT INTO storedReviewsTags VALUES("'.$tag.'")';
							
							mysql_query($insert);
						}
						
						$insert = 'INSERT INTO reviewsTags VALUES("'.$tag.'", '.$reviewId.')';
						
						mysql_query($insert);
					}
				}
			}
			
			$title = limitText($title, 20);

			$desc = limitText($desc, 20);

			$query = 'SELECT name FROM users WHERE id='.$_SESSION['id'];

			$query_run = mysql_query($query);

			$shareName = mysql_result($query_run, 0, 'name');

			$_SESSION['shareName'] = $shareName;

			if($_SESSION['shareName']=='N/A')
			{
				$_SESSION['shareName']='This user';
			}

			$_SESSION['shareId'] = $reviewId;

			header('Location:shareReview.php');

			die();
		}
		else
		{
			header('Location:reviewEmpty.php'); //user hasn't filled all fields
		
			die();
		}
	}
	else
	{
		header('Location:pageUnavailable.php'); //user hasn't come here through the form on writeReview
		
		die();
	}
?>