<?php
session_start();
include 'adminchecker.php';
include 'adminconfig.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title><?php echo $appname." - "; ?>Updating Settings...</title>
	<?php include 'adminstyles.html'; ?>
</head>
<body class="mainboy">
<main style="padding: 20px;">
<?php
	if($_SESSION['polllog']==true && $_SESSION['polladmin']==true && $_SESSION['polluserid'])
	{
		$editedagreement = $_POST['agreement'];
		$editedfootermessage = $_POST['footermessage'];
		$editedmaxops = $_POST['maxops'];


	if($editedmaxops && $editedfootermessage && $editedmaxops)
	{
		$handle = fopen('../inc/interconfig.php','w+');

		$interconfigstring="<?php\n";
		$interconfigstring.="\$maxops = ".$editedmaxops.";\n";
		$interconfigstring.="\$footermessage = \"".$editedfootermessage."\";\n";
		$interconfigstring.="\$agreement = \"".$editedagreement."\";\n";
		$interconfigstring.="?>";

		if(fwrite($handle, $interconfigstring)){
			echo "<br><br>File successfully written and updated.";
			header("refresh:1;url=forumsettings.php");
			exit();
		}
		else{
			echo "<br><br>Sorry, there was an error.";
		}
	  }
	  else{
	  	header("refresh:0;url=forumsettings.php");
	  	exit();
	  }
	}
	else{
		header("refresh:0;url=../index.php");
		exit();
	}
?>
</main>
</body>
</html>