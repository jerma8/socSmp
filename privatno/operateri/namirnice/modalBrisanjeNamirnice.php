<div id="myModalBrisanjeNamirnice" class="reveal-modal tiny" data-reveal data-animation="fade" 
data-animationspeed="300" data-closeonbackgroundclick="false" data-closeonesc="false">
	
	<h2 class="h25Font">Brisanje namirnice</h2><h2 id="kontejner" class="h25Font"></h2>
	<hr class="hrLinija" />
		
		<div class="row collapse">
			<div class="large-12 columns">
				<div class="large-6 columns">
					<a onclick="myFunction()" style="width: 100%; color:white;" id="potvrdaObrisi" class="obrisi potvrdaBrisanja button close-reveal-modal">DA</a>
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

$(function(){
	alert($(this).attr("id").split("_")[1]);
	$("#potvrdaObrisi").click(function(){
		
		alert($(this).attr("id").split("_")[1]);
		
  		var element = $(this);
  		$.ajax({
				type: "POST",
				url: "brisanjeNamirnice.php",
				data: "grupa=<?php echo $objekt->sifra; ?>&polaznik=" + element.attr("id"),
				success: function(vratioServer){
					
				}
				
			});
  		return false;
  	});
	
});
</script>