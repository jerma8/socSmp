<?php
include_once '../../../konfig.php';
unset($_SESSION['sifraTvrtke']);
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
								<div class="large-12 columns">
									<h2 class="h25Font">Namjenjene donacije</h2>
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
						
						//isto kao narudžba treba nova tablica +
						
							$uvjet="";
							if($_POST){
								$uvjet = $_POST['uvjet'];			
							}
							$uvjet = "%".$uvjet."%";
							
							
							$izraz = $veza -> prepare("
							select
							a.sifra,a.naziv as nazivTvrtke,a.imeKontaktOsobe,a.telKontaktOsobe,
							a.email, b.naziv as nazivNamirnice, b.kolicina, b.rokTrajanja
							from tvrtka a
							inner join pripremaDonacije b on a.sifra=b.sifraTvrtke
							where a.naziv like :uvjet
							group by a.sifra
							");
							$izraz ->bindParam(":uvjet",$uvjet);
							$izraz -> execute();
							$tvrtke = $izraz -> fetchAll(PDO::FETCH_OBJ);
							/*
							if($tvrtke==null){
								header("location:".$putanjaApp."privatno/operateri/index.php");
							}
							 * 
							 */
						
						
						?>
						<!--
						<pre>
						<?php print_r($naziviKorisnika); ?>	
						</pre>
						-->
						
						<div class="panel panelBorder">
							<div class="row">
								<?php
								foreach ($tvrtke as $o):
								
								?>
									
								<div class="large-4 end columns">
									<div  class="panel podlogaPanela">
										<div class="row">
											
											<div class="large-12 columns">
												<h5 class="h4Font colorA"><?php echo $o->nazivTvrtke; ?></h5>
												<hr />
												<h5 class="h5Font1r"><b>Ime kontakt osobe: </b><?php echo $o->imeKontaktOsobe; ?></h5>
												<h5 class="h5Font1r"><b>Telefon kontakt osobe: </b><?php echo $o->telKontaktOsobe; ?></h5>
												<h5 class="h5Font1r"><b>Email: <br/></b><?php echo $o->email; ?></h5>
											</div>
											
											<hr />
												<div class="large-12 marginTop05 columns">
													<a class="quote" href="pripremaDonacijeTvrtke.php?sifra=<?php echo $o->sifra; ?>">Prikaži namjenjene donacije</a>
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
