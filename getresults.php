<?php
session_start();
include 'inc/checker.php';
include 'inc/config.php';

$userid=$_GET['userid'];
$pollid=$_GET['pollid'];

if($_SESSION['polllog']==true && $userid && $userid==$_SESSION['polluserid'])
{
	$firstcheck=$db->query("SELECT * FROM ".$subscript."polls WHERE pollid='$pollid'");

	if($db->numrows($firstcheck)>0)
	{
		$secondcheck=$db->query("SELECT * FROM ".$subscript."poll");
	}
	else{
		echo "350";
	}
}
else{
	echo "Unauthorised.";
}
?>