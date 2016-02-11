<?php
	include_once '../../../konfig.php';
	
	$izraz = $veza -> prepare("
	select * from namirnica where sifra=:sifraNamirnice");
	
	$izraz->bindParam(":sifraNamirnice",$_GET["sifraNamirnice"]);
	$izraz -> execute();
	$detalji = $izraz -> fetch(PDO::FETCH_OBJ);
		
?>


<!-- stavlja u kontejner -->
	<div class="alert-box">
		<?php echo "Trenutno stanje namirnice ".$detalji->naziv . " je " . $detalji->stanje; ?>
	</div>
	<input type="hidden" id="hidStanje" name="hidStanje" value="<?php echo $detalji->stanje; ?>"/>