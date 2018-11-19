<?php
	session_start();
	include 'inc/checker.php';
	include 'inc/config.php';
	$_SESSION['polluserid']=1;
	$_SESSION['polllog']=true;
?>
<!DOCTYPE html>
<html>
<head>
	<title><?php echo $appname; ?></title>
	<?php include 'inc/styles.html'; ?>
</head>
<body>
	
</body>
</html>