<?php

include_once '../../../konfig.php';

$izraz = $veza -> prepare("select * from korisnik where oib=:oib");

$o=$_POST['oib'];
$izraz -> bindParam(':oib', $o);
$izraz -> execute();
$osoba = $izraz -> fetch(PDO::FETCH_OBJ);

 
 if($osoba==null){
  echo "NEPOSTOJI";
 }
 else{
  echo "POSTOJI";
 }