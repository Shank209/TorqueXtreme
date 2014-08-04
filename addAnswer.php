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

	if(isset($_POST['answer'])&&isset($_GET['questionId']))
	{
		$answer = $_POST['answer'];

		$_SESSION['shareDesc'] = $answer;
		
		$answer = mysql_real_escape_string($answer);
		
		$answer = strip_tags($answer);

		$answer = trim($answer);
		
		if($answer!='')
		{
			$questionId = $_GET['questionId'];
			
			$userId = $_SESSION['id'];

			date_default_timezone_set('Asia/Kolkata');

			$time = date('dS M y h:i A');
			
			$insert = 'INSERT INTO answers VALUES("", "'.$answer.'", '.$userId.', '.$questionId.', 0, "'.$time.'")';
			
			mysql_query($insert);
			
			$answerId = mysql_insert_id();

			$query = 'SELECT answers FROM questions WHERE id='.$questionId;
			
			$query_run = mysql_query($query); 

			if(mysql_num_rows($query_run)==0)
			{
				header('Location:pageUnavailable.php');

				die();
			}
			
			$noOfAnswers = mysql_result($query_run, 0, 'answers'); 
			
			$noOfAnswers++;
			
			$update = 'UPDATE questions SET answers='.$noOfAnswers.' WHERE id='.$questionId;
			
			mysql_query($update);
			
			$query = 'SELECT name FROM users WHERE id='.$_SESSION['id'];

			$query_run = mysql_query($query);

			$answer = limitText($answer, 20);

			$_SESSION['shareId'] = $questionId;

			$_SESSION['shareName'] = mysql_result($query_run, 0, 'name');

			if($_SESSION['shareName']=='N/A')
			{
				$_SESSION['shareName']='This user';
			}

			if($_FILES['image']['size']>0)
			{
				if($_FILES['image']['size']>3100*1024)
				{
					header('Location:answerEmpty.php');

					die();
				}

				$image = $_FILES['image']['tmp_name'];

				if(!getimagesize($image))
				{
					header('Location:answerEmpty.php');

					die();
				}

				$image = addslashes(file_get_contents($image));

				$insert = 'INSERT INTO answerImages VALUES('.$answerId.', "'.$image.'")';

				mysql_query($insert);
			}

			header('Location:shareAnswer.php');

			die();
		}
		else
		{
			header('Location:answerEmpty.php'); //the answer is empty
		
			die();
		}
	}
	else
	{
		header('Location:pageUnavailable.php'); //user hasn't come through the form on question
		
		die();
	}
?>