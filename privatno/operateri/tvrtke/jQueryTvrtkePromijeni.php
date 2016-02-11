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
					position : 'right',
					offsetX : '0px',
					offsetY : '95px',
					effect: "fade",
					trigger : 'custom'

				});

				$('#adresa').tooltipster({
					position : 'right',
					offsetX : '0px',
					offsetY : '95px',
					effect: "fade",
					trigger : 'custom'

				});

				$('#mjesto').tooltipster({
					position : 'right',
					offsetX : '0px',
					offsetY : '95px',
					effect: "fade",
					trigger : 'custom'

				});
				
				
				$('#imeKontaktOsobe').tooltipster({
					position : 'right',
					offsetX : '0px',
					offsetY : '95px',
					effect: "fade",
					trigger : 'custom'

				});

				$('#prezimeKontaktOsobe').tooltipster({
					position : 'right',
					offsetX : '0px',
					offsetY : '95px',
					effect: "fade",
					trigger : 'custom'

				});
				
				$('#telKontaktOsobe').tooltipster({
					position : 'right',
					offsetX : '0px',
					offsetY : '95px',
					effect: "fade",
					trigger : 'custom'

				});
				
				$('#email').tooltipster({
					position : 'right',
					offsetX : '0px',
					offsetY : '95px',
					effect: "fade",
					trigger : 'custom'

				});
				
				
			
			
			
				
$("#promijeni").click(function(){
					
					
					
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
				
				
				
				$("label[for=naziv]").click(function(){
					$('#naziv').val($('input:hidden[name=hidNaziv]').val());
					$('#naziv').tooltipster('hide');
				});
				
				$("label[for=adresa]").click(function(){
					$('#adresa').val($('input:hidden[name=hidAdresa]').val());
					$('#adresa').tooltipster('hide');
				});
				
				$("label[for=mjesto]").click(function(){
					$('#mjesto').val($('input:hidden[name=hidMjesto]').val());
					$('#mjesto').tooltipster('hide');
				});
				
				$("label[for=imeKontaktOsobe]").click(function(){
					$('#imeKontaktOsobe').val($('input:hidden[name=hidImeKontaktOsobe]').val());
					$('#imeKontaktOsobe').tooltipster('hide');
				});
				
				$("label[for=prezimeKontaktOsobe]").click(function(){
					$('#prezimeKontaktOsobe').val($('input:hidden[name=hidPrezimeKontaktOsobe]').val());
					$('#prezimeKontaktOsobe').tooltipster('hide');
				});
				
				$("label[for=telKontaktOsobe]").click(function(){
					$('#telKontaktOsobe').val($('input:hidden[name=hidTelKontaktOsobe]').val());
					$('#telKontaktOsobe').tooltipster('hide');
				});
				
				$("label[for=email]").click(function(){
					$('#email').val($('input:hidden[name=hidEmail]').val());
					$('#email').tooltipster('hide');
				});

		
		
				
});

</script>