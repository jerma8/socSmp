<script>
	$(document).ready(function(){
		
		//dozvoljava samo numbers u input
		$('.numbersOnly').keyup(function () { 
    		this.value = this.value.replace(/[^0-9\.]/g,'');
		});
		
		$(window).keypress(function() {
					$('#naziv').tooltipster('hide');
					$('#adresa').tooltipster('hide');
					$('#mjesto').tooltipster('hide');
					$('#imeKontaktOsobe').tooltipster('hide');
					$('#prezimeKontaktOsobe').tooltipster('hide');
					$('#telKontaktOsobe').tooltipster('hide');
					$('#email').tooltipster('hide');
				});



				$('#naziv').tooltipster({
					position : 'left',
					offsetX : '0px',
					offsetY : '95px',
					effect: "fade",
					trigger : 'custom'

				});

				$('#adresa').tooltipster({
					position : 'left',
					offsetX : '0px',
					offsetY : '95px',
					effect: "fade",
					trigger : 'custom'

				});

				$('#mjesto').tooltipster({
					position : 'left',
					offsetX : '0px',
					offsetY : '95px',
					effect: "fade",
					trigger : 'custom'

				});
				
				
				$('#imeKontaktOsobe').tooltipster({
					position : 'left',
					offsetX : '0px',
					offsetY : '95px',
					effect: "fade",
					trigger : 'custom'

				});

				$('#prezimeKontaktOsobe').tooltipster({
					position : 'left',
					offsetX : '0px',
					offsetY : '95px',
					effect: "fade",
					trigger : 'custom'

				});
				
				$('#telKontaktOsobe').tooltipster({
					position : 'left',
					offsetX : '0px',
					offsetY : '95px',
					effect: "fade",
					trigger : 'custom'

				});
				
				$('#email').tooltipster({
					position : 'left',
					offsetX : '0px',
					offsetY : '95px',
					effect: "fade",
					trigger : 'custom'

				});
				
				
			
			
			
				
$("#dodaj").click(function(){
					
					
					
				//NAZIV
					var naziv = $('#naziv').val();
					var naziv_regex = /^[a-zA-Z ćĆčČđĐšŠžŽ.]{2,50}$/;

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
				
				//ADRESA
					var adresa = $('#adresa').val();
	
					if (adresa.length == 0) {
	
						$('#adresa').tooltipster('content', 'Obavezno adresa!');
						$('#adresa').tooltipster('show');
						$("#adresa").focus().select();
						return false;
					}
				
				
				
				//MJESTO
					var mjesto = $('#mjesto').val();
					var mjesto_regex = /^[a-zA-Z ćĆčČđĐšŠžŽ]{2,50}$/;

					if (mjesto.length == 0) {

						$('#mjesto').tooltipster('content', 'Obavezno mjesto!');
						$('#mjesto').tooltipster('show');
						$("#mjesto").focus().select();
						return false;
					}

					if (!mjesto.match(mjesto_regex)) {

						$('#mjesto').tooltipster('content', 'Dozvoljena samo slova.');
						$('#mjesto').tooltipster('show');
						$("#mjesto").focus().select();
						return false;
					}
					
					
					
					
				//IME KONTAKT OSOBE
					var imeKontaktOsobe = $('#imeKontaktOsobe').val();
					var imeKontaktOsobe_regex = /^[a-zA-Z ćĆčČđĐšŠžŽ.]{2,50}$/;
	
					if (imeKontaktOsobe.length == 0) {
	
						$('#imeKontaktOsobe').tooltipster('content', 'Obavezno ime kontakt osobe!');
						$('#imeKontaktOsobe').tooltipster('show');
						$("#imeKontaktOsobe").focus().select();
						return false;
					}
					
					if (!imeKontaktOsobe.match(imeKontaktOsobe_regex)) {

						$('#imeKontaktOsobe').tooltipster('content', 'Dozvoljena samo slova.');
						$('#imeKontaktOsobe').tooltipster('show');
						$("#imeKontaktOsobe").focus().select();
						return false;
					}
				
				//PREZIME KONTAKT OSOBE
					var prezimeKontaktOsobe = $('#prezimeKontaktOsobe').val();
					var prezimeKontaktOsobe_regex = /^[a-zA-Z ćĆčČđĐšŠžŽ.]{2,50}$/;
	
					if (prezimeKontaktOsobe.length == 0) {
	
						$('#prezimeKontaktOsobe').tooltipster('content', 'Obavezno prezime kontakt osobe!');
						$('#prezimeKontaktOsobe').tooltipster('show');
						$("#prezimeKontaktOsobe").focus().select();
						return false;
					}
					
					if (!prezimeKontaktOsobe.match(prezimeKontaktOsobe_regex)) {

						$('#prezimeKontaktOsobe').tooltipster('content', 'Dozvoljena samo slova.');
						$('#prezimeKontaktOsobe').tooltipster('show');
						$("#prezimeKontaktOsobe").focus().select();
						return false;
					}
				
				
				//TELEFON
				
					var telKontaktOsobe = $('#telKontaktOsobe').val();
	
					if (telKontaktOsobe.length == 0) {
	
						$('#telKontaktOsobe').tooltipster('content', 'Obavezno telefon kontakt osobe!');
						$('#telKontaktOsobe').tooltipster('show');
						$("#telKontaktOsobe").focus().select();
						return false;
					}
				
				
				//EMAIL
					
					var email = $('#email').val();
					var email_regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  
	
					if (email.length == 0) {
	
						$('#email').tooltipster('content', 'Obavezno Email!');
						$('#email').tooltipster('show');
						$("#email").focus().select();
						return false;
					}
					
					
					if(!email.match(email_regex)){
						$('#email').tooltipster('content', 'Netočno unesen Email!');
						$('#email').tooltipster('show');
						$("#email").focus().select();
						return false;
					}
});
				

		
		
				
});

</script>