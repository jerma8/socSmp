<?php

include_once '../../../konfig.php';

$izraz = $veza -> prepare("select * from korisnik where korisnik=:korisnik and sifra!=:sifra");

$korisnickoIme=$_POST['korisnik'];
$sifraKorisnika=$_POST['sifraKorisnika'];

$izraz -> bindParam(':korisnik', $korisnickoIme, PDO::PARAM_STR);
$izraz -> bindParam(':sifra', $sifraKorisnika, PDO::PARAM_STR);
$izraz -> execute();
$korisnik = $izraz -> fetch(PDO::FETCH_OBJ);

	
if($korisnik==null){
	echo "NEPOSTOJI";
}
else{
	echo "POSTOJI";
}
