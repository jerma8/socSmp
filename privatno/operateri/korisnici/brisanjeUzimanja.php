<?php
include_once '../../../konfig.php';

if(isset($_GET['kolicina']) && is_numeric($_GET['kolicina'])){
	$izraz = $veza->prepare("
	update namirnica set stanje=stanje+:kolicina 
	where sifra=:sifraNamirnice");
	
	$izraz->bindParam(':kolicina', $_GET['kolicina']);
	$izraz->bindParam(':sifraNamirnice', $_GET['sifraNamirnice']);	
	$izraz->execute();
}

$izraz = $veza->prepare("delete from uzima where 
sifraKorisnika=:sifraKorisnika and 
sifraNamirnice=:sifraNamirnice and
DATE(datumUzimanja)=:datum
");

$sifraKorisnika=$_GET["sifraKorisnika"];
$izraz->bindParam(':sifraKorisnika', $sifraKorisnika);	

$sifraNamirnice=$_GET["sifraNamirnice"];
$izraz->bindParam(':sifraNamirnice', $sifraNamirnice);

$izraz->bindParam(':datum', $_GET['datum']);

$izraz->execute();

echo "OK";
?>
