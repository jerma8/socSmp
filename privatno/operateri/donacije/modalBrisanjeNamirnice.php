<div id="myModalBrisanjeNamirnice" class="reveal-modal tiny" data-reveal data-animation="fade" 
data-animationspeed="300" data-closeonbackgroundclick="false" data-closeonesc="false">
	
	<h2 class="h25Font">Brisanje namirnice</h2><h2 id="nazivNamirnice" class="h25Font"></h2>
	<hr class="hrLinija" />
	
	
		<div class="row collapse">
			<div class="large-12 columns">
				<div class="large-6 columns">
					<a onclick="myFunction()" style="width: 100%; color:white;" id="" class="obrisi potvrdaBrisanja button close-reveal-modal">DA</a>
				<!-- href="<?php echo $putanjaApp; ?>privatno/operateri/donacije/pripremaDonacijeTvrtke.php<?php echo "?sifra=".$sifra; ?>" -->
				</div>
				<div class="large-6 columns">
					<a style="color: white;" class="zatvori button alert close-reveal-modal">NE</a>
				</div>
			</div>
		</div>
	

</div>


<script>
function myFunction() {
    location.reload();
}
</script>