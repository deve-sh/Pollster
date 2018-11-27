<?php
	session_start();
	include 'inc/checker.php';
	include 'inc/config.php';
	include 'inc/salt.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title><?php echo $appname." - "; ?>Register</title>
	<?php include 'inc/styles.html'; ?>
</head>
<body class="installset">
	<main style="padding: 0px;">
		<?php include 'header.php'; ?>
		<div style="padding: 30px;" align="center">
		<?php
			if($_SESSION['polllog']==false || !$_SESSION['polluserid']){
				?>
					<!-- LOGIN FORM -->
					<form action="" method="POST" id='installform' enctype="multipart/form-data">
						<h2>Register</h2>
						<input type="text" name="name" placeholder="Name" required="true" autocomplete="false"/><br><br>
						<input type="email" name="email" placeholder="Email Address" required="true" autocomplete="false" /><br><br>
						<input type="password" name="password" placeholder="Password" required="true" autocomplete="false"/>
						<br><br>
						Profile Photo : 
						<br><br>
						<input type="file" name="image"><br><br>
						<div align="center">
							<button type="submit" name="submit" class="submitbutton">REGISTER</button>
						</div>
						<br>
					</form>
				<?php

				$name = $db->escape($_POST['name']);
				$email = $db->escape($_POST['email']);
				$password = $db->escape($_POST['password']);

			if($name && $email && $password){      // If all the fields were entered.

				echo "<br><Br><br><div class='register'>";
				
				if($db->numrows($db->query("SELECT * FROM ".$subscript."users WHERE email='$email'"))==0)
				{
					$filename=explode('.',basename($_FILES['image']['name']));

					$extension=$filename[1];
					$filename=$filename[0];

					$target_file=uniqid();
					$target_file=crypt($target_file,$salt);
					$target_file=md5($target_file);

					$target_file='files/'.$target_file.$filename.'.'.$extension;

					// Generating a completely random filename. UNBREAKABLE!!!

					$target_file=str_replace(' ','_',$target_file);
		   	        
		   	        // Replace all white spaces with an underscore to remove errors.

					$uploadOk = 1;
					$imageFileType = strtolower($extension);

					if(isset($_POST["submit"])) {
					    $check = getimagesize($_FILES["image"]["tmp_name"]);
					    if($check !== false) {
					        $uploadOk = 1;
					    } else {
					        echo "File is not an image.";
					        $uploadOk = 0;
					    }
					}

					if (file_exists($target_file)) {
					    $target_file=crypt($target_file,$salt);
					    $target_file=md5($target_file);
					    $target_file="files/".$target_file.".".$extension;
					    // Recycle hashing.
					}

					if ($_FILES["image"]["size"] > 2000000) {  // File Greater than 2 MB.
					    echo "Sorry, your file is too large.";
					    $uploadOk = 0;
					}

					if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
					&& $imageFileType != "gif" ) {
					    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
					    $uploadOk = 0;
					}

					if ($uploadOk == 0) {
					    echo "Sorry, your file was not uploaded.";
					} 
					else {
					    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
					    	echo "";
					    } else {
					        echo "Sorry, there was an error uploading your file. Kindly Try Again.";
					    }
					}

					if($uploadOk==1){
						$npolls=0;
						$isadmin=false;
						$salt=saltgen();
						$seckey=generator();

						// Hashing Password

						$password = crypt($password,$salt);
						$password = md5($password);

						$seckeytoins = crypt($seckey,$salt);

						if($db->query("INSERT INTO ".$subscript."users(name,email,password,npolls,photo,salt,securitykey,isadmin) VALUES('$name','$email','$password','$npolls','$target_file','$salt','$seckeytoins','$isadmin')")){
							echo "<br><br>Successfully Registered. Kindly Login Now.";
							echo "<br><br>Keep the security key : <b>$seckey</b>.<br>This will be important to change password later on.";
							echo "<br><br><button class='removebutton'><a href='index.php'>Home</a></button>";
							echo "&nbsp<button class='removebutton'><a href='login.php'>Login</a></button>";
						}
						else{
							unlink($target_file); // Delete the previously uploaded file.
							echo "<br><br>There was an error during registration. Kindly Try Again.";
						}
					}
				

				}
				else
				{
			  		echo "<br><br>A user with that email already exists. Try another Email.";
			  	}
			  }

			  echo "</div>";

			}
			else{
				echo "<br><br>Already logged in.";
				header("refresh:0;url=index.php");
				exit();
			}
		?>
		</div>
	</main>
	<?php include 'footer.php'; ?>
</body>
</html>