<?php

	$maxops=5;     // Maximum number of options in a poll.

	$footermessage = "<div class='header'>Footer</div>";
	if($_SESSION['polladmin']==true)
		$footermessage.="<br>Insert your footer message here in the admin section.";
?>