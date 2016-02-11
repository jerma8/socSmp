<?php
	include_once '../../../konfig.php';
	
	$izraz = $veza -> prepare("select sifra, naziv from namirnica where sifra=:sifra");
	$izraz->bindParam("sifra",$_GET["sifra"]);
	$izraz -> execute();
	$detalji = $izraz -> fetch(PDO::FETCH_OBJ);
	echo $detalji->naziv;
?>