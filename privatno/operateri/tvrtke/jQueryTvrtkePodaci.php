<script>
	$(document).ready(function(){
		$(".porukanaziv").hide();
		$(".porukaadresa").hide();
		$(".porukamjesto").hide();
		$(".porukakorisnik").hide();
		$(".porukalozinka1").hide();
		$(".porukalozinka2").hide();
	

		$("#promijeni").click(function(){
			
			
		//provjera
		if($("#naziv").val()==""){
			$(".porukanaziv").html("Obavezno naziv tvrtke!");
			$(".porukanaziv").show();
			$("#naziv").focus();
			
			$("#naziv").keyup(function() {
				if ($("#naziv").val()) {
					$(".porukanaziv").hide();
				}
			});
			
			return false;
		}
		
		
		//provjera
		if($("#adresa").val()==""){
			$(".porukaadresa").html("Obavezna adresa tvrtke!");
			$(".porukaadresa").show();
			$("#adresa").focus();
			
			$("#adresa").keyup(function() {
				if ($("#adresa").val()) {
					$(".porukaadresa").hide();
				}
			});
			
			return false;
		}
		
		
		//provjera
		if($("#mjesto").val()==""){
			$(".porukamjesto").html("Obavezno mjesto!");
			$(".porukamjesto").show();
			$("#mjesto").focus();
			
			$("#mjesto").keyup(function() {
				if ($("#mjesto").val()) {
					$(".porukamjesto").hide();
				}
			});
			
			return false;
		}

		
		//provjera korisnik
		if($("#korisnik").val()==""){
			$(".porukakorisnik").html("Obavezno korisničko ime!");
			$(".porukakorisnik").show();
			$("#korisnik").focus();
			
			$("#korisnik").keyup(function() {
				if ($("#korisnik").val()) {
					$(".porukakorisnik").hide();
				}
			});
			
			return false;
		}
		
		
		//provjera
		if($("#lozinka").val()==""){
			$(".porukalozinka1").html("Obavezna lozinka!");
			$(".porukalozinka1").show();
			$("#lozinka").focus();
			
			$("#lozinka").keyup(function() {
				if ($("#lozinka").val()) {
					$(".porukalozinka1").hide();
				}
			});
			
			return false;
		}
		
		//provjera
		if($("#lozinka2").val()==""){
			$(".porukalozinka2").html("Obavezna potvrda lozinke!");
			$(".porukalozinka2").show();
			$("#lozinka2").focus();
			
			$("#lozinka2").keyup(function() {
				if ($("#lozinka2").val()) {
					$(".porukalozinka2").hide();
				}
			});
			
			return false;
		}
		
		if($("#lozinka").val()!=$("#lozinka2").val()){
			$(".porukalozinka2").html("Lozinke nisu identične!");
			$(".porukalozinka2").show();
			$("#lozinka2").focus().select();
			
			$("#lozinka2").keyup(function() {
				if ($("#lozinka2").val()) {
					$(".porukalozinka2").hide();
				}
			});
			
			return false;
		}
		


		return true;	
		});
		
		
		
		
				
	});

</script>