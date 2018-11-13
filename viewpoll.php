<?php
	session_start();
	include 'inc/checker.php';
	include 'inc/config.php';
	$_SESSION['polllog']=true;
	$_SESSION['polluserid']=1;
	$pollid=$_GET['pollid'];
?>
<!DOCTYPE html>
<html>
<head>
	<title><?php echo $appname; ?></title>
	<?php include 'inc/styles.html'; ?>
</head>
<body class="mainbody">
	<main>
		<?php
		  if($pollid)
		  {
			if($_SESSION['polllog']==true){
				$query=$db->query("SELECT * FROM ".$subscript."polls WHERE pollid='$pollid'");
				if($db->numrows($query)!=0)
				{
					echo "<div id='poll' align='center'>
					</div>";
		?>
		<script type="text/javascript">
			var registervote = function(pollid,userid,optionid){
				
				// Function to register vote in realtime.

				var register=new XMLHttpRequest();

				register.open('GET','registervote.php?pollid='+pollid+'&userid='+userid+'&optionid='+optionid);

				register.onload=function(){

				}

				register.send();
			}
		</script>
		<?php
					echo "<script src='js/render.js'></script>";
					echo "<script>getpolldetails(".$pollid.",".$_SESSION['polluserid'].")</script>";
				}
				else
				{
					echo "<br><br>No such poll found.";
					header("refresh:1;url=index.php");
					exit();
				}
			}
			else{
				echo "<br><br>You need to login in order to view polls.";
			}
		  }
		  else{
		  	echo "<br><br>Valid Poll Not Found!";
		  	header("refresh:1;url=index.php");
		  	exit();
		  }
		?>
	</main>
	<!-- SCRIPTS -->
</body>
</html>