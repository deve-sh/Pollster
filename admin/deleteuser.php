<?php
session_start();
include 'adminchecker.php';
include 'adminconfig.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title>Delete User</title>
	<?php include 'adminstyles.html'; ?>
</head>
<body>
	<?php
		if($_SESSION['polluserid'] && $_SESSION['polladmin']==true && $_SESSION['polllog']==true){

			if(isset($_GET['userid']))
				$userid=$_GET['userid'];
			else
			{
				header("refresh:0;url=allusers.php");
				exit();
			}

			if((int)$userid%1==0 && $userid!=1){   // If userid is infact a number and the user is not the first user.
				// EXECUTION

				if($db->numrows($db->query("SELECT * FROM ".$subscript."users WHERE id='$userid'"))>0){

				    // Checking if the user is not an admin.

				    $user=$db->fetch($db->query("SELECT * FROM ".$subscript."users WHERE id='$userid'"));

				    if($user['isadmin']!=true){
				    	if($db->query("DELETE FROM ".$subscript."polls WHERE userid='$userid'") && $db->query("DELETE FROM ".$subscript."users WHERE id='$userid'")){

				    		if(strcmp($user['photo'],"files/default.png")!=0){
				    			unlink("../".$user['photo']);   // Delete Profile Photo
				    		}

				    		// Removing the vote index from each poll the user has voted.

				    		$deletionpoll=$db->query("SELECT * FROM ".$subscript."pollvotes WHERE userid='".$user['id']."'");

				    		if($db->numrows($deletionpoll)>0){
				    			
				    			while($userspoll = $db->fetch($deletionpoll)){
				    				$todelete = $db->fetch($db->query("SELECT * FROM ".$subscript."polls WHERE pollid='".$userspoll['pollid']."'"));

				    				$results = unserialize($todelete['results']);  // Creating an array from the stringed results.

				    				foreach ($results as $key => $value) {
				    					if((int)$key==(int)$todelete['voteindex'] && $results[$key]>0){
				    						$results[$key]-=1;   // Reduced One Vote.
				    					}
				    				}

				    				$results = serialize($results);  // Converted the results back to string.

				    				$db->query("UPDATE ".$subscript."polls SET results='".$results."' WHERE pollid='".$todelete['pollid']."'");

				    				$db->query("DELETE FROM ".$subscript."pollvotes WHERE userid='".$user['id']."'");

				    			}

				    		}

							echo "<br><br>User Successfully Deleted.";
							header("refresh:2;url=allusers.php");
							exit();
						}
						else{
							echo "<br>There was a problem.";
							header("refresh:1;url=allusers.php");
							exit();
						}
				    }
				    else{
				    	echo "<br><br>Cannot Delete an Admin.";
				    	header("refresh:1;url=allusers.php");
				    	exit();
				    }
				}
				else{

				}
			}
			else{
				header("refresh:0;url=allusers.php");
				exit();
			}
		}
		else{
			header("refresh:0;url=../index.php");
		}
	?>
</body>
</html>