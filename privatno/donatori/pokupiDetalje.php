<?php
	include_once '../../konfig.php';
	
	$izraz = $veza -> prepare("	select ime,prezime,oib,adresa,mjesto
	from korisnik where sifra=:sifra");
	
	$izraz->bindParam("sifra",$_GET["sifra"]);
	$izraz -> execute();
	$detalji = $izraz -> fetch(PDO::FETCH_OBJ);
	
?>
	<h2 class="h25Font">Osobni podaci</h2>
	<hr class="hrLinija" />
	
	<table>
		<tr>
			<th>Ime:</th>
			<td><?php echo $detalji->ime; ?></td>
		</tr>
		
		<tr>
			<th>Prezime:</th>
			<td><?php echo $detalji->prezime; ?></td>
		</tr>
		
		<tr>
			<th>OIB:</th>
			<td><?php echo $detalji->oib; ?></td>
		</tr>
				
		<tr>
			<th>Adresa:</th>
			<td><?php echo $detalji->adresa; ?></td>
		</tr>
		
		<tr>
			<th>Mjesto:</th>
			<td><?php echo $detalji->mjesto; ?></td>
		</tr>
		
	</table>