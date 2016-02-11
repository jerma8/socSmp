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
				
	$izraz = $veza -> prepare("
	select
	a.sifra as sifraNarudzbe,a.sifraNamirnice,a.naziv,a.kolicina,a.datumNarudzbe,
	b.sifra,b.ime,b.prezime
	from narudzba a
	inner join korisnik b on b.sifra=a.sifraKorisnika
	where a.sifra=:sifra;
	");
	$izraz->bindParam(":sifra",$sifra);
	$izraz->execute();
	$narudzba = $izraz->fetch(PDO::FETCH_OBJ);
	
	//print_r($narudzba);
	$_SESSION['sifraKorisnika'] = $narudzba->sifra;
	
	$_SESSION['sifraNarudzbe'] = $narudzba->sifraNarudzbe;
	$_SESSION['sifraNamirnice'] = $narudzba->sifraNamirnice;
	
}

if($_POST){
	$da="DA";
	//AKO NAMIRNICA POSTOJI U TABLICI NAMIRNICA - UPDATE TRAŽENO PO sifra=:sifraNamirnice
	if(isset($_SESSION['sifraNamirnice']) && $_SESSION['sifraNamirnice']!=""){
		
		$veza->beginTransaction();
		
		$izraz = $veza->prepare("update namirnica set trazeno=trazeno+:kolicina where sifra=:sifraNamirnice");
		$izraz->bindParam(":kolicina",$_POST['kolicinaHid']);
		$izraz->bindParam(":sifraNamirnice",$_SESSION['sifraNamirnice']);
		$izraz->execute();
		
		//update u narudžbe - set zapremljeno = "DA" where sifra=:sifraNarudzbe
		$izraz = $veza->prepare("update narudzba set zapremljeno=:zapremljeno where sifra=:sifraNarudzbe");
		$izraz->bindParam(":zapremljeno",$da);
		$izraz->bindParam(":sifraNarudzbe",$_SESSION['sifraNarudzbe']);
		$izraz->execute();
		
		unset($_SESSION['sifraNarudzbe']);
		unset($_SESSION['sifraNamirnice']);
		
		$veza->commit();
		
	}else {
		//AKO NAMIRNICA NE POSTOJI U TABLICI NAMIRNICA
		$stanje=0;
		$veza->beginTransaction();
		
		$izraz = $veza->prepare("insert into namirnica(barkod,jedinicaMjere,naziv,kvotaPoDanu,kvotaPoClanu,stanje,trazeno) values
		(:barkod,:jedinicaMjere,:naziv,:kvotaPoDanu,:kvotaPoClanu,:stanje,:trazeno)");
		
		$izraz->bindParam(":barkod",$_POST['barkod']);
		$izraz->bindParam(":jedinicaMjere",$_POST['jedinicaMjere']);
		$izraz->bindParam(":naziv",$_POST['naziv']);
		$izraz->bindParam(":kvotaPoDanu",$_POST['kvotaPoDanu']);
		$izraz->bindParam(":kvotaPoClanu",$_POST['kvotaPoClanu']);
		$izraz->bindParam(":stanje",$stanje);
		$izraz->bindParam(":trazeno",$_POST['kolicinaHidGet']);
		$izraz->execute();
		
		//update u narudžbe - set zapremljeno = "DA" where sifra=:sifraNarudzbe
		$izraz = $veza->prepare("update narudzba set zapremljeno=:zapremljeno where sifra=:sifraNarudzbe");
		$izraz->bindParam(":zapremljeno",$da);
		$izraz->bindParam(":sifraNarudzbe",$_SESSION['sifraNarudzbe']);
		$izraz->execute();
		
		unset($_SESSION['sifraNarudzbe']);
		unset($_SESSION['sifraNamirnice']);
		
		$veza->commit();
		
	}
	header("location:".	$putanjaApp ."privatno/operateri/narudzbe/narudzbeKorisnika.php?sifra=".$_SESSION['sifraKorisnika']);
}


?>

<!doctype html>
<html class="no-js" lang="en">
	<head>
		<?php
		include_once '../../../head.php';
		?>
		<link rel="stylesheet" href="<?php echo $putanjaApp; ?>css/jquery-ui.css" />
		<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.0.min.js"></script>
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
										<h2 class="h25Font">Nadopuna narudžbe</h2>
									</div>
									<div class="large-2 columns">
										<a id="nazad" class="button round right" href="<?php echo $putanjaApp; ?>privatno/operateri/narudzbe/narudzbeKorisnika.php?sifra=<?php echo $sifra; ?>">Nazad</a>
									</div>

							</div>
							
						
							<div class="panel panelBorder">
								<div class="row">
										<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
									<div class="row">
								<?php
								if(empty($_SESSION['sifraNamirnice'])){
								?>
										<div class="large-6 columns">
																			
											<label for="barkod">Barkod:</label>
											<input type="text" id="barkod" name="barkod"/>
											
											
											
											<label for="naziv">Naziv:</label>
											<input type="text" id="naziv" name="naziv" 
											value="<?php echo isset($narudzba->naziv) ? $narudzba->naziv : ""; ?>"/>
											
											
												
											<label for="jedinicaMjere">Jedinica mjere:</label>
											<input type="text" id="jedinicaMjere" name="jedinicaMjere"/>
											
											
											
											
											<label for="kvotaPoDanu">Kvota po danu:</label>
											<input type="text" class="numbersOnly" id="kvotaPoDanu" name="kvotaPoDanu" />
											
											
											
											<label for="kvotaPoClanu">Kvota po članu:</label>
											<input type="text" class="numbersOnly" id="kvotaPoClanu" name="kvotaPoClanu" />
											
											
											
											<label for="kolicina">Količina:</label>
											<input type="text" 
											<?php
											if($_GET){
												echo "disabled=\"disabled\"";
											}
											?> 
											id="kolicina" name="kolicina"		
											value="<?php echo isset($narudzba->kolicina) ? $narudzba->kolicina : ""; ?>"/>
											
											<?php
											if($_GET):
											?>
											<input type="hidden" name="kolicinaHidGet" id="kolicinaHidGet" value="<?php echo $narudzba->kolicina; ?>" />
											<?php
											endif;
											?>							
											<input type="hidden" name="sifra" id="sifra" value="<?php echo $sifra; ?>" />
										
										</div>
									<?php
									
									//AKO NAMIRNICA POSTOJI U TABLICI NAMIRNICA
									}else{
									
									$izraz = $veza -> prepare("select * from namirnica where sifra=:sifra;
									");
									$izraz->bindParam(":sifra",$_SESSION['sifraNamirnice']);
									$izraz->execute();
									$objekt = $izraz->fetch(PDO::FETCH_OBJ);
									
									?>
									
									<div class="large-12 columns">
										<h2 class="h5Font">Namirnica <?php echo isset($narudzba->naziv) ? $narudzba->naziv : ""; ?>:</h2>
									</div>
									
									<div class="large-12 columns">
										<table class="">
										<tr>
											<th>Barkod:</th>
											<th>Naziv:</th>
											<th>Jedinica mjere:</th>
											<th>Kvota po danu:</th>
											<th>Kvota po članu:</th>
											<th>Stanje:</th>
											<th>Traženo:</th>
										</tr>
										
										<tr>
											<td><?php echo $objekt -> barkod; ?></td>
											<td><?php echo $objekt -> naziv; ?></td>
											<td><?php echo $objekt -> jedinicaMjere; ?></td>
											<td><?php echo $objekt -> kvotaPoDanu; ?></td>
											<td><?php echo $objekt -> kvotaPoClanu; ?></td>
											<td><?php echo $objekt -> stanje; ?></td>
											<td><?php echo $objekt -> trazeno; ?></td>
										</tr>
									</table>
									</div>
									<div class="large-4 columns">
										<table>
											<tr>
												<th>Traženo od korisnika:</th>
											</tr>
											<tr>
												<td>
													<?php echo $narudzba->kolicina; ?>
												</td>
											</tr>
										</table>
									</div>
									
									
									<input type="hidden" name="kolicinaHid" id="kolicinaHid"
									value="<?php echo isset($narudzba->kolicina) ? $narudzba->kolicina : ""; ?>"/>
									<?php
									}
									?>		
									</div>
									<div class="large-6">
								</div>
									<input id="dodaj" class="button round" type="submit" value="Dodaj traženo!" />
								
							</form>
															
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
		include_once 'jQueryNarudzbe.php';
		?>
		<script>			
			$(function() {
				
				 $("#jedinicaMjere").autocomplete({
				 	//trazi jedinicu mjere i sifru za spremanje
				    source: "traziJedinicuMjere.php",
				    minLength: 1,
				    focus: function( event, ui ) {
				    	event.preventDefault();
				    	},
				    select: function(event, ui) {
				       // alert(ui.item.jedinicaMjere);
				       
				        $("#jedinicaMjere").val(ui.item.jedinicaMjere);
				        
				        //uvijek probati
				        return false;
				    }
					}).data( "ui-autocomplete" )._renderItem = function( ul, namirnica ) {
						return $( "<li>" )
				        .append( "<a>" + namirnica.jedinicaMjere + "</a>" )
				        .appendTo( ul );						
				      
				    };
				    
				});
			
		</script>
		
	
	</body>
</html>

