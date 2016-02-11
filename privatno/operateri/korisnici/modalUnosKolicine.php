<div style="height: 20rem;" id="myModalKolicina" class="reveal-modal tiny" data-reveal data-animation="fade" 
data-animationspeed="300" data-closeonbackgroundclick="false" data-closeonesc="false">
		
		
		<div class="row">
			<div class="large-12 columns">
				<h2 class="h5Font">Količina</h2>
				<input style="margin: 0;" class="numbersOnly" autocomplete="off" type="text" id="kolicina" name="kolicina" />
				<input type="hidden" id="sifraNamirnice" name="sifraNamirnice" value="" />
				<input type="hidden" id="sifraKorisnika" name="sifraKorisnika" value="<?php echo $sifra; ?>" />
				<input type="hidden" id="kvotaPoClanu" name="kvotaPoClanu" value=""/>
				<input type="hidden" id="trenutnaKolicina" name="trenutnaKolicina" value=""/>
				<small style="margin: 0;" class="error" id="porukaUnosKolicine">Unesite količinu!</small>
			</div>
		</div>
		<br />
		
		<div id="kontejnerStanje">
			
		</div>
		
		<div class="row collapse">
				<div class="large-6 columns">
					<a id="otvoriKolicinu" style="width: 100%; color:white;" class="obrisiNovi button">DA</a>
				</div>
				<div class="large-6 columns">
					<a style="color: white;" class="zatvori button alert close-reveal-modal">NE</a>
				</div>
		</div>
	
</div>



