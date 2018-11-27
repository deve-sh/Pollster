<?php
session_start();
include 'inc/checker.php';
include 'inc/config.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title><?php echo $appname." - User CP"; ?></title>
	<?php include 'inc/styles.html'; ?>
</head>
<body class="mainbody">
	<main style="border-top: 5px solid #009688;">
		<!-- HEADER -->
		<div id='header'>
			<div class="left"><span class="back"><?php if($_SERVER['HTTP_REFERER']){?><a href="<?php echo $_SERVER['HTTP_REFERER']; ?>" title='Previous Page'><i class="fas fa-arrow-left"></i></a><?php } ?></span>&nbsp&nbsp <a href='index.php' title='<?php echo $appname." - Home"; ?>'><?php echo $appname; ?></a></div>
			<div class="right" align="right">
				<?php
					if(!$_SESSION['polluserid'] || !$_SESSION['polllog']){
						?>
							<a href='register.php'><button class="removebutton">Register</button></a>&nbsp&nbsp <a href="login.php" class="logintext">Login</a>
						<?php
					}
					else{
						?>
								<?php 
									if($_SESSION['polladmin']==true){
								?>
									<a href='admin' title='Admin CP'><i class="fas fa-cog"></i></a>
								<?php
								  }
								?>
								&nbsp&nbsp&nbsp
								<a href="logout.php" title='Logout'><button class="removebutton">Logout</button></a>&nbsp
						<?php
					}
				?>
			</div>
		</div>
		<!-- MAIN USERCP -->
		<?php 
			if(!$_SESSION['polllog'] || !$_SESSION['polluserid']){
				?>
					<div class="nopolls" align="center">
						<div class="nopollsmessage">
							<i class="fas fa-user-times fa-3x"></i><br><br>
							You need to login first to view this page.
							<br><br>
							<a href="register.php"><button class="removebutton">Register</button></a> &nbsp&nbsp<a href="login.php" class="logintext">Login</a>
						</div>
					</div>
				<?php
			}
			else{
				$user=$db->fetch($db->query("SELECT * FROM ".$subscript."users WHERE id='".$_SESSION['polluserid']."'"));
				?>
					<div align="center">
						<br><br><img src="<?php echo $user['photo']; ?>" class="profilephoto">
						<h3><?php echo $user['name']; ?></h3><br>
						No Of Polls : <?php echo $user['npolls']; ?>
						<br><br>
						No Of Votes : <?php
							$nvotes = $db->numrows($db->query("SELECT * FROM ".$subscript."pollvotes WHERE userid='".$_SESSION['polluserid']."'"));
							echo $nvotes;
						?>
						<br><br>
						<a href='changephoto.php'><div class="useroptions">
							Change Profile Photo
						</div></a>
						<br>
						<a href='changepassword.php'><div class="useroptions">
							Change Password
						</div></a>
					</div><br>
				<h3 class="pollscreated">
					Polls Created : 
				</h3>
					<div align="center">
						<?php
							// Displaying of all the polls of the user.
							if($user['npolls']<=0){
								echo "No Polls Yet.";
							}
							else if($user['npolls']<=5){
								$pollquery=$db->query("SELECT * FROM ".$subscript."polls WHERE userid='".$_SESSION['polluserid']."'");

								echo "<div id='userpollwrapper'>";

								while($poll=$db->fetch($pollquery)){
									echo "<div class='userpoll'>
									<div class='left'>
										<a href='viewpoll.php?userid=".$_SESSION['polluserid']."&pollid=".$poll['pollid']."' target='_blank'><span class='title'>".$poll['title']."
										</span></a>&nbsp&nbsp<span class='time'>".$poll['date_created']."</span>
									</div>
									<div class='right' align='center'>
										<a href='removepoll.php?pollid=".$poll['pollid']."'><button class='userremovebutton'>Remove</button></a>
										</div>
									</div><br>";
								}

								echo "</div>";
							}
							else{       // If the polls do need to be laid out accross multiple pages.
								$pollquery=$db->query("SELECT * FROM ".$subscript."polls WHERE userid='".$_SESSION['polluserid']."'");

								// PAGINATION

								$numrows=$db->numrows($pollquery);

								$rowsperpage = 5;         // 10 Entries per page.
								
								$totalpages = ceil($numrows / $rowsperpage);

								if (isset($_GET['currentpage']) && is_numeric($_GET['currentpage'])) {
								   
								   $currentpage = (int) $_GET['currentpage'];
								} else {
								   
								   $currentpage = 1;
								} 

								
								if ($currentpage > $totalpages) {
								   
								   $currentpage = $totalpages;
								} 
								
								if ($currentpage < 1) {
								   
								   $currentpage = 1;
								} 

								
								$offset = ($currentpage - 1) * $rowsperpage;

								
								$sql = "SELECT * FROM ".$subscript."polls WHERE userid='".$_SERVER['polluserid']."' LIMIT $offset, $rowsperpage";
								$result = $db->query($sql);

								echo "<div id='userpollwrapper'>";

								while($poll=$db->fetch($pollquery)){
									echo "<div class='userpoll'>
									<div class='left'>
										<a href='viewpoll.php?userid=".$_SESSION['polluserid']."&pollid=".$poll['pollid']."' target='_blank'><span class='title'>".$poll['title']."
										</span></a>&nbsp&nbsp<span class='time'>".$poll['date_created']."</span>
									</div>
									<div class='right' align='center'>
										<a href='removepoll.php?pollid=".$poll['pollid']."'><button class='userremovebutton'>Remove</button></a>
										</div>
									</div><br>";
								} 

								echo "<div style='clear:both;' align='center'><br><br><div class='pagination'>";
								
								$range = 3;       // Three Page Bullets per page.

								if ($currentpage > 1) {
								   
								   echo "<a href='{$_SERVER['PHP_SELF']}?currentpage=1'><<</a> ";
								   
								   $prevpage = $currentpage - 1;
								   
								   echo "<a href='{$_SERVER['PHP_SELF']}?currentpage=$prevpage'><</a> ";
								} 

									
								for ($x = ($currentpage - $range); $x < (($currentpage + $range) + 1); $x++) {
								
								   if (($x > 0) && ($x <= $totalpages)) {
								
								      if ($x == $currentpage) {
									
								         echo "<a class='active'>$x</a>";
								      
								      } else {
								         
								         echo "<a href='{$_SERVER['PHP_SELF']}?currentpage=$x'>$x</a> ";
								      } 
								   } 
								}
								
								if ($currentpage != $totalpages) {
								   
								   $nextpage = $currentpage + 1;
								    
								   echo " <a href='{$_SERVER['PHP_SELF']}?currentpage=$nextpage'>></a> ";
								   
								   echo " <a href='{$_SERVER['PHP_SELF']}?currentpage=$totalpages'>>></a> ";
								} 

								echo "</div></div>";
							}
						?>
					</div>
					<br><br>
				<?php
			}
		?>
		<!-- FOOTER -->
	</main>
	<?php include 'footer.php'; ?>
</body>
</html>