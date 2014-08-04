<?php
	require 'fbSource/facebook.php';  
	
	$facebook = new Facebook(array(
		'appId'  => '501151410018317',   
		
		'secret' => '937967392e84889484e41819bcfc3380', 
		
		'cookie' => true,	
	));
	
	$user = $facebook->getUser();
?>