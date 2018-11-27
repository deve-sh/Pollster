<?php
session_start();
include 'inc/checker.php';
include 'inc/config.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title><?php echo $appname." - "; ?>Remove Photo</title>
	<?php include 'inc/styles.html'; ?>
</head>
<body class="mainbody">
	<div style="padding: 20px;">
		<?php
			if($_SESSION['polllog']==true && $_SESSION['polluserid']){

				$userquery = $db->query("SELECT * FROM ".$subscript."users WHERE id='".$_SESSION['polluserid']."'");

				if($db->numrows($userquery)>0){
					$user = $db->fetch($userquery);
					if(strcmp("files/default.png",$user['photo'])!=0){
						if($db->query("UPDATE ".$subscript."users SET photo='files/default.png' WHERE id='".$_SESSION['polluserid']."'") && unlink($user['photo'])){
							echo "<br><br>Successfully Removed Profile Photo.";
							header("refresh:1;url=index.php");
							exit();
						}
					}
				}
				else{
					header("refresh:0;url=index.php");
					exit();
				}
			}
			else{
				header("refresh:0;url=login.php");
				exit();
			}
		?>
	</div>
</body>
</html>