<?php
session_start();
include 'inc/checker.php';
include 'inc/config.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title><?php echo $appname." - "; ?>Forgot Password</title>
	<?php include 'inc/styles.html'; ?>
</head>
<body class="installset">
  <!-- HEADER -->
  <?php include 'header.php'; ?>
  <main>
	<?php 
		if($_SESSION['polllog']!=true || !$_SESSION['polluserid'] || !$_SESSION['polladmin']){
			// First fixing any error instances.

			$_SESSION['polllog']=false;
			$_SESSION['polluserid']="";
			$_SESSION['polladmin']=false; // I.E : Complete Logout.

			?>
				<div align="center" style="padding: 20px;">
					<form action="resetpass.php" method="POST" id='installform'>
						<h2>Forgot Password</h2>
						<input type="text" required name="seckey" placeholder="Security Key"><br><br>
						<input type="email" name="email" required placeholder="Email Address"><br><br>
						<input type="password" name="newpass" required placeholder="New Password"><br><br>
						<button type="submit" class="submitbutton">Reset</button>
					</form>
					<br><br>
					<a href='index.php'><button class="removebutton">Back</button></a>
				</div>
			<?
		}
		else{
			echo "<br><br><div align='center'>You are already logged in.</div>";
			header("refresh:1;url=index.php");
			exit();
		}
	?>
  </main>
</body>
</html>