<script>
		$(document).ready(function($) {
								
				//dozvoljava samo numbers u input
				$('.numbersOnly').keyup(function () { 
    				this.value = this.value.replace(/[^0-9\.]/g,'');
				});
				
				$('.numbersOnly19').keyup(function () { 
    				this.value = this.value.replace(/[^1-9\.]/g,'');
				});
				
				$(window).keypress(function() {
					$('#ime').tooltipster('hide');
					$('#prezime').tooltipster('hide');
					$('#oib').tooltipster('hide');
					$('#datumRodenja').tooltipster('hide');
					$('#adresa').tooltipster('hide');
					$('#mjesto').tooltipster('hide');
					$('#brojClanovaObitelji').tooltipster('hide');
					$('#korisnik').tooltipster('hide');
					$('#lozinka').tooltipster('hide');
					$('#lozinka2').tooltipster('hide');
				});



				$('#ime').tooltipster({
					position : 'left',
					offsetX : '0px',
					offsetY : '95px',
					effect: "fade",
					trigger : 'custom'

				});

				$('#prezime').tooltipster({
					position : 'left',
					offsetX : '0px',
					offsetY : '95px',
					effect: "fade",
					trigger : 'custom'

				});

				$('#oib').tooltipster({
					position : 'left',
					offsetX : '0px',
					offsetY : '95px',
					effect: "fade",
					trigger : 'custom'

				});
				
				//OIB TRAZI U BAZI - AJAX  - prođe ako je isti broj
				$("#oib").focusout(function() {

						$.ajax({
							type : "POST",
							url : "provjeriOib.php",
							data : "oib=" + $('#oib').val(),
							cache : false,
							success : function(data) {
								//alert(data);
								if (data == "POSTOJI") {
									$('#oib').tooltipster('content', 'Ovaj OIB se koristi.');
									$('#oib').tooltipster('show');
									$("#oib").focus().select();
									return false;
								}
								
							}
						});
					});
				
				$('#datumRodenja').tooltipster({
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
				
				$('#brojClanovaObitelji').tooltipster({
					position : 'left',
					offsetX : '0px',
					offsetY : '95px',
					effect: "fade",
					trigger : 'custom'

				});

				$('#korisnik').tooltipster({
					position : 'right',
					offsetX : '0px',
					offsetY : '95px',
					effect: "fade",
					trigger : 'custom'

				});
				
				
				//TRAŽI KORISNIČKO IME U BAZI - AJAX
				$("#korisnik").focusout(function() {

						$.ajax({
							type : "POST",
							url : "provjeriKorisnik.php",
							data : "korisnik=" + $('#korisnik').val(),
							cache : false,
							success : function(data) {
								//alert(data);
								if (data == "POSTOJI") {
									$('#korisnik').tooltipster('content', 'Ovo korisničko ime se koristi.');
									$('#korisnik').tooltipster('show');
									$("#korisnik").focus().select();
									return false;
								}
								
							}
						});
					});

				$('#lozinka').tooltipster({
					position : 'right',
					offsetX : '5px',
					offsetY : '95px',
					effect: "fade",
					trigger : 'custom'

				});

				$('#lozinka2').tooltipster({
					position : 'right',
					offsetX : '5px',
					offsetY : '95px',
					effect: "fade",
					trigger : 'custom'

				});
				
				
$("#dodaj").click(function(){
					
					
					
				//IME
					var ime = $('#ime').val();
					var ime_regex = /^[a-zA-Z ćĆčČđĐšŠžŽ-]{2,50}$/;

					if (ime.length == 0) {

						$('#ime').tooltipster('content', 'Obavezno ime!');
						$('#ime').tooltipster('show');
						$("#ime").focus().select();
						return false;
					}

					if (!ime.match(ime_regex)) {

						$('#ime').tooltipster('content', 'Dozvoljena samo slova.');
						$('#ime').tooltipster('show');
						$("#ime").focus().select();
						return false;
					}

				//PREZIME

					var prezime = $('#prezime').val();
					var prezime_regex = /^[a-zA-Z ćĆčČđĐšŠžŽ-]{2,50}$/;

					if (prezime.length == 0) {

						$('#prezime').tooltipster('content', 'Obavezno prezime!');
						$('#prezime').tooltipster('show');
						$("#prezime").focus().select();
						return false;
					}

					if (!prezime.match(prezime_regex)) {

						$('#prezime').tooltipster('content', 'Dozvoljena samo slova.');
						$('#prezime').tooltipster('show');
						$("#prezime").focus().select();
						return false;
					}
					
					
					
				//OIB

					var OIB = $('#oib').val();

					if (OIB.length == 0) {

						$('#oib').tooltipster('content', 'Obavezno OIB!');
						$('#oib').tooltipster('show');
						$("#oib").focus().select();
						return false;
					}
					if (OIB.length != 11) {

						$('#oib').tooltipster('content', 'Obavezno 11 znamenki!');
						$('#oib').tooltipster('show');
						$("#oib").focus().select();
						return false;
					}
					
					
						
				
				//DATUM ROĐENJA
					var datumRodenja = $('#datumRodenja').val();
	
					if (datumRodenja.length == 0) {
	
						$('#datumRodenja').tooltipster('content', 'Obavezno datum rođenja!');
						$('#datumRodenja').tooltipster('show');
						$("#datumRodenja").focus().select();
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
					
					
					
					
				//BROJ CLANOVA OBITELJI
					var brojClanovaObitelji = $('#brojClanovaObitelji').val();
	
					if (brojClanovaObitelji.length == 0) {
	
						$('#brojClanovaObitelji').tooltipster('content', 'Obavezno broj članova obitelji!');
						$('#brojClanovaObitelji').tooltipster('show');
						$("#brojClanovaObitelji").focus().select();
						return false;
					}
				
				
				
				
				//KORISNICKO IME
				
					var korisnik = $('#korisnik').val();
	
					if (korisnik.length == 0) {
	
						$('#korisnik').tooltipster('content', 'Obavezno korisničko ime!');
						$('#korisnik').tooltipster('show');
						$("#korisnik").focus().select();
						return false;
					}
				
				//KORISNICKO IME - AJAX
				
				$("#korisnik").focusout(function() {

						$.ajax({
							type : "POST",
							url : "provjeriKorisnik.php",
							data : "korisnik=" + $('#korisnik').val(),
							cache : false,
							success : function(data) {
								//alert(data);
								if (data == "POSTOJI") {
									$('#korisnik').tooltipster('content', 'Ovo korisničko ime se koristi.');
									$('#korisnik').tooltipster('show');
									$("#korisnik").focus().select();
									return false;
								}
								
							}
						});
					});
				
				
				
				//LOZINKA
					var lozinka = $('#lozinka').val();
	
					if (lozinka.length == 0) {
	
						$('#lozinka').tooltipster('content', 'Obavezno lozinka!');
						$('#lozinka').tooltipster('show');
						$("#lozinka").focus().select();
						return false;
					}
					
				
				
				//LOZINKA PONOVO
					var lozinka2 = $('#lozinka2').val();
	
					if (lozinka2.length == 0) {
	
						$('#lozinka2').tooltipster('content', 'Obavezno lozinka ponovo!');
						$('#lozinka2').tooltipster('show');
						$("#lozinka2").focus().select();
						return false;
					}
					
					
					if(lozinka!=lozinka2){
						$('#lozinka2').tooltipster('content', 'Nije identično kao lozinka!');
						$('#lozinka2').tooltipster('show');
						$("#lozinka2").focus().select();
						return false;
					}
});
				

		
					$.datepicker.regional['hr'] = {
					closeText : 'Zatvori',
					prevText : 'Prethodni',
					nextText : 'Sljedeći',
					currentText : 'Trenutni',
					monthNames : ['Siječanj', 'Veljača', 'Ožujak', 'Travanj', 'Svibanj', 'Lipanj', 'Srpanj', 'Kolovoz', 'Rujan', 'Listopad', 'Studeni', 'Prosinac'],
					monthNamesShort : ['sij', 'velj', 'ožu', 'tra', 'svi', 'lip', 'srp', 'kol', 'ruj', 'lis', 'stu', 'pro'],
					dayNames : ['Nedjelja', 'Ponedjeljak', 'Utorak', 'Srijeda', 'Četvrtak', 'Petak', 'Subota'],
					dayNamesShort : ['ned', 'pon', 'uto', 'sri', 'čet', 'pet', 'sub'],
					dayNamesMin : ['N', 'P', 'U', 'S', 'Č', 'P', 'S'],
					weekHeader : 'Tjedan',
					dateFormat : 'dd.mm.yy.',
					firstDay : 1,
					isRTL : false,
					showMonthAfterYear : false,
					yearSuffix : '',
					changeMonth : true,
					changeYear : true,
					showButtonPanel : true,
					yearRange : '1940:2020'
				};
				$.datepicker.setDefaults($.datepicker.regional['hr']);

				var datum = document.getElementById('datumRodenja').value;
				
				$("#datumRodenja").datepicker();
				$("#datumRodenja").datepicker("option", $.datepicker.regional['hr']);
				$("#datumRodenja").val(datum);


});

</script>