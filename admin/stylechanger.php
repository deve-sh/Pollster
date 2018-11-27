<?php
session_start();
include('adminchecker.php');
include('adminconfig.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title>Updating Styles ...</title>
	<?php include('adminstyles.html'); ?>
</head>
<body class="mainbody">
	<main style="padding: 20px;">
		<?php
			if($_SESSION['polllog']==true && $_SESSION['polluserid'] && $_SESSION['polladmin']==true){
				$mainstyle=$_POST['mainstyle'];
				$smallscreen=$_POST['smallscreen'];
				$ultrasmall=$_POST['ultrasmall'];

				// Opening the files to write.

				$mainstylefile = fopen("../styles/style.css","w+");
				$smallscreenfile = fopen("../styles/smallscreen.css", "w+");
				$ultrasmallfile = fopen("../styles/ultrasmall.css","w+");

				if(fwrite($mainstylefile, $mainstyle) && fwrite($smallscreenfile, $smallscreen) && fwrite($ultrasmallfile, $ultrasmall)){
					echo "<br><br>Successfully written and updated files.";

					fclose($mainstylefile);
					fclose($smallscreenfile);
					fclose($ultrasmallfile);
					
					header("refresh:1;url=templater.php");
					exit();
				}
				else{
					echo "<br><br>An error occured. Sorry. Please Try Again.";
					header("refresh:2;url=templater.php");
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