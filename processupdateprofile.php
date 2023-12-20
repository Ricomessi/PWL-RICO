<?php
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

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the updated profile information from the form
    $editFullName = $_POST['editFullName'];
    $editEmail = $_POST['editEmail'];

    // Common initialization for both cases
    $updateQuery = "UPDATE mesias SET full_name = ?, email = ?";
    $bindParams = "ss";

    // Check if a new profile picture is uploaded
    if (!empty($_FILES['editProfilePicture']['tmp_name']) && is_uploaded_file($_FILES['editProfilePicture']['tmp_name'])) {
        $uploadDir = "uploads/";
        $uploadPath = $uploadDir . basename($_FILES['editProfilePicture']['name']);

        // Move the uploaded file to the specified directory
        if (move_uploaded_file($_FILES['editProfilePicture']['tmp_name'], $uploadPath)) {
            $profilePictureFileName = basename($_FILES['editProfilePicture']['name']);

            // Update the profile information including the profile picture file name
            $updateQuery .= ", profile = ?";
            $bindParams .= "s";
            $stmt = $koneksi->prepare($updateQuery . " WHERE username = ?");
            $stmt->bind_param($bindParams . "s", $editFullName, $editEmail, $profilePictureFileName, $username);
        } else {
            // Handle the case where file upload fails
            $_SESSION['errors'] = array("Failed to upload the profile picture. Please try again.");
            header("Location: editprofile.php");
            exit();
        }
    } else {
        // Update the profile information excluding the profile picture file name
        $stmt = $koneksi->prepare($updateQuery . " WHERE username = ?");
        $stmt->bind_param($bindParams . "s", $editFullName, $editEmail, $username);
    }

    // Execute the update query
    if ($stmt->execute()) {
        $_SESSION['success'] = "Profile updated successfully!";
        header("Location: editprofile.php");
        exit();
    } else {
        // Handle the case where the update query fails
        $_SESSION['errors'] = array("Failed to update profile. Please try again.");
        header("Location: editprofile.php");
        exit();
    }
}
