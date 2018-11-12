<?php
    session_start();
	
	require('google-api-php-client/vendor/autoload.php');

	$client = new Google_Client;

	$code=isset($_GET['code'])?$_GET['code']:NULL;
	echo $code;

	if(isset($code)){
		$token = $client -> fetchAccessTokenWithAuthCode($code);
		$client -> setAccessToken($token);
	}
?>