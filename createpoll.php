<?php
	session_start();
	include 'inc/checker.php';
	include 'inc/config.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title>Create Poll</title>
	<?php include 'inc/styles.html'; ?>
</head>
<body class="mainbody createpoll">
	<main style="border-top:5px solid rgba(0,0,0,.2)">
		<?php include 'header.php'; ?>
		<?php
			if($_SESSION['polluserid'] && $_SESSION['polllog']==true){
		?>
			<div style="padding: 20px;">
				<div align="center">
					<div class="pollinputtitle" name='Poll Title' placehold='Poll Title (Required)' contenteditable="true"></div>
					<br><br>
					<label for='polloptions'>No Of Options</label> : <select onclick="setops((this.selectedIndex)+1)" onchange="setops((this.selectedIndex)+1)" name="polloptions" id='polloptions'>
						<?php
							for($i=1;$i<=$maxops;$i++){
								echo "<option>".$i."</option>";
							}
						?>
					</select>
					<br><br>
					<div id='options'></div>
					<div id='errors'></div>
					<br>
					<a href='<?php echo $_SERVER['HTTP_REFERER']; ?>'><button class="backbutton"><i class="fas fa-arrow-left fa-lg"></i></button></a>
				</div>
			</div>
		<?php
			}
			else{
				echo "<div style='padding: 15px;'>You are not authroised. Redirecting....</div>";
				header("refresh:0;url=index.php");
				exit();
			}
		?>
	</main>
	<?php include 'footer.php'; ?>
	<script type="text/javascript" src="js/createscripts.js"></script>
</body>
</html>