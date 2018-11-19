<?php
	session_start();

	$_SESSION['polladmin']=false;
	$_SESSION['polllog']=false;
	$_SESSION['polluserid']=0;

	header("refresh:0;url=index.php");
	exit();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Logging Out...</title>
</head>
<body>

</body>
</html>