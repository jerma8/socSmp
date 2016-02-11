<?php
include_once '../../../konfig.php';
if (!isset($_SESSION['operater'])) {
	header("location: ../../../logout.php");
}


if($_POST){
	
	
	$izraz = $veza -> prepare("insert into tvrtka(naziv,adresa,mjesto,imeKontaktOsobe,prezimeKontaktOsobe,telKontaktOsobe,email) 
		values(:naziv,:adresa,:mjesto,:imeKontaktOsobe,:prezimeKontaktOsobe,:telKontaktOsobe,:email);");
		
		$izraz->execute($_POST);
		
		header("location: index.php");
}
?>
<!doctype html>
<html class="no-js" lang="en">
	<head>
		<?php
		include_once '../../../head.php';
		?>
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
									<h2 class="h25Font">Unos nove tvrtke</h2>
								</div>
								<div class="large-2 columns">
									<a id="nazad" class="button round right" href="<?php echo $putanjaApp; ?>privatno/operateri/tvrtke/index.php">Nazad</a>
								</div>

							</div>
							

							<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
								<fieldset>
									<div class="row">
										<div class="large-6 columns">
																					
											<label for="naziv">Naziv:</label>
											<input type="text" id="naziv" name="naziv" 
											value="<?php echo isset($_POST['naziv']) ? $_POST['naziv'] : ""; ?>"/>
											
											
											<label for="adresa">Adresa:</label>
											<input type="text" id="adresa" name="adresa" 
											value="<?php echo isset($_POST['adresa']) ? $_POST['adresa'] : ""; ?>"/>
											
											
											<label for="mjesto">Mjesto:</label>
											<input type="text" id="mjesto" name="mjesto" 
											value="<?php echo isset($_POST['mjesto']) ? $_POST['mjesto'] : ""; ?>"/>
											
												
											<label for="imeKontaktOsobe">Ime kontakt osobe:</label>
											<input type="text" id="imeKontaktOsobe" name="imeKontaktOsobe" 
											value="<?php echo isset($_POST['imeKontaktOsobe']) ? $_POST['imeKontaktOsobe'] : ""; ?>"/>
											
											
											<label for="prezimeKontaktOsobe">Prezime kontakt osobe:</label>
											<input type="text" id="prezimeKontaktOsobe" name="prezimeKontaktOsobe" 
											value="<?php echo isset($_POST['prezimeKontaktOsobe']) ? $_POST['prezimeKontaktOsobe'] : ""; ?>"/>
										
											
											<label for="telKontaktOsobe">Telefon kontakt osobe:</label>
											<input type="text" class="numbersOnly" id="telKontaktOsobe" name="telKontaktOsobe" 
											value="<?php echo isset($_POST['telKontaktOsobe']) ? $_POST['telKontaktOsobe'] : ""; ?>"/>
																						
											
											<label for="email">Email:</label>
											<input type="text" id="email" name="email" 
											value="<?php echo isset($_POST['email']) ? $_POST['email'] : ""; ?>"/>
											
								
										</div>
									</div>
									<input id="dodaj" class="button round" type="submit" value="Dodaj tvrtku!" />
								</fieldset>
							</form>
							
						</div>
					</div>
				</div>
				
				
				
				
				
				

		<?php
		include_once '../../../skripte.php';
		?>
		<script src="<?php echo $putanjaApp; ?>tooltipster/js/jquery.tooltipster.min.js"></script>
		<?php
		include_once 'jQueryTvrtke.php';
		?>
	</body>
</html>
