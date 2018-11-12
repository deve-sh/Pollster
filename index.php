<?php
	require('google-api-php-client/vendor/autoload.php');
	session_start();
	$client = new Google_Client;
	$client -> setClientId("846496848444-ngt669h4jorpdg9dvrs14t26hq1emqhn.apps.googleusercontent.com");
	$client -> setClientSecret("auj92-QC3-QJube850iyx6Kl");
	$client -> setRedirectUri("http://localhost/voting/console.php");
	$client -> setScopes("email");
	//Step 2 : Create the url
	$auth_url = $client->createAuthURL();

	$_SESSION['client'] = $client;
?>
<!DOCTYPE html>
<html>
<head>
	<title>Login to Voting application</title>
</head>
<body>
	<?php
	    echo "<a href='".$auth_url."''>Login With Google!</a>";
	?>
</body>
</html>