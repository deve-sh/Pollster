<?php

   $x=array("assoc" => "yay","m" => "yayay");

   $str="";
   foreach ($x as $key => $value) {              // Better way to map.
      if($key=="m")
         $x[$key]="y";
      $str.="$".$key." = '".(string)$value."';<br>";
   }

   echo $str;

   var_dump($x);

?>