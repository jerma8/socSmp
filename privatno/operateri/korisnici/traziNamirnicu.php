<?php
include_once '../../../konfig.php';
if(isset($_GET["term"])){
$uv="%" . $_GET["term"] . "%";
}
else {
	$uv="%";
}

$date = date('Y-m-d H:i:s');
$date = substr($date, 0,10);


$izraz = $veza->prepare("
select * from namirnica where naziv like :naziv 
and stanje>0");
$izraz->bindParam(":naziv",$uv);
$izraz->execute();
echo json_encode($izraz->fetchAll(PDO::FETCH_OBJ));


