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

if($userid!=$_SESSION['polluserid']){
	echo "Unauthorised."; // First step, if user is not authenticated.
}
else if($pollid && $userid && $userid==$_SESSION['polluserid'] && $optionid>=0){
	// Main execution.

	$retquery=$db->query("SELECT * FROM ".$subscript."pollvotes WHERE userid='".$userid."' AND pollid='".$pollid."'");

	if($db->numrows($retquery)==0){
		if($db->query("INSERT INTO ".$subscript."pollvotes(pollid,userid,voteindex) VALUES('$pollid','$userid','$optionid')"))
			echo "200";      // No error. Successful execution.
		else
			echo "500";      // Some error.
	}else{
		$checkerobject=$db->fetch($retquery);
		// Obtained Object to check which option had gotten the vote.

		$prevoption=$checkerobject['voteindex'];
		$voteid=$checkerobject['voteid'];

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
}
else{
	echo "500";
}
?>