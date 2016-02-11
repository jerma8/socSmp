
<div id="myModalBrisanje" class="reveal-modal tiny" data-reveal data-animation="fade" 
data-animationspeed="300" data-closeonbackgroundclick="false" data-closeonesc="false">
	<div id="kontejner">
		
	</div>
	
	<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
								
		<div class="row">
			<div class="large-12 columns">						
				<input type="hidden" name="sifra" value="<?php echo $_SESSION['sifraBrisanja']; ?>" />
			</div>
		</div>
		<br />
		
		<div class="row collapse">
				<div class="large-6 columns">
					<input style="width: 100%;" id="<?php echo $_SESSION['sifraBrisanja']; ?>" class="obrisi button" type="submit" value="DA" />
				</div>
				<div class="large-6 columns">
					<a style="color: white;" class="zatvori button alert close-reveal-modal">NE</a>
				</div>
		</div>
			
	</form>
</div>


