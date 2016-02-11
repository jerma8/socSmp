<?php

include_once '../../../konfig.php';

$izraz = $veza -> prepare("select * from namirnica where barkod=:barkod and sifra!=:sifraNamirnice");

$barkod=$_POST['barkod'];
$sifraNamirnice=$_POST['sifraNamirnice'];

$izraz -> bindParam(':barkod', $barkod);
$izraz -> bindParam(':sifraNamirnice', $sifraNamirnice);
$izraz -> execute();

$namirnica = $izraz -> fetch(PDO::FETCH_OBJ);

if($namirnica==null){
	echo "NEPOSTOJI";
}
else{
	echo "POSTOJI";
}
?>