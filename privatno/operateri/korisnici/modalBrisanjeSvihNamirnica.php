<div style="top: 10rem;" id="myModal2BrisanjeSvihNamirnica" class="reveal-modal tiny" data-reveal data-animation="fade" 
data-animationspeed="300" data-closeonbackgroundclick="false" data-closeonesc="false">
	<div id="kontejner2">
		
	</div>
	
	<form method="post" action="namirnice.php">
								
		<div class="row">
			<div class="large-12 columns">
				<input type="hidden" name="sifraKorisnika" value="<?php echo $sifra; ?>" />
			</div>
		</div>
		<br />
		
		<div class="row collapse">
				<div class="large-6 columns">
					<input style="width: 100%;" id="" class="obrisiInput button" type="submit" value="DA" />
				</div>
				<div class="large-6 columns">
					<a style="color: white;" class="zatvori button alert close-reveal-modal">NE</a>
				</div>
		</div>
			
	</form>
</div>


