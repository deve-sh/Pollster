<?php

include 'inc/connect.php';

$host = 'localhost';
$username = 'userr';
$password = 'password';
$dbname = 'test';
$subscript = 'poll_';

$appname = 'Pollster';
$appemail = 'devesh2027@gmail.com';
$agreement = 'This is to agree to the conditions that none of the Web Application\'s features shall be misused.';
$db = new dbdriver;

$db -> connect($host,$username,$password,$dbname);
include 'inc/interconfig.php';
?>