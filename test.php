<?php

   $x=array("assoc" => "yay","myname" => "yayay");

   $str="";
   foreach ($x as $key => $value) {              // Better way to map.
        $str.="$".$key." = '".(string)$value."';<br>";
   }

   echo $str."<br><br>";

   include 'inc/config.php';
   $userid=1;
   $pollid=1;
?>