<?php

include_once '../../../konfig.php';

$izraz = $veza -> prepare("select * from namirnica where barkod=:barkod");

$o=$_POST['barkod'];
$izraz -> bindParam(':barkod', $o, PDO::PARAM_STR);
$izraz -> execute();
$oib = $izraz -> fetch(PDO::FETCH_OBJ);

 
 if($oib==null){
  echo "NEPOSTOJI";
 }
 else{
  echo "POSTOJI";
 }