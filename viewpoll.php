<?php
	session_start();
	include 'inc/checker.php';
	include 'inc/config.php';
	$pollid=$_GET['pollid'];
	$userid=$_GET['userid'];
?>
<!DOCTYPE html>
<html>
<head>
	<title>
		<?php echo $appname; ?>
	</title>
	<?php include 'inc/styles.html'; ?>
</head>
<body class="mainbody">
	<main style="border-top: 6px solid #2c97de;">
		<?php
		  include 'header.php';
		  if($pollid)
		  {
			if($_SESSION['polllog']==true && $_SESSION['polluserid'] && $userid && $userid==$_SESSION['polluserid'])
			{
				$query=$db->query("SELECT * FROM ".$subscript."polls WHERE pollid='$pollid'");
				if($db->numrows($query)!=0)
				{
					echo "<br><div id='poll' align='center'>
					</div>
					<div id='errors'></div>";
		?>
		<script type="text/javascript">
			var updatevote = function(userid,pollid,optionid){
				var updater = new XMLHttpRequest();

				updater.open('GET','apis/change.php?userid='+userid+'&pollid='+pollid+'&optionid='+optionid);

				updater.onload=function(){

				}

				updater.send();
			}

			var registervote = function(pollid,userid,optionid){
				
				// Function to register vote in realtime.

				var register=new XMLHttpRequest();

				register.open('GET','registervote.php?pollid='+pollid+'&userid='+userid+'&optionid='+optionid); 

				register.onload=function(){

					console.log(register.responseText);
					if(register.responseText.includes('200')){
						// If the register was successful.
						location.reload(true); // Also, a hard refresh from the server.
					}
					else if(register.responseText==='Already Registered.'){
						// Already voted for the same option.
						document.getElementById('errors').innerHTML="<br>You have already voted for the same option.";
					}
					else if(register.responseText==='500'){ // Unsuccessful for some reason.
						document.getElementById('errors').innerHTML="<br>An error occured for some reason. Try Again Later.";
					}
					else if(register.responseText==='300'){
						document.getElementById('errors').innerHTML="<br>Invalid Option";
					}
					else{
						// Unauthorised access by an unknown user / Unregistered User. 
						document.getElementById('errors').innerHTML="<br>Unauthorised.";
					}
				}

				// One Hovewer cannot delete a poll directly from the poll screen, one has to delete it using their User CP.

				register.send();
			}
		</script>
		<script type="text/javascript" src="js/removevote.js"></script>
		<?php
					echo "<script src='js/render.js'></script>";
					echo "<script>getpolldetails(".$pollid.",".$_SESSION['polluserid'].")</script>";
					if($_SESSION['polladmin']==true){
						echo "<div align='center'><a href='removepoll.php?pollid=".$pollid."'><button class='removebutton'>Remove Poll</button></a></div><br>";;
					}
				}
				else
				{
					echo "<br><br>&nbsp&nbsp&nbspNo such poll found.";
					header("refresh:1;url=index.php");
					exit();
				}
			}
			else{
				echo "<br><br>&nbsp&nbsp&nbspYou need to login in order to view polls.";
			}
		  }
		  else{
		  	echo "<br><br>&nbsp&nbsp&nbspValid Poll Not Found!";
		  	header("refresh:1;url=index.php");
		  	exit();
		  }
		?>
	</main>
	<!-- FOOTER -->
	<?php
		include 'footer.php';
	?>
</body>
</html>