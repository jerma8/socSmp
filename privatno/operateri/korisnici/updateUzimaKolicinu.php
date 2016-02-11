<?php
include_once '../../../konfig.php';


if(isset($_POST['trenutnaKolicina']) && is_numeric($_POST['trenutnaKolicina'])){
	
	$veza->beginTransaction();

	$izraz = $veza->prepare("
	update namirnica set stanje=stanje+:kolicina 
	where sifra=:sifraNamirnice");
	
	$izraz->bindParam(':kolicina', $_POST['trenutnaKolicina']);
	$izraz->bindParam(':sifraNamirnice', $_POST['sifraNamirnice']);	
	$izraz->execute();


	$izraz = $veza->prepare("
	update uzima set kolicina=:kolicina 
	where sifraKorisnika=:sifraKorisnika and sifraNamirnice=:sifraNamirnice
	 and datumUzimanja between DATE_SUB(NOW() , INTERVAL 2 MINUTE) AND NOW()");
	
	$izraz->bindParam(':kolicina', $_POST['kolicina']);	
	$izraz->bindParam(':sifraKorisnika', $_POST['sifraKorisnika']);	
	$izraz->bindParam(':sifraNamirnice', $_POST['sifraNamirnice']);	
	$izraz->execute();
	
	$izraz = $veza->prepare("
	update namirnica set stanje=stanje-:kolicina 
	where sifra=:sifraNamirnice");
	
	$izraz->bindParam(':kolicina', $_POST['kolicina']);
	$izraz->bindParam(':sifraNamirnice', $_POST['sifraNamirnice']);	
	$izraz->execute();
	
	$veza->commit();
	
	echo "OK";
	
}else{
	$veza->beginTransaction();

	$izraz = $veza->prepare("
	update uzima set kolicina=:kolicina 
	where sifraKorisnika=:sifraKorisnika and sifraNamirnice=:sifraNamirnice
	 and datumUzimanja between DATE_SUB(NOW() , INTERVAL 2 MINUTE) AND NOW()");
	
	$izraz->bindParam(':kolicina', $_POST['kolicina']);	
	$izraz->bindParam(':sifraKorisnika', $_POST['sifraKorisnika']);	
	$izraz->bindParam(':sifraNamirnice', $_POST['sifraNamirnice']);	
	$izraz->execute();
	
	$izraz = $veza->prepare("
	update namirnica set stanje=stanje-:kolicina 
	where sifra=:sifraNamirnice");
	
	$izraz->bindParam(':kolicina', $_POST['kolicina']);
	$izraz->bindParam(':sifraNamirnice', $_POST['sifraNamirnice']);	
	$izraz->execute();
	
	$veza->commit();
	
	echo "OK";
}



