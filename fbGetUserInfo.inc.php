<?php
	if($user) 
	{
		try 
		{
			$userProfile = $facebook->api('/me');
			
			$fbId = $userProfile['id'];                 
			
			$fbName = $userProfile['name']; 
			
			$fbEmail = $userProfile['email'];    

			$fbLink = $userProfile['link'];
		} 
		catch (FacebookApiException $e) 
		{
			error_log($e);
			
			$user = null;
		}
	}
?>