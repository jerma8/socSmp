<?php
include_once '../../../konfig.php';
if (!isset($_SESSION['operater'])) {
	header("location: ../../../logout.php");
}

$sifra="";

if (isset($_GET['sifra'])) {
	$sifra = $_GET['sifra'];
}

if ($_GET) {
	$izraz = $veza -> prepare("select * from tvrtka where sifra=:sifra");
	$izraz -> bindParam(":sifra", $sifra);

	$izraz -> execute();
	$objekt = $izraz -> fetch(PDO::FETCH_OBJ);
	
	
	$sifraKorisnika = $objekt -> sifraKorisnika;
	
	
	$izraz = $veza -> prepare("select * from korisnik where sifra=:sifra");
	$izraz -> bindParam(":sifra", $sifraKorisnika);

	$izraz -> execute();
	$objektKorisnik = $izraz -> fetch(PDO::FETCH_OBJ);
	
	$_SESSION['sifraKorisnika']=$sifraKorisnika;
}



if ($_POST) {
	//update u korisnik
	
	$korisnickoIme="";
	
	
	if($_POST['korisnik']==""){
		$korisnickoIme=$_POST['hidKorisnik'];
	}else{
		$korisnickoIme=$_POST['korisnik'];
	}
	

	$izraz = $veza->prepare("
	update korisnik set korisnik=:korisnik where sifra=:sifra");
	
	
	//update bez nove lozinke
	$izraz->bindParam(":korisnik",$korisnickoIme);
	$izraz->bindParam(":sifra",$_SESSION['sifraKorisnika']);
	
	$izraz->execute();
	
	if(isset($_POST['novalozinka'])){
		$izraz = $veza->prepare("
		update korisnik set lozinka=:lozinka
		where sifra=:sifra");
		
		//update nove lozinke
		$izraz->bindParam(":lozinka",md5($_POST['lozinka']));
		$izraz->bindParam(":sifra",$_SESSION['sifraKorisnika']);
		$izraz->execute();
	}
	
	header("location: index.php");
}

?>

<!doctype html>
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
				<!-- FONT BODY I H1 H2 H3 -->

			</div>
		</div>
		
	<div class="row">
			<div class="large-12 columns">
				<div class="panel">
							
							<div class="row">
									<div class="large-8 columns">
										<h2 class="h25Font">Promjena korisničkih podataka</h2>
									</div>
									<div class="large-2 columns">
										<a id="nazad" class="button round right" href="<?php echo $putanjaApp; ?>privatno/operateri/tvrtke/index.php">Nazad</a>
									</div>

							</div>
							
						
							<div class="panel panelBorder">
								<div class="row">
								
	
									<table>
										<tr>
											<th>Naziv:</th>
											<th>Adresa:</th>
											<th>Mjesto:</th>
											<th>Ime kontakt osobe:</th>
											<th>Prezime kontakt osobe:</th>
											<th>Telefon kontakt osobe:</th>
											<th>Email:</th>
										</tr>
										
										<tr>
											<td><?php echo $objekt -> naziv; ?></td>
											<td><?php echo $objekt -> adresa; ?></td>
											<td><?php echo $objekt -> mjesto; ?></td>
											<td><?php echo $objekt -> imeKontaktOsobe; ?></td>
											<td><?php echo $objekt -> prezimeKontaktOsobe; ?></td>
											<td><?php echo $objekt -> telKontaktOsobe; ?></td>
											<td><?php echo $objekt -> email; ?></td>
										</tr>
									</table>
		<hr class="hrLinija" />
		<br />
								
								
								<!-- FORMA ZA INSERT KORISNIK -->
							<div class="large-12 columns">
								<div class="large-6 ">
									<table class="spacing05">
																				
										<tr>
											<th>Korisničko ime:</th>
											<td><?php echo $objektKorisnik -> korisnik; ?></td>
										</tr>
										
									</table>
								</div>
								
								<div class="large-6 columns">
								<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
											
											<div class="row">
												<div class="large-4 marginLeftTop columns">
													<label for="korisnik">Korisničko&nbsp;ime:</label>
												</div>
												<div class="large-8 height295 columns">
													<input type="text" id="korisnik" name="korisnik" />
												</div>
											</div>
											<input type="hidden" name="hidKorisnik" value="<?php echo $objektKorisnik -> korisnik; ?>" />
											
											
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
											
											<br />
											<input id="promijeni" type="submit" class="width100 button round right" value="Promijeni" />
										</form>
										
										</div>
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
		
		<script>
		$(document).ready(function(){
				$(".prikazi").hide();
				
				$(window).keypress(function() {
					$('#lozinka').tooltipster('hide');
					$('#lozinka2').tooltipster('hide');
				});
				
				$('#lozinka').tooltipster({
					position : 'right',
					offsetX : '0px',
					offsetY : '95px',
					effect: "fade",
					trigger : 'custom'

				});

				$('#lozinka2').tooltipster({
					position : 'right',
					offsetX : '0px',
					offsetY : '95px',
					effect: "fade",
					trigger : 'custom'

				});
				
				$('#novalozinka').click(function () {
					$(".prikazi").toggle(this.checked);
					
							$("#promijeni").click(function(){
								
								if($('#novalozinka').is(':checked')){
							
								var lozinka = $('#lozinka').val();
		
									if (lozinka.length == 0) {
				
										$('#lozinka').tooltipster('content', 'Obavezno lozinka!');
										$('#lozinka').tooltipster('show');
										$("#lozinka").focus().select();
										return false;
									}
								
								
									var lozinka2 = $('#lozinka2').val();
				
									if (lozinka2.length == 0) {
				
										$('#lozinka2').tooltipster('content', 'Obavezno lozinka ponovo!');
										$('#lozinka2').tooltipster('show');
										$("#lozinka2").focus().select();
										return false;
									}
									
									if(lozinka!=lozinka2){
										$('#lozinka2').tooltipster('content', 'Nije identično kao lozinka!');
										$('#lozinka2').tooltipster('show');
										$("#lozinka2").focus().select();
										return false;
									}
									
									
								}else{
									$('#lozinka').tooltipster('hide');
									$('#lozinka2').tooltipster('hide');
								}
				
								
							});
					
				
				});
				
		});	
		</script> 
		
		
		
	</body>
</html>

