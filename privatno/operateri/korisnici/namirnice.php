<?php
include_once '../../../konfig.php';
if (!isset($_SESSION["operater"])) {
	header("location: ../../../logout.php");
}

$sifra = "";
if (isset($_GET['sifra'])) {
	$sifra = $_GET['sifra'];
} else if (isset($_POST['sifraKorisnika'])) {
	$sifra = $_POST['sifraKorisnika'];
}

if($_POST){
	//briši namirnicu
	if(isset($_POST['hidSifraNamirnice']) && $_POST['hidSifraNamirnice']!=""){
		
		$izraz = $veza -> prepare("
		delete from uzima where sifraKorisnika=:sifraKorisnika and sifraNamirnice=:hidSifraNamirnice and DATE(datumUzimanja)=:hidDatum
		");
		$izraz ->bindParam(":sifraKorisnika",$_POST['sifraKorisnika']);
		$izraz ->bindParam(":hidSifraNamirnice",$_POST['hidSifraNamirnice']);
		$izraz ->bindParam(":hidDatum",$_POST['hidDatum']);
		$izraz -> execute();
		
	}else{
		
		$izraz = $veza -> prepare("
		delete from uzima where sifraKorisnika=:sifraKorisnika
		");
		$izraz ->bindParam(":sifraKorisnika",$_POST['sifraKorisnika']);
		$izraz -> execute();
		
	}
		
}


$izraz = $veza -> prepare("
select ime,prezime from korisnik where sifra=:sifra
");
$izraz ->bindParam(":sifra",$sifra);
$izraz -> execute();
$korisnik = $izraz -> fetch(PDO::FETCH_OBJ);



$izraz = $veza -> prepare("
select
c.ime, c.prezime,b.sifraKorisnika,b.sifraNamirnice, b.datumUzimanja, b.kolicina, a.barkod, a.naziv, a.jedinicaMjere
from namirnica a
inner join uzima b on a.sifra=b.sifraNamirnice
inner join korisnik c on b.sifraKorisnika=c.sifra
where c.sifra=:sifra
");
$izraz ->bindParam(":sifra",$sifra);
$izraz -> execute();
$namirnice = $izraz -> fetchAll(PDO::FETCH_OBJ);
							
if($namirnice==null){
	header("location: index.php");
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
										<div class="large-9 columns">
											<h2 class="h25Font">Namirnice korisnika</h2>
											<h2 class="h25Font"><?php echo $korisnik->ime." ".$korisnik->prezime; ?></h2>
										</div>
										<div class="large-2 columns">
											<a id="nazad" class="button round right" href="<?php echo $putanjaApp; ?>privatno/operateri/korisnici/index.php">Nazad</a>
										</div>
									</div>
								</div>
								
							</div>
							
							<div class="panel panelBorder">
								<div class="row">
									<table>
										<th>Barkod</th>
										<th>Naziv</th>
										<th>Jedinica mjere</th>
										<th>Količina</th>
										<th>Datum uzimanja</th>
										<th></th>
										
								<?php
								foreach ($namirnice as $o):			
								?>
								
								<tr>
									<td><?php echo $o->barkod; ?></td>
									<td><?php echo $o->naziv; ?></td>
									<td><?php echo $o->jedinicaMjere; ?></td>
									<td><?php echo $o->kolicina; ?></td>
									<td><?php
									if($o->datumUzimanja!=""){
										$d = $o->datumUzimanja;
										$d=substr($d, 8,2) . "." . substr($d, 5,2) . "." . substr($d, 0,4) . ". ". substr($d, 11,8);
										$o->datumUzimanja=$d;
										echo $o->datumUzimanja;
									}else {
										echo $o->datumUzimanja;
									}
									?>
									</td>
									<?php
									$d = $o->datumUzimanja;
									$d=substr($d, 6,4) . "-" . substr($d, 3,2) . "-" . substr($d, 0,2);
									$o->datumUzimanja=$d;
									?>					
									<td>
										<a id="<?php echo $o->sifraNamirnice."_".$o->naziv."_".$o->datumUzimanja; ?>" title="Obriši" class="obrisiNamirnicu iconsColor" href="#"><i class="fi-trash"></i></a>
									</td>
								</tr>
								
								<?php
								endforeach;
								?>
								<tr>
									<td></td>
									<td></td>
									
									<td colspan="2" class="podlogaZeleno">
										<a title="PDF dokument" class="obrisiNamirnicu iconsColor" href="printanjeNamirnica.php?sifra=<?php echo $sifra; ?>">Ispiši namirnice</a>
									</td>
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

		
		<div class="potpis">
			<label class="right">&copy; Damir Majer 07.03.2015.</label>
		</div>

		<?php
		include_once 'modalBrisanjeNamirnice.php';
		?>
		
		<?php
		include_once 'modalBrisanjeSvihNamirnica.php';
		?>
		
		<?php
		include_once '../../../skripte.php';
		?>
		<script>
			$(function(){
				
				$('.obrisiNamirnicu').click(function(){
					
					$("#hidSifraNamirnice").val($(this).attr("id").split("_")[0]);
					$("#hidDatum").val($(this).attr("id").split("_")[2]);
					$(".obrisiInput").attr("id",$(this).attr("id").split("_")[0]);
					$("#kontejner").html("<h2 class=\"h25Font\">Potvrda brisanja namirnice <br\>" + $(this).attr("id").split("_")[1] +"</h2>");
					$('#myModal2BrisanjeNamirnice').foundation('reveal','open');
					
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
