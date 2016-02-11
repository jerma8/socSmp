<?php
include_once '../../../konfig.php';
unset($_SESSION['dosaoDonator']);
if (!isset($_SESSION["operater"])) {
	header("location: ../../../logout.php");
}
$sifra = "";
if (isset($_GET['sifra'])) {
	$sifra = $_GET['sifra'];
} else if (isset($_POST['sifsifraNamirnicera'])) {
	$sifra = $_POST['sifraNamirnice'];
}



if($_POST){	
	$izraz = $veza -> prepare("	delete from pripremaDonacije where sifraNamirnice=:sifra");
	$izraz->bindParam("sifra",$sifra);
	$izraz -> execute();
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
		
		<?php
						
			$izraz = $veza -> prepare("
			select
			a.sifra,a.ime,a.prezime,
			b.sifra as sifraNamirnice, b.naziv as nazivNamirnice, b.kolicina,b.jedinicaMjere, b.rokTrajanja
			from korisnik a
			inner join pripremaDonacije b on a.sifra=b.sifraKorisnika
			where a.sifra=:sifra;
			");
			$izraz->bindParam(":sifra",$sifra);
			$izraz->execute();
			$pripremaDonacije = $izraz->fetchAll(PDO::FETCH_OBJ);
		
			
			if($pripremaDonacije==null){
				header("location: index.php");
			}
			
			
			$nazivTvrtke="";
			foreach ($pripremaDonacije as $p) {
				$nazivDonatora = $p->ime." ".$p->prezime;
			}
		?>
		
		<div class="row">
			<div class="large-12 columns">
				<div class="panel">
							
					<div class="row">
						<div class="large-12 columns">
							<div class="row">
								<div class="large-8 columns">
									<h2 class="h25Font">Priprema donacije donatora<br /> <?php echo $nazivDonatora; ?></h2>
								</div>
								<div class="large-2 columns">
									<a id="nazad" class="button round right" href="<?php echo $putanjaApp; ?>privatno/operateri/donacijeDonatora/index.php">Nazad</a>
								</div>
							</div>
						</div>
					</div>
						
						
						
						<div class="panel panelBorder">
							<div class="row">
									<table>
										<th>Naziv</th>
										<th>Količina</th>
										<th>Jedinica mjere</th>
										<th>Rok trajanja</th>
										<th>Dodaj namirnicu</th>
										<th></th>
										
								<?php
									foreach ($pripremaDonacije as $o):			
								?>
								
								<tr>
									<td><?php echo $o->nazivNamirnice; ?></td>
									<td><?php echo $o->kolicina; ?></td>
									<td><?php echo $o->jedinicaMjere; ?></td>
									<td><?php 
									if($o->rokTrajanja!=""){
										$d = $o->rokTrajanja;
										$d=substr($d, 8,2) . "." . substr($d, 5,2) . "." . substr($d, 0,4) . ".";
										$o->rokTrajanja=$d;
										echo $o->rokTrajanja;
									}else {
										echo $o->rokTrajanja;
									}
									?></td>
									<td>
										<a title="Uredi" class="iconsColor" href="<?php echo $putanjaApp; ?>privatno/operateri/namirnice/dodaj.php?sifra=<?php echo $o->sifraNamirnice;?>"><i class="fi-plus"></i></a>
									</td>
									
									<td>
										<a title="Obriši" class="iconsColor brisanjeNamirnice" id="brisanje_<?php echo $o->nazivNamirnice; ?>_<?php echo $o->sifraNamirnice; ?>"><i class="fi-trash"></i></a>
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
		

		
<script>
			$(document).ready(function(){
			
			$(".brisanjeNamirnice").click(function(){
				
				//alert($(this).attr("id").split("_")[2]); // 1 - sifra
				
				//alert($(this).attr("id").split("_")[1]); //Kruh - naziv 
				
				$('#nazivNamirnice').html($(this).attr("id").split("_")[1]);
				$('.potvrdaBrisanja').attr('id', $(this).attr("id").split("_")[2]);
								
				$('#myModalBrisanjeNamirnice').foundation('reveal','open');
				
				
				$(".potvrdaBrisanja").click(function(){
				
				$.ajax({
						type : "GET",
						url : "pokupiDetaljeBrisanje.php?sifra=" + $(this).attr("id"),
						cache : false,
						success : function(data) {
							
						}
					});
				
					
				return true;
			});
					
	
				return true;
			});	

		
		
		});
</script>
		
		
	</body>
</html>
