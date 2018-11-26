<?php
session_start();
include 'adminchecker.php';
include 'adminconfig.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title><?php echo $appname." - "; ?>All Users</title>
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
				$pollquery=$db->query("SELECT * FROM ".$subscript."users");
				?>
				<main>
					<h2 style="padding: 15px;">All Users</h2>
					<?php

						if($db->numrows($pollquery)==0){
						?>
							<div class="nopolls" align="center">
								<div class="nopollsmessage">
									<i class="fas fa-user-injured fa-3x"></i>
									<br><br>
									No Users Found Yet!
								</div>
							</div>
						<?php
						}
						else if($db->numrows($pollquery)<=10){
							while($user=$db->fetch($pollquery)){
								?>
								<div class="adminpoll">
									<div class="left">
										<img src="<?php echo "../".$user['photo']; ?>" alt="<?php echo "User : ".$user['name']; ?>" class='userphoto'> &nbsp&nbsp <?php echo $user['name']."&nbsp&nbsp<span class='desc'>".$user['email']."</span>"; ?>
									</div>
									<div class="right" align="center">
										<?php
										 if($user['isadmin']!=1 && $user['id']!=1){
										 ?>
										 	<a href='deleteuser.php?userid=<?php echo $user['id']; ?>'><span class="remover removebutton"><i class="fas fa-trash-alt"></i></span></a>
										 <?php
										 }
										 ?>
										&nbsp
										<?php
										if($user['isadmin']==false)
										{
											?>
											<a href="makeadmin.php?userid=<?php echo $user['id']; ?>" title="Make Admin"><span class="removebutton"><i class="fas fa-user-shield"></i></span></a>
											<?php
										}
										else if($user['id']!=1 && $user['isadmin']==true){     // Remove Admin Privileges Button
											?>
											<a href="removeadmin.php?userid=<?php echo $user['id']; ?>" title="Revoke Admin Privileges"><span class="removebutton"><i class="fas fa-user-shield"></i></span></a>
											<?php
										}
										?>
									</div>
								</div>
								<?php
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

								
								$sql = "SELECT * FROM ".$subscript."users LIMIT $offset, $rowsperpage";
								$result = $db->query($sql);

								while ($user = $db->fetch($result)) {
								?>
									<div class="adminpoll">
										<div class="left">
											<img src="<?php echo "../".$user['photo']; ?>" alt="<?php echo "User : ".$user['name']; ?>" class='userphoto'> &nbsp&nbsp <?php echo $user['name']."&nbsp&nbsp<span class='desc'>".$user['email']."</span>"; ?>
										</div>
										<div class="right" align="center">
											<?php
											 if($user['isadmin']!=1 && $user['id']!=1){
											 	?>
											 <a href='deleteuser.php?userid=<?php echo $user['id']; ?>'><span class="remover removebutton"><i class="fas fa-trash-alt"></i></span></a>
											 <?php
											 }
											?>
											&nbsp
											<?php
											if($user['isadmin']==false)
											{
												?>
												<a href="makeadmin.php?userid=<?php echo $user['id']; ?>" title="Make Admin"><span class="removebutton"><i class="fas fa-user-shield"></i></span></a>
												<?php
											}
											else if($user['id']!=1 && $user['isadmin']==true){     // Remove Admin Privileges Button
											?>
											<a href="removeadmin.php?userid=<?php echo $user['id']; ?>" title="Revoke Admin Privileges"><span class="removebutton"><i class="fas fa-user-shield"></i></span></a>
											<?php
										}
											?>
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
				}
				?>
				</main>
				<?php include '../footer.php'; ?>
</body>
</html>