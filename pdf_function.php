<?php
function generatePDFReceipt($data)
{

    require_once('TCPDF-main\tcpdf.php');

    $pdf = new TCPDF();

    // Set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Rico Mesias Tamba');
    $pdf->SetTitle('Purchase Receipt');
    $pdf->SetSubject('Purchase Receipt');

    // Add a page
    $pdf->AddPage();

    // Set font
    $pdf->SetFont('times', 'B', 16);

    // Output purchase data in the PDF
    foreach ($data as $row) {
        $pdf->Cell(0, 10, 'Purchase ID: ' . $row['id_pembeli'], 0, 1, 'C');
        $pdf->Cell(0, 10, 'Date: ' . $row['Tgl_Transaksi'], 0, 1, 'C');

        // Output customer information
        $pdf->Cell(0, 10, 'Customer Name: ' . $row['nama'], 0, 1, 'C');
        $pdf->Cell(0, 10, 'Address: ' . $row['alamat'], 0, 1, 'C');
        $pdf->Cell(0, 10, 'Phone Number: ' . $row['HP'], 0, 1, 'C');

        // Output purchased items
        $pdf->Ln(10);
        $pdf->Cell(0, 10, 'Purchased Items:', 0, 1, 'L');
        $pdf->Ln(5);

        // Headers for the purchased items table
        $pdf->SetFont('times', 'B', 12);
        $pdf->Cell(40, 10, 'Item', 1, 0, 'C');
        $pdf->Cell(30, 10, 'Quantity', 1, 0, 'C');
        $pdf->Cell(40, 10, 'Unit Price', 1, 0, 'C');
        $pdf->Cell(50, 10, 'Total', 1, 1, 'C');

        $pdf->SetFont('times', '', 12);

        // Output each item in a row
        $pdf->Cell(40, 10, $row['Nama_Barang'], 1, 0, 'L');
        $pdf->Cell(30, 10, $row['Jumlah'], 1, 0, 'C');
        $pdf->Cell(40, 10, 'Rp ' . number_format($row['Harga'], 0, ',', '.'), 1, 0, 'R');

        // Calculate total for the purchased item
        $total_item = $row['Jumlah'] * $row['Harga'];
        $pdf->Cell(50, 10, 'Rp ' . number_format($total_item, 0, ',', '.'), 1, 1, 'R');

        $pdf->Ln(10);
    }

    // Output the PDF
    $pdf->Output('purchase_receipt.pdf', 'D');
}
