<?php
include_once '../../../konfig.php';
if (!isset($_SESSION["operater"])) {
	header("location: index.php");
}
$sifra = "";
if (isset($_GET['sifra'])) {
	$sifra = $_GET['sifra'];
}else if(isset($_POST['sifraKorisnika'])){
	$sifra = $_POST['sifraKorisnika'];
}


$izraz = $veza -> prepare("
select * from korisnik where sifra=:sifra
");
$izraz ->bindParam(":sifra",$sifra);
$izraz -> execute();
$korisnik = $izraz -> fetch(PDO::FETCH_OBJ);


if($_POST){
	
	if(isset($_POST['hidSifraBrisanja']) && $_POST['hidSifraBrisanja']!=""){
		
		$izraz = $veza -> prepare("
		delete from narudzba where sifra=:sifra
		");
		$izraz ->bindParam(":sifra",$_POST['hidSifraBrisanja']);
		$izraz -> execute();
		
	}else {
		$izraz = $veza -> prepare("
		delete from narudzba where sifraKorisnika=:sifraKorisnika
		");
		$izraz ->bindParam(":sifraKorisnika",$_POST['sifraKorisnika']);
		$izraz -> execute();
		
		header("location: index.php");
	}
	
	
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
						<div class="large-12 columns">
							<div class="row">
								<div class="large-6 columns">
									<h2 class="h25Font">Narudžbe korisnika <?php echo $korisnik->ime." ".$korisnik->prezime; ?></h2>
								</div>
								<div class="large-2 columns">
									<a id="nazad" class="button round right" href="<?php echo $putanjaApp; ?>privatno/operateri/narudzbe/index.php">Nazad</a>
								</div>
							</div>
						</div>
					</div>
						<?php
						
						$izraz = $veza -> prepare("
						select
						a.sifra as sifraNarudzbe,a.sifraNamirnice,a.naziv,a.kolicina,a.datumNarudzbe,a.zapremljeno,
						b.sifra,b.ime,b.prezime
						from narudzba a
						inner join korisnik b on b.sifra=a.sifraKorisnika
						where b.sifra=:sifra;
						");
						$izraz->bindParam(":sifra",$sifra);
						$izraz->execute();
						$narudzbe = $izraz->fetchAll(PDO::FETCH_OBJ);
						
						if($narudzbe==null){
							header("location: index.php");
						}
						
						?>
						<div class="panel panelBorder">
								<div class="row">
									<div class="large-9 large-centered columns">
										<table>
											<th>Naziv</th>
											<th>Količina</th>
											<th>Datum narudžbe</th>
											<th>Zapremljeno</th>
											<th>Uredi namirnicu</th>
											
									<?php
										foreach ($narudzbe as $o):			
									?>
									
									<tr>
										<td><?php echo $o->naziv; ?></td>
										<td><?php echo $o->kolicina; ?></td>
										<td><?php
										if($o->datumNarudzbe!=""){
											$d = $o->datumNarudzbe;
											$d=substr($d, 8,2) . "." . substr($d, 5,2) . "." . substr($d, 0,4) . ". ". substr($d, 11,8);
											$o->datumNarudzbe=$d;
											echo $o->datumNarudzbe;
										}else {
											echo $o->datumNarudzbe;
										}
										?></td>
										<td <?php 
										if($o->zapremljeno=="DA"){
											echo "style=\"background: green;\"";
										}else{
											echo "style=\"background: red;\"";
										}
										?>><?php echo $o->zapremljeno; ?></td>
										
										<td>
											<?php
											if($o->zapremljeno=="NE"):
											?>
											<a title="Uredi" class="iconsColor" href="uredi.php?sifra=<?php echo $o->sifraNarudzbe; ?>"><i class="fi-pencil"></i></a>&nbsp;&nbsp;&nbsp;
											<?php
											endif;
											?>
											<a id="<?php echo $o->sifraNarudzbe."_".$o->naziv; ?>" title="Obriši" class="brisanje iconsColor" href="#"><i class="fi-trash"></i></a>
										</td>
									</tr>
									
									<?php
									endforeach;
									?>
									<tr>
										<td></td>
										<td></td>
										<td></td>
										<td colspan="2" class="podlogaCrveno">
											<a id="<?php echo $sifra; ?>" title="Obriši" class="obrisiSveNamirnice iconsColor" href="#">Obriši sve namirnice</a>
										</td>
									</tr>
									
										</table>
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
		include_once 'modalDetalji.php';
		?>
		<?php
		include_once 'modalBrisanjeSvihNamirnica.php';
		?>
		<?php
		include_once '../../../skripte.php';
		?>
		<script>
			$(function(){
				
				$('.brisanje').click(function(){
					
					$("#hidSifraBrisanja").val($(this).attr("id").split("_")[0]);
					$(".obrisiInput").attr("id",$(this).attr("id").split("_")[0]);
					$("#kontejner").html("<h2 class=\"h25Font\">Potvrda brisanja namirnice " + $(this).attr("id").split("_")[1] +"</h2>");
					$('#myModal2').foundation('reveal','open');
					
					return true;
				});
			});	
				
			$(function(){
				
				$('.obrisiSveNamirnice').click(function(){
					
					$("#kontejner2").html("<h2 class=\"h25Font\">Potvrda brisanja svih namirnica</h2>");
					$('#myModal2BrisanjeSvihNamirnica').foundation('reveal','open');
					
					return true;
				});
			});
			
		</script>
		
	</body>
</html>
