<?php
session_start();
include 'inc/checker.php';
include 'inc/config.php';
$_SESSION['polllog']=true;
$_SESSION['polluserid']=1;

// Registering Vote to a poll!

$pollid=$_GET['pollid'];
$userid=$_GET['userid'];
$optionid=$_GET['optionid'];

if($userid!=$_SESSION['polluserid'])
	echo "Unauthorised."; // First step, if user is not authenticated.
else if($pollid && $userid && $userid==$_SESSION['polluserid'] && $optionid>=0){
	// Main execution.

	$sampquery=$db->query("SELECT * FROM ".$subscript."polls WHERE pollid='".$pollid."'");
	$retquery=$db->query("SELECT * FROM ".$subscript."pollvotes WHERE userid='".$userid."' AND pollid='".$pollid."'");

	if($db->numrows($retquery)==0 && $db->numrows($sampquery)>0)
	{	
		$checker1=$db->fetch($sampquery);
		$nooptions=$checker1['nooptions'];
		
		if($optionid<$nooptions)
		{
			if($db->query("INSERT INTO ".$subscript."pollvotes(pollid,userid,voteindex) VALUES('$pollid','$userid','$optionid')"))
			{
				echo "200";      // No error. Successful execution.
			}
			else{
				echo "500";
			}
		}
		else
			echo "300";      // Some error.
	}
	else if($db->numrows($sampquery)>0){
			$checkerobject=$db->fetch($retquery);
			// Obtained Object to check which option had gotten the vote.
			
			$checker1=$db->fetch($sampquery);
			$nooptions=$checker1['nooptions'];
			
			$prevoption=$checkerobject['voteindex'];
			$voteid=$checkerobject['voteid'];
		if($optionid<$nooptions)
		{
			if($prevoption==$optionid)
				echo "Already Registered.";
			else
			{
				if($db->query("UPDATE ".$subscript."pollvotes SET voteindex='$optionid' WHERE userid='$userid' AND pollid='$pollid' AND voteid='$voteid'")) // No injection and no need to update no of votes of user and so on.
					echo "200";
				else
					echo "500";
			}
		}
		else{
			echo "300";
		}
		}
		else{
			echo "500";
		}
	}
	else{
		echo "500";
	}
?>