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
				$userid = $_GET['userid'];
				
				if((int)$userid%1==0){
					$userquery=$db->query("SELECT * FROM ".$subscript."users WHERE id='$userid'");

					if($db->numrows($userquery)>0){
						$user=$db->fetch($userquery);
						if($user['isadmin']==true){
							echo "<br><br>The user is already an administrator.";
							header("refresh:1.5;url=allusers.php");
							exit();
						}
						else{
							if($db->query("UPDATE ".$subscript."users SET isadmin=1 where id='$userid'")){
								echo "<br><br>User Made Admin.";
								header("refresh:2;url=allusers.php");
								exit();
							}
							else{
								echo "<br><br>An error occured.";
								header("refresh:1;url=allusers.php");
								exit();
							}
						}
					}
					else{
						echo "<br><br>No user found.";
						header("refresh:2;url=allusers.php");
						exit();
					}
				}
				else{
					header("refresh:0;url=index.php");
					exit();
				}
			}
		}
		else{  // If current user is not an admin, remove.
			header("refresh:0;url=../index.php");
			exit();
		}
	?>

</body>
</html>