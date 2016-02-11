<?php
include_once '../../../konfig.php';
if (!isset($_SESSION['operater'])) {
	header("location: ../../../logout.php");
}
$sifra = "";
$naziv="";

if (isset($_GET['sifra'])) {
	$sifra = $_GET['sifra'];
} else if (isset($_POST['sifra'])) {
	$sifra = $_POST['sifra'];
}


if ($_POST) {
	
		
		$veza->beginTransaction();
		
		//1. brisanje iz priprema donacije
		$izraz = $veza -> prepare("delete from pripremaDonacije where sifraKorisnika=:sifra");
		$izraz -> bindParam(":sifra", $sifra);
		$izraz -> execute();
	
		
		//2. brisanje iz korisnik
		$izraz = $veza -> prepare("delete from korisnik where sifra=:sifraKorisnika");
		$izraz -> bindParam(":sifraKorisnika", $sifra);
		$izraz -> execute();
		
		$veza->commit();
		
		header("location: index.php");
	
}

if ($_GET) {
	$izraz = $veza -> prepare("select * from korisnik where sifra=:sifra");
	$izraz -> bindParam(":sifra", $sifra);

	$izraz -> execute();
	$objekt = $izraz -> fetch(PDO::FETCH_OBJ);
	
	$naziv = $objekt -> ime. " ". $objekt -> prezime;
}
?><!doctype html>
<html class="no-js" lang="en">
	<head>
		<?php
		include_once '../../../head.php';
		?>
	</head>
	<body>
		<?php
		include_once '../../../zaglavlje.php';
		?>

		<!-- TIJELO ZA LARGE I MEDIUM -->
		<div class="row marginBottom20 textCenter">
			<div class="large-12 columns">
				<br />
				<h1 class="h1Font2">Socijalna&nbsp;&nbsp;&nbsp;samoposluga</h1>
				<!-- FONT BODY I H1 H2 H3 -->

			</div>
		</div>
		
	<div class="row">
			<div class="large-8 large-centered columns">
				<div class="panel">
							
							<div class="row">
									<div class="large-6 columns">
										<h2 class="h25Font">Brisanje donatora</h2>
									</div>
									<div class="large-2 columns">
										<a id="nazad" class="button round right" href="<?php echo $putanjaApp; ?>privatno/operateri/donatori/index.php">Nazad</a>
									</div>

							</div>
							
						
							<div class="panel panelBorder">
								<div class="row">
								
	
	<table>
		<tr>
			<th>Naziv:</th>
			<td><?php echo $objekt -> oib; ?></td>
		</tr>
		
		<tr>
			<th>Adresa:</th>
			<td><?php echo $objekt -> ime; ?></td>
		</tr>
		
		<tr>
			<th>Ime kontakt osobe:</th>
			<td><?php echo $objekt -> prezime; ?></td>
		</tr>
		
		<tr>
			<th>Telefon kontakt osobe:</th>
			<td><?php echo $objekt -> adresa; ?></td>
		</tr>
		
		<tr>
			<th>Email:</th>
			<td><?php echo $objekt -> mjesto; ?></td>
		</tr>
	
	</table>
				

			<a id="<?php echo $sifra; ?>" class="obrisi button round">Obriši donatora</a>
								
								
								</div>
							</div>
							
							
						</div>
					</div>
				</div>

		
		<div class="potpis">
			<label class="right">&copy; Damir Majer 07.03.2015.</label>
		</div>
		
		<?php
		include_once 'modalDetalji.php';
		?>
		<?php
		include_once '../../../skripte.php';
		?>
		
		<script>
		$(document).ready(function(){
			
			$(".obrisi").click(function(){
				
				
				$.ajax({
						type : "GET",
						url : "pokupiDetalje.php?sifra=" + $(this).attr("id"),
						cache : false,
						success : function(data) {

							$("#kontejner").html(data);
							$('#myModal2').foundation('reveal','open');
						}
					});
				
					
				return true;
			});	
			
		});
			
		</script>		
		
		
	</body>
</html>

