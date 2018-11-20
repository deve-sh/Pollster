<?php
	session_start();
	include 'inc/checker.php';
	include 'inc/config.php';
	
?>
<!DOCTYPE html>
<html>
<head>
	<title><?php echo $appname; ?></title>
	<?php include 'inc/styles.html'; ?>
	<style type="text/css">
		.pagination a {
		    color: black;
		    padding: 8px 16px;
		    text-decoration: none;
		    transition: background-color .3s;
		}
		
		.pagination a.active {
		    background-color: dodgerblue;
		    color: white;
		}

		.pagination a:hover:not(.active) {
			background-color: #ddd;
		}
	</style>
</head>
<body class="mainbody">
	<main style="border-top : 5px solid #007fd0;">
		<?php include 'header.php'; ?>
		<div style="padding: 20px; overflow: auto;">
		<?php
			$pollquery=$db->query("SELECT * FROM ".$subscript."polls ORDER BY date_created DESC");   // Extracting all the polls in the database.

			if($db->numrows($pollquery)<=0){       // If no polls have been created so far. Display a message.
				?>
					<div class="nopolls" align="center">
						<div class="nopollsmessage">
							<i class="far fa-list-alt fa-3x"></i><br><br>
							No Polls Found Yet!
							<br><br>
							<?php
								if($_SESSION['polluserid'] && $_SESSION['polllog']==true){
									?>
										<a href="createpoll.php"><button class="removebutton">Create One</button></a>
									<?php
								}
								else{
									?>
										<a href="register.php" class="removebutton">Register</a> &nbsp&nbsp<a href="login.php" class="logintext">Login</a>
									<?php
								}
							?>
						</div>
					</div>
				<?php
			}
			else if($db->numrows($pollquery)>10){
				// If pagination is required.
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

				
				$sql = "SELECT * FROM ".$subscript."polls LIMIT $offset, $rowsperpage";
				$result = $db->query($sql);

				while ($poll = $db->fetch($result)) {
				   echo "<div class='pollbody'>
						<a href='viewpoll.php?pollid=".$poll['pollid']."&userid=".$_SESSION['polluserid']."'>
						<div class='polltitle'>".$poll['title']."</div></a>
						<div class='polldetails'>
						";
						if($_SESSION['polladmin']==true || $_SESSION['polluserid']==$poll['userid'])
							echo "<div class='left'><a href=\"removepoll.php?pollid=".$poll['pollid']."\"><span class='deletebutton'><i class=\"fas fa-trash\"></i></span></a></div>";

						echo "<div class='right'>".$poll['date_created']."</div>
						</div>
					</div>";
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

				echo "<br><div align=\"center\"><div class=\"bottomdash\"></div></div></div></div>";
			}
			else{                     // Spread all the polls out in a single page instead of pagination.
				while($poll=$db->fetch($pollquery)){ 
					echo "<div class='pollbody'>
						<a href='viewpoll.php?pollid=".$poll['pollid']."&userid=".$_SESSION['polluserid']."'>
						<div class='polltitle'>".$poll['title']."</div></a>
						<div class='polldetails'>
						";
						if($_SESSION['polladmin']==true || $_SESSION['polluserid']==$poll['userid'])
							echo "<div class='left'><a href=\"removepoll.php?pollid=".$poll['pollid']."\"><span class='deletebutton'><i class=\"fas fa-trash\"></i></span></a></div>";

						echo "<div class='right'>".$poll['date_created']."</div>
						</div>
					</div>";
				}
			}
		?>
		</div>
		<br><div align="center">
			<div class="bottomdash"></div>
			<?php 
				if($_SESSION['polllog']==true && $_SESSION['polluserid']){
					echo "<br><br><a href='createpoll.php'><button class='removebutton'>Create A Poll</button></a>";
				}
			?>
		</div>
	</main>
	<?php include 'footer.php'; ?>
</body>
</html>