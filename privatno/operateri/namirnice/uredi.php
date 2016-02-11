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
	$izraz = $veza -> prepare("select * from namirnica where sifra=:sifra");
	$izraz -> bindParam(":sifra", $sifra);

	$izraz -> execute();
	$objekt = $izraz -> fetch(PDO::FETCH_OBJ);
}

if($_POST){
	
	$izraz = $veza->prepare("update namirnica set 
	barkod=:barkod,
	naziv=:naziv,
	jedinicaMjere=:jedinicaMjere,
	kvotaPoDanu=:kvotaPoDanu,
	kvotaPoClanu=:kvotaPoClanu,
	stanje=:stanje,
	trazeno=:trazeno
	where sifra=:sifra");
	
	
	$izraz->bindParam(":barkod",$_POST['barkod']);
	$izraz->bindParam(":naziv",$_POST['naziv']);
	$izraz->bindParam(":jedinicaMjere",$_POST['jedinicaMjere']);
	$izraz->bindParam(":kvotaPoDanu",$_POST['kvotaPoDanu']);
	$izraz->bindParam(":kvotaPoClanu",$_POST['kvotaPoClanu']);
	$izraz->bindParam(":stanje",$_POST['stanje']);
	$izraz->bindParam(":trazeno",$_POST['trazeno']);
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
										<a id="nazad" class="button round right" href="<?php echo $putanjaApp; ?>privatno/operateri/namirnice/index.php">Nazad</a>
									</div>

							</div>
							
						
							<div class="panel panelBorder">
								<div class="row">
									
									<div class="large-6 columns">
										<table class="spacing05">
										<tr>
											<th>Barkod:</th>
											<td><?php echo $objekt -> barkod; ?></td>
										</tr>
										
										<tr>
											<th>Naziv:</th>
											<td><?php echo $objekt -> naziv; ?></td>
										</tr>
										
										<tr>
											<th>Jedinica mjere:</th>
											<td><?php echo $objekt -> jedinicaMjere; ?></td>
										</tr>
										
										<tr>
											<th>Kvota po danu:</th>
											<td><?php echo $objekt -> kvotaPoDanu; ?></td>
										</tr>
										
										<tr>
											<th>Kvota po članu:</th>
											<td><?php echo $objekt -> kvotaPoClanu; ?></td>
										</tr>
										
										<tr>
											<th>Stanje:</th>
											<td><?php echo $objekt -> stanje; ?></td>
										</tr>
										
										<tr>
											<th>Traženo:</th>
											<td><?php echo $objekt -> trazeno; ?></td>
										</tr>
									</table>
									</div>
									
									<div class="large-6 marginTop05 columns">
										<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
											
											<div class="row">
												<div class="large-2 marginLeftTop columns">
													<label for="barkod">=></label>
												</div>
												<div class="large-10 height28 columns">
													<input type="text" class="numbersOnly" id="barkod" name="barkod"/>
												</div>
											</div>
											<input type="hidden" name="hidBarkod" value="<?php echo $objekt -> barkod; ?>" />
											
											
											<div class="row">
												<div class="large-2 marginLeftTop columns">
													<label for="naziv">=></label>
												</div>
												<div class="large-10 height28 columns">
													<input type="text" id="naziv" name="naziv" />
												</div>
											</div>
											<input type="hidden" name="hidNaziv" value="<?php echo $objekt -> naziv; ?>" />
											
											
											<div class="row">
												<div class="large-2 marginLeftTop columns">
													<label for="jedinicaMjere">=></label>
												</div>
												<div class="large-10 height28 columns">
													<input type="text" id="jedinicaMjere" name="jedinicaMjere"/>
												</div>
											</div>
											<input type="hidden" name="hidJedinicaMjere" value="<?php echo $objekt -> jedinicaMjere; ?>" />
											
											
											<div class="row">
												<div class="large-2 marginLeftTop columns">
													<label for="kvotaPoDanu">=></label>
												</div>
												<div class="large-10 height28 columns">
													<input type="text" class="numbersOnly" id="kvotaPoDanu" name="kvotaPoDanu"/>
												</div>
											</div>
											<input type="hidden" name="hidKvotaPoDanu" value="<?php echo $objekt -> kvotaPoDanu; ?>" />
											
											
											<div class="row">
												<div class="large-2 marginLeftTop columns">
													<label for="kvotaPoClanu">=></label>
												</div>
												<div class="large-10 height28 columns">
													<input type="text" class="numbersOnly" id="kvotaPoClanu" name="kvotaPoClanu" />
												</div>
											</div>
											<input type="hidden" name="hidKvotaPoClanu" value="<?php echo $objekt -> kvotaPoClanu; ?>" />
											
											
											
											<div class="row">
												<div class="large-2 marginLeftTop columns">
													<label for="stanje">=></label>
												</div>
												<div class="large-10 height28 columns">
													<input type="text" class="numbersOnly" id="stanje" name="stanje" />
												</div>
											</div>
											<input type="hidden" name="hidStanje" value="<?php echo $objekt -> stanje; ?>" />
											
											
											<div class="row">
												<div class="large-2 marginLeftTop columns">
													<label for="trazeno">=></label>
												</div>
												<div class="large-10 height28 columns">
													<input type="text" class="numbersOnly" id="trazeno" name="trazeno" />
												</div>
											</div>
											<input type="hidden" name="hidTrazeno" value="<?php echo $objekt -> trazeno; ?>" />
											
											
											
											
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
		include_once 'jQueryNamirniceUredi.php';
		?>
	</body>
</html>

