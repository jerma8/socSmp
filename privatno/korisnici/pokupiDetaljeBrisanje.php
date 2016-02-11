<?php
	include_once '../../konfig.php';
	
	$izraz = $veza -> prepare("select * from narudzba where sifra=:sifra");
	
	$izraz->bindParam("sifra",$_GET["sifra"]);
	$izraz -> execute();
	$detalji = $izraz -> fetch(PDO::FETCH_OBJ);

	$_SESSION['sifraBrisanja']=$_GET["sifra"]; 
	
?>
	<h2 class="h25Font">Brisanje narudžbe</h2>
	<hr class="hrLinija" />
	
	<table>
		<tr>
			<th>Namirnica:</th>
			<td><?php echo $detalji->naziv; ?></td>
		</tr>
		
		<tr>
			<th>Količina:</th>
			<td><?php echo $detalji->kolicina; ?></td>
		</tr>
		
		<tr>
			<th>Datum narudžbe:</th>
			<td><?php echo $detalji->datumNarudzbe; ?></td>
		</tr>
		
	</table>