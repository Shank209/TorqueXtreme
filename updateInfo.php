<?php
	session_start();
	
	require 'mysqlCon.inc.php';
	
	require 'backSignedInCheck.inc.php';
	
	if(!isset($user))
	{
		require 'fbGetUser.inc.php';
	}
	
	if($user)
	{
		$username = $_POST['username'];
		
		$username = mysql_real_escape_string($username);
		
		$username = strip_tags($username);
		
		$username = trim($username);
		
		$name = $_POST['name'];
		
		$name = trim($name);
		
		$name = mysql_real_escape_string($name);
		
		$name = strip_tags($name);
		
		$place = $_POST['place'];
		
		$place = mysql_real_escape_string($place);
		
		$place = strip_tags($place);
		
		$place = trim($place);

		$about = $_POST['about'];
		
		$about = mysql_real_escape_string($about);
		
		$about = strip_tags($about);

		$about = trim($about);

		$vehicles = $_POST['vehicles'];

		$vehicles = trim($vehicles);
		
		$vehicles = mysql_real_escape_strig($vehicles);
		
		$vehicles = strip_tags($vehicles);
		
		if($username=='')
		{
			echo '
				<script type="text/javascript">
					$("#error").text(\'Username cannot be empty.\');
				</script>
			';
			
			die();
		}
		
		$query = 'SELECT id FROM users WHERE BINARY username="'.$username.'"';
		
		$query_run = mysql_query($query);
		
		if(mysql_num_rows($query_run)==1)
		{
			if(mysql_result($query_run, 0, 'id')!=$_SESSION['id'])
			{
				echo '
					<script type="text/javascript">
						$("#error").text(\'This username is already taken.\');
					</script>
				';
				
				die();
			}
		}
		
		if($name=='')
		{ 
			echo '
				<script type="text/javascript"> 
					$("#error").text(\'Name cannot be empty.\');
				</script>
			';
				
			die();
		}
		
		if($place=='')
		{
			echo '
				<script type="text/javascript">
					$("#error").text(\'Place cannot be empty.\');
				</script>
			';
				
			die();
		}
		
		if($about=='')
		{
			echo '
				<script type="text/javascript">
					$("#error").text(\'"About Yourself" cannot be empty. Let others know about you.\');
				</script>
			';
				
			die();
		}

		if($vehicles=='')
		{
			echo '
				<script type="text/javascript">
					$("#error").text(\'"Vehicles Owned" cannot be empty. You can enter "None" if you want to.\');
				</script>
			';
				
			die();
		}

		$update = 'UPDATE users SET username="'.$username.'", name="'.$name.'", place="'.$place.'", about="'.$about.'", vehicles="'.$vehicles.'" WHERE id='.$_SESSION['id'];
	
		mysql_query($update);
		
		$_SESSION['username'] = $username;
		
		echo '<script type="text/javascript"> window.location="user.php?id='.$_SESSION['id'].'" </script>';
	}
	else
	{
		$username = $_POST['username'];
		
		$username = mysql_real_escape_string($username);
		
		$username = strip_tags($username);
		
		$username = trim($username);
		
		$name = $_POST['name'];
		
		$name = mysql_real_escape_string($name);
		
		$name = strip_slashes($name);
		
		$name = trim($name);
		
		$place = $_POST['place'];
		
		$place = mysql_real_escape_string($place);
		
		$place = strip_slashes($place);
		
		$place = trim($place);
		
		$newPass = $_POST['newPass'];

		$newPass = mysql_real_escape_string($newPass);
		
		$conNewPass = $_POST['conNewPass'];

		$conNewPass = mysql_real_escape_string($conNewPass);
		
		$currPass = $_POST['currPass'];

		$curPass = mysql_real_escape_string($currPass);

		$about = $_POST['about'];
		
		$about = mysql_real_escape_string($about);
		
		$about = strip_slashes($about);

		$about = trim($about);

		$vehicles = $_POST['vehicles'];

		$vehicles = mysql_real_escape_string($vehicles);
		
		$vehicles = strip_slashes($vehicles);
		
		$vehicles = trim($vehicles);
		
		$query = 'SELECT salt, pass FROM users WHERE id='.$_SESSION['id'];
		
		$query_run = mysql_query($query);
		
		$salt = mysql_result($query_run, 0, 'salt');
		
		$currPass = hash('sha256', $currPass);
		
		$currPass = hash('sha256', $currPass.$salt);
		
		if($currPass!=mysql_result($query_run, 0, 'pass'))
		{
			echo '
				<script type="text/javascript">
					$("#error").text(\'Please enter the correct password\');
				</script>
			';
			
			die();
		}
		
		if($username=='')
		{
			echo '
				<script type="text/javascript">
					$("#error").text(\'Username cannot be empty.\');
				</script>
			';
			
			die();
		}
		
		$query = 'SELECT id FROM users WHERE BINARY username="'.$username.'"';
		
		$query_run = mysql_query($query);
		
		if(mysql_num_rows($query_run)==1)
		{
			if(mysql_result($query_run, 0, 'id')!=$_SESSION['id'])
			{
				echo '
					<script type="text/javascript">
						$("#error").text(\'This username is already taken.\');
					</script>
				';
				
				die();
			}
		}
		
		if($name=='')
		{ 
			echo '
				<script type="text/javascript"> 
					$("#error").text(\'Name cannot be empty.\');
				</script>
			';
				
			die();
		}
		
		if($place=='')
		{
			echo '
				<script type="text/javascript">
					$("#error").text(\'Place cannot be empty.\');
				</script>
			';
				
			die();
		}
		
		if($about=='')
		{
			echo '
				<script type="text/javascript">
					$("#error").text(\'"About Yourself" cannot be empty. Let others know about you.\');
				</script>
			';
				
			die();
		}

		if($vehicles=='')
		{
			echo '
				<script type="text/javascript">
					$("#error").text(\'"Vehicles Owned" cannot be empty. You can enter "None" if you want to.\');
				</script>
			';
				
			die();
		}

		if($newPass!='')
		{ 
			if($newPass!=$conNewPass)
			{
				echo '
					<script type="text/javascript">
					$("#error").text(\'The new password and the re-entered password do not match.\');
				</script>
				';
					
				die();
			}
			
			$newPass = hash('sha256', $newPass);
			
			$newPass = hash('sha256', $newPass.$salt);
			
			$update = 'UPDATE users SET pass="'.$newPass.'" WHERE id='.$_SESSION['id'];
			
			mysql_query($update);
		}
		
		$update = 'UPDATE users SET username="'.$username.'", name="'.$name.'", place="'.$place.'", about="'.$about.'", vehicles="'.$vehicles.'" WHERE id='.$_SESSION['id'];
	
		mysql_query($update);
		
		$_SESSION['username'] = $username;
		
		echo '<script type="text/javascript"> window.location="user.php?id='.$_SESSION['id'].'" </script>';
	}
?>