<script>
			$(document).ready(function(){
				$(".oNama").hide();
				$(".kontakt").hide();
				$(".gdjeSmo").hide();
				
			
	   			$("#oNamaKrug").click(function(){
	        		$(".oNama").animate({
	            		height: 'toggle'
	        		});
					$(".kontakt").hide();
					$(".gdjeSmo").hide();
	   			});
	   			
	   			
	   			$("#kontaktKrug").click(function(){
	        		$(".kontakt").animate({
	            		height: 'toggle'
	        		});
	        		$(".oNama").hide();
					$(".gdjeSmo").hide();
	   			});

				
				$("#gdjeSmoKrug").click(function(){
	        		$(".gdjeSmo").animate({
	            		height: 'toggle'
	        		});
	        		$(".oNama").hide();
					$(".kontakt").hide();
	   			});

				
			});
		</script>