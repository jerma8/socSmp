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
											<h2 class="h25Font">Korisnici</h2>
										</div>
										<div class="large-5 end columns">
											<a id="nazad" class="button round" href="dodaj.php">Dodaj korisnika</a>
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
												<select class="traziSelect" name="uloga">
													
													
													<?php 
													$uloga = array(
													"admin" => "Operateri",
													"primateljiPomoci" => "Korisnici",
													"tvrtka" => "Tvrtke",
													"donator" => "Donatori",
													"svi" => "Svi");
													
													foreach ($uloga as $u => $l) {
														?>
														<option
													<?php
														if(!isset($_POST["uloga"]) || $_POST["uloga"]==$u){
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
							
							
							$uvjet="";
							$uloga="%";
							if($_POST){
								$uvjet = $_POST['uvjet'];
								if($_POST["uloga"]=="svi"){
									$uloga="%";
								}else {
									$uloga = $_POST["uloga"];
								}
								
							}
							$uvjet = "%".$uvjet."%";
														
							
							$izraz = $veza -> prepare("
							select * from korisnik where ime like :uvjet and uloga like :uloga
							");
							$izraz ->bindParam(":uvjet",$uvjet);
							$izraz ->bindParam(":uloga",$uloga);
							$izraz -> execute();
							$korisnici = $izraz -> fetchAll(PDO::FETCH_OBJ);
							
							?>
							<div class="panel panelBorder">
								<div class="row">
									<table>
										<th>OIB</th>
										<th>Ime</th>
										<th>Prezime</th>
										<th class="width1">Isporuči namirnicu</th>
										<th class="width1">Namirnice korisnika</th>
										<th></th>
										
								<?php
									foreach ($korisnici as $o):			
								?>
								
								<tr>
									<td><?php echo $o->oib; ?></td>
									<td><?php echo $o->ime; ?></td>
									<td><?php echo $o->prezime; ?></td>
									<?php
									if($o->uloga=="adminPrimateljPomoci" || $o->uloga=="primateljiPomoci"):
									?>
									<td>
										<a title="Isporuči namirnicu" class="iconsColor" href="isporuka.php?sifra=<?php echo $o->sifra; ?>"><i class="fi-shopping-bag"></i></a>
									</td>
									<td>
										<a title="Namirnice korisnika" class="iconsColor" href="namirnice.php?sifra=<?php echo $o->sifra; ?>"><i class="fi-shopping-cart"></i></a>
									</td>
									<?php
									else:
									?>
									<td></td>
									<td></td>
									<?php
									endif;
									?>
									
									<td>
										<a title="Promijeni" class="iconsColor" href="uredi.php?sifra=<?php echo $o->sifra; ?>"><i class="fi-pencil"></i></a>&nbsp;&nbsp;&nbsp;
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
