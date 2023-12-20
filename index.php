<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <style>
        .body {
            padding-bottom: 70px;
        }

        .hero-section {
            background-image: url('img/kucing.jpg');
            background-size: cover;
            background-position: center;
            color: #fff;
            padding: 100px 0;
            text-align: center;
        }

        .cta-button {
            background-color: #007BFF;
            color: #fff;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        footer {
            bottom: 0;
            width: 100%;
            background-color: #343a40;
            /* Use your preferred color */
            color: #fff;
            text-align: center;
            padding: 10px 0;
        }

        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .container {
            flex: 1;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Cashier App</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            </div>
        </div>
    </nav>

    <section class="hero-section">
        <div class="container">
            <h1 class="display-4"><strong>Selamat datang di Web Belanja</strong></h1>
            <p class="lead"><strong>Discover amazing features and services.</strong></p>
            <a href="userver.php" class="btn btn-lg cta-button"><strong>Get Started</strong></a>
        </div>
    </section>

    <?php
    include 'koneksi.php';

    $sql = "SELECT COUNT(*) as total_records FROM tamba";
    $result = $koneksi->query($sql);
    $row = $result->fetch_assoc();
    $total_records = $row['total_records'];


    $records_per_page = 7;

    // Halaman yang sedang ditampilkan, diambil dari parameter "page" dalam URL
    $page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;

    // Hitung offset (posisi awal data untuk halaman saat ini)
    $offset = ($page - 1) * $records_per_page;

    $sql = "SELECT id_pembeli, nama, HP, Nama_Barang, Harga, Jumlah, Jumlah * Harga as TotalBayar FROM tamba LIMIT $records_per_page OFFSET $offset";
    $result = $koneksi->query($sql);
    ?>

    <table>
        <thead>
            <tr>
                <th>ID Pelanggan</th>
                <th>Nama</th>
                <th>Nomor HP</th>
                <th>Nama Barang</th>
                <th>Harga</th>
                <th>Total Bayar</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['id_pembeli'] . "</td>";
                    echo "<td>" . $row['nama'] . "</td>";
                    echo "<td>" . $row['HP'] . "</td>";
                    echo "<td>" . $row['Nama_Barang'] . "</td>";
                    echo "<td>" . "Rp " . number_format($row['Harga'], 0, ',', '.') . "</td>";
                    echo "<td>" . "Rp " . number_format($row['Jumlah'] * $row['Harga'], 0, ',', '.') . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>Tidak ada data transaksi.</td></tr>";
            }

            $koneksi->close();
            ?>

        </tbody>
    </table>

    <div class="mt-4 mx-4">
        <?php
        $total_pages = ceil($total_records / $records_per_page);

        if ($total_pages > 1) {
            if ($page > 1) {
                $prev_page = $page - 1;
                echo '<a class="btn btn-secondary" href="index.php?page=' . $prev_page . '">Previous</a> ';
            }

            for ($i = 1; $i <= $total_pages; $i++) {
                if ($i == $page) {
                    echo '<span class="btn btn-secondary">' . $i . '</span> ';
                } else {
                    echo '<a class="btn btn-secondary" href="index.php?page=' . $i . '">' . $i . '</a> ';
                }
            }

            if ($page < $total_pages) {
                $next_page = $page + 1;
                echo '<a class="btn btn-secondary" href="index.php?page=' . $next_page . '">Next</a>';
            }
        }
        ?>
    </div>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>

    <!-- Footer Section -->
    <footer class="bg-dark text-light py-3 text-center">
        <div class="container">
            &copy; <?php echo date("Y"); ?> Made by Rico Mesias Tamba
        </div>
    </footer>

    <!-- Include Bootstrap JS (Optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-6ZjFdOed1Fm5nZLxF5LIR9Zwuvzv4C5sXH7U1uOD7z7pJ79R5DGhFbrTVvCht6o4l" crossorigin="anonymous"></script>
</body>

</html>