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
									<h2 class="h25Font">Donatori</h2>
								</div>
								<div class="large-5 end columns">
									<a id="nazad" class="width100 button round" href="<?php echo $putanjaApp; ?>privatno/operateri/korisnici/dodaj.php?d1=d1">Dodaj<br />donatora</a>
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
							select * from korisnik where concat(ime, ' ',prezime) like :uvjet and uloga='donator'
							");
							$izraz ->bindParam(":uvjet",$uvjet);
							$izraz -> execute();
							$tvrtke = $izraz -> fetchAll(PDO::FETCH_OBJ);
							
						
						?>
						
							<div class="panel panelBorder">
								<div class="row">
									<table>
										<th>OIB</th>
										<th>Ime</th>
										<th>Prezime</th>
										<th>Adresa</th>
										<th>Mjesto</th>
										<th class="width1">Donirane namirnice</th>
										
								<?php
									foreach ($tvrtke as $o):
								?>
								
								<tr>
									<td><?php echo $o->oib; ?></td>
									<td><?php echo $o->ime; ?></td>
									<td><?php echo $o->prezime; ?></td>
									<td><?php echo $o->adresa; ?></td>
									<td><?php echo $o->mjesto; ?></td>
									<td><a class="colorA" href="doniraneNamirnice.php?sifra=<?php echo $o->sifra; ?>"><i class="fi-first-aid"></i></a></td>
									
									
									<td>
										<a title="Promijeni" class="iconsColor" href="<?php echo $putanjaApp; ?>privatno/operateri/korisnici/uredi.php?sifra=<?php echo $o->sifra; ?>"><i class="fi-pencil"></i></a>&nbsp;&nbsp;&nbsp;
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
