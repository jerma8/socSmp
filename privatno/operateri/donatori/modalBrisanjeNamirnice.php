<div id="myModal2BrisanjeNamirnice" class="reveal-modal tiny" data-reveal data-animation="fade" 
data-animationspeed="300" data-closeonbackgroundclick="false" data-closeonesc="false">
	<div id="kontejner">
		
	</div>
	
	<form method="post" action="doniraneNamirnice.php">
								
		<div class="row">
			<div class="large-12 columns">						
				<input type="hidden" id="hidSifraNamirnice" name="hidSifraNamirnice" value="" />
				<input type="hidden" name="sifraKorisnika" value="<?php echo $sifra; ?>" />
				<input type="hidden" id="hidDatum" name="hidDatum" value="" />
			</div>
		</div>
		<br />
		
		<div class="row collapse">
				<div class="large-6 columns">
					<input onclick="myFunction()" style="width: 100%;" id="" class="obrisiInput button" type="submit" value="DA" />
				</div>
				<div class="large-6 columns">
					<a style="color: white;" class="zatvori button alert close-reveal-modal">NE</a>
				</div>
		</div>
			
	</form>
</div>

<script>
function myFunction() {
    location.reload();
}
</script>
