<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username2'])) {
    header("Location: userver.php");
    exit();
}
$errors = array();
$success = "";
if (isset($_SESSION['errors'])) {
    $errors = $_SESSION['errors'];
    unset($_SESSION['errors']);
} else if (isset($_SESSION['success'])) {
    $success = $_SESSION['success'];
    unset($_SESSION['success']);
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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Edit Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-300">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand text-white" href="#">Cashier App</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="main.php">Kembali</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <?php
    if (!empty($errors)) {
        echo '<div class="max-w-4xl mx-auto p-4 bg-red-200 rounded-lg shadow-md mb-8">';
        echo '<h2 class="text-2xl text-red-700 mb-2">Pesan Kesalahan:</h2>';
        echo '<ul class="list-disc list-inside text-red-700">';
        foreach ($errors as $error) {
            echo '<li>' . $error . '</li>';
        }
        echo '</ul>';
        echo '</div>';
    } else if (!empty($success)) {
        echo '<div class="max-w-4xl mx-auto p-4 bg-green-200 rounded-lg shadow-md mb-8">';
        echo '<ul class="list-disc list-inside text-green-700">';
        echo '<li>' . $success . '</li>';
        echo '</ul>';
        echo '</div>';
    }
    ?>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h1 class="text-4xl text-center">Edit Your Profile</h1>
                    </div>
                    <div class="card-body">
                        <form action="processupdateprofile.php" method="post" enctype="multipart/form-data">
                            <!-- Full Name -->
                            <div class="mb-3">
                                <label for="editFullName" class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="editFullName" name="editFullName" value="<?php echo isset($userData['full_name']) ? htmlspecialchars($userData['full_name']) : ''; ?>" required>
                            </div>

                            <!-- Email -->
                            <div class="mb-3">
                                <label for="editEmail" class="form-label">Email</label>
                                <input type="email" class="form-control" id="editEmail" name="editEmail" value="<?php echo isset($userData['email']) ? htmlspecialchars($userData['email']) : ''; ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="editProfilePicture" class="form-label">Profile Picture</label>
                                <input type="file" class="form-control" id="editProfilePicture" name="editProfilePicture">
                                <?php if (isset($userData['profile'])) : ?>
                                    <img src="uploads/<?php echo htmlspecialchars($userData['profile']); ?>" alt="Current Profile Picture" class="mt-2" style="width: 100px; height: 100px; object-fit: cover;">
                                <?php endif; ?>
                            </div>

                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <nav class="navbar fixed-bottom navbar-dark bg-dark">
        <div class="container">
            <span class="navbar-text">
                &copy; <?php echo date("Y"); ?> Made by Rico Mesias Tamba
            </span>
        </div>
    </nav>

</body>

</html>