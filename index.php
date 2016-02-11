<?php
include_once 'konfig.php';

$poruka="";

if($_POST){
		
	if(isset($_POST["korisnik"]) && isset($_POST["lozinka"])){
				
		$izraz = $veza->prepare("select * from korisnik where korisnik=:korisnik and lozinka=:lozinka");
		
		$k=$_POST["korisnik"];
		$izraz->bindParam(":korisnik",$k);
		$l=md5($_POST["lozinka"]);
		$izraz->bindParam(":lozinka",$l);

		$izraz->execute();
		$objekt = $izraz->fetch(PDO::FETCH_OBJ);
		
		if($objekt!=null){
			//ispitaj tko je logiran			
			if ($objekt->uloga=="admin") {
				$_SESSION["operater"]=$objekt;
				$_SESSION['vrijeme'] = date('H:i:s d-m-Y');
				//header("location: privatno/pocetnaPrivatno.php");	
			}else
			if ($objekt->uloga=="primateljiPomoci") {
				$_SESSION["korisnik"]=$objekt;
				$_SESSION['vrijeme'] = date('Y-m-d H:i:s');
				//header("location: privatno/pocetnaPrivatno.php");	
			}else
			if ($objekt->uloga=="tvrtka") {
				$_SESSION["tvrtka"]=$objekt;
				$_SESSION['vrijeme'] = date('Y-m-d H:i:s');
				//header("location: privatno/pocetnaPrivatno.php");	
			}else
			if ($objekt->uloga=="donator") {
				$_SESSION["donator"]=$objekt;
				$_SESSION['vrijeme'] = date('Y-m-d H:i:s');
				//header("location: privatno/pocetnaPrivatno.php");	
			}
	
		}
	
	}
}

?>
<!doctype html>
<html class="no-js" lang="en">
	<head>
		<?php
			include_once 'head.php';
		?>
	</head>
	<body>
				<?php
					include_once 'zaglavlje.php';
				?>


				<!-- TIJELO ZA LARGE I MEDIUM -->
				<div class="row marginBottom80">
					<div class="large-12 hide-for-small columns">
						<q class="right quote"><i>Pomogni sebi pomaganjem drugima. - J.M.T.</i></q>
						<br />
						<br />
							<h1 class="h1Font">Socijalna <br/>&nbsp;&nbsp;&nbsp;&nbsp;
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;samoposluga</h1>   
							<!-- FONT BODY I H1 H2 H3 -->
							
							
					</div>
				</div>
				
				
				
				<div class="panel white">	</div>
				
				
				
				
				
				<div class="row krugovi">
					<div id="oNamaKrug" class="whiteCirclePaddingLeft large-2 columns">
						<div class="panel whiteCircle">
							<img src="img/oNama-icon.png" alt=""/>
						</div>
					</div>
					<div id="kontaktKrug" class="whiteCirclePaddingMiddle large-2 columns">
						<div class="panel whiteCircle">
							<img src="img/kontakt-icon.png" alt=""/>
						</div>
					</div>
					<div id="gdjeSmoKrug" class="whiteCirclePaddingRight large-2 end columns">
						<div class="panel whiteCircle">
							<img src="img/gdjeSmo-icon.png" alt=""/>
						</div>
					</div>	
				</div>
				
				

				<div class="row krugovi">
					<div class="textPadding large-2 columns">
						<p class="meniBar">O&nbsp;NAMA</p>
					</div>
					<div class="textPadding large-2 columns">
						<p class="meniBar">KONTAKT</p>
					</div>
					<div class="textPadding large-2 end columns">
						<p class="meniBar">GDJE&nbsp;SMO</p>
					</div>
				</div>


				<div class="potpis">
						<label class="right">&copy; Damir Majer 07.03.2015.</label>
				</div>
			
				
				<?php
				include_once 'oNama.php';
				?>
				
				
				<?php
				include_once 'kontakt.php';
				?>
				
				
				<?php
				include_once 'gdjeSmo.php';
				?>
				
				
				

<?php
if(isset($objekt)):
?>

<div id="podloga" style="display: block;">
	<div id="mojModal">
		<?php
		if($objekt==null):
		?>
		<h4 class="h4Font">
		<b>Neispravno korisničko ime ili lozinka!</b>
		<br />
		<a href="index.php">Nazad</a>
		</h4>
		<?php
		else:
		?>
		<h4 class="h4Font">
		<b>Uspješno ste logirani!</b>
		<br />
		<a href="privatno/	
		<?php 
		
			//ispitaj tko je logiran			
			if (isset($objekt->uloga) && $objekt->uloga=="admin") {
				echo "operateri";
			}else
			if (isset($objekt->uloga) && $objekt->uloga=="primateljiPomoci") {
				echo "korisnici";
			}else
			if (isset($objekt->uloga) && $objekt->uloga=="adminPrimateljPomoci") {
				echo "operaterKorisnici";
			}else
			if (isset($objekt->uloga) && $objekt->uloga=="tvrtka") {
				echo "tvrtke";
			}else
			if (isset($objekt->uloga) && $objekt->uloga=="donator") {
				echo "donatori";
			}
	
		?>/index.php">Idi na nadzornu ploču</a>
		</h4>
		<?php
		endif;
		
		//if ((isset($objekt->uloga) && $objekt->uloga=="admin") || (isset($objekt->uloga) && $objekt->uloga=="adminPrimateljPomoci")):
		?>
		<!-- <h4 class="h4Font">
			<a href="#">Aplikacija za skladište</a> <!--privatno/skladiste/index.php -->
		<!--	
		</h4> -->
		<?php
		//endif;
		?>
	</div>
</div>

<?php
endif;
?>

		<?php include_once 'skripte.php'; ?>
		<?php include_once 'jQueryAutorizacija.php'; ?>
		<?php include_once "meniSkripta.php"; ?>
		
		
	</body>
</html>
