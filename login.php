<?php
	session_start();
	include 'inc/checker.php';
	include 'inc/config.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title><?php echo $appname." - "; ?>Login</title>
	<?php include 'inc/styles.html'; ?>
</head>
<body class="installset">
	<main style="padding: 0px;">
		<?php include 'header.php'; ?>
		<div style="padding: 30px;" align="center">
		<?php
			if($_SESSION['polllog']==false || !$_SESSION['polluserid']){
				?>
					<!-- LOGIN FORM -->
					<form action="" method="POST" id='installform'>
						<h2>Login</h2>
						<input type="email" name="email" placeholder="Email Address" required="true" autocomplete="false" /><br><br>
						<input type="password" name="password" placeholder="Password" required="true" autocomplete="false"/>
						<br><br>
						<div align="center">
							<button type="submit" name="submit" class="submitbutton">LOGIN</button>
						</div>
						<br>
						<a style='font-size: 12.5px;' href='forgotpass.php'>Forgot Your Password?</a>
					</form>
				<?php

				$email=$_POST['email'];
				$password=$_POST['password'];

				if(isset($_POST['submit']) && $email && $password){
					if($db->numrows($db->query("SELECT * FROM ".$subscript."users WHERE email='".$email."'"))==1){

						$user=$db->fetch($db->query("SELECT * FROM ".$subscript."users WHERE email='".$email."'"));

						if($db->numrows($db->query("SELECT * FROM ".$subscript."users WHERE email='$email' AND password='".md5(crypt($password,$user['salt']))."'"))==1) // If password hashes have the same value.
						{
							$_SESSION['polllog']=true;
							$_SESSION['polluserid']=$user['id'];

							if($user['isadmin']==1){
								$_SESSION['polladmin']=true;
							}

							header("refresh:0;url=index.php");
							exit();
						}else{
							echo "<br><br><span style='color: #ffffff;'>Wrong Credentials.</span>";
						}
					}
					else{
						echo "<br><br><span style='color: #ffffff;'>No user with such email exists.</span>";
					}
				}
			}
			else{
				echo "<br><br>Already logged in.";
				header("refresh:0;url=index.php");
				exit();
			}
		?>
		</div>
	</main>
	<?php include 'footer.php'; ?>
</body>
</html>