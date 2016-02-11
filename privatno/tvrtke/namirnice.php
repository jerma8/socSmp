<?php
include_once '../../konfig.php';
if (!isset($_SESSION["tvrtka"])) {
	header("location: ../../logout.php");
}

$poruka="";
$rok="";
$sifraNamirnice="";


if($_POST){
	$date = date('Y-m-d H:i:s');
	
	
	$izraz= $veza->prepare("select sifra from tvrtka where sifraKorisnika=:sifraKorisnika");
	$izraz->bindParam(":sifraKorisnika",$_SESSION["tvrtka"]->sifra);
	$izraz->execute();
	$objekt = $izraz -> fetch(PDO::FETCH_OBJ);
	
	$sifraTvrtke = $objekt->sifra;
	
	
	if(isset($_POST['rokTrajanja']) && $_POST['rokTrajanja']!=""){
		$d = $_POST["rokTrajanja"];
		$d=substr($d, 6,4) . "-" . substr($d, 3,2) . "-" . substr($d, 0,2);
		$_POST["rokTrajanja"]=$d;
		$rok=$_POST['rokTrajanja'];
	}else {
		$rok=null;
	}
	
	if(isset($_POST['sifra']) && $_POST['sifra']!=""){
		$sifraNamirnice=$_POST['sifra'];
	}	
	else {
				
		$izraz= $veza->prepare("select sifra,naziv from namirnica where naziv=:naziv");
		$izraz->bindParam(":naziv",$_POST['naziv']);
		$izraz->execute();
		$objektPoNazivu = $izraz -> fetch(PDO::FETCH_OBJ);
		
		//echo $objektPoNazivu->sifra. "<br>".$objektPoNazivu->naziv;
		
		if(isset($objektPoNazivu->sifra)){
			$sifraNamirnice = $objektPoNazivu->sifra;
		}else{
			$sifraNamirnice=null;
		}
	}
	
	
	$izraz = $veza -> prepare("
	insert into pripremaDonacije(sifraTvrtke,sifraNamirnice,naziv,kolicina,jedinicaMjere,rokTrajanja,datumSlanjaPripreme) values
	(:sifra,:sifraNamirnice,:naziv,:kolicina,:jedinicaMjere,:rokTrajanja,:datumSlanjaPripreme)");
	
	$izraz->bindParam(":sifra",$sifraTvrtke);
	$izraz->bindParam(":sifraNamirnice",$sifraNamirnice);
	$izraz->bindParam(":naziv",$_POST['naziv']);
	$izraz->bindParam(":kolicina",$_POST['kolicina']);
	$izraz->bindParam(":jedinicaMjere",$_POST['jedinicaMjere']);
	$izraz->bindParam(":rokTrajanja",$rok);
	$izraz->bindParam(":datumSlanjaPripreme",$date);	
	$izraz -> execute();
	

	//Tražene namirnice checkbox
	if(isset($_POST['doniraj'])){
		foreach ($_POST['doniraj'] as $s) {
						
			$izraz= $veza->prepare("select naziv,jedinicaMjere,trazeno from namirnica where sifra=:sifra");
			$izraz->bindParam(":sifra",$s);
			$izraz->execute();
			$objektNamirnica = $izraz -> fetch(PDO::FETCH_OBJ);
			
			
			$izraz = $veza -> prepare("
			insert into pripremaDonacije
			(sifraTvrtke,sifraNamirnice,naziv,kolicina,jedinicaMjere,datumSlanjaPripreme) 
			values
			(:sifra,:sifraNamirnice,:naziv,:kolicina,:jedinicaMjere,:datumSlanjaPripreme)");
			
			$izraz->bindParam(":sifra",$sifraTvrtke);
			$izraz->bindParam(":sifraNamirnice",$s);
			$izraz->bindParam(":naziv",$objektNamirnica->naziv);
			$izraz->bindParam(":kolicina",$objektNamirnica->trazeno);
			$izraz->bindParam(":jedinicaMjere",$objektNamirnica->jedinicaMjere);
			$izraz->bindParam(":datumSlanjaPripreme",$date);	
			$izraz -> execute();
			
			header("location: namirnice.php?active=2");		
		}
	}
	
}

?>
<!doctype html>
<html class="no-js" lang="en">
	<head>
		<?php
		include_once '../../head.php';
		?>
		<link rel="stylesheet" href="<?php echo $putanjaApp; ?>css/jquery-ui.css" />
	</head>
	<body>
		<?php
		include_once '../../zaglavlje.php';
		?>
		<div class="row marginBottom20 textCenter">
			<div class="large-12 columns">
				<br />
				<h1 class="h1Font2">Socijalna&nbsp;&nbsp;&nbsp;samoposluga</h1>
				<!-- FONT BODY I H1 H2 H3 -->

			</div>
		</div>
		
		<?php
		
		$uvjet = $_SESSION["tvrtka"]->sifra;
		
		//prijenos parametra za simuliranje 2 selecta
		$x = isset($_GET["active"]) ? $_GET["active"] : "";
		
		
		//$x=1
		$izraz = $veza -> prepare("
		select 
		a.naziv as Naziv,
		a.jedinicaMjere as Jedinica_mjere,
		b.datumIsporuke as Datum_isporuke,
		b.kolicina as Kolicina,
		a.stanje as Stanje,
		b.rokTrajanja as Rok_trajanja,
		c.sifra
		from namirnica a
		inner join donira b on a.sifra=b.sifraNamirnice
		inner join tvrtka c on b.sifraTvrtke=c.sifra
		where c.sifraKorisnika=:sifra;
		");
		$izraz ->bindParam(":sifra",$uvjet);
		$izraz -> execute();
		$namirnice = $izraz -> fetchAll(PDO::FETCH_OBJ);
		
		
		
		//$x=2
		$izraz = $veza -> prepare("
		select sifra,naziv,jedinicaMjere,trazeno from namirnica where trazeno>0");
		$izraz -> execute();
		$namirniceTrazene = $izraz -> fetchAll(PDO::FETCH_OBJ);
		
		
		
		?>	
		
		<div class="row">
			<div class="panel">
				<div class="row">
					<div class="large-10 columns">
						<h2 class="h25Font"><?php echo $_SESSION["tvrtka"]->ime . " " . $_SESSION["tvrtka"]->prezime; ?></h2>
					</div>
					<div class="large-2 columns">
						<a id="nazad" class="button round right" href="<?php echo $putanjaApp; ?>privatno/tvrtke/index.php">Nazad</a>
					</div>
				</div>
				<hr class="hrLinija"/>
				
				<!-- SUB NAV -->
				
				<dl class="sub-nav">
				  <dt>Traži namirnice:</dt>
				  
				  <dd class="
				  <?php
				  if($x==1 || !isset($_GET["active"])){
				  	echo "active";
				  }
				  ?>
				  "><a href="?active=1">Moje donirane</a></dd>
				  
				  <dd class="
				  <?php
				  if($x==2){
				  	echo "active";
				  }				  
				  ?>
				  "><a href="?active=2">Tražene namirnice</a></dd>
				  
				  <dd class="
				  <?php
				  if($x==3){
				  	echo "active";
				  }				  
				  ?>
				  "><a href="?active=3">Napravi donaciju</a></dd>
				</dl>
			
			<?php
			
			
			if($x==1 || !isset($_GET["active"])):
			?>
			<div class="row">
				<div class="panel panelBorder">
								<div class="row">
									<table>
										<th>Naziv</th>
										<th>Jedinica mjere</th>
										<th>Datum isporuke</th>
										<th>Donirana količina</th>
										<th>Stanje</th>
										<th>Rok trajanja</th>
										
								<?php
									foreach ($namirnice as $o):			
								?>
								
								<tr>
									<td><?php echo $o->Naziv; ?></td>
									<td><?php echo $o->Jedinica_mjere; ?></td>
									
									<td> <?php 
									if($o->Datum_isporuke!=""){
										$d = $o->Datum_isporuke;
										//11,8 za vrijeme
										$d=substr($d, 8,2) . "." . substr($d, 5,2) . "." . substr($d, 0,4) . ". ". substr($d, 11,8);
										$o->Datum_isporuke=$d;
										echo $o->Datum_isporuke;
									}else {
										echo $o->Datum_isporuke;
									}
									?></td>
									
									
									<td><?php echo $o->Kolicina; ?></td>									
									<td><?php echo $o->Stanje; ?></td>
									<td><?php 
									if($o->Rok_trajanja!=""){
										$d = $o->Rok_trajanja;
										$d=substr($d, 8,2) . "." . substr($d, 5,2) . "." . substr($d, 0,4) . ".";
										$o->Rok_trajanja=$d;
										echo $o->Rok_trajanja;
									}else {
										echo $o->Rok_trajanja;
									}
									?>
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
			
			if($x==2):
			?>
			
			<div class="row">
				<div class="panel panelBorder">
				
					<div id="#porukaDonacije" data-alert class="large-6 large-centered columns alert-box info radius columns">
						Odaberite namirnice za donaciju!
						<a href="#" class="close">&times;</a>
					</div>
								<div class="large-7 large-centered columns">
									<table>
										<th>Napravi donaciju</th>
										<th>Naziv</th>
										<th>Jedinica mjere</th>
										<th>Količina</th>
										
								<form method="post" action="<?php echo $putanjaApp; ?>privatno/tvrtke/namirnice.php?active=2">		
									<?php
										foreach ($namirniceTrazene as $ot):			
									?>
									
									<tr>
										<td>
											<input style="margin: 0rem;" class="check" type="checkbox" name="doniraj[]" 
											value="<?php echo $ot->sifra; ?>" id="<?php echo $ot->sifra; ?>"/>
										</td>
										<td><?php echo $ot->naziv; ?></td>
										<td><?php echo $ot->jedinicaMjere; ?></td>
										<td><?php echo $ot->trazeno; ?></td>									
									</tr>
									
									<?php
									endforeach;
									?>
								
									</table>
									<input id="posaljiTrazeno" type="submit" class="button round" value="Napravi donaciju!" />
								</form>
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
												
						<form method="post" action="<?php echo $putanjaApp; ?>privatno/tvrtke/namirnice.php?active=3">
							<div class="row">
								<div class="large-12 columns">
									<div class="large-4 columns">
										<label for="naziv">Naziv namirnice</label>
										<input type="text" id="naziv" name="naziv"/>
									</div>
									<div class="large-3 end columns">
										<label for="kolicina">Količina</label>
										<input class="numbersOnly" type="text" id="kolicina" name="kolicina"/>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="large-12 columns">
									<div class="large-4 columns">
										<label for="jedinicaMjere">Jedinica mjere</label>
										<input type="text" id="jedinicaMjere" name="jedinicaMjere"/>
									</div>
									<div class="large-3 end columns">
										<label for="rokTrajanja">Rok trajanja</label>
										<input type="text" id="rokTrajanja" name="rokTrajanja"/>
									</div>
								</div>
							</div>	
								<!-- ajax sprema sifru namirnice, a nakon posta sifru sprema u sifraNamirnice -->
								<input type="hidden" id="sifra" name="sifra" value="" />
								
								<div class="marginTop05 large-3 end columns">
									<small class="porukanaziv error">Obavezno naziv namirnice!</small>
									<small class="porukakolicina error">Obavezno količinu namirnice!</small>
									
									<input id="posalji" type="submit" class="button round" value="Pošalji"/>
								</div>
						</form>
					
					</div>
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
		include_once 'modalUspjesnoDoniranje.php';
		?>
		
		<?php
		include_once '../../skripte.php';
		?>
		
		<?php
		include_once 'jQueryDonacija.php';
		?>
		<script src="<?php echo $putanjaApp; ?>js/vendor/jquery-ui.js"></script>
		
		<script>
		
		/* sakri button ako ništa nije označeno */
		
			$(document).ready(function(){
				$('#posaljiTrazeno').hide();
				
				$('input[class="check"]').change(function(){
				   
				    if ($('input[class="check"]:checked').length > 0) {
				        $('#posaljiTrazeno').show();
				    } else {
				        $('#posaljiTrazeno').hide();
				    }
				});
				
				/*
				$('#posaljiTrazeno').click(function(){
					return false;
				});
				*/
				
			});
		</script>
		
		<script>
			$(function() {
				
				 $("#jedinicaMjere").autocomplete({
				 	//trazi jedinicu mjere i sifru za spremanje
				    source: "traziJedinicuMjere.php",
				    minLength: 1,
				    focus: function( event, ui ) {
				    	event.preventDefault();
				    	},
				    select: function(event, ui) {
				       // alert(ui.item.jedinicaMjere);
				       
				        $("#jedinicaMjere").val(ui.item.jedinicaMjere);
				        
				        //uvijek probati
				        return false;
				    }
					}).data( "ui-autocomplete" )._renderItem = function( ul, namirnica ) {
						return $( "<li>" )
				        .append( "<a>" + namirnica.jedinicaMjere + "</a>" )
				        .appendTo( ul );						
				      
				    };
				    
			});
			
			
		</script>
		<script>	
			$(function() {
				
				
				
				$.datepicker.regional['hr'] = {
					closeText : 'Zatvori',
					prevText : 'Prethodni',
					nextText : 'Sljedeći',
					currentText : 'Trenutni',
					monthNames : ['Siječanj', 'Veljača', 'Ožujak', 'Travanj', 'Svibanj', 'Lipanj', 'Srpanj', 'Kolovoz', 'Rujan', 'Listopad', 'Studeni', 'Prosinac'],
					monthNamesShort : ['sij', 'velj', 'ožu', 'tra', 'svi', 'lip', 'srp', 'kol', 'ruj', 'lis', 'stu', 'pro'],
					dayNames : ['Nedjelja', 'Ponedjeljak', 'Utorak', 'Srijeda', 'Četvrtak', 'Petak', 'Subota'],
					dayNamesShort : ['ned', 'pon', 'uto', 'sri', 'čet', 'pet', 'sub'],
					dayNamesMin : ['N', 'P', 'U', 'S', 'Č', 'P', 'S'],
					weekHeader : 'Tjedan',
					dateFormat : 'dd.mm.yy.',
					firstDay : 1,
					isRTL : false,
					showMonthAfterYear : false,
					yearSuffix : '',
					changeMonth : true,
					changeYear : true,
					showButtonPanel : true,
					yearRange : '1940:2020'
				};
				$.datepicker.setDefaults($.datepicker.regional['hr']);

				var datum = document.getElementById('rokTrajanja').value;
				
				$("#rokTrajanja").datepicker();
				$("#rokTrajanja").datepicker("option", $.datepicker.regional['hr']);
				$("#rokTrajanja").val(datum);
				
				
				
				 $("#naziv").autocomplete({
				    source: "traziNamirnicu.php",
				    minLength: 1,
				    focus: function( event, ui ) {
				    	event.preventDefault();
				    	},
				    select: function(event, ui) {
						//alert(ui.item.sifra);
				        
				        $("#naziv").val(ui.item.naziv);
				        $("#sifra").val(ui.item.sifra);
				        //uvijek probati 
				        return false;
				    }
					}).data( "ui-autocomplete" )._renderItem = function( ul, namirnica ) {
						return $( "<li>" )
				        .append( "<a>" + namirnica.naziv + "</a>" )
				        .appendTo( ul );						
				      
				    };
				    
			});
		</script>
	</body>
</html>
