<?php
include_once '../../../konfig.php';
if (!isset($_SESSION['operater'])) {
	header("location: ../../../logout.php");
}

$date = date('Y-m-d H:i:s');
$date = substr($date, 0,10);


if (isset($_GET['sifra'])) {
	$sifra = $_GET['sifra'];
} else if (isset($_POST['sifra'])) {
	$sifra = $_POST['sifra'];
}

if ($_GET) {
	$izraz = $veza -> prepare("select * from korisnik where sifra=:sifra");
	$izraz -> bindParam(":sifra", $sifra);

	$izraz -> execute();
	$objekt = $izraz -> fetch(PDO::FETCH_OBJ);
}

?>
<!doctype html>
<html class="no-js" lang="en">
	<head>
		<?php
		include_once '../../../head.php';
		?>
		<link rel="stylesheet" href="<?php echo $putanjaApp; ?>css/jquery-ui.css" />
		
	</head>
	<body>
				<?php
				include_once '../../../zaglavlje.php';
				?>

				<div class="row marginBottom20 textCenter">
			<div class="large-12 columns">
				<br />
				<h1 class="h1Font2">Socijalna&nbsp;&nbsp;&nbsp;samoposluga</h1>
				<!-- FONT BODY I H1 H2 H3 -->

			</div>
		</div>


				<div class="row">
					<div class="large-12 columns">
						<div class="panel podloga margin-1">
							<div class="row">
								<div class="large-7 columns">
									<h2 class="h25Font">Isporuka namirnice korisniku</h2>
								</div>
							</div>
			<div class="panel panelBorder">			
				<div class="row">
					<div class="large-4 columns">
						
						<table>
							<tr>
								<th>Ime:</th>
								<td><?php echo $objekt->ime; ?></td>
							</tr>
							
							<tr>
								<th>Prezime:</th>
								<td><?php echo $objekt->prezime; ?></td>
							</tr>
							
							<tr>
								<th>OIB:</th>
								<td><?php echo $objekt->oib; ?></td>
							</tr>
							
							<tr>
								<th>Datum rođenja:</th>
								<td><?php 
								if(strtotime($objekt->datumRodenja)!=0){
									$d = $objekt->datumRodenja;
									$d=substr($d, 8,2) . "." . substr($d, 5,2) . "." . substr($d, 0,4) . ".";
									echo $d;
								}?></td>
							</tr>
							
							<tr>
								<th>Adresa:</th>
								<td><?php echo $objekt->adresa; ?></td>
							</tr>
							
							<tr>
								<th>Mjesto:</th>
								<td><?php echo $objekt->mjesto; ?></td>
							</tr>
							
							<tr>
								<th>Broj članova obitelji:</th>
								<td class="brojClanova" id="<?php echo $objekt->brojClanovaObitelji; ?>"><?php echo $objekt->brojClanovaObitelji; ?></td>
							</tr>
						</table>
					
					</div>
					
					<div class="large-8 columns">
						
						<form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
						<div class="large-7 columns">
							<label class="font1rem">Traži namirnicu:</label>
						</div>
						<div class="large-8 columns">
							<input type="text" id="traziNamirnicu" />
						</div>
						
						
						<div class="large-12">
						
						<div class="large-2">
							<label>Namirnice:</label>
						</div>
						 	<table>
				    		
				    				<tr>
				    					<th>Naziv</th>
				    					<th>Jedinica mjere</th>
				    					<th>Kvota po danu</th>
				    					<th>Kvota po članu</th>
				    					<th>Količna</th>
				    				</tr>
				    			
				    			<tbody id="podaci">
				    				<?php 
				    			
				    				$izraz = $veza->prepare("
				    				select 
				    				a.sifra, a.barkod, a.naziv, a.jedinicaMjere, a.kvotaPoDanu, a.kvotaPoClanu,a.stanje
				    				from namirnica a 
				    				inner join uzima b on a.sifra=b.sifraNamirnice
				    				inner join korisnik c on b.sifraKorisnika=c.sifra 
				    				where c.sifra=:sifra and b.datumUzimanja=:datum");
									$izraz->bindParam(':datum', $date);
									$izraz->bindParam(':sifra', $sifra);
									$izraz->execute();
									$namirnice = $izraz->fetchAll(PDO::FETCH_OBJ);
				    				
															
				    				foreach ($namirnice as $n) :
									?>
										<tr id="<?php echo $n->sifra; ?>">
											<td><?php echo $n -> naziv; ?></td>
											<td><?php echo $n -> jedinicaMjere; ?></td>
											<td><?php echo $n -> kvotaPoDanu; ?></td>
											<td><?php echo $n -> kvotaPoClanu; ?></td>
											<td>	
											</td>
										</tr>
									<?php
									endforeach;
				    				?>
				    			</tbody>
				    		</table>
						</form>
						<small class="error" id="porukaPotvrde">Unesite količine namirnica!</small>
						
						
						<div class="large-12 columns">
									<a id="nazad" class="button round right" href="<?php echo $putanjaApp; ?>privatno/operateri/korisnici/index.php">Nazad</a>
								</div>
						</div>
					</div>
						
									
				</div>
			</div>
				
		</div>
	</div>
</div>
		<?php
		include_once 'modalUnosKolicine.php';
		?>
		
		<?php
		include_once '../../../skripte.php';
		?>
		
		<script src="<?php echo $putanjaApp; ?>js/vendor/jquery-ui.js"></script>
		
		<script>
		
			$('.numbersOnly').keyup(function () { 
    			this.value = this.value.replace(/[^0-9\.]/g,'');
			});
		
			$("#porukaUnosKolicine").hide();
			$("#porukaPotvrde").hide();
			
			var brojClanova = $('.brojClanova').attr('id').trim();
			
			
		
			$(function() {
				
				 $("#traziNamirnicu").autocomplete({
				    source: "traziNamirnicu.php?sifra=" + <?php echo $sifra; ?> + "&brojClanovaObitelji="+<?php echo $objekt->brojClanovaObitelji; ?>,
				    minLength: 1,
				    focus: function( event, ui ) {
				    	event.preventDefault();
				    	},
				    select: function(event, ui) {
				        $(this).val('').blur();
				        event.preventDefault();
				        spremiUBazu(ui.item);
				       
				    }
					}).data( "ui-autocomplete" )._renderItem = function( ul, namirnica ) {
						var postoji=false;
						$.each($(".stavkeUzima"), function( index, value ) {
							if($(this).attr("id").split("_")[1]==namirnica.sifra){
								postoji=true;
							}
							});
							
						if(postoji){
							return $( "<span>" )
						}else{
						return $( "<li>" )
				        .append( "<a>" + namirnica.naziv + " - " + namirnica.jedinicaMjere + "</a>" )
				        .appendTo( ul );	
						}
				      
				    };
				    
				    definirajBrisanje();
			});
			
			
			
		
		
		
		//FUNKCIJE ZA SPREMANJE I BRISANJE	
					
		function spremiUBazu(item){
  			$.ajax({
				type: "POST",
				url: "dodajNamirnicuKorisnika.php",
				data: "sifraKorisnika=<?php echo $objekt->sifra; ?>&sifraNamirnice=" + item.sifra,
				success: function(vratioServer){
					if(vratioServer=="OK"){
						//alert("dada");
						$("#podaci").append("<tr class=\"stavkeUzima\" id=\"stavka_" + item.sifra + "\">" + 
						"<td>" + item.naziv + "</td>" +
						"<td>" + item.jedinicaMjere + "</td>" +
						"<td>" + item.kvotaPoDanu + "</td>" +
						"<td class=\"kpc\" id=\"" + item.kvotaPoClanu + "\">" + item.kvotaPoClanu + "</td>" +
						"<td class=\"stavkeUnesi\" id=\"unesi_" + item.sifra + "\">" + "Unesi" +"</td>" +
						"<td><a class=\"obrisi iconsColor\" id=\"" + item.sifra + "\" href=\"#\"><i class=\"fi-x\"></i></a></td></tr>"
						);
						
						if ($(".stavkeUzima").text().indexOf("Unesi") >= 0){
							$("#porukaPotvrde").show();
						}else{
							$("#porukaPotvrde").hide();
						}
						$("#nazad").hide();
						$("#traziNamirnicu").focus();
						
						
						definirajBrisanje();
					}
				}
				
			});
			
 		}
 		
		function definirajBrisanje(){
  	
		  	$(".obrisi").click(function(){
		  		
		  	//VRAČA Količinu TOG REDA! RAdi povečanja stanja ako je već uneseno stanje namirnice
			 var kol = $(this).closest("tr")
                       .find(".stavkeUnesi")
                       .text();
                       //alert(kol);
		  		
		  		var element = $(this);
		  		$.ajax({
						type: "GET",
						url: "brisanjeUzimanja.php",
						data: "kolicina=" + kol + "&sifraKorisnika=<?php echo $objekt->sifra; ?>&sifraNamirnice=" + $(".obrisi").attr("id") +"&datum=<?php echo $date; ?>" ,
						success: function(vratioServer){
							if(vratioServer=="OK"){
								//alert("da");
								element.parent().parent().remove();
								
								if($(".stavkeUzima").text()==""){
									$("#porukaPotvrde").hide();
									$("#nazad").show();
								}
							}
						}
						
					});
		  		return false;
		  	});
		  	
		  }
		  
		  
			$(function(){
				$("table").on("click", ".stavkeUnesi", function() {
					
					
					//VRAČA KVOTU PO CLANU IZ TOG REDA!
					var $item = $(this).closest("tr")   // Finds the closest row <tr> 
                       .find(".kpc")     // Gets a descendent with class="kpc"
                       .text();         // Retrieves the text within <td>
                       //alert($item);
					
					$("#kvotaPoClanu").val($item); //stavlja u hidden kvotaPoClanu
					
					 var kol = $(this).closest("tr")
                       .find(".stavkeUnesi")
                       .text();
                    
                    $("#trenutnaKolicina").val(kol);
                    
                    
					$('#sifraNamirnice').val($(this).attr("id").split("_")[1]);
					
					
					//prije nego sto se otvori modal stavi u kontejner trenutno stanje namirnice
					
					$.ajax({
						type : "GET",
						url : "pokupiStanje.php?sifraNamirnice=" + $("#sifraNamirnice").val(),
						cache : false,
						success : function(data) {
							
							$("#kontejnerStanje").html(data);
							
							$('#myModalKolicina').foundation('reveal','open');
							setTimeout(function(){ $("#kolicina").focus().select(); }, 600);
						}
					});
					
					
				});
				
			});
			
			$(function(){
				$("#otvoriKolicinu").click(function(){
					//PROBLEM - STANJE - KOLICINA
					
					
					
					//FORMA KOLICINE
					if($('#kolicina').val()!=""){
						
						var stanje=$('#hidStanje').val().trim();
						var kvota=$("#kvotaPoClanu").val().trim();
						var kolicina = $('#kolicina').val().trim();
						stanje = stanje.split(".")[0];
						kvota = kvota.split(".")[0];
						
						var KBCO = kvota * brojClanova;
						
						if(KBCO<kolicina || stanje<kolicina){
							alert("stanje="+stanje+"kolicina="+kolicina);
							$("#porukaUnosKolicine").text("Prevelika količina namirnice!");
							$("#porukaUnosKolicine").show();
						}
						if(KBCO>=kolicina){
						
							//Ako brojClanovaObitelji * kvotaPoClanu je manje od kolicina unesi u tablicu
								$('#myModalKolicina').foundation('reveal', 'close');
				    	
						    	var zaUnos = "unesi_" + $('#sifraNamirnice').val();
						    	
						    	$("#"+zaUnos).text($('#kolicina').val());
						    	
						    	//ajax update uzima set kolicina = kolicina iz forme
						    	$.ajax({
										type: "POST",
										url: "updateUzimaKolicinu.php",
										data: "trenutnaKolicina=" + $("#trenutnaKolicina").val() + "&kolicina=" + kolicina + "&sifraNamirnice=" + $('#sifraNamirnice').val() + "&sifraKorisnika=" + $('#sifraKorisnika').val(),
										success: function(vratioServer){
											if(vratioServer=="OK"){
												//dodaj kolicinu u tablicu
												//alert("prošlo");
												
												if ($(".stavkeUzima").text().indexOf("Unesi") >= 0){
													$("#nazad").hide();
													$("#porukaPotvrde").show();
												}else{
													$("#nazad").show();
													$("#porukaPotvrde").hide();
												}
												$("#porukaUnosKolicine").hide();
												$("#traziNamirnicu").focus();
											}
										}
										
								});
							
						
						}	
							
					}
					
					
					else{
						$("#porukaUnosKolicine").text("Unesite količinu!");
						$("#porukaUnosKolicine").show();
					}
					
				});
			});
	
</script>
		
	</body>
</html>
