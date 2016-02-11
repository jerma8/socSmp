<?php
	include_once '../../../konfig.php';
	
	$izraz = $veza -> prepare("	select naziv
	from namirnica where sifra=:sifra");
	
	$izraz->bindParam("sifra",$_GET["sifra"]);
	$izraz -> execute();
	$detalji = $izraz -> fetch(PDO::FETCH_OBJ);
		
?>
	<h2 class="h25Font">Potvrda brisanja</h2>
	<hr class="hrLinija" />
	
	<div class="row quote">
		Sigurno želite obrisati namirnicu:<br>
		
			<?php echo $detalji->naziv; ?>
		
		
	</div>
