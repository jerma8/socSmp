<?php
include_once '../../konfig.php';
if (!isset($_SESSION["operater"])) {
	header("location: ../../logout.php");
}

?>
<!doctype html>
<html class="no-js" lang="en">
	<head>
		<?php
		include_once '../../head.php';
		?>
	</head>
	<body>
		<?php
		include_once '../../zaglavlje.php';
		?>

		<!-- TIJELO ZA LARGE I MEDIUM -->
		<div class="row marginBottom20">
			<div class="large-12 columns">
				<q class="right quote"><i>Pomogni sebi pomaganjem drugima. - J.M.T.</i></q>
				<br />
				<br />
				<h1 class="h1Font">Socijalna
				<br/>
				&nbsp;&nbsp;&nbsp;&nbsp;
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;samoposluga</h1>
				<!-- FONT BODY I H1 H2 H3 -->

			</div>
		</div>
<hr id="meniBarLinija1operateri" />
<div class="row relativePositionOperateri">		
	<div class="large-5 columns">
		
		
		<div id="<?php echo $_SESSION['operater']->sifra; ?>" class="panel pricingPanel">
					
					<ul class="pricing-table">
						<?php
						if(isset($_SESSION['vrijeme'])):
						?>										  
							<li id="podlogaNone" class="opis"><?php echo "Logiran od: " . $_SESSION['vrijeme']; ?></li>
						<?php
						endif;
						?>
							<caption>
								<img id="pricingImage" src="../../img/korisnici/def.jpg" />
							</caption>
							
							<li id="podlogaNone" class="naziv"><?php echo $_SESSION['operater'] -> ime . " " . $_SESSION['operater'] -> prezime; ?></li>
						
					</ul>
										
				</div>
	</div>
	
		
	<div class="large-7 relativePositionMeniOperateri columns">	
		<div id="meniRadius" class="icon-bar five-up">
		  
		  <a href="<?php echo $putanjaApp; ?>index.php" id="prvaIkonaOperateri" class="ikone item">
		    <img src="<?php echo $putanjaApp; ?>css/foundation-icons/svgs/fi-home1.svg" >
		    <label>Početna</label>
		  </a>
		  
		  <a href="<?php echo $putanjaApp; ?>privatno/operateri/korisnici/index.php" id="drugaIkona" class="ikone item">
		    <img src="<?php echo $putanjaApp; ?>css/foundation-icons/svgs/fi-torsos-all1.svg" >
		    <label>Korisnici</label>
		  </a>
		  
		  <a href="<?php echo $putanjaApp; ?>privatno/operateri/namirnice/index.php" id="trecaIkonaOperateri" class="ikone item">
		    <img src="<?php echo $putanjaApp; ?>css/foundation-icons/svgs/fi-shopping-cart1.svg" >
		    <label>Namirnice</label>
		  </a>
		  
		  <a href="<?php echo $putanjaApp; ?>privatno/operateri/tvrtke/index.php" class="ikone item">
		    <img src="<?php echo $putanjaApp; ?>css/foundation-icons/svgs/fi-torso-business1.svg" >
		    <label>Tvrtke</label>
		  </a>
		  
		  <a href="<?php echo $putanjaApp; ?>privatno/operateri/donacije/index.php" class="ikone item">
		    <img src="<?php echo $putanjaApp; ?>css/foundation-icons/svgs/fi-first-aid1.svg" >
		    <label>Donacije (
		    <?php
		    $izraz = $veza -> prepare("
			select count(distinct sifraTvrtke) as broj from pripremaDonacije;
			");
			$izraz -> execute();
			$brojDonacija = $izraz -> fetchAll(PDO::FETCH_OBJ);
			foreach ($brojDonacija as $key) {
				echo $key->broj;
			}
		    
		    ?>		    	
		    )</label>
		  </a>
		 
		  <a href="<?php echo $putanjaApp; ?>privatno/operateri/narudzbe/index.php" class="ikone item">
		    <img src="<?php echo $putanjaApp; ?>css/foundation-icons/svgs/fi-archive1.svg" >
		    <label>Narudžbe (
		    <?php
		    $izraz = $veza -> prepare("
			select count(sifra) as broj from narudzba
			");
			$izraz -> execute();
			$brojNarudzbi = $izraz -> fetchAll(PDO::FETCH_OBJ);
			foreach ($brojNarudzbi as $key) {
				echo $key->broj;
			}
		    ?>
		    )</label>
		  </a>
		  
		  
		  
		  
		  
		  
		  <!-- TREBA RIJEŠITI -->
		  <a href="<?php echo $putanjaApp; ?>privatno/operateri/donatori/index.php"  id="cetvrtaIkonaOperateri" class="ikone item">
		    <img src="<?php echo $putanjaApp; ?>css/foundation-icons/svgs/fi-torso-business1.svg" >
		    <label>Donatori<br/>(osobe)</label>
		  </a>
		  
		   
		   <!-- TREBA RIJEŠITI -->
		  <a href="<?php echo $putanjaApp; ?>privatno/operateri/donacijeDonatora/index.php" class="ikone item">
		    <img src="<?php echo $putanjaApp; ?>css/foundation-icons/svgs/fi-first-aid1.svg" >
		    <label>Donacije osoba <br />(
		    <?php
		    $izraz = $veza -> prepare("
			select count(distinct sifraKorisnika) as broj from pripremaDonacije;
			");
			$izraz -> execute();
			$brojDonacija = $izraz -> fetchAll(PDO::FETCH_OBJ);
			foreach ($brojDonacija as $key) {
				echo $key->broj;
			}
		    
		    ?>		    	
		    )</label>
		  </a>
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
		include_once '../../skripte.php';
		?>
		
		<script>
		$(document).ready(function(){
			
			$(".pricingPanel").click(function(){
							
				$.ajax({
						type : "GET",
						url : "pokupiDetalje.php?sifra=" + $(this).attr("id"),
						cache : false,
						success : function(data) {

							$("#kontejner").html(data);
							$('#myModal2').foundation('reveal','open');
						}
					});
					
					
				return true;
			});
	
		});
			
		</script>
		
	</body>
</html>
