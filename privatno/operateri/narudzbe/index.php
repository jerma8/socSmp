<?php
include_once '../../../konfig.php';
if (!isset($_SESSION["operater"])) {
	header("location: ../../../logout.php");
}
?>
<!doctype html>
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
			<div class="large-12 columns">
				<div class="panel">
							
					<div class="row">
						<div class="large-6 columns">
							<div class="row">
								<div class="large-6 columns">
									<h2 class="h25Font">Narudžbe</h2>
								</div>
								
							</div>
						</div>
							<div class="large-6 columns">									
									<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
										<div class="row collapse">
											<div class="large-9 remForma columns">
												<input type="text" name="uvjet" value="<?php echo isset($_POST["uvjet"]) ? $_POST["uvjet"] : ""; ?>" />
											</div>
											<div class="large-2 end columns">
												<input class="button remFormaButton" type="submit" value="Traži!" />
											</div>
										</div>
									</form>
							</div>
						</div>
						<?php
						
							$uvjet="";
							if($_POST){
								$uvjet = $_POST['uvjet'];			
							}
							$uvjet = "%".$uvjet."%";
							
							
							$izraz = $veza -> prepare("
							select
							a.sifra as sifraNarudzbe,a.naziv,a.kolicina,a.datumNarudzbe,
							b.sifra,b.ime,b.prezime
							from narudzba a
							inner join korisnik b on b.sifra=a.sifraKorisnika
							where b.ime like :uvjet or b.prezime like :uvjet
							group by b.sifra;
							");
							$izraz ->bindParam(":uvjet",$uvjet);
							$izraz -> execute();
							$korisnici = $izraz -> fetchAll(PDO::FETCH_OBJ);
							
						?>
						
						<div class="panel panelBorder">
							<div class="row">
								<?php
								foreach ($korisnici as $o):
									
								$slika=$putanjaApp . "img/korisnici/def.jpg";
								
								?>
									
								<div class="large-4 end columns">
									<div  class="colorA panel podlogaPanela">
										<div class="row">
											<div class="large-6 columns">
												<img class="slikaKorisnika" alt="" src="<?php echo $slika; ?>" />
											</div>
											<div class="large-6 columns">
												<h5 class="h5Font colorA"><?php echo $o->ime; ?></h5>
												<h5 class="h5Font colorA"><?php echo $o->prezime; ?></h5>
											</div>
											
												<div class="large-12 marginTop05 columns">
													<a class="quote" href="narudzbeKorisnika.php?sifra=<?php echo $o->sifra; ?>">Prikaži narudžbe</a>
												</div>												
											
										</div>
										
									</div>
								</div>
									
								<?php
								endforeach;
								?>
								
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
		
		
	</body>
</html>
