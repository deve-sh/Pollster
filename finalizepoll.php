<?php
session_start();
include 'inc/checker.php';
include 'inc/config.php';

$options=$_GET['options'];
$nooptions=$_GET['nooptions'];
$polltitle=$_GET['polltitle'];
$time=$_GET['time'];

if($options && $nooptions && $polltitle && $_SESSION['polllog']==true && $_SESSION['polluserid'] && $time){
	$results=array();

	for($i=0;$i<$nooptions;$i++){
		$results[$i]=0;
	}

	$results=serialize($results);

	if($db->query("INSERT INTO ".$subscript."polls(
		userid,
		title,
		nooptions,
		options,
		date_created,
		results
	) VALUES(
		'".$_SESSION['polluserid']."',
		'$polltitle',
		'$nooptions',
		'$options',
		'$time',
		'$results'
	)") && $db->query("UPDATE ".$subscript."users SET npolls=npolls+1 WHERE id='".$_SESSION['polluserid']."'")){
		echo "200";
	}
}
else{
	echo "300";      // Invalid Entries or Unauthorised.
}
?>