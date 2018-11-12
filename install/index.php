<?php
   session_start();
   include 'filer.php';     // Redirect to home if the script is already installed.

   // If the script has not been already installed : 

   include './installsettings.php';   // Preset Variables.
   $_SESSION['installing']=true;      // Session variable to identify the users actually installing the script.
?>
<!DOCTYPE html>
<html>
<head>
	<title>Install Pollster</title>
	<?php
		include '../inc/installstyles.html';   // Installation Essentials.
	?>
</head>
<body>
	<main>
		<!-- SIGNUP FORM -->
		<form action="installer.php" method="POST" id='installform'>
			<h2>Pollster Installation</h2>
			<h3>Database Details</h3>

			MySQL Improved Databases are the only ones supported.
			
			<br/><br/>
			<input type="text" name="host" autocomplete="off" required placeholder="Host"><br/><br/>
			<input type="text" name="username" autocomplete="off" required placeholder="Username"><br/><br/>
			<input type="text" name="password" autocomplete="off" placeholder="Password"><br/><br/>
			<input type="text" name="dbname" autocomplete="off" required placeholder="Database Name"><br/><br/>

			<h3>Voting Details</h3>
			<input type="text" name="appname" autocomplete="off" required placeholder="Voting App Name"><br/><br/>
			<input type="email" name="appemail" autocomplete="off" required placeholder="Voting App Email"><br/><br/>
			<label for="Aggreement">Enter an Agreement your users may see at the time of Registration</label> : <br/><br/>
			<textarea name="Aggreement" placeholder="Enter Your Terms of Use for Users to Signup. Leave Blank for default.">
				<?php 
					echo $installagreement;
				?>
			</textarea>
			<br/><br/>
			<input type="submit" name="submit" value="INSTALL" class="submitbutton">
			<br/><br/>
		</form>
	</main>
</body>
</html>