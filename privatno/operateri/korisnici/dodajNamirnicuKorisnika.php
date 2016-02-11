<?php
include_once '../../../konfig.php';

$date = date('Y-m-d H:i:s');

$izraz = $veza->prepare("insert into uzima(sifraKorisnika,sifraNamirnice,datumUzimanja) values
(:sifraKorisnika,:sifraNamirnice,:datum);");

$sifraKorisnika=$_POST["sifraKorisnika"];
$izraz->bindParam(':sifraKorisnika', $sifraKorisnika);	

$sifraNamirnice=$_POST["sifraNamirnice"];
$izraz->bindParam(':sifraNamirnice', $sifraNamirnice);

$izraz->bindParam(':datum', $date);	

$izraz->execute();

echo "OK";


