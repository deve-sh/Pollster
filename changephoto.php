<?php
session_start();
include 'inc/checker.php';
include 'inc/config.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title><?php echo $appname." - "; ?>Change Profile Photo</title>
	<?php include 'inc/styles.html'; ?>
</head>
<body class="mainbody">
	<main style="border-top: 5px solid #cfcfcf;">
		<?php include 'header.php'; ?>
		<div align="center">
			<?php
				if($_SESSION['polluserid'] && $_SESSION['polllog']==true){
					?>
					<br><br>
					<form action="" method="POST" enctype="multipart/form-data" id="installform">
						<h3>Change Photo</h3><br>
						<input type='file' name="image" required/>
						<br><br>
						<button type="submit" class="submitbutton">Change</button>
					</form>
					<br><br>
					<a href="removephoto.php">Remove Photo</a> &nbsp&nbsp<button class="removebutton"><a href='index.php'>Home</a></button>
					<?php

					if($_FILES['image']['tmp_name'])
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

						if(isset($_POST["submit"])) {    // If user actually uploaded file.
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

						    	$user = $db->fetch($db->query("SELECT * FROM ".$subscript."users WHERE id='".$_SESSION['polluserid']."'"));

						    	$oldphoto = $user['photo'];

						    	// Updating the Photo URL for the user.

						    	if($db->query("UPDATE ".$subscript."users SET photo='".$target_file."' WHERE id='".$_SESSION['polluserid']."'")){
						    		echo "<br><br>Profile Picture Successfully updated!";

						    		if(strcmp("files/default.png",$oldphoto)!=0){
						    			unlink($oldphoto); // Deleted previous photo.
						    		}

						    		header("refresh:2;url=index.php");
						    		exit();
						    	}
						    	else{
						    		echo "<br><br>There was a problem in uploading the file.";

						    	}
						    } else {
						        echo "Sorry, there was an error uploading your file. Kindly Try Again.";
						    }
						}
					}
				}
				else{
					header("refresh:0;url=login.php");
					exit();
				}
			?>
		</div>
	</main>
</body>
</html>