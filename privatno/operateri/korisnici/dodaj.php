<?php
include_once '../../../konfig.php';
if (!isset($_SESSION['operater'])) {
	header("location: ../../../logout.php");
}

$sifra = "";
$donatorSelect="";
if (isset($_GET['sifra'])) {
	$sifra = $_GET['sifra'];
}else
if(isset($_GET['d1'])){
	$donatorSelect=1;
}


if($_GET){
	//radi ispisa naziva i adrese u formu
	if(isset($_GET['sifra'])){
		$izraz = $veza->prepare("select * from tvrtka where sifra=:sifra");
		$izraz->bindParam(":sifra",$sifra);
		$izraz->execute();
		$tvrtka = $izraz->fetch(PDO::FETCH_OBJ);
		
		$_SESSION['sifraTvrtke']=$tvrtka->sifra;
	}	
}



if($_POST){
		$d = $_POST["datumRodenja"];
		$d=substr($d, 6,4) . "-" . substr($d, 3,2) . "-" . substr($d, 0,2);
		$_POST["datumRodenja"]=$d;
	
	
		$veza->beginTransaction();
		
		$izraz = $veza -> prepare("insert into korisnik(ime,prezime,oib,datumRodenja,adresa,mjesto,brojClanovaObitelji,korisnik,lozinka,uloga) 
		values(:ime,:prezime,:oib,:datumRodenja,:adresa,:mjesto,:brojClanovaObitelji,:korisnik,md5(:lozinka),:uloga)");
		
		unset($_POST['lozinka2']);
		$izraz->execute($_POST);
		
		$sifraOsobe = $veza->lastInsertId();
		
		//update sifraKorisnika u tablicu tvrtke radi izlistanja podataka o tvrtci
		
		$izraz = $veza -> prepare("update tvrtka set sifraKorisnika=:sifraOsobe where sifra=:sifra");
		$izraz->bindParam(":sifraOsobe",$sifraOsobe);
		$izraz->bindParam(":sifra",$_SESSION['sifraTvrtke']);
		$izraz->execute();
		
		unset($_SESSION['sifraTvrtke']);
		
		$veza->commit();
		
		//print_r($_POST);
		header("location: index.php");
}
?>
<!doctype html>
<html class="no-js" lang="en">
	<head>
		<?php
		include_once '../../../head.php';
		?>
	<link rel="stylesheet" href="<?php echo $putanjaApp; ?>css/jquery-ui.css" /> <!-- datum -->
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
									<h2 class="h25Font">Unos novog korisnika</h2>
								</div>
								<div class="large-2 columns">
									<a id="nazad" class="button round right" href="<?php echo $putanjaApp; ?>privatno/operateri/korisnici/index.php">Nazad</a>
								</div>

							</div>
							

							<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
								<fieldset>
									<div class="row">
										<div class="large-6 columns">
																					
																				
											<label for="ime">Ime:</label>
											<input type="text" id="ime" name="ime" 
											value="<?php
											if(isset($tvrtka->imeKontaktOsobe)){
												echo $tvrtka->imeKontaktOsobe;
											}else 
											if(isset($_POST['ime'])){
												echo $_POST['ime'];
											}
											?>"/>
											<!-- <small class="porukaime error"></small> -->
											
											
											<label for="prezime">Prezime:</label>
											<input type="text" id="prezime" name="prezime" 
											value="<?php
											if(isset($tvrtka->prezimeKontaktOsobe)){
												echo $tvrtka->prezimeKontaktOsobe;
											}else 
											if(isset($_POST['prezime'])){
												echo $_POST['prezime'];
											}
											?>"/>
											<!-- <small class="porukaprezime error"></small> -->
											
												
											<label for="oib">OIB:</label>
											<input type="text" class="numbersOnly" maxlength="11" id="oib" name="oib"
											value="<?php echo isset($_POST['oib']) ? $_POST['oib'] : ""; ?>"/>
											
											<!-- <small class="porukaoib error"><?php echo $poruka1; ?></small> -->
											
											
											<label for="datumRodenja">Datum rođenja:</label>
											<input type="text" id="datumRodenja" name="datumRodenja" 
											value="<?php echo isset($_POST['datumRodenja']) ? $_POST['datumRodenja'] : ""; ?>"/>
											<!-- <small class="porukadatum error"></small> -->
											
											
											<label for="adresa">Adresa:</label>
											<input type="text" id="adresa" name="adresa" 
											value="<?php
											if(isset($tvrtka->adresa)){
												echo $tvrtka->adresa;
											}else 
											if(isset($_POST['adresa'])){
												echo $_POST['adresa'];
											}
											?>"/>
											<!-- <small class="porukaadresa error"></small> -->
											
											
											<label for="mjesto">Mjesto:</label>
											<input type="text" id="mjesto" name="mjesto" 
											value="<?php
											if(isset($tvrtka->mjesto)){
												echo $tvrtka->mjesto;
											}else 
											if(isset($_POST['mjesto'])){
												echo $_POST['mjesto'];
											}
											?>"/>
											<!-- <small class="porukamjesto error"></small> -->
											
											
											<label for="brojClanovaObitelji">Broj članova obitelji:</label>
											<input type="text" class="numbersOnly19" autocomplete="off" id="brojClanovaObitelji" name="brojClanovaObitelji" 
											value="<?php echo isset($_POST['brojClanovaObitelji']) ? $_POST['brojClanovaObitelji'] : ""; ?>"/>
											<!-- <small class="porukaclanovi error"></small> -->
										</div>
										<div class="large-6 columns">
											<label for="korisnik">Korisničko ime:</label>
											<input type="text" id="korisnik" name="korisnik" 
											value="<?php echo isset($_POST['korisnik']) ? $_POST['korisnik'] : ""; ?>"/>
											<!-- <small class="porukakorisnik error"><?php echo $poruka2; ?></small> -->
											
											
											<label for="lozinka">Lozinka:</label>
											<input type="password" id="lozinka" name="lozinka" 
											value="<?php echo isset($_POST['lozinka']) ? $_POST['lozinka'] : ""; ?>"/>
											<!-- <small class="porukalozinka1 error"></small> -->
											
											
											<label for="lozinka2">Lozinka ponovo:</label>
											<input type="password" id="lozinka2" name="lozinka2" 
											value="<?php echo isset($_POST['lozinka2']) ? $_POST['lozinka2'] : ""; ?>"/>
											<!-- <small class="porukalozinka2 error"></small> -->
											<br />
											
											
											
											
											
											
											<label>Uloga:</label>
											<select id="obavezno" name="uloga">
													<option
													<?php
													if(isset($_POST["uloga"]) && $_POST["uloga"]=="primateljiPomoci"){
														echo "selected=\"selected\"";
													}
													?>
													value="primateljiPomoci">Korisnik</option>
													
													<option
													<?php
													if(isset($_POST["uloga"]) && $_POST["uloga"]=="admin"){
														echo "selected=\"selected\"";
													}
													?> 
													value="admin">Operater</option>
													
													<option
													<?php
													if((isset($_POST["uloga"]) && $_POST["uloga"]=="donator") || $donatorSelect==1){
														echo "selected=\"selected\"";
													}
													?>
													value="donator">Donator</option>
													
													<option
													<?php
													if(isset($tvrtka->naziv) || (isset($_POST["uloga"]) && $_POST["uloga"]=="tvrtka")){
														echo "selected=\"selected\"";
													}
													?>
													value="tvrtka">Tvrtka</option>
												</select>
												<div data-alert class="alert-box info radius">
												  Obavezno odabrati valjanu ulogu!
												  <a href="#" class="close">&times;</a>
												</div>
						
										</div>
									</div>
									<input id="dodaj" class="button round" type="submit" value="Dodaj korisnika!" />
								</fieldset>
							</form>
							
						</div>
					</div>
				</div>
				
				
				

		<?php
		include_once '../../../skripte.php';
		?>
		<script src="<?php echo $putanjaApp; ?>tooltipster/js/jquery.tooltipster.min.js"></script>
		<script src="<?php echo $putanjaApp; ?>js/vendor/jquery-ui.js"></script>
		<?php
		include_once 'jQueryKorisnici.php';
		?>
		
		
	</body>
</html>
