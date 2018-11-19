<?php
	session_start();
	include 'inc/checker.php';
	include 'inc/config.php';

	$pollid=$_GET['pollid'];

	if($pollid && $_SESSION['polllog']==true && $_SESSION['polluserid']){
		$checker1=$db->query("SELECT * FROM ".$subscript."polls WHERE pollid='$pollid'");

		$checker2=$db->query("SELECT * FROM ".$subscript."pollvotes WHERE pollid='$pollid' AND userid='".$_SESSION['polluserid']."'");

		if($checker1 && $checker2 && $db->numrows($checker1)>0 && $db->numrows($checker2)>0)
		{
			$remover=$db->query("DELETE FROM ".$subscript."pollvotes WHERE pollid='$pollid' AND userid='".$_SESSION['polluserid']."'");

			if($remover){

				$voter=$db->fetch($checker2);
				
				$voteindex=$voter['voteindex'];

				$toremove=$db->fetch($checker1);

				$toremovearray=unserialize($toremove['results']);

				foreach ($toremovearray as $key => $value) {
					if($key==(int)$voteindex)
						$toremovearray[$key]=$toremovearray[$key]-1;
				}

				$toremovearray=serialize($toremovearray);

				$updater1=$db->query("UPDATE ".$subscript."polls SET results='$toremovearray' WHERE pollid='$pollid'");

				if($updater1){
					// DO NOTHING
				}
				else{
					$resetter=$db->query("INSERT INTO ".$subscript."pollvotes(pollid,userid,voteindex) VALUES('$pollid','".$_SESSION['polluserid']."')");
					// Reset
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
	}
	else{
		header("refresh:0;url=index.php");
		exit();
	}

?>