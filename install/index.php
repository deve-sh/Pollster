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
<body class="installset">
	<header>
		Pollster!
	</header>
	<main>
		<!-- SIGNUP FORM -->
		<form action="installer.php" method="POST" id='installform'>
			<h2>Pollster Installation</h2>
			<h3>Database Details</h3>

			MySQL Improved Databases are the only ones supported.
			
			<br/><br/>
			<input type="text" name="host" autocomplete="on" required placeholder="Host"><br/><br/>
			<input type="text" name="username" autocomplete="on" required placeholder="Username"><br/><br/>
			<input type="password" name="password" autocomplete="off" placeholder="Password"><br/><br/>
			<input type="text" name="dbname" autocompleteon="on" required placeholder="Database Name"><br/><br/>
			<input type="text" name="subscript" autocomplete="on" placeholder="Subscript (Default : poll_)"><br/><br/>

			<h3>Voting App Details</h3>

			<input type="text" name="appname" autocomplete="on" required placeholder="Voting App Name"><br/><br/>
			<input type="email" name="appemail" autocomplete="on" required placeholder="Voting App Email"><br/><br/>
			<label for="agreement">Enter an Agreement your users may see at the time of Registration</label> : <br/><br/>
			<textarea name="agreement" placeholder="Enter Your Terms of Use for Users to Signup. Leave Blank for default."><?php echo $installagreement;?></textarea>
			<br/><br/>

			<h3>Administrator Details</h3>
			
			<input type="text" name="adminname" required placeholder="Admin Name"><br/><br/>
			<input type="email" name="adminemail" required placeholder="Admin Email"><br/><br/>
			<input type="password" name="adminpass" required placeholder="Admin Password"><br/><br/>
			
			<div align="center">
				<button type="submit" name="submit" value="INSTALL" class="submitbutton">INSTALL</button>
			</div>
		</form>
	</main>
</body>
</html>