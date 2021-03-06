<?php
   session_start();
   include 'filer.php';     // Redirect to home if the script is already installed.

   // If the script has not been already installed : 
   include '../inc/connect.php';
   include '../inc/salt.php';          // For the security key.
?>
<!DOCTYPE html>
<html>
<head>
	<title>Installing Pollster</title>
	<?php include '../inc/installstyles.html'; ?>
</head>
<body class="installset">
	<main>
	<header>
		Pollster!
	</header>
	<div id="installform">
	<?php
		if($_SESSION['installing']==true){ // If the user actually entered the installation through the home page.

			// INSTALLATION VARIABLES
			
			$subscript=escapestr($_POST['subscript']);

			if(!$subscript){
				$subscript="poll_";
			}

			$errors=0;          // Error Counting Variable.

			$dbvars=array("host" => escapestr($_POST['host']),"username" => escapestr($_POST['username']),"password" => escapestr($_POST['password']),"dbname" => escapestr($_POST['dbname']),"subscript"=>escapestr($subscript));

			$appvars=array("appname" => escapestr($_POST['appname']),"appemail" => escapestr($_POST['appemail']));

			$adminvars=array("adminname"=>escapestr($_POST['adminname']),"adminpass"=>escapestr($_POST['adminpass']),"adminemail"=>escapestr($_POST['adminemail']));

			// Following are loops to check whether all the required variables are truthy or not.

			foreach ($dbvars as $key => $value) {
				if(strcmp($key,"password")!=0){      // Doesn't matter if password is empty or not. Database Passwords can be usually set to empty.
					if(!$value)
						$errors++;
				}
			}

			foreach ($appvars as $key => $value) {
				if(!$value)
					$errors++;
			}

			foreach($adminvars as $key => $value){
				if(!$value)
					$errors++;
			}

			if($errors==0){		// If there are no errors found.
			
			// Installation process begins.

				$db = new dbdriver;    // Database Driver Object.

				if($db -> connect($dbvars['host'],$dbvars['username'],$dbvars['password'],$dbvars['dbname'])){

					// First delete any sort of databases from previously failed installations.

					$db->query("DROP TABLE IF EXISTS ".$subscript."pollvotes CASCADE");

					$db->query("DROP TABLE IF EXISTS ".$subscript."polls CASCADE");

					$db->query("DROP TABLE IF EXISTS ".$subscript."users");

					// Loops to Escape every single string to avoid XXS Attacks or SQL Injection.

					$agreement = $_POST['agreement'];  // User Agreement

					$successcounter=0;

					$megaarray=array_merge($dbvars,$appvars,$adminvars);
					
					$query1="CREATE TABLE ".$subscript."users(id integer primary key auto_increment,name text not null,email varchar(255) unique not null,password varchar(255) not null,npolls integer,photo varchar(255) not null,salt varchar(255),securitykey varchar(255) not null,isadmin boolean not null)";

					$query2="CREATE TABLE ".$subscript."polls(pollid integer primary key auto_increment, userid integer references ".$subscript."users(id) on update set null on delete cascade, title text not null,nooptions integer not null,options text not null /*JSON*/,date_created text not null,results text not null /*Yet Anothr JSON*/,updated timestamp not null)";

					$query3="CREATE TABLE ".$subscript."pollvotes(voteid integer primary key auto_increment,pollid integer references ".$subscript."polls(pollid) on update set null on delete cascade,userid integer references ".$subscript."users(id) on delete cascade on update set null,voteindex integer not null)";

					// HASHING OF PASSWORD AND GENERATION OF SECURITY KEY

					$securitykey=generator();       // Generated Security Key.
					$salt=saltgen();

					$adminvars['adminpass']=crypt($adminvars['adminpass'],$salt);       // DEFAULT ALGORITHM
					$adminvars['adminpass']=md5($adminvars['adminpass']);               // EXTRA LAYER OF SECURITY

					$query4="INSERT INTO ".$subscript."users(name,email,password,npolls,photo,salt,securitykey,isadmin) VALUES('".$adminvars['adminname']."','".$adminvars['adminemail']."','".$adminvars['adminpass']."',0,'files/default.png','$salt','".crypt($securitykey,$salt)."',true)";

					if($db->query($query1)){
						$successcounter++;
						echo "Created User Tables.";
					}
					else{
						echo "<br/><br/>Failed to create User tables.";
					}

					if($db->query($query2)){
						$successcounter++;
						echo "<br><br>Created Poll Tables.";
					}
					else{
						echo "<br><br>Failed to create Poll Tables.";
					}

					if($db->query($query3)){
						$successcounter++;
						echo "<br><Br>Created Votes Table.";
					}
					else{
						echo "<br><br>Failed to create votes table.";
					}

					if($db->query($query4)){
						$successcounter++;
						echo "<br><Br>Inserted Admin Details.";
					}
					else{
						echo "<br><br>Could not insert admin details.";
					}

					// Checking if the installation was successful.

					if($successcounter==4){
						// NOW WRITING FILES

						fclose($handle1);
						fclose($handle2);

						// Closed the previously open files, now rewriting them.

						$configstring="<?php\n\nerror_reporting(0);\n\n";  // String to be written to the configuration file.

						$configstring.="include 'inc/connect.php';\n\n";

						foreach($dbvars as $key => $value) {
							$configstring.="\$".(string)$key." = '".$value."';\n";
						}

						$configstring.="\n";

						// Other settings :

						foreach($appvars as $key => $value){
							$configstring.="\$".(string)$key." = '".$value."';\n";
						}
						
						$configstring.="\$db = new dbdriver;\n\n";           // DB Driver Object Instance.
						$configstring.="\$db -> connect(\$host,\$username,\$password,\$dbname);";

						$configstring.="\ninclude 'inc/interconfig.php';\n?>";  // End of String

						// ADMIN CP CONFIGURATIONS

						$adminconfigstring="<?php\n\nerror_reporting(0);\n\n";  // String to be written to the configuration file.

						$adminconfigstring.="include '../inc/connect.php';\n\n";

						foreach($dbvars as $key => $value) {
							$adminconfigstring.="\$".(string)$key." = '".$value."';\n";
						}

						$adminconfigstring.="\n";

						// Other settings :

						foreach($appvars as $key => $value){
							$adminconfigstring.="\$".(string)$key." = '".$value."';\n";
						}
						
						$adminconfigstring.="\$db = new dbdriver;\n\n";           // DB Driver Object Instance.
						$adminconfigstring.="\$db -> connect(\$host,\$username,\$password,\$dbname);";

						$adminconfigstring.="\ninclude '../inc/interconfig.php';\n?>";  // End of String

						$writingsuccess=0;

						$filename4="../inc/interconfig.php";

						$handle1=fopen($filename1,"w+");
						if(fwrite($handle1,"1"))
							$writingsuccess++;
						fclose($handle1);

						$handle2=fopen($filename2,"w+");
						if(fwrite($handle2,$configstring))
							$writingsuccess++;
						fclose($handle2);

						$handle3=fopen($filename3,"w+");
						if(fwrite($handle3,$adminconfigstring))
							$writingsuccess++;
						fclose($handle3);

						$interconfigstring="<?php\n";
						$interconfigstring.="\$maxops = 5;\n\$footermessage = \"<div class = 'header'>Footer</div>\";\n";
						$interconfigstring.="\$agreement = \"".$agreement."\";\n";
						$interconfigstring.="?>";

						$handle4=fopen($filename4, "w+");

						if(fwrite($handle4,$interconfigstring))
							$writingsuccess++;
						fclose($handle4);

						if($writingsuccess==4)
							echo "<br><br>Congratulations, Your Pollster App was installed.<br><br>
								Kindly Note your User Security Key : <b>$securitykey</b>. <br>This will help you reset your password.<br><br>
								<a href='../index.php'><button class='submitbutton'>Check it out!</button></a>";
						else{
							echo "<br><br>Sorry, your app could not be installed, please try again.";
							echo "<br><br><a href='index.php'><button class='backbutton'><i class=\"fas fa-arrow-left fa-lg\"></i></button></a>";
						}
					}
					else{
						echo "<br><br>Sorry, your app could not be installed, please try again.";
						echo "<br><br><a href='index.php'><button class='backbutton'><i class=\"fas fa-arrow-left fa-lg\"></i></button></a>";
					}

				}
				else{
					echo "<br/><br/>Connection Could Not be Established.";
					echo "<br><br><a href='index.php'><button class='backbutton'><i class=\"fas fa-arrow-left fa-lg\"></i></button></a>";
				}

			}
			else{
				echo "<br><br>Something is wrong with the inputs.<br><br>Try Again.";
				echo "<br><br><a href='index.php'><button class='backbutton'><i class=\"fas fa-arrow-left fa-lg\"></i></button></a>";
			}
		}
		else
		{
			header("refresh:0;url=../index.php");
			exit();
			// If the user directly came to this page. Redirect to install.php as the script is not installed. Otherwise he would have been at ../index.php due to redirection.
		}
	?>
	</div>
   </main>
</body>
</html>