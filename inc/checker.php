<?php
	# PAGE TO CHECK IF POLLSTER IS INSTALLED OR NOT

	// INSTALLATION FILES TO BE OPENED AND CHECKED
    $filename1="./inc/confirm.txt";         // Confirmation File.
    $filename2="./inc/config.php";          // Configuration File.

	$handle1=fopen($filename1,"r");
	$handle2=fopen($filename2, "r");

	$string1=fread($handle1, filesize($filename1));
	$string2=fread($handle2, filesize($filename2));

	fclose($handle1);
	fclose($handle2);                           // Closed both the configuration files.

	if($string1=="0" || $string2=="0"){          // Redirect to home if any of these have been installed.
		header("refresh:0;url=./install");
	}
?>