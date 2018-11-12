<?php
	require('google-api-php-client/src/Google/autoload.php');
	session_start();
	$client = new driver;
	$client -> setClientId("846496848444-ngt669h4jorpdg9dvrs14t26hq1emqhn.apps.googleusercontent.com");
	$client -> setClientSecret("auj92-QC3-QJube850iyx6Kl");
	$client -> setRedirectURL("http://localhost/voting/console.php");
	$client->setScope("email");
	//Step 2 : Create the url
	$auth_url = $client->createAuthURL();
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