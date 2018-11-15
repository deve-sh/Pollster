<?php
session_start();
include 'inc/checker.php';
include 'inc/config.php';
$_SESSION['polluserid']=1;
$_SESSION['polllog']=true;
$pollid=$_GET['pollid'];
$userid=$_GET['userid'];

if($_SESSION['polllog']==true && $userid && $userid==$_SESSION['polluserid'])
{
  echo "[";
   if($pollid)
   {
   	   $query=$db->query("SELECT * FROM ".$subscript."polls WHERE pollid='$pollid'");

   	   if($db->numrows($query)){
   	   	 
         $result=$db->fetch($query);
     	   
         // First printing the main details : 
     	   
     	   echo "{";
     	   echo '"title":"'.$result['title']."\",";
     	   echo '"options":'.$result['options'].",";
         echo '"totalvotes":'.$result['totalvotes']."";
     	   echo "},";

     	   // Now the voting results.

         $query1=$db->query("SELECT * FROM ".$subscript."pollvotes WHERE userid='$userid' AND pollid='$pollid'");

         if($db->numrows($query1)!=0){
            $vote=$db->fetch($query1);
            echo "{\"uservote\":".$vote['voteindex']."}";
         }
         else{
          echo "{\"uservote\":-1}";
         }
     }
   }
  echo "]";
}else{
  echo "Unauthorised.";
}
?>