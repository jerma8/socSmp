<?php
include_once '../../../konfig.php';
if (!isset($_SESSION['operater'])) {
	header("location: ../../../logout.php");
}
$sifra = "";
if (isset($_GET['sifra'])) {
	$sifra = $_GET['sifra'];
} else if (isset($_POST['sifra'])) {
	$sifra = $_POST['sifra'];
}

if ($_GET) {
	$izraz = $veza -> prepare("select * from tvrtka where sifra=:sifra");
	$izraz -> bindParam(":sifra", $sifra);

	$izraz -> execute();
	$objekt = $izraz -> fetch(PDO::FETCH_OBJ);
	
	if(isset($objek->sifraKorisnika))
		$_SESSION['sifraKorisnika'] = $objek->sifraKorisnika;
}

if($_POST){
	
	$izraz = $veza->prepare("update tvrtka set 
	naziv=:naziv,
	adresa=:adresa,
	mjesto=:mjesto,
	imeKontaktOsobe=:imeKontaktOsobe,
	prezimeKontaktOsobe=:prezimeKontaktOsobe,
	telKontaktOsobe=:telKontaktOsobe,
	email=:email
	where sifra=:sifra");
	
	///AKO NE ZELIMO UREDITI NPR:  KORISNIK I LOZINKA
	$izraz->bindParam(":naziv",$_POST['naziv']);
	$izraz->bindParam(":adresa",$_POST['adresa']);
	$izraz->bindParam(":mjesto",$_POST['mjesto']);
	$izraz->bindParam(":imeKontaktOsobe",$_POST['imeKontaktOsobe']);
	$izraz->bindParam(":prezimeKontaktOsobe",$_POST['prezimeKontaktOsobe']);
	$izraz->bindParam(":telKontaktOsobe",$_POST['telKontaktOsobe']);
	$izraz->bindParam(":email",$_POST['email']);
	
	$izraz->bindParam(":sifra",$sifra);
		
	$izraz->execute();
	
	
	$izraz = $veza->prepare("update korisnik set 
	adresa=:adresa,
	mjesto=:mjesto,
	imeKontaktOsobe=:imeKontaktOsobe,
	prezimeKontaktOsobe=:prezimeKontaktOsobe
	where sifra=:sifraKorisnika");
	
	
	$izraz->bindParam(":adresa",$_POST['adresa']);
	$izraz->bindParam(":mjesto",$_POST['mjesto']);
	$izraz->bindParam(":imeKontaktOsobe",$_POST['imeKontaktOsobe']);
	$izraz->bindParam(":prezimeKontaktOsobe",$_POST['prezimeKontaktOsobe']);
	$izraz->bindParam(":sifraKorisnika",$_SESSION['sifraKorisnika']);
	
	$izraz->execute();
	
	unset($_SESSION['sifraKorisnika']);

	header("location: index.php");
}
?><!doctype html>
<html class="no-js" lang="en">
	<head>
		<?php
		include_once '../../../head.php';
		?>
		<link rel="stylesheet" href="<?php echo $putanjaApp; ?>tooltipster/css/tooltipster.css"/>
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
			</div>
		</div>
		
	<div class="row">
			<div class="large-12 columns">
				<div class="panel">
							
							<div class="row">
									<div class="large-6 columns">
										<h2 class="h25Font">Promjena podataka</h2>
									</div>
									<div class="large-2 columns">
										<a id="nazad" class="button round right" href="<?php echo $putanjaApp; ?>privatno/operateri/tvrtke/index.php">Nazad</a>
									</div>

							</div>
							
						
							<div class="panel panelBorder">
								<div class="row">
									
									<div class="large-7 columns">
										<table class="spacing05">
										<tr>
											<th>Naziv:</th>
											<td><?php echo $objekt -> naziv; ?></td>
										</tr>
										
										<tr>
											<th>Adresa:</th>
											<td><?php echo $objekt -> adresa; ?></td>
										</tr>
										
										<tr>
											<th>Mjesto:</th>
											<td><?php echo $objekt -> mjesto; ?></td>
										</tr>
										
										<tr>
											<th>Ime kontakt osobe:</th>
											<td><?php echo $objekt -> imeKontaktOsobe; ?></td>
										</tr>
										
										<tr>
											<th>Prezime kontakt osobe:</th>
											<td><?php echo $objekt -> prezimeKontaktOsobe; ?></td>
										</tr>
										
										<tr>
											<th>Telefon kontakt osobe:</th>
											<td><?php echo $objekt -> telKontaktOsobe; ?></td>
										</tr>
										
										<tr>
											<th>Email:</th>
											<td><?php echo $objekt -> email; ?></td>
										</tr>
										
									</table>
									</div>
									
									<div class="large-5 marginTop05 columns">
										<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
											
											<div class="row">
												<div class="large-2 marginLeftTop columns">
													<label for="naziv">=></label>
												</div>
												<div class="large-10 height28 columns">
													<input type="text" id="naziv" name="naziv"/>
												</div>
											</div>
											<input type="hidden" name="hidNaziv" value="<?php echo $objekt -> naziv; ?>" />
											
											
											<div class="row">
												<div class="large-2 marginLeftTop columns">
													<label for="adresa">=></label>
												</div>
												<div class="large-10 height28 columns">
													<input type="text" id="adresa" name="adresa" />
												</div>
											</div>
											<input type="hidden" name="hidAdresa" value="<?php echo $objekt -> adresa; ?>" />
											
											
											<div class="row">
												<div class="large-2 marginLeftTop columns">
													<label for="mjesto">=></label>
												</div>
												<div class="large-10 height28 columns">
													<input type="text" id="mjesto" name="mjesto" />
												</div>
											</div>
											<input type="hidden" name="hidMjesto" value="<?php echo $objekt -> mjesto; ?>" />
											
											
											<div class="row">
												<div class="large-2 marginLeftTop columns">
													<label for="imeKontaktOsobe">=></label>
												</div>
												<div class="large-10 height28 columns">
													<input type="text" id="imeKontaktOsobe" name="imeKontaktOsobe"/>
												</div>
											</div>
											<input type="hidden" name="hidImeKontaktOsobe" value="<?php echo $objekt -> imeKontaktOsobe; ?>" />
											
											
											<div class="row">
												<div class="large-2 marginLeftTop columns">
													<label for="prezimeKontaktOsobe">=></label>
												</div>
												<div class="large-10 height28 columns">
													<input type="text" id="prezimeKontaktOsobe" name="prezimeKontaktOsobe"/>
												</div>
											</div>
											<input type="hidden" name="hidPrezimeKontaktOsobe" value="<?php echo $objekt -> prezimeKontaktOsobe; ?>" />
											
											
											<div class="row">
												<div class="large-2 marginLeftTop columns">
													<label for="telKontaktOsobe">=></label>
												</div>
												<div class="large-10 height28 columns">
													<input type="text" class="numbersOnly" id="telKontaktOsobe" name="telKontaktOsobe"/>
												</div>
											</div>
											<input type="hidden" name="hidTelKontaktOsobe" value="<?php echo $objekt -> telKontaktOsobe; ?>" />
																		
											
											<div class="row">
												<div class="large-2 marginLeftTop columns">
													<label for="email">=></label>
												</div>
												<div class="large-10 height28 columns">
													<input type="text" id="email" name="email" />
												</div>
											</div>
											<input type="hidden" name="hidEmail" value="<?php echo $objekt -> email; ?>" />
											
											
											
											
											<input type="hidden" name="sifra" value="<?php echo $sifra; ?>" />
											<br />
											<input id="promijeni" type="submit" class="width100 button round right" value="Promijeni" />
										</form>
									</div>
																
								</div>
							</div>
							
							
						</div>
					</div>
				</div>

		
		<div class="potpis">
			<label class="right">&copy; Damir Majer 07.03.2015.</label>
		</div>
		
		
		<?php
		include_once '../../../skripte.php';
		?>
		<script src="<?php echo $putanjaApp; ?>tooltipster/js/jquery.tooltipster.min.js"></script>
		<?php
		include_once 'jQueryTvrtkePromijeni.php';
		?>
		<script>
			
			$(document).ready(function(){
				
				
								
				
			});			
			
			
		</script>
		
	</body>
</html>

