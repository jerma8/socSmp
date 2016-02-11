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
	$izraz = $veza -> prepare("select * from korisnik where sifra=:sifra");
	$izraz -> bindParam(":sifra", $sifra);

	$izraz -> execute();
	$objekt = $izraz -> fetch(PDO::FETCH_OBJ);
}

if($_POST){

	$datumRodenja=$_POST['datumRodenja'];
		
	$d = $_POST["datumRodenja"];
	$d=substr($d, 6,4) . "-" . substr($d, 3,2) . "-" . substr($d, 0,2);
	$datumRodenja=$d;

	
	$izraz = $veza->prepare("update korisnik set 
	ime=:ime,
	prezime=:prezime,
	oib=:oib,
	datumRodenja=:datumRodenja,
	adresa=:adresa,
	mjesto=:mjesto,
	brojClanovaObitelji=:brojClanovaObitelji,
	korisnik=:korisnik
	where sifra=:sifra");
	
	///AKO NE ZELIMO UREDITI NPR:  KORISNIK I LOZINKA
	$izraz->bindParam(":ime",$_POST['ime']);
	$izraz->bindParam(":prezime",$_POST['prezime']);
	$izraz->bindParam(":oib",$_POST['oib']);
	$izraz->bindParam(":datumRodenja",$datumRodenja);
	$izraz->bindParam(":adresa",$_POST['adresa']);
	$izraz->bindParam(":mjesto",$_POST['mjesto']);
	$izraz->bindParam(":brojClanovaObitelji",$_POST['brojClanovaObitelji']);
	$izraz->bindParam(":korisnik",$_POST['korisnik']);
	$izraz->bindParam(":sifra",$sifra);
		
	$izraz->execute();
	
	
	$izraz = $veza->prepare("update tvrtka set 
	imeKontaktOsobe=:ime,
	prezimeKontaktOsobe=:prezime,
	adresa=:adresa,
	mjesto=:mjesto
	where sifraKorisnika=:sifra");
	
	///AKO NE ZELIMO UREDITI NPR:  KORISNIK I LOZINKA
	$izraz->bindParam(":ime",$ime);
	$izraz->bindParam(":prezime",$prezime);
	$izraz->bindParam(":adresa",$adresa);
	$izraz->bindParam(":mjesto",$mjesto);
	$izraz->bindParam(":sifra",$sifra);
		
	$izraz->execute();
	
	
	header("location: index.php");
}
?><!doctype html>
<html class="no-js" lang="en">
	<head>
		<?php
		include_once '../../../head.php';
		?>
		<link rel="stylesheet" href="<?php echo $putanjaApp; ?>css/jquery-ui.css" />
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
										<a id="nazad" class="button round right" href="<?php echo $putanjaApp; ?>privatno/operateri/korisnici/index.php">Nazad</a>
									</div>

							</div>
							
						
							<div class="panel panelBorder">
								<div class="row">
									
									<div class="large-6 columns">
										<table class="spacing05">
										<tr>
											<th>Korisničko ime:</th>
											<td><?php echo $objekt -> korisnik; ?></td>
										</tr>
										<tr>
											<th>Ime:</th>
											<td><?php echo $objekt -> ime; ?></td>
										</tr>
										
										<tr>
											<th>Prezime:</th>
											<td><?php echo $objekt -> prezime; ?></td>
										</tr>
										
										<tr>
											<th>OIB:</th>
											<td><?php echo $objekt -> oib; ?></td>
										</tr>
										
										<tr>
											<th>Datum rođenja:</th>
											<td>
											<?php
											if($objekt->datumRodenja!=""){
												$d = $objekt->datumRodenja;
												$d=substr($d, 8,2) . "." . substr($d, 5,2) . "." . substr($d, 0,4) . ".";
												$objekt->datumRodenja=$d;
												echo $objekt->datumRodenja;
											}else {
												echo $objekt->datumRodenja;
											}
											?></td>
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
											<th>Broj članova obitelji:</th>
											<td><?php echo $objekt -> brojClanovaObitelji; ?></td>
										</tr>
									</table>
									</div>
									
									<div class="large-6 marginTop05 columns">
										<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
											
											<div class="row">
												<div class="large-2 marginLeftTop columns">
													<label for="korisnik">=></label>
												</div>
												<div class="large-10 height28 columns">
													<input type="text" autocomplete="off" id="korisnik" name="korisnik" />
												</div>
											</div>
											<input type="hidden" name="hidKorisnik" value="<?php echo $objekt -> korisnik; ?>" />
											
											
											
											<div class="row">
												<div class="large-2 marginLeftTop columns">
													<label for="ime">=></label>
												</div>
												<div class="large-10 height28 columns">
													<input type="text" id="ime" name="ime"/>
												</div>
											</div>
											<input type="hidden" name="hidIme" value="<?php echo $objekt -> ime; ?>" />
											
											
											<div class="row">
												<div class="large-2 marginLeftTop columns">
													<label for="prezime">=></label>
												</div>
												<div class="large-10 height28 columns">
													<input type="text" id="prezime" name="prezime" />
												</div>
											</div>
											<input type="hidden" name="hidPrezime" value="<?php echo $objekt -> prezime; ?>" />
											
											
											<div class="row">
												<div class="large-2 marginLeftTop columns">
													<label for="oib">=></label>
												</div>
												<div class="large-10 height28 columns">
													<input type="text" maxlength="11" class="numbersOnly" id="oib" name="oib"/>
												</div>
											</div>
											<input type="hidden" name="hidOib" value="<?php echo $objekt -> oib; ?>" />
											
											
											<div class="row">
												<div class="large-2 marginLeftTop columns">
													<label for="datumRodenja">=></label>
												</div>
												<div class="large-10 height28 columns">
													<input type="text" id="datumRodenja" name="datumRodenja"/>
												</div>
											</div>
											<input type="hidden" name="hidDatumRodenja" value="<?php echo $objekt -> datumRodenja; ?>" />
											
											
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
													<label for="brojClanovaObitelji">=></label>
												</div>
												<div class="large-10 height28 columns">
													<input type="text" autocomplete="off" class="numbersOnly19" id="brojClanovaObitelji" name="brojClanovaObitelji" />
												</div>
											</div>
											<input type="hidden" name="hidBrojClanovaObitelji" value="<?php echo $objekt -> brojClanovaObitelji; ?>" />
											
											<div class="row">
												<hr class="hrLinija"/>
												<div class="large-10 marginTop  columns">
													<label for="novalozinka">Nova&nbsp;lozinka:</label>
												</div>
												<div class="large-2 height295 end columns">
													<input type="checkbox" id="novalozinka" name="novalozinka"/>
												</div>
											</div>
											
											
											<div id="marginLeftRight" class="row prikazi">
												<div class="row">
													<div class="large-2 columns">
														<label for="lozinka">Lozinka:</label>
													</div>
													<div class="large-10 height295 columns">
														<input type="password" id="lozinka" name="lozinka" />
													</div>
												</div>
												
												<div class="row">
													<div class="large-2 columns">
														<label for="lozinka2">Lozinka ponovo:</label>
													</div>
													<div class="large-10 height295 columns">
														<input type="password" id="lozinka2" name="lozinka2" />
													</div>
												</div>
											</div>
											
											
											
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
		<script src="<?php echo $putanjaApp; ?>js/vendor/jquery-ui.js"></script>
		<?php
		include_once 'jQueryKorisniciUredi.php';
		?>
		
		
	</body>
</html>

