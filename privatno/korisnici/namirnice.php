<?php
include_once '../../konfig.php';
if (!isset($_SESSION["korisnik"])) {
	header("location: ../../logout.php");
}

$sifra = $_SESSION["korisnik"]->sifra;

if($_POST){
	$date = date('Y-m-d H:i:s');
	$ne="NE";
	if($_POST['unos']=="selectForma"){
		
		$izraz = $veza -> prepare("
		select * from namirnica where sifra=:sifra");
		$izraz->bindParam(":sifra",$_POST['namirnica']);
		$izraz->execute();
		$objekt = $izraz->fetch(PDO::FETCH_OBJ);
		
		echo $objekt->naziv;
		
		$izraz = $veza -> prepare("
		insert into narudzba(sifraKorisnika,sifraNamirnice,naziv,kolicina,datumNarudzbe,zapremljeno) 
		values(:sifra,:sifraNamirnice,:naziv,:kolicina,:datum,:zapremljeno)");
		$izraz->bindParam(":sifra",$sifra);
		$izraz->bindParam(":sifraNamirnice",$_POST['namirnica']);
		$izraz->bindParam(":naziv",$objekt->naziv);
		$izraz->bindParam(":kolicina",$_POST['kolicinaN']);
		$izraz->bindParam(":datum",$date);
		$izraz->bindParam(":zapremljeno",$ne);
		
		$izraz->execute();
		
		print_r($_POST);
		header("location: namirnice.php?active=2");
	}
		
	if($_POST['unos']=="inputForma"){
		
		$izraz = $veza -> prepare("
		insert into narudzba(sifraKorisnika,naziv,kolicina,datumNarudzbe,zapremljeno) 
		values(:sifra,:naziv,:kolicina,:datum,:zapremljeno)");
		$izraz->bindParam(":sifra",$sifra);
		$izraz->bindParam(":naziv",$_POST['nazivTrazeneNamirnice']);
		$izraz->bindParam(":kolicina",$_POST['kolicinaTN']);
		$izraz->bindParam(":datum",$date);
		$izraz->bindParam(":zapremljeno",$ne);
		
		$izraz->execute();

		header("location: namirnice.php?active=2");
	}
	
	
	if(isset($_SESSION['sifraBrisanja'])){
		$izraz = $veza -> prepare("delete from narudzba where sifra=:sifra");
		$izraz -> bindParam(":sifra", $_SESSION['sifraBrisanja']);
		$izraz -> execute();
		
		
		unset($_SESSION['sifraBrisanja']);
		header("location: namirnice.php?active=2");
	}
}



?>

<!doctype html>
<html class="no-js" lang="en">
	<head>
		<?php
		include_once '../../head.php';
		?>
		
		<link rel="stylesheet" type="text/css" href="<?php echo $putanjaApp; ?>css/tooltipster.css" />
	    <script type="text/javascript" src="http://code.jquery.com/jquery-1.7.0.min.js"></script>
	    <script type="text/javascript" src="<?php echo $putanjaApp; ?>js/jquery.tooltipster.min.js"></script>
	    
	</head>
	<body>
		<?php
		include_once '../../zaglavlje.php';
		?>

		<div class="row marginBottom20 textCenter">
			<div class="large-12 columns">
				<br />
				<h1 class="h1Font2">Socijalna&nbsp;&nbsp;&nbsp;samoposluga</h1>

			</div>
		</div>
		
		<?php

		//MOŽE SA SWITCH
		
		//prijenos parametra za simuliranje selecta
		$x = isset($_GET["active"]) ? $_GET["active"] : "";
		
		//$x = 1
		$izraz = $veza -> prepare("
		select 
		a.naziv as Naziv,
		a.jedinicaMjere as Jedinica_mjere, 
		b.kolicina as Kolicina,
		b.datumUzimanja as Datum_preuzimanja
		from namirnica a
		inner join uzima b on a.sifra=b.sifraNamirnice
		inner join korisnik c on b.sifraKorisnika=c.sifra
		where c.sifra=:sifra
		");
		$izraz ->bindParam(":sifra",$sifra);
		$izraz -> execute();
		$namirniceKorisnika = $izraz -> fetchAll(PDO::FETCH_OBJ);
		
		
		//$x = 2
		$izraz = $veza -> prepare("
		select 
		a.sifra,a.naziv,a.kolicina,a.datumNarudzbe,a.zapremljeno
		from narudzba a
		inner join korisnik b on a.sifraKorisnika = b.sifra
		where b.sifra=:sifra;
		");
		$izraz ->bindParam(":sifra",$sifra);
		$izraz -> execute();
		$naruceneNamirnice = $izraz -> fetchAll(PDO::FETCH_OBJ);
		
		
		
		//$x = 3
		$izraz = $veza -> prepare("
		select naziv, jedinicaMjere, stanje from namirnica where stanje!=0");
		$izraz -> execute();
		$namirniceTrazene = $izraz -> fetchAll(PDO::FETCH_OBJ);
		
		
		
		//$x = 4
		$izraz = $veza -> prepare("
		select sifra,naziv,jedinicaMjere,stanje from namirnica where stanje=0");
		$izraz -> execute();
		$namirniceNarudzba = $izraz -> fetchAll(PDO::FETCH_OBJ);
		
		
		
		
		?>	
		
		<pre>
		<?php //print_r($naruceneNamirnice); ?>	
		</pre>
		
		
		<div class="row">
			<div class="panel">
				<div class="row">
					<div class="large-10 columns">
						<h2 class="h25Font"><?php echo $_SESSION["korisnik"]->ime . " " . $_SESSION["korisnik"]->prezime; ?></h2>
					</div>
					<div class="large-2 columns">
						<a id="nazad" class="button round right" href="<?php echo $putanjaApp; ?>privatno/korisnici/index.php">Nazad</a>
					</div>
				</div>
				<hr class="hrLinija"/>
				
				<!-- SUB NAV -->
				
				<dl class="sub-nav">
				  <dt>Namirnice:</dt>
				  <dd class="
				  <?php
				  if($x==1 || !isset($_GET["active"])){
				  	echo "active";
				  }
				  ?>
				  "><a href="?active=1">Moje preuzete namirnice</a></dd>
				  
				  <dd class="
				  <?php
				  if($x==2){
				  	echo "active";
				  }				  
				  ?>
				  "><a href="?active=2">Moje narudžbe</a></dd>
				  
				  
				  <dd class="
				  <?php
				  if($x==3){
				  	echo "active";
				  }				  
				  ?>
				  "><a href="?active=3">Sve namirnice</a></dd>
				  
				
				  <dd class="
				  <?php
				  if($x==4){
				  	echo "active";
				  }				  
				  ?>
				  "><a href="?active=4">Narudžba</a></dd>
				</dl>
			
			<?php
			
			
			if($x==1 || !isset($_GET["active"])):
			?>
			<div class="row">
				<div class="panel panelBorder">
					
							<!-- KORISNIKOVE PREUZETE NAMIRNICE -->
								<div class="row">
									<table>
										<th>Naziv</th>
										<th>Jedinica mjere</th>
										<th>Kolicina</th>
										<th>Datum preuzimanja</th>
										
								<?php
									foreach ($namirniceKorisnika as $o):			
								?>
								
								<tr>
									<td><?php echo $o->Naziv; ?></td>
									<td><?php echo $o->Jedinica_mjere; ?></td>
									<td><?php echo $o->Kolicina; ?></td>	
									<td> <?php
									if($o->Datum_preuzimanja!=""){
										$d = $o->Datum_preuzimanja;
										$d=substr($d, 8,2) . "." . substr($d, 5,2) . "." . substr($d, 0,4) . ". ". substr($d, 11,8);
										$o->Datum_preuzimanja=$d;
										echo $o->Datum_preuzimanja;
									}else {
										echo $o->Datum_preuzimanja;
									}
									?></td>								
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
			
			
			
			if($x==2):
			?>
			
			<div class="row">
				<div class="panel panelBorder">
					
					<!-- SVE KORISNIKOVE NARUĐBE -->
					<div class="row">
									<table>
										<th>Naziv</th>
										<th>Kolicina</th>
										<th>Datum narudžbe</th>
										<th>Zapremljeno</th>
										<th>Ukloni narudžbu</th>
										
								<?php
									foreach ($naruceneNamirnice as $o):			
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
									<td <?php if($o->zapremljeno=="DA"){echo "style=\"background: green;\"";
									}else{echo "style=\"background: red;\"";}?>><?php echo $o->zapremljeno; ?></td>
									<td>
										<a id="<?php echo $o->sifra; ?>" title="Obriši narudžbu" class="iconsColor brisanjeNarudzbe">
											<i class="fi-x"></i>
										</a>
									</td>
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
			
			
			if($x==3):
			?>
			
			<div class="row">
				<div class="panel panelBorder">
								<div class="row">
									<table>
										<th>Naziv</th>
										<th>Jedinica mjere</th>
										<th>Stanje</th>
										
										
								<?php
									foreach ($namirniceTrazene as $ot):			
								?>
								
								<tr>
									<td><?php echo $ot->naziv; ?></td>
									<td><?php echo $ot->jedinicaMjere; ?></td>									
									<td><?php echo $ot->stanje; ?></td>								
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
			
			
			
			
			
			
			if($x==4):
			?>
			
			<div class="row">
				<div class="panel panelBorder">
					<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
						<div class="row">
							<div class="large-6 columns">
								<label for="unos1">Odaberite namirnicu koju želite naručiti:</label>
								<input type="radio" class="trigger" id="unos1" name="unos" value="selectForma"/>
							</div>
							<div class="large-6 columns">
								<label for="unos2">Unos nove namirnice:</label>
								<input type="radio" class="trigger" id="unos2" name="unos" value="inputForma"/>
							</div>
						</div>
						<hr class="hrLinija"/>
						
						
						<div id="odabirNamirnice" class="row">
							<div class="large-5 columns">
								<label>Namirnica</label>
								<select id="selectNamirnice" name="namirnica"> <!-- salji sifru i onda koristi sifru rdi izvlacenja naziva-->
									<?php
									foreach ($namirniceNarudzba as $on):
									?>
									
									<option value="<?php echo $on->sifra; ?>"><?php echo $on->naziv."&nbsp;&nbsp;&nbsp;(".$on->jedinicaMjere.")"; ?></option>
									
									<?php
									endforeach;
									?>
								</select>
								<small class="porukaselect error">Odaberite namirnicu i količinu!</small>
								
								<!-- <input type="hidden" name="sifraNamirnice" id="sifraNamirnice" value="" /> -->
							</div>
							
							<div class="large-2 end columns">
								<label>Količina</label>
								<select name="kolicinaN">
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>							
								</select>
							</div>
						</div>
						
				
						<div id="unosNamirnice" class="row">
							<div class="large-5 columns">
								<label for="naziv">Naziv&nbsp;namirnice</label>
								<input type="text" id="naziv" name="nazivTrazeneNamirnice"/>
								<small class="porukanaziv error"></small>
							</div>
							<div class="large-3 end columns">
								<label for="kolicina">Količina</label>
								<input class="numbersOnly" type="text" id="kolicina" name="kolicinaTN"/>
								<small class="porukakolicina error"></small>
							</div>
						</div>
						<br />
						<input id="posaljiSelect" type="submit" class="button round" value="Pošalji"/>
						<input id="posaljiInput" type="submit" class="button round" value="Pošalji"/>
					</form>
				</div>
			</div>
			
			<?php
			endif;
			?>
			
			</div>
		</div>
		<div class="potpis">
			<label class="right">&copy; Damir Majer 07.03.2015.</label>
		</div>
		
		
		<?php
		include_once 'modalBrisanjeNarudzbe.php';
		?>
		
		<?php
		include_once '../../skripte.php';
		?>
		
		<?php
		include_once 'jQueryNarudzba.php';
		?>
		
		<!-- BRISANJE NARUDŽBE -->
		<script>
		$(document).ready(function(){
			
			$(".brisanjeNarudzbe").click(function(){
				
				//alert($(this).attr("id"));
				
				$.ajax({
						type : "GET",
						url : "pokupiDetaljeBrisanje.php?sifra=" + $(this).attr("id"),
						cache : false,
						success : function(data) {

							$("#kontejner").html(data);
							$('#myModalBrisanje').foundation('reveal','open');
						}
					});
				
					
				return true;
			});	
			
		});
			
		</script>
		
		
		
		<!-- NARUDŽBA -->
		<script>
			$(document).ready(function(){
				$("#odabirNamirnice").hide();
				$("#unosNamirnice").hide();
				$("#posaljiSelect").hide();
				$("#posaljiInput").hide();
				
				
				$('.trigger').click(function() {    				
    				if($(this).val()=="selectForma"){
    					$("#odabirNamirnice").show();
    					$("#unosNamirnice").hide();
    					$("#posaljiInput").hide();
    					$("#posaljiSelect").show();
    				}else{
    					$("#odabirNamirnice").hide();
    					$("#unosNamirnice").show();
    					$("#posaljiSelect").hide();
    					$("#posaljiInput").show();
    				}
				});
				
			});
		</script>
	
	</body>
</html>
