<?php

include_once '../../../konfig.php';

$izraz = $veza -> prepare("select * from korisnik where korisnik=:korisnik");

$o=$_POST['korisnik'];
$izraz -> bindParam(':korisnik', $o, PDO::PARAM_STR);
$izraz -> execute();
$osoba = $izraz -> fetch(PDO::FETCH_OBJ);
 
 if($osoba==null){
  echo "NEPOSTOJI";
 }
 else{
  echo "POSTOJI";
 }