<?php
session_start();
include 'adminchecker.php';
include 'adminconfig.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title><?php echo $appname." - "; ?>Edit Styles</title>
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
							<form action="stylechanger.php" method="post">
					<?php

					// Header End

						// Main Stuff Begins

						$mainstyle=fopen("../styles/style.css","r");

						while(!feof($mainstyle) and (connection_status()==0)) {
					      $mainstylestring.=fgets($mainstyle);
					    }

						fclose($mainstyle);

						$smallscreen = fopen("../styles/smallscreen.css","r");

						while(!feof($smallscreen) and (connection_status()==0)) {
					      $smallscreenstring.=fgets($smallscreen);
					    }

						fclose($smallscreen);

						$ultrasmall = fopen("../styles/ultrasmall.css","r");

						while(!feof($ultrasmall) and (connection_status()==0)) {
					      $ultrasmallstring.=fgets($ultrasmall);
					    }

						fclose($ultrasmall);

					?>
					<h2>style.css - Main File</h2>
					<textarea name="mainstyle" required class="styletextarea">
						<?php echo $mainstylestring; ?>
					</textarea>

					<h2>smallscreen.css - For Tablets</h2>
						For Screens of Width upto 900px. <br><br>
					<textarea class="styletextarea" required name='smallscreen'>
						<?php echo $smallscreenstring; ?>
					</textarea>

					<h2>ultrasmall.css - For Smartphones</h2>
						For Screens Of Width upto 600px. <br><br>
					<textarea class="styletextarea" name='ultrasmall' required>
						<?php echo $ultrasmallstring; ?>
					</textarea>

					<?php
				?>
				<br><br>
				<button class="submitbutton" style="width: 100%;">Update Styles</button>
				</form>
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