<?php
session_start();
include 'adminchecker.php';
include 'adminconfig.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title><?php echo $appname." - "; ?> All Polls</title>
	<?php include 'adminstyles.html'; ?>
</head>
<body class="mainbody">
		<?php
			if(!$_SESSION['polluserid'] || $_SESSION['polllog']==false){       // If user is not logged in.
				echo "<br><br>Unauthorised.";
				header("refresh:2;url=../login.php");
				exit();
			}
			else if($_SESSION['polladmin']==false){             // If user is not admin.
				echo "<br><br>You are unauthorised to view the Admin CP.";
				header("refresh:2;url=../index.php");
				exit();
			}
			else{
				// If user is logged in and is also an admin.
				
				//-------------- HEADER---------------
		?>
				<div id='header' style="border-top: 5px solid #6200ee;">
				<div class="left"><span class="back"><?php if($_SERVER['HTTP_REFERER']){?><a href="<?php echo $_SERVER['HTTP_REFERER']; ?>" title='Previous Page'><i class="fas fa-arrow-left"></i></a><?php } ?></span>&nbsp&nbsp <a href='../index.php' title='<?php echo $appname." - Home"; ?>'><?php echo $appname; ?></a></div>
				<div class="right" align="right">
					<?php
						if(!$_SESSION['polluserid'] || !$_SESSION['polllog']){
							?>
								<a href='register.php'><button class="removebutton">Register</button></a>&nbsp&nbsp <a href="login.php" class="logintext">Login</a>
							<?php
						}
						else{
							?>
							<a href='usercp.php' title="User CP"><i class="fas fa-user-cog"></i></a>
							&nbsp&nbsp&nbsp
							<a href="../logout.php" title='Logout'><button class="removebutton">Logout</button></a>&nbsp
							<?php
						}
					?>
				</div>
				</div>
				<?php
				// -----------------------------------
				?>
				<main>
					<h2 style="padding: 15px;">All Polls</h2>
					<?php
						$pollquery = $db->query("SELECT * FROM ".$subscript."polls ORDER BY date_created DESC");

						if($db->numrows($pollquery)==0){
					?>
						<div class="nopolls" align="center">
							<div class="nopollsmessage">
								<i class="far fa-list-alt fa-3x"></i>
								<br><br>
								No Polls Found Yet!
							</div>
						</div>
					<?php
						}
						else if($db->numrows($pollquery)<=10){
							while($poll = $db->fetch($pollquery)){
								?>
								<div class='adminpoll'>
									<?php
									echo "<a href='../viewpoll.php?pollid=".$poll['pollid']."&userid=".$_SESSION['polluserid']."' target='_blank'>";
									?>
									<div class='left'>
										<?php echo $poll['title']."&nbsp&nbsp<span class='desc'>".$poll['date_created']."</span>"; ?>
									</div>
									<?php echo "</a>"; ?> 
									<div class="right" align='center'>
										<a href='../removepoll.php?pollid=<?php echo $poll['pollid']; ?>'><div class="remover removebutton"><i class="fas fa-trash-alt"></i></div></a>
									</div>
								</div>
								<?
							}
						}
						else{
								$numrows=$db->numrows($pollquery);

								$rowsperpage = 10;         // 10 Entries per page.
								
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

								
								$sql = "SELECT * FROM ".$subscript."polls ORDER BY date_created DESC LIMIT $offset, $rowsperpage";
								$result = $db->query($sql);

								while ($poll = $db->fetch($result)) {
								?>
									<div class='adminpoll'>
										<?php
										echo "<a href='../viewpoll.php?pollid=".$poll['pollid']."&userid=".$_SESSION['polluserid']."' target='_blank'>";
										?>
										<div class='left'>
											<?php echo $poll['title']."&nbsp&nbsp<span style='color: gray;font-size: 14px;'>".$poll['date_created']."</span>"; ?>
										</div>
										<?php echo "</a>"; ?> 
										<div class="right" align='center'>
											<a href='../removepoll.php?pollid=<?php echo $poll['pollid']; ?>'><div class="remover removebutton"><i class="fas fa-trash-alt"></i></div></a>
										</div>
									</div>
								<?php
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

						}
					?>
				</main>
			<?php
			 }
			?>
			<?php include '../footer.php'; ?>
</body>
</html>