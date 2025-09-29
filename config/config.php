<?php
session_start();
date_default_timezone_set('Asia/Kolkata');

//Database Connection
$dbhost='sql203.infinityfree.com';
$dbuser='if0_39824054';
$dbpass='frl2g7n0oZh0';
$dbname='if0_39824054_project_db';

$conn= mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);

