<?php
require_once('TCPDF-main/tcpdf.php');

session_start();

// Check if the user is logged in
if (!isset($_SESSION['username2'])) {
    header("Location: userver.php");
    exit();
}

include("koneksi.php");

// Fetch user data based on the session information
$username = $_SESSION['username2'];
$selectQuery = "SELECT * FROM mesias WHERE username = ?";
$stmt = $koneksi->prepare($selectQuery);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

// Check if user data is available
if ($result->num_rows > 0) {
    $userData = $result->fetch_assoc();
} else {
    // Handle the case where user data is not found (optional)
    $userData = array(); // You can set it to an empty array or handle it as needed
}

$stmt->close();

// Get the profile image path
$profileImagePath = "uploads/" . htmlspecialchars($userData['profile']);
$defaultImagePath = "default.jpg";

// Create PDF content
$pdfContent = "
    <h1>Data Profile For, " . htmlspecialchars($userData['full_name']) . "!</h1>
    <p><strong>Username:</strong> " . htmlspecialchars($userData['username']) . "</p>
    <p><strong>Email:</strong> " . htmlspecialchars($userData['email']) . "</p>
    <p><strong>Profile Picture:</strong></p>
    <img src=\"$profileImagePath\" alt=\"Profile Picture\" style=\"width: 150px; height: 150px; object-fit: cover;\">
    <!-- Include other user data as needed -->
";

// Create an instance of the TCPDF class
$pdf = new TCPDF();

// Set document information
$pdf->SetCreator('Your Name');
$pdf->SetAuthor('Your Name');
$pdf->SetTitle('User Profile');
$pdf->SetSubject('User Profile PDF');
$pdf->SetKeywords('TCPDF, PDF, user, profile');

// Add a page
$pdf->AddPage();

// Set font
$pdf->SetFont('times', 'N', 12);

// Write PDF content
$pdf->writeHTML($pdfContent, true, false, true, false, '');

// Output PDF
$pdf->Output('user_profile.pdf', 'D'); // 'D' option prompts the browser to download the file
