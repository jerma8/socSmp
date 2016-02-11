<?php
include_once '../../../konfig.php';
//BRISANJE - BROWSER BACK

$izraz = $veza->prepare("
delete from uzima where sifraKorisnika=:sifraKorisnika and datumUzimanja between DATE_SUB(NOW() , INTERVAL 10 MINUTE) AND NOW()");

$izraz->bindParam(':sifraKorisnika', $_GET['sifraKorisnika']);	
$izraz->execute();
echo "OK";
?>
