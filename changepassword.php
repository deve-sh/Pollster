<?php
	session_start();
	include 'inc/checker.php';
	include 'inc/config.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title><?php echo $appname." - "; ?>Change Password</title>
	<?php include 'inc/styles.html'; ?>
</head>
<body class="mainbody">
	<main style="border-top: 5px solid gray;">
	  <?php include 'header.php'; ?>
	  <div align="center">

		<?php
			if($_SESSION['polllog']==true && $_SESSION['polluserid']){
				?>
				<br><br>
				<form action="" method="POST" id="installform">
					<h2>Change Password</h2>
					<input type="password" name="oldpass" placeholder="Old Password" required><br><br>
					<input type="password" name="newpass" placeholder="New Password" required><br><br>
					<button type="submit" class="submitbutton">Change</button>
				</form>
				<?

				if($_POST['oldpass'] && $_POST['newpass']){
					$newpass=$db->escape($_POST['newpass']);
					$oldpass=$db->escape($_POST['oldpass']);

					$userquery=$db->query("SELECT * FROM ".$subscript."users WHERE id='".$_SESSION['polluserid']."'");

					if($db->numrows($userquery)==1){
						$user = $db->fetch($userquery);

						if(strcmp(md5(crypt($oldpass,$user['salt'])),$user['password'])==0){
							$newpass=crypt($newpass,$user['salt']);
							$newpass=md5($newpass);

							if($db->query("UPDATE ".$subscript."users SET password='$newpass' WHERE id='".$_SESSION['polluserid']."'")){
								echo "<br><br>Successfully Updated Password. Login with the new password now.";

								$_SESSION['polllog']=false;
								$_SESSION['polluserid']="";
								$_SESSION['polladmin']=false;

								// Completely Logged Out.

								header("refresh:2;url=login.php");
								exit();
							}
							else{
								echo "<br><br>An error occured during the change. Try Again.";
							}
						}
						else{
							echo "<br><br>Wrong Old Password. Try Again.";
						}
					}
					else{
						header("refresh:0;url=index.php");
						exit();
					}
				}
			}
			else{
				header("refresh:0;url=login.php");
				exit();
			}
		?>
	  </div>
	</main>
</body>
</html>