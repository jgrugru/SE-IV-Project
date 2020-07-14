<?php
require './fpdf181/fpdf.php';
require('utilities/database.php');
$db = new DATABASE();




class PDF extends FPDF
{
    // Page header
    function Header()
    {
        // Arial bold 15
        $this->SetFont('Arial','B',15);

        // Title
        $this->Cell(0,10,'Instructions','B',0,'L');

        // Move to the right
        $this->Cell(80);

        // Logo
        $this->Image('ACMEB.png',$this->GetPageWidth()-40,9,30);

        // Line break
        $this->Ln(20);
    }

    // Page footer
    function Footer()
    {

        $this->Image('ACMEB.png',$this->GetPageWidth()-40,$this->GetPageHeight()-30,30);
        // Position at 1.5 cm from bottom
        $this->SetY(-40);
        $this->Cell(0,10,' ','B',1,'C');

        // Arial italic 8
        $this->SetFont('Arial','I',8);
        // Page number
        $this->Cell(0,8,'Page '.$this->PageNo().'/{nb}',0,1,'C');
        $this->Cell(0,8,date('m/d/Y'),0,1,'C');

    }
}



// Instanciation of inherited class
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(true);
$pdf->AddPage();



$fullDirections = $_GET['direct'];

//header name
$pdf->SetFont('Times','',12);
$fullDirections = array(2, 9, 16);
$lengthOfFullTrip = sizeof($fullDirections);


 for($x = 0; $x<$lengthOfFullTrip; $x++){
   if($pdf->GetY()>260){
           $pdf->AddPage();
      }

    $intersection = $db->getIntersectionById($fullDirections[$x]);
    $pdf->Cell(0,10,$intersection->getStreetX()->getName(). " , ".$intersection->getStreetY()->getName(),'B',0,'C');
    $pdf->Ln();
 }


$pdf->Output();
$pdf->Output('D',"Instructions".date("m/d/Y").".pdf");

?>
