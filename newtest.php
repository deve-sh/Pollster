<!DOCTYPE html>
<html>
<head>
	<title>Pagination</title>
	<style type="text/css">

	    .pagination a {
		    color: black;
		    float: left;
		    padding: 8px 16px;
		    text-decoration: none;
		    transition: background-color .3s;
		}
		
		.pagination a.active {
		    background-color: dodgerblue;
		    color: white;
		}

		.pagination a:hover:not(.active) {
			background-color: #ddd;
		}
	</style>
</head>

<?php
	include 'inc/config.php';
	$db = new dbdriver;

	$db->connect("localhost","userr","password","test");

	$results=$db->query("SELECT * FROM testtable");
	
	$numrows=mysqli_num_rows($results);

	echo "<br><Br>".$numrows."<br><br>";


	/* BASIC PAGINATION */

	echo "<br><div class='pagination'>";

	$rowsperpage = 10;
	
	$totalpages = ceil($numrows / $rowsperpage);

	
	if (isset($_GET['currentpage']) && is_numeric($_GET['currentpage'])) {
	   
	   $currentpage = (int) $_GET['currentpage'];
	} else {
	   
	   $currentpage = 1;
	} 

	
	if ($currentpage > $totalpages) {
	   
	   $currentpage = $totalpages;
	} 
	
	if ($currentpage < 1) {
	   
	   $currentpage = 1;
	} 

	
	$offset = ($currentpage - 1) * $rowsperpage;

	
	$sql = "SELECT name FROM testtable LIMIT $offset, $rowsperpage";
	$result = $db->query($sql);

	
	while ($list = $db->fetch($result)) {
	   echo "".$list['name']."<br/>";
	} 

	

	$range = 2;

	if ($currentpage > 1) {
	   
	   echo "<a href='{$_SERVER['PHP_SELF']}?currentpage=1'><<</a> ";
	   
	   $prevpage = $currentpage - 1;
	   
	   echo "<a href='{$_SERVER['PHP_SELF']}?currentpage=$prevpage'><</a> ";
	} 

		
	for ($x = ($currentpage - $range); $x < (($currentpage + $range) + 1); $x++) {
	
	   if (($x > 0) && ($x <= $totalpages)) {
	
	      if ($x == $currentpage) {
		
	         echo "<a class='active'>$x</a>";
	      
	      } else {
	         
	         echo "<a href='{$_SERVER['PHP_SELF']}?currentpage=$x'>$x</a> ";
	      } 
	   } 
	} 
	                 
	
	if ($currentpage != $totalpages) {
	   
	   $nextpage = $currentpage + 1;
	    
	   echo " <a href='{$_SERVER['PHP_SELF']}?currentpage=$nextpage'>></a> ";
	   
	   echo " <a href='{$_SERVER['PHP_SELF']}?currentpage=$totalpages'>>></a> ";
	} 

	echo "</div>";
	
?>