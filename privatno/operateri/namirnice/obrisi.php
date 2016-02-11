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

if ($_POST) {
	
	$izraz = $veza -> prepare("select * from donira where sifraNamirnice=:sifra");
	$izraz -> bindParam(":sifra", $sifra);

	$izraz -> execute();
	$objekt = $izraz -> fetch(PDO::FETCH_OBJ);
	
	if($objekt->sifraTvrtke==null && $objekt->sifraKorisnika==null){
		
		$veza->beginTransaction();
	
		$izraz = $veza -> prepare("delete from donira where sifraNamirnice=:sifra");
		$izraz -> bindParam(":sifra", $sifra);
		$izraz -> execute();
		
		
		$izraz = $veza -> prepare("delete from namirnica where sifra=:sifra");
		$izraz -> bindParam(":sifra", $sifra);
		$izraz -> execute();
	
		$veza->commit();
		
		
	}else {
		$izraz = $veza -> prepare("delete from namirnica where sifra=:sifra");
		$izraz -> bindParam(":sifra", $sifra);
		$izraz -> execute();
	}
	
	header("location: index.php");
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
			<div class="large-12 columns">
				<div class="panel">
							
							<div class="row">
									<div class="large-6 columns">
										<h2 class="h25Font">Brisanje Namirnice</h2>
									</div>
									<div class="large-2 columns">
										<a id="nazad" class="button round right" href="<?php echo $putanjaApp; ?>privatno/operateri/namirnice/index.php">Nazad</a>
									</div>

							</div>
							
						
							<div class="panel panelBorder">
								<div class="row">
									<div class="large-6 columns">
								
										
										<table>
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
									
									<div class="large-6 columns">
										
									<?php
									$izraz = $veza -> prepare("
									select distinct(a.ime),a.prezime,a.oib
									from korisnik a
									inner join uzima b on a.sifra=b.sifraKorisnika
									inner join namirnica c on b.sifraNamirnice=c.sifra
									where c.sifra=:sifra;
									");
									$izraz -> bindParam(":sifra", $sifra);
									
									$izraz -> execute();
									$uzeliKorisnici = $izraz -> fetchAll(PDO::FETCH_OBJ);
										
										
										
									if($uzeliKorisnici!=null):
									?>	
										<b>Korisnici koji su uzeli namirnicu:</b>
																			
										<div class="row">
											<div class="large-12 columns">
												
											<table>
												<tr>
													<th>OIB</th>
													<th>Ime</th>
													<th>Prezime</th>
												</tr>
												
												
												<?php
												foreach ($uzeliKorisnici as $k):
												?>
												<tr>
													<td><?php echo $k->oib; ?></td>
													<td><?php echo $k->ime; ?></td>
													<td><?php echo $k->prezime; ?></td>
												</tr>
												<?php
												endforeach;
												?>
												
											</table>
												
											</div>
										</div>
										<?php
										endif;
										?>
										
									</div>
								
								
								</div>
								
								<?php
								$izraz = $veza -> prepare("
								select
								distinct(a.naziv),a.imeKontaktOsobe,a.prezimeKontaktOsobe,a.telKontaktOsobe
								from tvrtka a
								inner join donira b on a.sifra=b.sifraTvrtke
								inner join namirnica c on b.sifraNamirnice=c.sifra
								where c.sifra=:sifra
								");
								$izraz -> bindParam(":sifra", $sifra);
									
								$izraz -> execute();
								$donatoriTvrtke = $izraz -> fetchAll(PDO::FETCH_OBJ);
								?>
								
								<div class="row">
									
									<?php
									if($donatoriTvrtke!=null):
									?>
									
									<div class="large-6 columns">
										<b>Donatori tvrtke:</b>
										
										<div class="row">
											<div class="large-12 columns">
												
											<table>
												<tr>
													<th>Naziv</th>
													<th>Ime kontakt osobe</th>
													<th>Prezime kontakt osobe</th>
													<th>Telefon kontakt osobe</th>
												</tr>
												
												
												<?php
												foreach ($donatoriTvrtke as $k):
												?>
												<tr>
													<td><?php echo $k->naziv; ?></td>
													<td><?php echo $k->imeKontaktOsobe; ?></td>
													<td><?php echo $k->prezimeKontaktOsobe; ?></td>
													<td><?php echo $k->telKontaktOsobe; ?></td>
												</tr>
												<?php
												endforeach;
												?>
												
											</table>
												
											</div>
										</div>
										
									</div>
									
									<?php
									endif;
									?>

									
									
									
									<?php
									$izraz = $veza -> prepare("
									select
									distinct(a.ime),a.prezime,a.oib
									from korisnik a
									inner join donira b on a.sifra=b.sifraKorisnika
									inner join namirnica c on b.sifraNamirnice=c.sifra
									where c.sifra=:sifra
									");
									$izraz -> bindParam(":sifra", $sifra);
									
									$izraz -> execute();
									$donatoriKorisnici = $izraz -> fetchAll(PDO::FETCH_OBJ);
									
									if($donatoriKorisnici!=null):
									?>
									
									<div class="large-6 columns">
										<b>Donatori osobe:</b>
										<div class="row">
											<div class="large-12 columns">
												
											<table>
												<tr>
													<th>OIB</th>
													<th>Ime</th>
													<th>Prezime</th>
												</tr>
												
												
												<?php
												foreach ($donatoriKorisnici as $k):
												?>
												<tr>
													<td><?php echo $k->oib; ?></td>
													<td><?php echo $k->ime; ?></td>
													<td><?php echo $k->prezime; ?></td>
												</tr>
												<?php
												endforeach;
												?>
												
											</table>
												
											</div>
										</div>
										
									</div>
									
									<?php
									endif;
									?>
									<a id="<?php echo $sifra; ?>" class="obrisi button round">Obriši namirnicu</a>
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

