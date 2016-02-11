<?php
include_once '../../../konfig.php';

$date = date('Y-m-d H:i:s');
$date = substr($date, 0,10);

$izraz = $veza->prepare("delete from uzima where 
sifraKorisnika=:sifraKorisnika and 
sifraNamirnice=:sifraNamirnice and
datumUzimanja=:datum
");

$sifraKorisnika=$_POST["sifraKorisnika"];
$izraz->bindParam(':sifraKorisnika', $sifraKorisnika);	

$sifraNamirnice=$_POST["sifraNamirnice"];
$izraz->bindParam(':sifraNamirnice', $sifraNamirnice);

$izraz->bindParam(':datum', $date);


$izraz->execute();
echo "OK";
?>
