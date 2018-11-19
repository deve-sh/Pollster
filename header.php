<div id='header'>
	<div class="left"><span class="back"><?php if($_SERVER['HTTP_REFERER']){?><a href="<?php echo $_SERVER['HTTP_REFERER']; ?>"><i class="fas fa-arrow-left"></i></a><?php } ?></span>&nbsp&nbsp <?php echo $appname; ?></div>
	<div class="right" align="right">
		<?php
			if(!$_SESSION['polluserid'] || !$_SESSION['polllog']){
				?>
					<button class="removebutton"><a href="register.php">Register</a></button>&nbsp&nbsp <a href="login.php" class="logintext">Login</a>
				<?php
			}else{
				?>
					<a href='usercp.php' title="User CP"><i class="fas fa-user-cog"></i></a> &nbsp&nbsp&nbsp
						<?php if($_SESSION['polladmin']==true){
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