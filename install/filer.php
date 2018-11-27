<?php
	// INSTALLATION FILES TO BE OPENED AND CHECKED
    $filename1="../inc/confirm.txt";         // Confirmation File.
    $filename2="../inc/config.php";          // Configuration File.
    $filename3="../admin/adminconfig.php";
    $filename4="../inc/interconfig.php";

	$handle1=fopen($filename1, "r");
	$handle2=fopen($filename2, "r");
	$handle3=fopen($filename3, "r");
	$handle4=fopen($filename4, "r");

	$string1=fread($handle1, filesize($filename1));
	$string2=fread($handle2, filesize($filename2));
	$string3=fread($handle3, filesize($filename3));
	$string4=fread($handle4, filesize($filename4));

	if($string1!="0" && $string2!="0" && $string3!="0" && $string4!="0"){          // Redirect to home if any of these have been installed.
		header("refresh:0;url=../index.php");
	}
?>