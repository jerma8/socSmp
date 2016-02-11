<?php
	include_once '../../../konfig.php';
	
	$izraz = $veza -> prepare("delete from pripremaDonacije where sifra=:sifra");
	$izraz->bindParam("sifra",$_GET["sifra"]);
	$izraz -> execute();
	$detalji = $izraz -> fetch(PDO::FETCH_OBJ);
	
?>