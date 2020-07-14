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
$customers = $db->getCustomers();

class PDF extends FPDF
{
    // Page header
    function Header()
    {
        // Arial bold 15
        $this->SetFont('Arial','B',15);

        // Title
        $this->Cell(0,10,'Performance Report','B',0,'L');

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
$pdf->SetFont('Times','',20);
$pdf->Cell(0,10,date_format(date_create($startDate),'m/d/Y')." - ".date_format(date_create($endDate),'m/d/Y'),'B',1,'C');

//header row
$pdf->SetFont('Times','',12);
$pdf->Cell(30,10,"Customer ID",'LRB',0,'C');
$pdf->Cell(55,10,"Name",'LRB',0,'C');
$pdf->Cell(45,10,"Delivery Count",'LRB',0,'C');
$pdf->Cell(35,10,"On-Time",'LRB',0,'C');
$pdf->Cell(0,10,"%",'LRB',0,'C');
$pdf->Ln();


 foreach($customers as $val){ 
    if($pdf->GetY()>260){
        $pdf->AddPage();
    }
    $totalDeliveries = $db->getTicketCountByRecipientAndDates($val,$startDate, $endDate);
    $OnTimeDeliveries = $db->getOnTimeTicketCountByRecipientAndDates($val, $startDate, $endDate);
    if($totalDeliveries != 0)
        $percentOnTime = number_format($OnTimeDeliveries/$totalDeliveries, 2)*100;
    else
        $percentOnTime = 0;
    $pdf->Cell(30,10,$val->getId(),'B',0,'C');
    $pdf->Cell(55,10,$val->getName(),'B',0,'L');
    $pdf->Cell(45,10,$totalDeliveries,'B',0,'C');
    $pdf->Cell(35,10,$OnTimeDeliveries,'B',0,'C');
    $pdf->Cell(0,10,"   ".$percentOnTime."% ",'B',0,'L');

    $pdf->Ln();
 }

//$pdf->Output();
$pdf->Output('D',"PerformanceReport".date("m/d/Y").".pdf");

?>

