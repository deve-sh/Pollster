<?php

error_reporting(0);

include '../inc/connect.php';

$host = 'localhost';
$username = 'userr';
$password = 'password';
$dbname = 'test';
$subscript = 'poll_';

$appname = 'Pollster';
$appemail = 'devesh2027@gmail.com';
$db = new dbdriver;

$db -> connect($host,$username,$password,$dbname);
include '../inc/interconfig.php';
?>