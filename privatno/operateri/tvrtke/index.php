<?php
include_once '../../../konfig.php';
unset($_SESSION['sifraKorisnika']);

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
									<h2 class="h25Font">Tvrtke</h2>
								</div>
								<div class="large-5 end columns">
									<a id="nazad" class="width100 button round" href="dodaj.php">Dodaj<br />tvrtku</a>
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
							select * from tvrtka where naziv like :uvjet
							");
							$izraz ->bindParam(":uvjet",$uvjet);
							$izraz -> execute();
							$tvrtke = $izraz -> fetchAll(PDO::FETCH_OBJ);
							
						
						?>
						
							<div class="panel panelBorder">
								<div class="row">
									<table>
										<th>Naziv</th>
										<th>Adresa</th>
										<th>Ime kontakt osobe</th>
										<th>Prezime kontakt osobe</th>
										<th>Telefon kontakt osobe</th>
										<th class="width1">Donirane namirnice</th>
										<th>Podaci o korisniku</th>
										
								<?php
									foreach ($tvrtke as $o):
										
										
										
									$izraz = $veza -> prepare("
									select ime,prezime from korisnik where sifra=:sifraTvrtke
									");
									$izraz->bindParam(":sifraTvrtke",$o->sifraKorisnika);
									$izraz -> execute();
									$objekt = $izraz -> fetch(PDO::FETCH_OBJ);
									
								?>
								
								<tr>
									<td><?php echo $o->naziv; ?></td>
									<td><?php echo $o->adresa; ?></td>
									<td><?php echo $o->imeKontaktOsobe; ?></td>
									<td><?php echo $o->prezimeKontaktOsobe; ?></td>
									<td><?php echo $o->telKontaktOsobe; ?></td>
									<td><a class="colorA" href="doniraneNamirnice.php?sifra=<?php echo $o->sifra; ?>"><i class="fi-first-aid"></i></a></td>
									<td>
									<!-- podaci o korisniku -->
									<?php
									if($objekt!=null){
										
									?>
										<a class="colorA" href="podaci.php?sifra=<?php echo $o->sifra; ?>">Podaci o tvrtci</a>
									<?php
									
									}else{
									
									?>
										<a class="colorA" href="<?php echo $putanjaApp; ?>privatno/operateri/korisnici/dodaj.php?sifra=<?php echo $o->sifra; ?>">Dodaj u korisnike</a>
									<?php
									}									
									?>
									</td>
									
									<td>
										<a title="Promijeni" class="iconsColor" href="uredi.php?sifra=<?php echo $o->sifra; ?>"><i class="fi-pencil"></i></a>
										<a title="Obriši" class="iconsColor" href="obrisi.php?sifra=<?php echo $o->sifra; ?>"><i class="fi-trash"></i></a>
									</td>
								</tr>
								
								<?php									
								endforeach;
								?>
									</table>
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
