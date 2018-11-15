<?php

   $x=array("assoc" => "yay","myname" => "yayay");

   $str="";
   foreach ($x as $key => $value) {              // Better way to map.
        $str.="$".$key." = '".(string)$value."';<br>";
   }

   echo $str."<br><br>";

   $myarray=array(
   		"0"=>40,
   		"1"=>45,
   		"2"=>5,
   		"3"=>0
   );

   echo serialize($myarray);

   echo "<br>
   {";
   foreach ($myarray as $key => $value) {
   		echo $key." : ".$value."<br>";
   }
   echo "}<br>";
?>