<?php
	ob_start();
	
	$error = 'Couldn\'t connect to database';

	mysql_connect('localhost','root','') or die ($error);
	
	mysql_select_db('projectX') or die($error);
?> 