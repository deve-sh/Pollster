<?php
	session_start();
	include 'inc/checker.php';
	include 'inc/config.php';

	$userid=$_GET['userid'];
	$pollid=$_GET['pollid'];

	if($_SESSION['polllog']==true && $userid && $userid==$_SESSION['polluserid'])
	{
		$firstcheck=$db->query("SELECT * FROM ".$subscript."polls WHERE pollid='$pollid'"); // If the poll is valid.

		if($db->numrows($firstcheck)>0)
		{
			$cpoll=$db->fetch($firstcheck);

			$totalvotes=$db->numrows($db->query("SELECT * FROM ".$subscript."pollvotes WHERE pollid='$pollid'"));

			if($totalvotes<=0)
			{
				echo "100";      // No Votes So far.
			}
			else{
				echo "[";
				echo "{\"totalvotes\":".$totalvotes.",\"options\":".$cpoll['options'].",\"results\":";

				// Now editing the response.

				$results=unserialize($cpoll['results']); 

				echo "{";

				foreach($results as $key => $value) {
					echo "\"$key\" : $value";
					if((int)$key!=(int)$cpoll['nooptions']-1)
						echo ",";
				}


				echo "}}]";    // End of JSON.
			}
		}
		else{
			echo "350";        // Poll ID Invalid.
		}
	}
	else{
		echo "Unauthorised.";      // Unauthorised Access to DB.
	}
?>