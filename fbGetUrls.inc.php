<?php
	if($user)
	{
		$signOutUrl = $facebook->getLogoutUrl(array(
			'next' => 'http://www.torquextreme.com/index.php',  
		));
	} 
	else 
	{
		$signInUrl = $facebook->getLoginUrl(array(
			'scope'		=> 'email', 
		));
	}
?>