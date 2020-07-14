<?php
session_start();
if (!isset($_SESSION['acme_user_id'])){
  echo "<script>document.location = 'login.php'</script>";
}
require './fpdf181/fpdf.php';
require('utilities/database.php');
$db = new DATABASE();
$user = $db->getUserById($_SESSION['acme_user_id']);
if ($user->getPermission() != 'Admin') {
  echo "<script>document.location = 'index.php'</script>";
}
$startDate = date_format(date_create($_POST['startDate']), 'Y/m/d');
$endDate = date_format(date_create($_POST['endDate']), 'Y/m/d');
$customerID = $_POST['customer'];
$customer = $db->getCustomerById($customerID);
$tickets = $db->getTicketsByBillToIdAndDates($customerID, $startDate, $endDate);


class PDF extends FPDF
{
    // Page header
    function Header()
    {
        // Arial bold 15
        $this->SetFont('Arial','B',15);

        // Title
        $this->Cell(0,10,'Billing Report','B',0,'L');

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
        $this->Cell(0,8,date("m/d/Y"),0,1,'C');

    }
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);



// Instanciation of inherited class
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(true);
$pdf->AddPage();

//header name
$pdf->SetFont('Times','',25);
$pdf->Cell(0,10,$customer->getName()."    ".date_format(date_create($startDate),'m/d/Y')." - ".date_format(date_create($endDate),'m/d/Y'),'B',1,'C');

//header row
$pdf->SetFont('Times','',12);
$pdf->Cell(20,10,"Ticket ID",'LRB',0,'C');
$pdf->Cell(50,10,"Sender Location",'LRB',0,'C');
$pdf->Cell(50,10,"Recipient Location",'LRB',0,'C');
$pdf->Cell(40,10,"Date",'LRB',0,'C');
$pdf->Cell(0,10,"Cost",'LRB',0,'C');
$pdf->Ln();


foreach($tickets as $val){ 
    if($pdf->GetY()>260){
        $pdf->AddPage();
    }
    $pdf->Cell(20,10,$val['ticket']->getId(),'B',0,'C');
    $pdf->Cell(50,10,$val['sender']->getIntersection()->getStreetX()->getName()." & ".$val['sender']->getIntersection()->getStreetY()->getName(),'B',0,'C');
    $pdf->Cell(50,10,$val['recipient']->getIntersection()->getStreetX()->getName()." & ".$val['recipient']->getIntersection()->getStreetY()->getName(),'B',0,'C');
    $pdf->Cell(40,10,$val['ticket']->getDate(),'B',0,'C');
    $pdf->Cell(0,10,$val['ticket']->getCost(),'B',0,'C');
    $pdf->Ln();
}

//$pdf->Output();
$pdf->Output('D',str_replace(' ', '', $customer->getName())."BillingReport".date("m/d/Y").".pdf");

?>




