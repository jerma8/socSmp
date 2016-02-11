<?php
include_once '../../../konfig.php';
if(!isset($_SESSION["operater"])){
	header("location: ../../../logout.php");
}
if(isset($_GET["sifra"])){
	$sifra=$_GET["sifra"];
	
}
else {
	header("location:index.php");
}


$izraz = $veza -> prepare("select * from korisnik where sifra=:sifra");
$izraz -> bindParam (":sifra", $sifra);
$izraz -> execute();
$objekt = $izraz -> fetch(PDO::FETCH_OBJ);


//============================================================+
// File name   : example_001.php
// Begin       : 2008-03-04
// Last Update : 2013-05-14
//
// Description : Example 001 for TCPDF class
//               Default Header and Footer
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: Default Header and Footer
 * @author Nicola Asuni
 * @since 2008-03-04
 */

// Include the main TCPDF library (search for installation path).
require_once('../../../tcpdf/tcpdf.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Damir Majer');
$pdf->SetTitle('Namirnice korisnika ' . $objekt->ime . " " . $objekt->prezime);
$pdf->SetSubject('Podaci o namirnicama ');
$pdf->SetKeywords('Namirnice');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, "Izvještaj namirnica korisnika ", $objekt->ime." ".$objekt->prezime, array(0,64,255), array(0,64,128));
$pdf->setFooterData(array(0,64,0), array(0,64,128));

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);


// ---------------------------------------------------------

// set default font subsetting mode
$pdf->setFontSubsetting(true);

// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
$pdf->SetFont('dejavusans', '', 12, '', true);

// Add a page
// This method has several options, check the source code documentation for more information.
$pdf->AddPage();

$html="";

$html.="<table>";
$html.="<tr>";
	$html.="<th>OIB:</th>";
	$html.="<td>". $objekt -> oib ."</td>";
$html.="</tr>";

$html.="<tr>";
	$html.="<th>Ime:</th>";
	$html.="<td>". $objekt -> ime ."</td>";
$html.="</tr>";

$html.="<tr>";
	$html.="<th>Prezime:</th>";
	$html.="<td>". $objekt -> prezime ."</td>";
$html.="</tr>";

$html.="<tr>";
	$html.="<th>Datum rođenja:</th>";
	if(strtotime($objekt->datumRodenja)!=0){
		$d = $objekt->datumRodenja;
		$d=substr($d, 8,2) . "." . substr($d, 5,2) . "." . substr($d, 0,4) . ".";
		$html.="<td>". $d ."</td>";
	}
$html.="</tr>";

$html.="<tr>";
	$html.="<th>Adresa:</th>";
	$html.="<td>". $objekt -> adresa ."</td>";	
$html.="</tr>";

$html.="<tr>";
	$html.="<th>Mjesto:</th>";
	$html.="<td>". $objekt -> mjesto ."</td>";
$html.="</tr>";

$html.="<tr>";
	$html.="<th>Broj članova obitelji:</th>";
	$html.="<td>". $objekt -> brojClanovaObitelji ."</td>";
$html.="</tr>";
			 
$html.="</table>";


$html.="<br />";
$html.="<br />";
$html.="<br />";
$html.="<br />";
$html.="Namirnice korisnika<hr />";
$html.="<table>";
$html.="<thead>";
$html.="<tr>";
$html.="<th>Barkod</th>";
$html.="<th>Naziv</th>";
$html.="<th>Jedinica mjere</th>";
$html.="<th>Količina</th>";
$html.="<th>Datum uzimanja</th>";
$html.="</tr>";
$html.="</thead>";



$html.="<tbody>";
$izraz = $veza -> prepare("
select
c.ime, c.prezime,b.sifraKorisnika,b.sifraNamirnice, b.datumUzimanja, b.kolicina, a.barkod, a.naziv, a.jedinicaMjere
from namirnica a
inner join uzima b on a.sifra=b.sifraNamirnice
inner join korisnik c on b.sifraKorisnika=c.sifra
where c.sifra=:sifra
");
$izraz ->bindParam(":sifra",$sifra);
$izraz -> execute();
$namirnice = $izraz -> fetchAll(PDO::FETCH_OBJ);

    			
    		foreach ($namirnice as $n) :
				
				$html.="<tr>";
				$html.="<br>";
					$html.="<td>" . $n->barkod . "</td>";
					$html.="<td>" . $n->naziv . "</td>";
					$html.="<td>" . $n->jedinicaMjere . "</td>";
					$html.="<td>" . $n->kolicina . "</td>";
					$d = $n->datumUzimanja;
					$d=substr($d, 8,2) . "." . substr($d, 5,2) . "." . substr($d, 0,4) . ". ". substr($d, 11,8);
					$html.="<td>". $d ."</td>";
					
				$html.="</tr>";
			
			endforeach;




$html.="</tbody>";


$html.="</table>";


// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('Namirnice_korisnika_' . substr($objekt->prezime,0,1) . "." . $objekt->ime . '.pdf', 'I');

//============================================================+
// END OF FILE
//==========================================