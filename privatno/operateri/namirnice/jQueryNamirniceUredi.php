<script>
	$(document).ready(function(){
		
		//dozvoljava samo numbers u input
		$('.numbersOnly').keyup(function () { 
    		this.value = this.value.replace(/[^0-9\.]/g,'');
		});
		
		
		$(window).keypress(function() {
					$('#barkod').tooltipster('hide');
					$('#naziv').tooltipster('hide');
					$('#jedinicaMjere').tooltipster('hide');
					$('#kvotaPoDanu').tooltipster('hide');
					$('#kvotaPoClanu').tooltipster('hide');
					$('#kolicina').tooltipster('hide');
					$('#stanje').tooltipster('hide');
					$('#trazeno').tooltipster('hide');
				});



				$('#barkod').tooltipster({
					position : 'right',
					offsetX : '0px',
					offsetY : '95px',
					effect: "fade",
					trigger : 'custom'

				});
				//BARKOD TRAZI U BAZI - AJAX  - prođe ako je isti broj
				$("#barkod").focusout(function() {

						$.ajax({
							type : "POST",
							url : "provjeriBarkodPromjena.php",
							data : "barkod=" + $('#barkod').val() + "&sifraNamirnice=" + <?php echo $sifra; ?>,
							cache : false,
							success : function(data) {
								//alert(data);
								if (data == "POSTOJI") {
									$('#barkod').tooltipster('content', 'Ovaj barkod se koristi.');
									$('#barkod').tooltipster('show');
									$("#barkod").focus().select();
									return false;
								}
								
							}
						});
					});
				

				$('#naziv').tooltipster({
					position : 'right',
					offsetX : '0px',
					offsetY : '95px',
					effect: "fade",
					trigger : 'custom'

				});

				$('#jedinicaMjere').tooltipster({
					position : 'right',
					offsetX : '0px',
					offsetY : '95px',
					effect: "fade",
					trigger : 'custom'

				});
				
				
				$('#kvotaPoDanu').tooltipster({
					position : 'right',
					offsetX : '0px',
					offsetY : '95px',
					effect: "fade",
					trigger : 'custom'

				});

				$('#kvotaPoClanu').tooltipster({
					position : 'right',
					offsetX : '0px',
					offsetY : '95px',
					effect: "fade",
					trigger : 'custom'

				});
				
				$('#kolicina').tooltipster({
					position : 'right',
					offsetX : '0px',
					offsetY : '95px',
					effect: "fade",
					trigger : 'custom'

				});
				
				$('#stanje').tooltipster({
					position : 'right',
					offsetX : '0px',
					offsetY : '95px',
					effect: "fade",
					trigger : 'custom'

				});
				
				$('#trazeno').tooltipster({
					position : 'right',
					offsetX : '0px',
					offsetY : '95px',
					effect: "fade",
					trigger : 'custom'

				});
				
$("#promijeni").click(function(){
				
				//BARKOD
					var barkod = $('#barkod').val();

					if (barkod.length == 0) {

						$('#barkod').tooltipster('content', 'Obavezno barkod!');
						$('#barkod').tooltipster('show');
						$("#barkod").focus().select();
						return false;
					}
					
				
				//NAZIV
					var naziv = $('#naziv').val();
					var naziv_regex = /^[a-zA-Z ćĆčČđĐšŠžŽ.()]{2,50}$/;

					if (naziv.length == 0) {

						$('#naziv').tooltipster('content', 'Obavezno naziv!');
						$('#naziv').tooltipster('show');
						$("#naziv").focus().select();
						return false;
					}

					if (!naziv.match(naziv_regex)) {

						$('#naziv').tooltipster('content', 'Dozvoljena samo slova.');
						$('#naziv').tooltipster('show');
						$("#naziv").focus().select();
						return false;
					}
								
				
				
				//JEDINICA MJERE
					var jedinicaMjere = $('#jedinicaMjere').val();

					if (jedinicaMjere.length == 0) {

						$('#jedinicaMjere').tooltipster('content', 'Obavezno jedinica mjere!');
						$('#jedinicaMjere').tooltipster('show');
						$("#jedinicaMjere").focus().select();
						return false;
					}

					
					
					
					
				//KVOTA PO DANU
					var kvotaPoDanu = $('#kvotaPoDanu').val();
	
					if (kvotaPoDanu.length == 0) {
	
						$('#kvotaPoDanu').tooltipster('content', 'Obavezno kvota po danu!');
						$('#kvotaPoDanu').tooltipster('show');
						$("#kvotaPoDanu").focus().select();
						return false;
					}
					
				
				//KVOTA PO ČLANU
					var kvotaPoClanu = $('#kvotaPoClanu').val();
	
					if (kvotaPoClanu.length == 0) {
	
						$('#kvotaPoClanu').tooltipster('content', 'Obavezno kvota po članu!');
						$('#kvotaPoClanu').tooltipster('show');
						$("#kvotaPoClanu").focus().select();
						return false;
					}
				
					
				//STANJE
					var stanje = $('#stanje').val();
	
					if (stanje.length == 0) {
	
						$('#stanje').tooltipster('content', 'Obavezno stanje!');
						$('#stanje').tooltipster('show');
						$("#stanje").focus().select();
						return false;
					}
				
				
				
				//TRAŽENO
					var trazeno = $('#trazeno').val();
	
					if (trazeno.length == 0) {
	
						$('#trazeno').tooltipster('content', 'Obavezno trazeno!');
						$('#trazeno').tooltipster('show');
						$("#trazeno").focus().select();
						return false;
					}
					
});


				$("label[for=barkod]").click(function(){
					$('#barkod').val($('input:hidden[name=hidBarkod]').val());
					$('#barkod').tooltipster('hide');
				});
				
				$("label[for=naziv]").click(function(){
					$('#naziv').val($('input:hidden[name=hidNaziv]').val());
					$('#naziv').tooltipster('hide');
				});
				
				$("label[for=jedinicaMjere]").click(function(){
					$('#jedinicaMjere').val($('input:hidden[name=hidJedinicaMjere]').val());
					$('#jedinicaMjere').tooltipster('hide');
				});
				
				$("label[for=kvotaPoDanu]").click(function(){
					$('#kvotaPoDanu').val($('input:hidden[name=hidKvotaPoDanu]').val());
					$('#kvotaPoDanu').tooltipster('hide');
				});
				
				$("label[for=kvotaPoClanu]").click(function(){
					$('#kvotaPoClanu').val($('input:hidden[name=hidKvotaPoClanu]').val());
					$('#kvotaPoClanu').tooltipster('hide');
				});
				
				$("label[for=stanje]").click(function(){
					$('#stanje').val($('input:hidden[name=hidStanje]').val());
					$('#stanje').tooltipster('hide');
				});
				
				$("label[for=trazeno]").click(function(){
					$('#trazeno').val($('input:hidden[name=hidTrazeno]').val());
					$('#trazeno').tooltipster('hide');
				});
				

		
		
				
});

</script>