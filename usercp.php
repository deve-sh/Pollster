<?php
session_start();
include 'inc/checker.php';
include 'inc/config.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title><?php echo $appname." - User CP"; ?></title>
	<?php include 'inc/styles.html'; ?>
</head>
<body class="mainbody">
	<main>
		<!-- HEADER -->
		<div id='header'>
			<div class="left"><span class="back"><?php if($_SERVER['HTTP_REFERER']){?><a href="<?php echo $_SERVER['HTTP_REFERER']; ?>" title='Previous Page'><i class="fas fa-arrow-left"></i></a><?php } ?></span>&nbsp&nbsp <a href='index.php' title='<?php echo $appname." - Home"; ?>'><?php echo $appname; ?></a></div>
			<div class="right" align="right">
				<?php
					if(!$_SESSION['polluserid'] || !$_SESSION['polllog']){
						?>
							<a href='register.php'><button class="removebutton">Register</button></a>&nbsp&nbsp <a href="login.php" class="logintext">Login</a>
						<?php
					}
					else{
						?>
								<?php 
									if($_SESSION['polladmin']==true){
								?>
									<a href='admin' title='Admin CP'><i class="fas fa-cog"></i></a>
								<?php
								  }
								?>
								&nbsp&nbsp&nbsp 
								<a href="logout.php" title='Logout'><button class="removebutton">Logout</button></a>&nbsp
						<?php
					}
				?>
			</div>
		</div>
		<!-- MAIN USERCP -->
		<?php 
			if(!$_SESSION['polllog'] || !$_SESSION['polluserid']){
				?>
					<div class="nopolls" align="center">
						<div class="nopollsmessage">
							<i class="fas fa-user-times fa-3x"></i><br><br>
							You need to login first to view this page.
							<br><br>
							<a href="register.php"><button class="removebutton">Register</button></a> &nbsp&nbsp<a href="login.php" class="logintext">Login</a>
						</div>
					</div>
				<?php
			}
			else{
				$user=$db->fetch($db->query("SELECT * FROM ".$subscript."users WHERE id='".$_SESSION['polluserid']."'"));
				?>
					<div align="center">
						<br><br><img src="<?php echo $user['photo']; ?>" class="profilephoto">
						<h3><?php echo $user['name']; ?></h3><br>
						No Of Polls : <?php echo $user['npolls']; ?>
						<br><br>
						No Of Votes : <?php
							$nvotes = $db->numrows($db->query("SELECT * FROM ".$subscript."pollvotes WHERE userid='".$_SESSION['polluserid']."'"));
							echo $nvotes;
						?>
						<br><br>
						<a href='changephoto.php'><div class="useroptions">
							Change Profile Photo
						</div></a>
						<br>
						<a href='changepassword.php'><div class="useroptions">
							Change Password
						</div></a>
					</div>
<h3 style="margin-left: 20px;">
	Polls Created : 
</h3>
					<div align="center">
						<?php
							// Displaying of all the polls of the user.
							if($user['npolls']==0){
								echo "No Polls Yet.";
							}
							else{
								$pollquery=$db->query("SELECT * FROM ".$subscript."polls WHERE userid='".$_SESSION['polluserid']."'");

								if($user['npolls']<=10){
									while($poll=$db->fetch($pollquery)){
										echo "<div class='userpoll'>
										<span class='title'>".$poll['title']."
										</span>&nbsp&nbsp<span class='time'>".$poll['date_created']."</span><br><a href='removepoll.php?pollid=".$poll['pollid']."'><button class='userremovebutton'>Remove</button></a>";
									}
								}
							}
						?>
					</div>
					<br><br>
				<?php
			}
		?>
		<!-- FOOTER -->
	</main>
	<?php include 'footer.php'; ?>
</body>
</html>