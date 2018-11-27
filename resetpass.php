<?php
session_start();
include 'inc/checker.php';
include 'inc/config.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title>
		<?php echo $appname." - "; ?>Reset Password
	</title>
	<?php include 'inc/styles.html'; ?>
</head>
<body class="mainbody">
	<!--HEADER-->
	<?php include 'header.php'; ?>
	<main>
		<div align="center">
			<?php 
				if($_SESSION['polllog']!=true || !$_SESSION['polluserid'] || !$_SESSION['polladmin'])
				{   // User not already logged in.
					$seckey = $_POST['seckey'];
					$email = $_POST['email'];
					$password = $_POST['newpass'];

					if($seckey && $email && $password){
						$userquery=$db->query("SELECT * FROM ".$subscript."users WHERE email='$email'");

						if($db->numrows($userquery)==1){
							$user=$db->fetch($userquery);

								if(strcmp(crypt($seckey,$user['salt']),$user['securitykey'])!=0){
									echo "<br><br>Invalid Security Key.";
									header("refresh:2;url=index.php");
									exit();
								}
								else{       // If the security key matches.
									
									if($password!="")     // If user did enter something into the password field.
									{
										$password=crypt($password,$user['salt']);
										$password=md5($password);

										if($db->query("UPDATE ".$subscript."users SET password='$password' WHERE id='".$user['id']."'")){
											echo "<br><br> Password Successfully updated.";

											$_SESSION['polllog']=false;
											$_SESSION['polluserid']="";
											$_SESSION['polladmin']=false;

											header("refresh:2;url=login.php");
											exit();
										}
										else{
											echo "<br><br>There was an error. Kindly Try Again.";
											header("refresh:2:url=forgotpass.php");
											exit();
										}
									}
								}
						}
						else{
							echo "<br><br>No such user exists.";
							header("refresh:2;url=forgotpass.php");
							exit();
						}
					}
					else{
						echo "<br><br>Invalid Entries.";
						header("refresh:2;url=forgotpass.php");
						exit();
					}
				}
				else{
					echo "<br>Already Logged In.";
	 				header("refresh:2;url=index.php");
	 				exit();
				}
			?>
		</div>
	</main>
</body>
</html>