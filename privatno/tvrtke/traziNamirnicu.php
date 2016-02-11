<?php
include_once '../../konfig.php';
if(isset($_GET["term"])){
	$uv=$_GET["term"] . "%";
}
else {
	$uv="%";
}
$izraz = $veza->prepare("
select sifra,naziv from namirnica where naziv like :naziv
");
$izraz->bindParam(":naziv",$uv);
$izraz->execute();
echo json_encode($izraz->fetchAll(PDO::FETCH_OBJ));
