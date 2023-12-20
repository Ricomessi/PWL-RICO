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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Welcome <?php echo isset($userData['full_name']) ? $userData['full_name'] : 'User'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-300">

    <!-- Navigation -->
    <nav class="navbar fixed-up navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand text-white" href="#">Cashier App</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="main.php">Main Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="form.php">Isi Formulir</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="cari.php">Cari Data</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="manage.php">Atur Data</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-danger" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h1 class="text-4xl text-center">Welcome, <?php echo isset($userData['full_name']) ? htmlspecialchars($userData['full_name']) : 'User'; ?>!</h1>
                    </div>
                    <div class="card-body text-center">
                        <?php if (isset($userData['profile'])) : ?>
                            <?php
                            $profileImagePath = "uploads/" . htmlspecialchars($userData['profile']);
                            $defaultImagePath = "uploads/OIP.jpg";
                            ?>
                            <img src="<?php echo $profileImagePath; ?>" alt="Profile Picture" class="mx-auto rounded-circle img-thumbnail mb-4" style="width: 150px; height: 150px; object-fit: cover;">
                        <?php else : ?>
                            <img src="<?php echo $defaultImagePath; ?>" alt="Default Profile Picture" class="mx-auto rounded-circle img-thumbnail mb-4" style="width: 150px; height: 150px; object-fit: cover;">
                        <?php endif; ?>
                        <p class="font-bold"><?php echo isset($userData['full_name']) ? htmlspecialchars($userData['full_name']) : ''; ?></p>
                        <p class="mb-2">Username: <?php echo isset($userData['username']) ? htmlspecialchars($userData['username']) : ''; ?></p>
                        <p class="mb-4">Email: <?php echo isset($userData['email']) ? htmlspecialchars($userData['email']) : ''; ?></p>
                        <!-- Display other user data as needed -->

                        <a href="editprofile.php" class="btn btn-info">Edit Profile</a>
                        <a href="profilpdf.php" class="btn btn-primary">Save Data</a>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Chart Container -->
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <canvas id="jenisBarangChart" width="10" height="10"></canvas>
                </div>
            </div>
        </div>
    </div>


    <!-- Chart Script -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var ctx = document.getElementById('jenisBarangChart').getContext('2d');

            // Fetch data from the server (Assuming PHP script is named 'chartdata.php')
            fetch('chartdata.php')
                .then(response => response.json())
                .then(data => {
                    var chartData = {
                        labels: data.labels,
                        datasets: [{
                            data: data.values,
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.7)',
                                'rgba(54, 162, 235, 0.7)',
                                'rgba(255, 206, 86, 0.7)',
                                'rgba(75, 192, 192, 0.7)',
                                'rgba(153, 102, 255, 0.7)',
                                'rgba(255, 159, 64, 0.7)',
                                'rgba(201, 203, 207, 0.7)',
                                'rgba(255, 99, 132, 0.7)'
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)',
                                'rgba(201, 203, 207, 1)',
                                'rgba(255, 99, 132, 1)'
                            ],
                            borderWidth: 1
                        }]
                    };

                    var options = {
                        responsive: true,
                        maintainAspectRatio: true
                    };

                    var myPieChart = new Chart(ctx, {
                        type: 'pie',
                        data: chartData,
                        options: options
                    });
                })
                .catch(error => console.error('Error fetching data:', error));
        });
    </script>

    <br>
    <br>
    <br>
    <!-- Footer -->
    <nav class="navbar fixed-bottom navbar-dark bg-dark">
        <div class="container">
            <span class="navbar-text">
                &copy; <?php echo date("Y"); ?> Made by Rico Mesias Tamba
            </span>
        </div>
    </nav>

</body>

</html>