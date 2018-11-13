<?php
session_start();
include 'inc/config.php';
$pollid=$_GET['pollid'];

  echo "[";
   if($pollid)
   {
   	   $query=$db->query("SELECT * FROM ".$subscript."polls WHERE pollid='$pollid'");

   	   if($db->numrows($query)){
   	   	  $result=$db->fetch($query);
   	   }
   	   // First printing the main details : 
   	   
   	   echo "{";
   	   echo '"title":"'.$result['title']."\",";
   	   echo '"options":'.$result['options']."";
   	   echo "},";

   	   // Now the voting results.

   	   echo $result['results']."";
   }
  echo "]";

?>