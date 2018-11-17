<?php
	session_start();
	include 'inc/checker.php';
	include 'inc/config.php';
	$pollid=$_GET['pollid'];
?>
<!DOCTYPE html>
<html>
<head>
	<title>Removing Poll</title>
</head>
<body>
	<?php
		if($_SESSION['polluserid'] && $_SESSION['polllog']==true && $pollid){
			if($db->numrows($db->query("SELECT * FROM ".$subscript."polls WHERE pollid='".$pollid."'"))>0){
				$poll=$db->fetch($db->query("SELECT * FROM ".$subscript."polls WHERE pollid='".$pollid."'"));

				if($poll['userid']==$_SESSION['polluserid'] || $_SESSION['polladmin']==true){
					$delete1=$db->query("DELETE FROM ".$subscript."polls WHERE pollid='".$pollid."'");
					$delete2=$db->query("DELETE FROM ".$subscript."pollvotes WHERE pollid='".$pollid."'");
					$delete3=$db->query("UPDATE ".$subscript."users SET npolls=npolls-1 WHERE id='".$poll['userid']."'");
					header("refresh:0;url=index.php");
					exit();
				}
				else{
					header("refresh:0;url=index.php");
					exit();
				}
			}
			else{
				header("refresh:0;url=index.php");
				exit();		
			}
		}
		else{
			header("refresh:0;url=index.php");
			exit();
		}
	?>
</body>
</html>