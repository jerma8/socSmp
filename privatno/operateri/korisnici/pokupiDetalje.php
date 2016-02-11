<?php
	include_once '../../../konfig.php';
	
	$izraz = $veza -> prepare("	select ime,prezime
	from korisnik where sifra=:sifra");
	
	$izraz->bindParam("sifra",$_GET["sifra"]);
	$izraz -> execute();
	$detalji = $izraz -> fetch(PDO::FETCH_OBJ);
		
?>
	<h2 class="h25Font">Potvrda brisanja</h2>
	<hr class="hrLinija" />
	
	<div class="row quote">
		Sigurno želite obrisati korisnika:<br>
		
			<?php echo $detalji->ime . " " . $detalji->prezime; ?>
		
		
	</div>
