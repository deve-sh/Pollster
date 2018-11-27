<?php
   // Script to check if the application has been properly installed.

   $handle1=fopen("../inc/confirm.txt", "r");
   $handle2=fopen("../inc/config.php", "r");
   $handle3=fopen("adminconfig.php", "r");
   $handle4=fopen("../inc/interconfig.php", "r")

   $text1=fread($handle1, filesize("../inc/confirm.txt"));
   $text2=fread($handle2, filesize("../inc/config.php"));
   $text3=fread($handle3, filesize("adminconfig.php"));
   $text4=fread($handle4, filesize("../inc/interconfig.php"));

   fclose($handle1);
   fclose($handle2);
   fclose($handle3);
   fclose($handle4);

   if($text1=="0"||$text2=="0"||$text3=="0"||$text4=="0"){
   		header("refresh:0;url=../install");     // Redirect if any process might return false.
   		exit();
   }
   // Otherwise continue.
?>