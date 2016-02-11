<script>
			$(document).ready(function(){
		
				
				$("#autoriziraj").click(function(){
					
					
					if($("#korisnik").val().trim().length==0){
						$("#korisnik").val("Obavezno korisnik");
						$("#korisnik").css("background-color","red");
						$("#korisnik").focus().select();
						
						$("#korisnik").keyup(function() {
							if ($("#korisnik").val()) {
								$("#korisnik").css("background-color","white");
							}
						});
						return false;
					}
					
					if($("#lozinka").val().trim().length==0){
						$("#lozinka").val("Obavezno lozinka");
						$("#lozinka").css("background-color","red");
						$("#lozinka").focus().select();
						
						$("#lozinka").keyup(function() {
							if ($("#lozinka").val()) {
								$("#lozinka").css("background-color","white");
							}
						});
						return false;
					}
					
					return true;
				});
				
			});
		</script>