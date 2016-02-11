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


$izraz = $veza -> prepare("select * from tvrtka where sifra=:sifra");
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
$pdf->SetTitle('Namirnice tvrtke ' . $objekt->naziv);
$pdf->SetSubject('Podaci o doniranim namirnicama');
$pdf->SetKeywords('Namirnice');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, "Izvještaj doniranih namirnica tvrtke ", $objekt->naziv, array(0,64,255), array(0,64,128));
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
$html.="<h1>Socijalna samoposluga</h1>";
$html.="<br />";
$html.="<br />";

$html.="<table>";
$html.="<tr>";
	$html.="<th>Naziv:</th>";
	$html.="<td>". $objekt -> naziv ."</td>";
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
	$html.="<th>Ime kontakt osobe:</th>";
	$html.="<td>". $objekt->imeKontaktOsobe ."</td>";
$html.="</tr>";

$html.="<tr>";
	$html.="<th>Prezime kontakt osobe:</th>";
	$html.="<td>". $objekt -> prezimeKontaktOsobe ."</td>";	
$html.="</tr>";

$html.="<tr>";
	$html.="<th>Telefon kontakt osobe:</th>";
	$html.="<td>". $objekt -> telKontaktOsobe ."</td>";
$html.="</tr>";

$html.="<tr>";
	$html.="<th>Email:</th>";
	$html.="<td>". $objekt -> email ."</td>";
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
$html.="<th>Naziv</th>";
$html.="<th>Datum isporuke</th>";
$html.="<th>&nbsp;&nbsp;&nbsp;Količina</th>";
$html.="<th>Jedinica mjere</th>";
$html.="<th>&nbsp;&nbsp;&nbsp;Rok trajanja</th>";
$html.="</tr>";
$html.="</thead>";



$html.="<tbody>";
$izraz = $veza -> prepare("
select
a.sifra,a.naziv,b.sifraNamirnice,b.datumIsporuke,b.kolicina,b.rokTrajanja,c.naziv,c.stanje,c.jedinicaMjere
from tvrtka a
inner join donira b on a.sifra=b.sifraTvrtke
inner join namirnica c on b.sifraNamirnice=c.sifra
where a.sifra=:sifra
");
$izraz ->bindParam(":sifra",$sifra);
$izraz -> execute();
$namirnice = $izraz -> fetchAll(PDO::FETCH_OBJ);

    				
    		foreach ($namirnice as $n) :
				
				$html.="<tr>";
					$html.="<br>";
					$html.="<td>" . $n->naziv . "</td>";
					$di = $n->datumIsporuke;
					$di=substr($di, 8,2) . "." . substr($di, 5,2) . "." . substr($di, 0,4) . ". ". substr($di, 11,8);
					$html.="<td>". $di ."</td>";
					$html.="<td>&nbsp;&nbsp;&nbsp;" . $n->kolicina . "</td>";
					$html.="<td>" . $n->jedinicaMjere . "</td>";
					if(strtotime($n->rokTrajanja)!=0){
						$dt = $n->rokTrajanja;
						$dt=substr($dt, 8,2) . "." . substr($dt, 5,2) . "." . substr($dt, 0,4);
						$html.="<td>&nbsp;&nbsp;&nbsp;". $dt ."</td>";
					}
					
					
				$html.="</tr>";
			
			endforeach;




$html.="</tbody>";


$html.="</table>";


// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('Namirnice_tvrtke_' . $objekt->naziv . '.pdf', 'I');

//============================================================+
// END OF FILE
//==========================================