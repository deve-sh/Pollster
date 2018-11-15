<?php
include 'inc/config.php';

$userid=1;
$pollid=1;

$sampquery=$db->query("SELECT * FROM ".$subscript."polls WHERE pollid='".$pollid."'");
$checker1=$db->fetch($sampquery);

$result=($checker1['results']);

$results=unserialize($result);

foreach ($results as $key => $value) {
	if($key==$optionid){
		$results[$key]=$results[$key]+1;
	}
}

var_dump($results);

$results=serialize($results);
echo "<br><Br>".$results;
?>