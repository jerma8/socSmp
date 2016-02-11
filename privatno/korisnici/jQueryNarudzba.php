<script>
	$(document).ready(function(){
		$(".porukanaziv").hide();
		$(".porukakolicina").hide();
		$(".porukaselect").show();
		
		
		$("#selectNamirnice").click(function(){
			$(".porukaselect").hide();
			return true;
		});
		
		
		$("#posaljiInput").click(function(){
			    				
    				if($("#naziv").val()==""){
						$(".porukanaziv").html("Obavezno naziv namirnice!");
						$(".porukanaziv").show();
						$("#naziv").focus();
						
						$("#naziv").keyup(function() {
							if ($("#naziv").val()) {
								$(".porukanaziv").hide();
							}
						});
						
						return false;
					}
			
			
					if($("#kolicina").val()==""){
						$(".porukakolicina").html("Obavezno kolicina!");
						$(".porukakolicina").show();
						$("#kolicina").focus();
						
						$("#kolicina").keyup(function() {
							if ($("#kolicina").val()) {
								$(".porukakolicina").hide();
							}
						});
						return false;
					}
    				
			return true;
		});
		
		
		$('.numbersOnly').keyup(function () { 
    		this.value = this.value.replace(/[^0-9\.]/g,'');
		});
	});
</script>