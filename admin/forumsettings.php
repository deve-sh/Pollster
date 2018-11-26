<?php
session_start();
include 'adminchecker.php';
include 'adminconfig.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title><?php echo $appname." - "; ?>App Settings</title>
	<?php include 'adminstyles.html'; ?>
</head>
<body class="mainbody">
	<?php
		if($_SESSION['polllog']==true && $_SESSION['polluserid'] && $_SESSION['polladmin']==true){
					// HEADER
					?>
						<div id='header' style="border-top: 5px solid rgb(0,128,128);">
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
									<a href="../logout.php" title='Logout'><button class="removebutton">Logout</button></a>
									<?php
								}
							?>
						</div>
						</div>
						<main style="padding: 20px;">
					<?php

					// Header End

					// Main Stuff Begins
					echo "<form action='changer.php' method=\"post\">";
					echo "<h2>User Agreement Message : </h2>";
					echo "<textarea required name='agreement'>".$agreement."</textarea>";
					echo "<h2>Footer Message</h2>";
					echo "<textarea required name='footermessage'>".$footermessage."</textarea>";
					echo "<h2>Max No of Options For a Poll : </h2>";
					echo "<input type='number' name='maxops' min='2' required placeholder='Max Options' value=".$maxops."><br><br><button type='submit' class='submitbutton' style='width: 100%;'>Change</button>";
					echo "</form>
					<br><br>
					<div align='center'><a href='templater.php'><div class='removebutton' style='display: inline-block'><i class=\"fas fa-palette\"></i> &nbspEdit Styles</div></a></div>";
				?>
			</main>
			<?

			// Editing files if the user has made a change or not.

			}
			else{
				header("refresh:0;url=../index.php");
				exit();
			}
	?>

	<?php include '../footer.php'; ?>
</body>
</html>