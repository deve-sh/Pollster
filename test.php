<?php

   $x=array("assoc" => "yay","myname" => "yayay");

   $str="";
   foreach ($x as $key => $value) {              // Better way to map.
        $str.="$".$key." = '".$value."';<br>";
   }

   echo $str."<br><br>";

   $password="devesh2028";

   echo password_hash($password,PASSWORD_BCRYPT)."<br><br>";

   if(password_verify("devesh2028",password_hash($password,PASSWORD_BCRYPT))){
    echo "Verified<br><BR>";
   }
   else{
    echo "Wrong Password<br><br>";
   }

   $var="";

   if(!$var){
    echo "Yay";
   }
?>