<?php
include('db_connect.php');
// memanggil library FPDF
require('../fpdf185/fpdf.php');
// intance object dan memberikan pengaturan halaman PDF
$pdf = new FPDF('P', 'mm', 'A4');
$pdf->AddPage();

$pdf->SetFont('Times', 'B', 13);
$pdf->Cell(200, 10, 'Ganerate Laporan', 0, 0, 'C');

$pdf->Ln(10); //Line break


$pdf->Cell(10, 15, '', 0, 1);
$pdf->SetFont('Times', 'B', 9);
$pdf->Cell(10, 7, 'No', 1, 0, 'C');
$pdf->Cell(50, 7, 'NAME', 1, 0, 'C');
$pdf->Cell(55, 7, 'PRODUCT', 1, 0, 'C');
$pdf->Cell(30, 7, 'HARGA', 1, 0, 'C');
$pdf->Cell(45, 7, 'STATUS', 1, 0, 'C');

$pdf->Cell(10, 7, '', 0, 1);
$pdf->SetFont('Times', '', 10);
$data = file('print.txt');


$i = 1;
$cat = array();
$cat[] = '';
$qry = $conn->query("SELECT * FROM categories ");
while ($row = $qry->fetch_assoc()) {
    $cat[$row['id']] = $row['name'];
}
$books = $conn->query("SELECT b.*, u.name as uname,p.name,p.bid_end_datetime bdt FROM bids b inner join users u on u.id = b.user_id inner join products p on p.id = b.product_id ");
while ($row = $books->fetch_assoc()) {

    // start multi cell

    // foreach ($row as $item) {
    //     $cellWidth = 80; //wrapped cell width
    //     $cellHeight = 5; //normal one-line cell height

    //     //check whether the text is overflowing
    //     if ($pdf->GetStringWidth($item[2]) < $cellWidth) {
    //         //if not, then do nothing
    //         $line = 1;
    //     } else {
    //         //if it is, then calculate the height needed for wrapped cell
    //         //by splitting the text to fit the cell width
    //         //then count how many lines are needed for the text to fit the cell

    //         $textLength = strlen($item[2]);    //total text length
    //         $errMargin = 10;        //cell width error margin, just in case
    //         $startChar = 0;        //character start position for each line
    //         $maxChar = 0;            //maximum character in a line, to be incremented later
    //         $textArray = array();    //to hold the strings for each line
    //         $tmpString = "";        //to hold the string for a line (temporary)

    //         while ($startChar < $textLength) { //loop until end of text
    //             //loop until maximum character reached
    //             while (
    //                 $pdf->GetStringWidth($tmpString) < ($cellWidth - $errMargin) &&
    //                 ($startChar + $maxChar) < $textLength
    //             ) {
    //                 $maxChar++;
    //                 $tmpString = substr($item[2], $startChar, $maxChar);
    //             }
    //             //move startChar to next line
    //             $startChar = $startChar + $maxChar;
    //             //then add it into the array so we know how many line are needed
    //             array_push($textArray, $tmpString);
    //             //reset maxChar and tmpString
    //             $maxChar = 0;
    //             $tmpString = '';
    //         }
    //         //get number of line
    //         $line = count($textArray);
    //     }
    // }

    // end multi cell

    $get = $conn->query("SELECT * FROM bids where product_id = {$row['product_id']} order by bid_amount desc limit 1 ");
    $uid = $get->num_rows > 0 ? $get->fetch_array()['user_id'] : 0;

    $pdf->Cell(10, 7, $i++, 1, 0, 'C');
    $pdf->Cell(50, 7, $row['uname'], 1, 0, 'C');
    // $pdf->MultiCell($cellWidth, $cellHeight, $item[2], $row['name'], 1);
    $pdf->Cell(55, 10, $row['name'], 1, 0, 'C');
    $pdf->Cell(30, 7, $row['bid_amount'], 1, 0, 'C');
    if ($row['status'] == 1) {
        if (strtotime(date('Y-m-d H:i')) < strtotime($row['bdt'])) {
            $pdf->Cell(45, 7,  "Bidding Stage", 1, 0, 'C');
        } else {
            if ($uid == $row['user_id']) {
                $pdf->Cell(45, 7,  "menang lelang", 1, 0, 'C');
            } else {
                $pdf->Cell(45, 7,  "kalah lelang", 1, 0, 'C');
            }
        }
    } elseif ($row['status'] == 2) {
        $pdf->Cell(30, 7,  "confirmed", 1, 0, 'C');
    } else {
        $pdf->Cell(30, 7,  "cancel", 1, 0, 'C');
    }
    $pdf->Ln(20); //Line break

    $qryy = $conn->query("SELECT * FROM users where id= " . $row['user_id']);
    while ($val = $qryy->fetch_assoc()) {

        $pdf->Cell(10, 0, 'Name:', 0, 0, 'L');
        $pdf->Cell(10, 0, $val['name'], 0, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(10, 0, 'Email:', 0, 0, 'L');
        $pdf->Cell(10, 0, $val['email'], 0, 3, 'L');
        $pdf->Ln(6);
        $pdf->Cell(13, 0, 'Contact: ', 0, 0, 'L');
        $pdf->Cell(13, 0, $val['contact'], 0, 3, 'L');
        $pdf->Ln(6);
        $pdf->Cell(13, 0, 'Alamat:', 0, 0, 'L');
        $pdf->Cell(13, 0, $val['address'], 0, 3, 'L');
    }

    $pdf->Line(10, 30, 200, 30);

    $pdf->Ln(6); //Line break
    $pdf->Cell(14, 0, 'Tanggal:', 0, 0, 'C');
    $pdf->Cell(30, 0, $row['date_created'], 0, 0, 'C');
}


$pdf->Output();
