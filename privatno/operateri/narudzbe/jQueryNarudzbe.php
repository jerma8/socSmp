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
				});



				$('#barkod').tooltipster({
					position : 'left',
					offsetX : '0px',
					offsetY : '95px',
					effect: "fade",
					trigger : 'custom'

				});

				$('#naziv').tooltipster({
					position : 'left',
					offsetX : '0px',
					offsetY : '95px',
					effect: "fade",
					trigger : 'custom'

				});

				$('#jedinicaMjere').tooltipster({
					position : 'left',
					offsetX : '0px',
					offsetY : '95px',
					effect: "fade",
					trigger : 'custom'

				});
				
				
				$('#kvotaPoDanu').tooltipster({
					position : 'left',
					offsetX : '0px',
					offsetY : '95px',
					effect: "fade",
					trigger : 'custom'

				});

				$('#kvotaPoClanu').tooltipster({
					position : 'left',
					offsetX : '0px',
					offsetY : '95px',
					effect: "fade",
					trigger : 'custom'

				});
				
$("#dodaj").click(function(){
					
					
					
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
					var jedinicaMjere_regex = /^[a-zA-Z ćĆčČđĐšŠžŽ.()]{2,50}$/;

					if (jedinicaMjere.length == 0) {

						$('#jedinicaMjere').tooltipster('content', 'Obavezno jedinica mjere!');
						$('#jedinicaMjere').tooltipster('show');
						$("#jedinicaMjere").focus().select();
						return false;
					}

					if (!jedinicaMjere.match(jedinicaMjere_regex)) {

						$('#jedinicaMjere').tooltipster('content', 'Dozvoljena samo slova.');
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
					
});
				

		
		
				
});

</script>