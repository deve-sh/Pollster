<?php

   require('connect.php');

   $db = new dbdriver;

   $connect = $db->connect('localhost','userr','password','test');

   $query = $db->query("SELECT *  FROM keep_notes");

   $mystring = $db -> escape("Sdsfad^7&@#\"'.2132-_+=");

   echo ($mystring."<br><br>");

   while($myname = $db -> fetch($query)){
   	  echo $myname['title']."<br/><br/>";
   }
?>