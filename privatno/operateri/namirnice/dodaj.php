<?php
include_once '../../../konfig.php';
if (!isset($_SESSION['operater'])) {
	header("location: ../../../logout.php");
}


//Ako dođe sa GET sifrom - tvrtka donira namirnicu
//1.select from donira i ubaci value naziv, kolicinu, jedinicu mjere 
$sifra = "";
if (isset($_GET['sifra']) && $_GET['sifra']!="") {
	$sifraNamirnice = $_GET['sifra'];
}
if (isset($_GET['donator']) && $_GET['donator']!="") {
	$_SESSION['dosaoDonator']=$_GET['donator'];
}


if($_GET){
	$_SESSION['sifra']=$sifraNamirnice;
	
	$izraz = $veza -> prepare("
	select * from pripremaDonacije
	where sifra=:sifra;
	");
	$izraz->bindParam(":sifra",$sifraNamirnice);
	$izraz->execute();
	$objektIzPripreme = $izraz->fetch(PDO::FETCH_OBJ);
	
	//dovlaci barkod, kvote, TRAZENO iz tablice namirnica
	$izraz = $veza -> prepare("
	select barkod,jedinicaMjere,kvotaPoDanu,kvotaPoClanu,trazeno from namirnica
	where sifra=:sifra;
	");
	$izraz->bindParam(":sifra",$objektIzPripreme->sifraNamirnice);
	$izraz->execute();
	$objektIzNamirnica = $izraz->fetch(PDO::FETCH_OBJ);
	
	//uzima sifru iz priprema donacije
	if(isset($objektIzPripreme->sifraNamirnice) && $objektIzPripreme->sifraNamirnice!=null){
		$_SESSION['sifraNamirnice']= $objektIzPripreme->sifraNamirnice;	
	}else {
		$_SESSION['sifraNamirnice']=null;
	}
	
	if(isset($objektIzPripreme->sifraTvrtke) && $objektIzPripreme->sifraTvrtke!=null){
		$_SESSION['sifraTvrtke']= $objektIzPripreme->sifraTvrtke;	
	}else {
		$_SESSION['sifraTvrtke']=null;
	}
	
	if(isset($objektIzPripreme->rokTrajanja) && $objektIzPripreme->rokTrajanja!=null){
		$_SESSION['rokTrajanja']= $objektIzPripreme->rokTrajanja;	
	}else {
		$_SESSION['rokTrajanja']=null;
	}
	
	
	if(isset($objektIzNamirnica->trazeno) && $objektIzNamirnica->trazeno!=0){
		$_SESSION['trazeno']=$objektIzNamirnica->trazeno;
	}
	
}else {
	$_SESSION['normalanUnos'] = 1;
	//echo $_SESSION['normalanUnos'];
}
/*
echo "sifra =".$_SESSION['sifra']."<br>sifra namirnice ->".$_SESSION['sifraNamirnice'].
"<br>sifra tvrtke ->".$_SESSION['sifraTvrtke']."<br>rokTrajanja ->".$_SESSION['rokTrajanja']."<br>donator".$_SESSION['dosaoDonator']
."<br>normUnos".$normalanUnos;
*/

if($_POST){
	
	$date = date('Y-m-d H:i:s');
	
	
	//AKO NAMIRNICE POSTOJI U NAMIRNICAMA
	if(isset($_SESSION['sifraNamirnice']) && $_SESSION['sifraNamirnice']!=""){
		
		$veza->beginTransaction();
				
		//BRISANJE
		$izraz = $veza -> prepare("delete from pripremaDonacije where sifra=:sifra");
		$izraz->bindParam(":sifra",$_SESSION['sifra']);
		$izraz->execute();
		
		//update stanja
		$izraz = $veza -> prepare("update namirnica set stanje=stanje+:stanjeNovo where sifra=:sifraNamirnice");
		$izraz->bindParam(":stanjeNovo",$_POST['kolicina']);
		$izraz->bindParam(":sifraNamirnice",$_SESSION['sifraNamirnice']);
		$izraz->execute();
		
		
		
		
		//update traženo
		if($_SESSION['trazeno']<=$_POST['kolicina']){
			//stavi trazeno na 0
			$izraz = $veza -> prepare("update namirnica set trazeno=0 where sifra=:sifraNamirnice");
			$izraz->bindParam(":sifraNamirnice",$_SESSION['sifraNamirnice']);
			$izraz->execute();
		}else{
		//ako je traženo veće od donacije, umanji traženo na donaciju
			$izraz = $veza -> prepare("update namirnica set trazeno=trazeno-:stanjeNovo where sifra=:sifraNamirnice");
			$izraz->bindParam(":stanjeNovo",$_POST['kolicina']);
			$izraz->bindParam(":sifraNamirnice",$_SESSION['sifraNamirnice']);
			$izraz->execute();
			
		}
		
		
		
			if(isset($_SESSION['dosaoDonator'])){
				$tvrtke=null;
				//echo "sdadasdasdas";
				//INSERT DONIRA  TVRTKA - AKO DODE SAMO SA SIFROM
				$izraz = $veza -> prepare("insert into donira(sifraTvrtke,sifraKorisnika,sifraNamirnice,datumIsporuke,kolicina,rokTrajanja) 
				values(:sifraTvrtke,:sifraKorisnika,:sifraNamirnice,:datumIsporuke,:kolicina,:rokTrajanja)");
				
				$izraz->bindParam(":sifraTvrtke",$tvrtke);
				$izraz->bindParam(":sifraKorisnika",$_SESSION['dosaoDonator']);
				$izraz->bindParam(":sifraNamirnice",$_SESSION['sifraNamirnice']);
				$izraz->bindParam(":datumIsporuke",$date);
				$izraz->bindParam(":kolicina",$_POST['kolicina']);
				$izraz->bindParam(":rokTrajanja",$_SESSION['rokTrajanja']);
				$izraz->execute();
				
			}else {
				//echo "11";
				$donator=null;
				
				//INSERT DONIRA KORISNIK - AKO DODE SA DONATOR I SIFROM
				$izraz = $veza -> prepare("insert into donira(sifraTvrtke,sifraKorisnika,sifraNamirnice,datumIsporuke,kolicina,rokTrajanja) 
				values(:sifraTvrtke,:sifraKorisnika,:sifraNamirnice,:datumIsporuke,:kolicina,:rokTrajanja)");
				
				$izraz->bindParam(":sifraTvrtke",$_SESSION['sifraTvrtke']);
				$izraz->bindParam(":sifraKorisnika",$donator);
				$izraz->bindParam(":sifraNamirnice",$_SESSION['sifraNamirnice']);
				$izraz->bindParam(":datumIsporuke",$date);
				$izraz->bindParam(":kolicina",$_POST['kolicina']);
				$izraz->bindParam(":rokTrajanja",$_SESSION['rokTrajanja']);
				$izraz->execute();
			}
		
		
		
			
		$veza->commit();
		
		unset($_SESSION['sifra']);
		unset($_SESSION['sifraNamirnice']);
		//ne smijem unset jer me neće baciti na donacije te tvrtke - ali napravi unset na donacijama
		//unset($_SESSION['sifraTvrtke']);
		unset($_SESSION['rokTrajanja']);
		
		 
		 
//prebacujue nazad

		header("location: ".$putanjaApp."privatno/operateri/namirnice/index.php");
		

	
		
		//AKO NEMA SIFRE NAMIRNICE	
		}
		else if(!isset($_SESSION['sifraNamirnice'])){
		
		$veza->beginTransaction();
		
		//BRISANJE
		$izraz = $veza -> prepare("delete from pripremaDonacije where sifra=:sifra");
		$izraz->bindParam(":sifra",$_SESSION['sifra']);
		$izraz->execute();
		
		
		//insert nove namirnice jer ne postoji u namirnicama	
		$izraz = $veza -> prepare("insert into namirnica(barkod,naziv,jedinicaMjere,kvotaPoDanu,kvotaPoClanu,stanje) 
		values(:barkod,:naziv,:jedinicaMjere,:kvotaPoDanu,:kvotaPoClanu,:kolicina)");
		$izraz->execute($_POST);
		
		
		$sifraNoveNamirnice = $veza->lastInsertId();
		
		
			if(isset($_SESSION['dosaoDonator'])){
				
				$tvrtke=null;
				//INSERT DONIRA  TVRTKA - AKO DODE SAMO SA SIFROM
				$izraz = $veza -> prepare("insert into donira(sifraTvrtke,sifraKorisnika,sifraNamirnice,datumIsporuke,kolicina,rokTrajanja) 
				values(:sifraTvrtke,:sifraKorisnika,:sifraNamirnice,:datumIsporuke,:kolicina,:rokTrajanja)");
				
				$izraz->bindParam(":sifraTvrtke",$tvrtke);
				$izraz->bindParam(":sifraKorisnika",$_SESSION['dosaoDonator']);
				$izraz->bindParam(":sifraNamirnice",$sifraNoveNamirnice);
				$izraz->bindParam(":datumIsporuke",$date);
				$izraz->bindParam(":kolicina",$_POST['kolicina']);
				$izraz->bindParam(":rokTrajanja",$_SESSION['rokTrajanja']);
				$izraz->execute();
				
			}else {
				
				$donator=null;
				
				//INSERT DONIRA TVRTKA
				$izraz = $veza -> prepare("insert into donira(sifraTvrtke,sifraKorisnika,sifraNamirnice,datumIsporuke,kolicina,rokTrajanja) 
				values(:sifraTvrtke,:sifraKorisnika,:sifraNamirnice,:datumIsporuke,:kolicina,:rokTrajanja)");
				
				$izraz->bindParam(":sifraTvrtke",$_SESSION['sifraTvrtke']);
				$izraz->bindParam(":sifraKorisnika",$donator);
				$izraz->bindParam(":sifraNamirnice",$sifraNoveNamirnice);
				$izraz->bindParam(":datumIsporuke",$date);
				$izraz->bindParam(":kolicina",$_POST['kolicina']);
				$izraz->bindParam(":rokTrajanja",$_SESSION['rokTrajanja']);
				$izraz->execute();
			}
				
		$veza->commit();
		
		unset($_SESSION['sifra']);
		unset($_SESSION['sifraNamirnice']);
		//unset($_SESSION['sifraTvrtke']);
		unset($_SESSION['rokTrajanja']);
		
		
//prebacujue nazad

		header("location: ".$putanjaApp."privatno/operateri/namirnice/index.php");

	}
	
	
}
 
 
?>
<!doctype html>
<html class="no-js" lang="en">
	<head>
		<?php
		include_once '../../../head.php';
		?>
		<link rel="stylesheet" href="<?php echo $putanjaApp; ?>css/jquery-ui.css" />
		<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.0.min.js"></script>
   		<link rel="stylesheet" href="<?php echo $putanjaApp; ?>tooltipster/css/tooltipster.css"/>
	</head>
	<body>
				<?php
				include_once '../../../zaglavlje.php';
				?>

				<div class="row marginBottom20 textCenter">
			<div class="large-12 columns">
				<br />
				<h1 class="h1Font2">Socijalna&nbsp;&nbsp;&nbsp;samoposluga</h1>
				<!-- FONT BODY I H1 H2 H3 -->

			</div>
		</div>


				<div class="row">
					<div class="large-12 columns">
						<div class="panel podloga margin-1">
							<div class="row">
								<div class="large-6 columns">
									<h2 class="h25Font">Unos nove namirnice</h2>
								</div>
								<div class="large-2 columns">
									<a id="nazad" class="button round right" href="<?php echo $putanjaApp; ?>privatno/operateri/namirnice/index.php">Nazad</a>
								</div>

							</div>
							
							

							<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
								<fieldset>
									<div class="row">
										<div class="large-6 columns">
																			
											<label for="barkod">Barkod:</label>
											<input type="text" class="numbersOnly" id="barkod" name="barkod"
											value="<?php echo isset($objektIzNamirnica->barkod) ? $objektIzNamirnica->barkod : ""; ?>"/>
											
											
											
											<label for="naziv">Naziv:</label>
											<input type="text" id="naziv" name="naziv" 
											value="<?php echo isset($objektIzPripreme->naziv) ? $objektIzPripreme->naziv : ""; ?>"/>
											
											
												
											<label for="jedinicaMjere">Jedinica mjere:</label>
											<input type="text" id="jedinicaMjere" name="jedinicaMjere" 
											value="<?php
											if(isset($objektIzNamirnica->jedinicaMjere)){
												echo $objektIzNamirnica->jedinicaMjere;
											}else
											if(isset($objektIzPripreme->jedinicaMjere)){
												echo $objektIzPripreme->jedinicaMjere;
											}else {
												echo "";
											}?>"/>
											
											
											
											
											<label for="kvotaPoDanu">Kvota po danu:</label>
											<input type="text" autocomplete="off" class="numbersOnly" id="kvotaPoDanu" name="kvotaPoDanu" 
											value="<?php echo isset($objektIzNamirnica->kvotaPoDanu) ? $objektIzNamirnica->kvotaPoDanu : ""; ?>"/>
											
											
											
											<label for="kvotaPoClanu">Kvota po članu:</label>
											<input type="text" autocomplete="off" class="numbersOnly" id="kvotaPoClanu" name="kvotaPoClanu" 
											value="<?php echo isset($objektIzNamirnica->kvotaPoClanu) ? $objektIzNamirnica->kvotaPoClanu : ""; ?>"/>
											
											
											
											<label for="kolicina">Količina:</label>
											<input type="text" autocomplete="off" class="numbersOnly" id="kolicina" name="kolicina"											
											value="<?php echo isset($objektIzPripreme->kolicina) ? $objektIzPripreme->kolicina : ""; ?>"/>
											
							
											
										</div>
										
									</div>
									<input id="dodaj" class="button round" type="submit" value="Dodaj namirnicu!" />
								</fieldset>
							</form>
						
						</div>
					</div>
				</div>

		<?php
		include_once '../../../skripte.php';
		?>
		<script src="<?php echo $putanjaApp; ?>js/vendor/jquery-ui.js"></script>
		<script src="<?php echo $putanjaApp; ?>tooltipster/js/jquery.tooltipster.min.js"></script>
		<?php
		include_once 'jQueryNamirnice.php';
		?>
		<script>
			$(function() {
				
				 $("#jedinicaMjere").autocomplete({
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
		
	</body>
</html>
