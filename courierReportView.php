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
$couriers = $db->getEmployeesByType("Courier");

class PDF extends FPDF
{
    // Page header
    function Header()
    {
        // Arial bold 15
        $this->SetFont('Arial','B',15);

        // Title
        $this->Cell(0,10,'Courier Report','B',0,'L');

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
$pdf->Cell(0,10,$customer->getName()."       ".date_format(date_create($startDate),'m/d/Y')." - ".date_format(date_create($endDate),'m/d/Y'),'B',1,'C');

//header row
$pdf->SetFont('Times','',12);
$pdf->Cell(35,10,"Courier ID",'LRB',0,'C');
$pdf->Cell(35,10,"Name",'LRB',0,'C');
$pdf->Cell(40,10,"Delivery Count",'LRB',0,'C');
$pdf->Cell(40,10,"Amount On Time",'LRB',0,'C');
$pdf->Cell(0,10,"Bonus",'LRB',0,'C');
$pdf->Ln();


 foreach($couriers as $val){ 
    if($pdf->GetY()>260){
        $pdf->AddPage();
    }
    $OnTimeDeliveries = $db->getOnTimeTicketCountByRecipientAndCourierAndDates($customer, $val->getId(), $startDate, $endDate);
    //$OnTimeDeliveries = 3;
    $pdf->Cell(35,10,$val->getId(),'B',0,'C');
    $pdf->Cell(35,10,$val->getFirstName()." ".$val->getLastName(),'B',0,'C');
    $pdf->Cell(40,10,$db->getTicketCountByRecipientAndCourierAndDates($customer, $val->getId(), $startDate, $endDate),'B',0,'C');
    $pdf->Cell(40,10,$OnTimeDeliveries,'B',0,'C');
    $pdf->Cell(0,10,"$".$OnTimeDeliveries * $db->getCompany()->getCourierBonusAmount(),'B',0,'C');
    $pdf->Ln();
 }

//$pdf->Output();
$pdf->Output('D',str_replace(' ', '', $customer->getName())."CourierReport".date("m/d/Y").".pdf");

?>



