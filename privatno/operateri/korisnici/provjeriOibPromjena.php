<?php

include_once '../../../konfig.php';

$izraz = $veza -> prepare("select * from korisnik where oib=:oib and sifra!=:sifraKorisnika");

$oib=$_POST['oib'];
$sifraKorisnika=$_POST['sifraKorisnika'];

$izraz -> bindParam(':oib', $oib, PDO::PARAM_STR);
$izraz -> bindParam(':sifraKorisnika', $sifraKorisnika, PDO::PARAM_STR);
$izraz -> execute();

$korisnik = $izraz -> fetch(PDO::FETCH_OBJ);

if($korisnik==null){
	echo "NEPOSTOJI";
}
else{
	echo "POSTOJI";
}
