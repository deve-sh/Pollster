<?php
session_start();
include 'adminchecker.php';
include 'adminconfig.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title>Admin CP</title>
	<?php include 'adminstyles.html'; ?>
</head>
<body class="adminbody">
	<main>
		<?php
			if(!$_SESSION['polluserid'] || $_SESSION['polllog']==false){       // If user is not logged in.
				echo "<br><br>Unauthorised.";
				header("refresh:2;url=../login.php");
				exit();
			}
			else if($_SESSION['polladmin']==false){             // If user is not admin.
				echo "<br><br>You are unauthorised to view the Admin CP.";
				header("refresh:2;url=../index.php");
				exit();
			}
			else{
				// If user is logged in and is also an admin.
				
				//-------------- HEADER---------------
		?>
				<div id='header'>
				<div class="left"><span class="back"><?php if($_SERVER['HTTP_REFERER']){?><a href="<?php echo $_SERVER['HTTP_REFERER']; ?>" title='Previous Page'><i class="fas fa-arrow-left"></i></a><?php } ?></span>&nbsp&nbsp <a href='../index.php' title='<?php echo $appname." - Home"; ?>'><?php echo $appname; ?></a></div>
				<div class="right" align="right">
					<?php
						if(!$_SESSION['polluserid'] || !$_SESSION['polllog']){
							?>
								<a href='register.php'><button class="removebutton">Register</button></a>&nbsp&nbsp <a href="login.php" class="logintext">Login</a>
							<?php
						}
						else{
							?>
							<a href='usercp.php' title="User CP"><i class="fas fa-user-cog"></i></a>
							&nbsp&nbsp&nbsp
							<a href="../logout.php" title='Logout'><button class="removebutton">Logout</button></a>&nbsp
							<?php
						}
					?>
				</div>
				</div>
				<?php
				// -----------------------------------
				?>
				<div class="mainbody">
					<br>
					Hey Admin!<br><br>
					<!-- LIST OF OPTIONS -->
					<div align="center">
						<div class="useroptions">
							<a href="viewusers.php">
								Manage All Users
							</a>
						</div>
						<br><br>
						<div class="useroptions">
							<a href="viewpolls.php">
								Manage All Polls
							</a>
						</div>
						<br><br>
						<div class="useroptions">
							<a href="forumsettings.php">
								Forum Settings
							</a>
						</div>
					</div>
				</div>
				<?php
			}
		?>
	</main>
	<?php include '../footer.php'; ?>
</body>
</html>