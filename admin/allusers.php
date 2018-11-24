<?php
session_start();
include 'adminchecker.php';
include 'adminconfig.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title><?php echo $appname." - "; ?>All Users</title>
	<?php include 'adminstyles.html'; ?>
</head>
<body class="mainbody">
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
				<div id='header' style="border-top: 5px solid #6200ee;">
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
				$pollquery=$db->query("SELECT * FROM ".$subscript."users");
				?>
				<main>
					<h2 style="padding: 15px;">All Users</h2>
					<?php

						if($db->numrows($pollquery)==0){
						?>
							<div class="nopolls" align="center">
								<div class="nopollsmessage">
									<i class="fas fa-user-injured fa-3x"></i>
									<br><br>
									No Users Found Yet!
								</div>
							</div>
						<?php
						}
						else if($db->numrows($pollquery)<=10){
							while($user=$db->fetch($pollquery)){
								?>
								<div class="adminpoll">
									<div class="left">
										<img src="<?php echo "../".$user['photo']; ?>" alt="<?php echo "User ID : ".$user['id']; ?>" class='userphoto'> &nbsp&nbsp <?php echo $user['name']."&nbsp&nbsp<span class='desc'>".$user['email']."</span>"; ?>
									</div>
									<div class="right" align="center">
										<a href='deleteuser.php?userid=<?php echo $user['id']; ?>'><span class="remover removebutton"><i class="fas fa-trash-alt"></i></span></a>
										&nbsp
										<a href="makeadmin.php?userid=<?php echo $user['id']; ?>" title="Make Admin"><span class="removebutton"><i class="fas fa-user-shield"></i></span></a>
									</div>
								</div>
								<?php
							}
						}
						else{

						}
				}
				?>
				</main>
				<?php include '../footer.php'; ?>
</body>
</html>