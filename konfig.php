<?php
session_start();


$putanjaApp="/Zadaci/socSamoposluga/";
$mysql_host = "localhost";
$mysql_database = "socijalnaSamoposluga";  //probalogin
$mysql_user = "root";
$mysql_password = "";
$ida = 'hkos';

//server
/*
$putanjaApp="/";
$mysql_host = "mysql8.000webhost.com";
$mysql_database = "a6295371_baza8";
$mysql_user = "a6295371_zuky8";
$mysql_password = "jerma454";
*/


$veza = new PDO(
'mysql:host=' . $mysql_host . ';dbname=' . $mysql_database . ';charset=utf8', 
$mysql_user, 
$mysql_password);



?>