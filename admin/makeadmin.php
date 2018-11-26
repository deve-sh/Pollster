<?php
session_start();
include 'adminchecker.php';
include 'adminconfig.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title><?php echo $appname." - "; ?>Make Admin</title>
	<?php include 'adminstyles.html'; ?>
</head>
<body>
	<?php
		if($_SESSION['polluserid'] && $_SESSION['polllog']==true && $_SESSION['polladmin']==true){
			if(isset($_GET['userid'])){
				
			}
		}
		else{  // If current user is not an admin, remove.
			header("refresh:0;url=../index.php");
			exit();
		}
	?>

</body>
</html>