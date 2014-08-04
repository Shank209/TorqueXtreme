<?php
	session_start();

	require 'mysqlCon.inc.php';

	require 'frontSignedInCheck.inc.php';

	if(!isset($_POST['newPass']))
	{
		echo '
			<script type="text/javascript">
				alert("OOPS! Something went wrong.");
			</script>
		';
	}

	$newPass = $_POST['newPass'];
	
	$conNewPass = $_POST['conNewPass'];

	$userId = $_POST['userId'];

	$key = $_POST['key'];

	if($newPass != $conNewPass)
	{
		echo '
			<script type="text/javascript">
				$("#error").text("Passwords don\'t match. Please check.");

				$("#submit").attr("disabled", false);

				$("#submit").val("Submit");
			</script>
		';

		die();
	}
	else if(strlen($newPass)>15)
	{
		echo '
			<script type="text/javascript">
				$("#error").text("Password cannot be longer than 15 characters.");

				$("#submit").attr("disabled", false);

				$("#submit").val("Submit");
			</script>
		';

		die();
	}
	else if(strlen($newPass)<6)
	{	
		echo '
			<script type="text/javascript">
					$("#error").text("Password must be atleast 6 characters long.");

					$("#submit").attr("disabled", false);

					$("#submit").val("Submit");
			</script>
		';

		die();
	}

	$query = 'SELECT userId FROM newPassword WHERE userId='.$userId.' AND `key`="'.$key.'"';

	$query_run = mysql_query($query);

	if(mysql_num_rows($query_run)==0)
	{
		echo '
			<script type="text/javascript">
				alert("OOPS! Something went wrong.");
			</script>
		';

		die();
	}
	
	$newPass = mysql_real_escape_string($newPass);
	
	$conNewPass = mysql_real_escape_string($conNewPass);
	
	$delete = 'DELETE FROM newPassword WHERE `key`="'.$key.'"';
	
	mysql_query($delete);
	
	$query = 'SELECT salt FROM users WHERE id='.$userId;

	$query_run = mysql_query($query);

	$salt = mysql_result($query_run, 0, 'salt');

	$newPass = hash('sha256', $newPass);

	$newPass = hash('sha256', $newPass.$salt);

	$update = 'UPDATE users SET pass="'.$newPass.'" WHERE id='.$userId;

	mysql_query($update);

	echo '
			<script type="text/javascript">
					$("#error").text("Your password has been reset. You can now sign in from the homepage.");

					$("#submit").val("Done");
			</script>
		';

		die();
?>