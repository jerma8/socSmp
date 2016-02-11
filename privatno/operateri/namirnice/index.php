<?php
include_once '../../../konfig.php';
unset($_SESSION['normalanUnos']);

if (!isset($_SESSION["operater"])) {
	header("location: ../../../logout.php");
}

$sifra = "";
if (isset($_GET['sifra'])) {
	$sifra = $_GET['sifra'];
} else if (isset($_POST['sifra'])) {
	$sifra = $_POST['sifra'];
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
											<h2 class="h25Font">Namirnice</h2>
										</div>
										<div class="large-5 end columns">
											<a id="nazad" class="button round" href="dodaj.php">Dodaj namirnicu</a>
										</div>
									</div>
								</div>
								<div class="large-6 columns">									
									<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
										<div class="row collapse">
											<div class="large-5 remForma columns">
												<input type="text" name="uvjet" value="<?php echo isset($_POST["uvjet"]) ? $_POST["uvjet"] : ""; ?>" />
											</div>
											<div class="large-4 remForma columns">
												<select class="traziSelect" name="traziPo">
													
													
													<?php 
													$traziPo = array(
													"stanje" => "Dostupno",
													"trazeno" => "Traženo",
													"naziv" => "Naziv");
													
													foreach ($traziPo as $u => $l) {
														?>
														<option
													<?php
														if(!isset($_POST["traziPo"]) || $_POST["traziPo"]==$u){
															echo "selected=\"selected\"";
														}
														?>
														
													value="<?php echo $u ?>"><?php echo $l; ?></option>
													<?php
													}
													?>
													
													
												
												</select>
											</div>
											<div class="large-2 end columns">
												<input class="button remFormaButton" type="submit" value="Traži!" />
											</div>
										</div>
									</form>
								</div>
							</div>
							<?php
							
							
							$uvjet="";   //input
							$traziNamirnicuPo="%";  //select
							
							if($_POST){
								$uvjet = $_POST['uvjet'];
								if($_POST["traziPo"]=="svi"){
									$traziNamirnicuPo="%";
								}else {
									$traziNamirnicuPo = $_POST["traziPo"];
								}
								
							}
							$uvjet = "%".$uvjet."%";
														
							
							$izraz = $veza -> prepare("
							select * from namirnica where ime like :uvjet and uloga like :uloga
							");
							$izraz ->bindParam(":uvjet",$uvjet);
							$izraz ->bindParam(":uloga",$uloga);
							$izraz -> execute();
							$namirnice = $izraz -> fetchAll(PDO::FETCH_OBJ);
							
							
							
							
							
							if($_POST){
								$uvjet = $_POST['uvjet'];
								$uvjet = "%".$uvjet."%";
								
								
								switch ($_POST["traziPo"]) {
																		
									case 'naziv':
										$izraz = $veza -> prepare("
										select * from namirnica where naziv like :uvjet
										");
										$izraz ->bindParam(":uvjet",$uvjet);
										$izraz -> execute();
										$namirnice = $izraz -> fetchAll(PDO::FETCH_OBJ);
									
										break;
									
									case 'trazeno':
										$izraz = $veza -> prepare("
										select * from namirnica where naziv like :uvjet and trazeno!=0
										");
										$izraz ->bindParam(":uvjet",$uvjet);
										$izraz -> execute();
										$namirnice = $izraz -> fetchAll(PDO::FETCH_OBJ);
										
										break;
										
									case 'stanje':
										$izraz = $veza -> prepare("
										select * from namirnica where naziv like :uvjet and stanje!=0
										");
										$izraz ->bindParam(":uvjet",$uvjet);
										$izraz -> execute();
										$namirnice = $izraz -> fetchAll(PDO::FETCH_OBJ);
										
										break;
												
									/*default:
										
										break;*/
								}
							}else{
								$izraz = $veza -> prepare("select * from namirnica");
								$izraz -> execute();
								$namirnice = $izraz -> fetchAll(PDO::FETCH_OBJ);
							}
							
							
							?>
							<div class="panel panelBorder">
								<div class="row">
									<table>
										<th>Barkod</th>
										<th>Naziv</th>
										<th>Jedinica mjere</th>
										<th>Kvota po danu</th>
										<th>Kvota po članu</th>
										<th class="podlogaZeleno">Stanje</th>
										<th class="podlogaCrveno">Traženo</th>
										<th></th>
										
								<?php
									foreach ($namirnice as $o):			
								?>
								
								<tr>
									<td><?php echo $o->barkod; ?></td>
									<td><?php echo $o->naziv; ?></td>
									<td><?php echo $o->jedinicaMjere; ?></td>
									<td><?php echo $o->kvotaPoDanu; ?></td>
									<td><?php echo $o->kvotaPoClanu; ?></td>
									<td <?php
									if($o->stanje<=0)
										echo "class=\"podlogaCrveno\"";
									else 
										echo "class=\"podlogaZeleno\"";
									?>><?php echo $o->stanje; ?></td>
									
									
									<td <?php 
									if($o->stanje>0 && $o->trazeno>0)
										echo "class=\"podlogaZeleno\"";
									else
										echo "class=\"podlogaCrveno\"";
									?>class="podlogaCrveno"><?php echo $o->trazeno; ?></td>
																		
									<td>
										<a title="Promijeni" class="iconsColor" href="uredi.php?sifra=<?php echo $o->sifra; ?>"><i class="fi-pencil"></i></a>
										<a title="Obriši" class="obrisiNamirnicu iconsColor" href="obrisi.php?sifra=<?php echo $o->sifra; ?>"><i class="fi-trash"></i></a>
										
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
		include_once 'modalBrisanjeNamirnice.php';
		?>

		<?php
		include_once '../../../skripte.php';
		?>
			
	</body>
</html>
