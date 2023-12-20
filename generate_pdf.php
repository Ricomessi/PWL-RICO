<?php
// Include pdf_functions.php
include 'pdf_function.php';

// Include your database connection file (koneksi.php)
include 'koneksi.php';

if (isset($_GET['id'])) {
    $id_pembeli = $_GET['id'];

    // Fetch data for the specified ID
    $sql = "SELECT * FROM tamba WHERE id_pembeli = $id_pembeli";
    $result = $koneksi->query($sql);
    $purchaseData = $result->fetch_all(MYSQLI_ASSOC);

    // Generate PDF receipt
    generatePDFReceipt($purchaseData);
} else {
    echo 'Invalid ID';
}
