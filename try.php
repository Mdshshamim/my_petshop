<?php
// require('fpdf.php');
require('fpdf_mac_table.php');
// require('include/config.php');

// if (isset($_POST['search']) && $_POST['search'] != '') {
//     $sdate = $_POST['sdate'];
//     $edate = $_POST['edate'];

//     $invoices = $db->prepare("SELECT invoices.id, invoices.invoice_type, invoices.final_cost, payment_history.payment_amount, payment_history.timestamp, payment_history.payment_type, payment_history.cash_type FROM invoices INNER JOIN payment_history  ON invoices.id=payment_history.invoice_id WHERE invoices.timestamp BETWEEN '$sdate' AND '$edate'");
//     $invoices->execute();

//     $expenses = $db->prepare("SELECT * FROM expenses WHERE timestamp BETWEEN '$sdate' AND '$edate'");
//     $expenses->execute();

//     // if ($invoices->rowCount() > 0) {
//     //     while ($invoice = $invoices->fetchObject()) {
//             //echo "<p>".$invoice->timestamp."   ".$invoice->id."   ".$invoice->payment_amount."    ".$invoice->payment_type."    ".$invoice->invoice_type."    ".$invoice->cash_type."     ".$invoice->final_cost."</p>";
//     //     }
//     // }
// }
//create new class extending fpdf class
// class PDF_MC_Table extends FPDF {

// }

$pdf = new PDF_MC_Table();
$pdf->AddPage();
$pdf->SetFont('Arial','',14);
$pdf->SetWidths(Array(20,40,40,30,20,40));
$pdf->SetLineHeight(5);
$pdf->SetAligns(Array('','L','L','','',''));
$pdf->SetFont('Arial','B',14);
$pdf->Cell(20,5,"ID",1,0);
$pdf->Cell(40,5,"First Name",1,0);
$pdf->Cell(40,5,"Last Name",1,0);
$pdf->Cell(30,5,"Email",1,0);
$pdf->Cell(20,5,"Gender",1,0);
$pdf->Cell(40,5,"Address",1,0);
//add a new line
$pdf->Ln();
//reset font
$pdf->SetFont('Arial','',14);
// foreach($data as $item){
    //write data using Row() method containing array of values.
    for($i=0; $i< 100; $i++){
        $pdf->Row(Array(
            "ffadfadfasdfasd",
            "ff",
            "ff",
            "ff",
            "ff",
            "ff",
           ));
    }
    // $pdf->Row(Array(
    //  $item['id'],
    //  $item['first_name'],
    //  $item['last_name'],
    //  $item['email'],
    //  $item['gender'],
    //  $item['address'],
    // ));
    
//    }

// class PDF extends FPDF
// {
//     function Header()
//     {
//         $this->SetFont('Times', 'B', 15);
//         #set logo
//         $this->Cell(12);
//         $this->Image('../assets/img/Alifa-noor2.png', 10, 10, 10, 10);
//         $this->Cell(100, 10, "Art Beauty", 0, 1);
//         $this->Ln(5);

//         $this->SetFont('Times', 'B', 16);
//         $this->Cell(189, 10, 'Account Summary', 0, 1, 'C');
//         $this->Ln(5);

//         $this->SetFont('Times', 'B', 13);
//         $this->Cell(108, 8, '', 0, 0);
//         $this->Cell(27, 8, 'Debit', 0, 0);
//         $this->Cell(27, 8, 'Credit', 0, 0);
//         $this->Cell(27, 8, 'Net Profit', 0, 1);

//         $this->Cell(39, 8, 'Date', 1, 0);
//         $this->Cell(39, 8, 'Description', 1, 0);
//         $this->Cell(30, 8, 'Memo No', 1, 0);
//         $this->Cell(27, 8, 'Expense', 1, 0);
//         $this->Cell(27, 8, 'Income', 1, 0);
//         $this->Cell(27, 8, 'Net Profit', 1, 1);
//     }
//     function Footer()
//     {
//         $this->SetY(-15);
//         $this->SetFont('Arial', 'B', 8);
//         $this->Cell(0, 10, "Page No: " . $this->PageNo() . '/ {pages}', 0, 1, 'C');
//     }
// }

// $pdf = new PDF('P', 'mm', 'A4');
// $pdf->AddPage();

// $pdf->AliasNbPages('{pages}');

//         $pdf->Cell(39, 8, 'adf asdf sdfasdf asdf adfa sdfas', 1, 0);
//         $pdf->Cell(39, 8, '', 1, 0);
//         $pdf->Cell(30, 8, '', 1, 0);
//         $pdf->Cell(27, 8, '', 1, 0);
//         $pdf->Cell(27, 8, '', 1, 0);
//         $pdf->Cell(27, 8, '', 'LR', 1);

// $pdf->SetFont('Times', '', 12);
// if ($invoices->rowCount() > 0) {
//     while ($invoice = $invoices->fetchObject()) {
//         if($invoice->cash_type == "due"){
//             $invoice->final_cost= 0;
//             $invoice->invoice_type= "Due Payment";
//         }

//         $pdf->Cell(39, 8, $invoice->timestamp, 1, 0);
//         $pdf->Cell(39, 8, $invoice->invoice_type.'('.$invoice->payment_type.')', 1, 0);
//         $pdf->Cell(30, 8, $invoice->id, 1, 0);
//         $pdf->Cell(27, 8, $invoice->final_cost, 1, 0);
//         $pdf->Cell(27, 8, $invoice->payment_amount, 1, 0);
//         $pdf->Cell(27, 8, '', 'LR', 1);
//         //echo "<p>".$invoice->timestamp."   ".$invoice->id."   ".$invoice->payment_amount."    ".$invoice->payment_type."    ".$invoice->invoice_type."    ".$invoice->cash_type."     ".$invoice->final_cost."</p>";
//     }
// }


$pdf->Output();
