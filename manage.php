<?php
session_start();

if (!isset($_SESSION['username2'])) {
    $errorsu = "Anda harus login terlebih dahulu untuk dapat mengakses URL Tersebut";
    $_SESSION['errorsu'] = $errorsu;
    header("Location: userver.php");
    exit();
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Form Pendataan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            padding-bottom: 70px;
        }

        table {
            max-height: calc(150vh - 200px);
            /* Adjust the value based on your specific layout */
            overflow-y: auto;
        }
    </style>
</head>

<body class="bg-gray-300">
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

    <table class="max-w-8xl mx-auto mt-8 bg-gray-100 rounded-lg shadow-md">
        <thead class="bg-gray-200">
            <tr>
                <th class="px-4 py-2">ID Pelanggan</th>
                <th class="px-4 py-2">Nama</th>
                <th class="px-4 py-2">Alamat</th>
                <th class="px-4 py-2">Nomor HP</th>
                <th class="px-4 py-2">Tanggal Transaksi</th>
                <th class="px-4 py-2">Jenis Barang</th>
                <th class="px-4 py-2">Nama Barang</th>
                <th class="px-4 py-2">Jumlah</th>
                <th class="px-4 py-2">Harga</th>
                <th class="px-4 py-2">Total Bayar</th>
                <th class="px-4 py-2">Update</th>
                <th class="px-4 py-2">Delete</th>
                <th class="px-4 py-2">Struk</th>
            </tr>
        </thead>
        <?php
        include 'koneksi.php';

        $sql = "SELECT COUNT(*) as total_records FROM  tamba";
        $result = $koneksi->query($sql);
        $row = $result->fetch_assoc();
        $total_records = $row['total_records'];

        // Jumlah data yang ingin ditampilkan per halaman
        $records_per_page = 7;

        // Halaman yang sedang ditampilkan, diambil dari parameter "page" dalam URL
        $page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;

        // Hitung offset (posisi awal data untuk halaman saat ini)
        $offset = ($page - 1) * $records_per_page;

        $sql = "SELECT * FROM tamba LIMIT $records_per_page OFFSET $offset";
        $result = $koneksi->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td class='border px-4 py-2'>" . $row['id_pembeli'] . "</td>";
                echo "<td class='border px-4 py-2'>" . $row['nama'] . "</td>";
                echo "<td class='border px-4 py-2'>" . $row['alamat'] . "</td>";
                echo "<td class='border px-4 py-2'>" . $row['HP'] . "</td>";
                echo "<td class='border px-4 py-2'>" . $row['Tgl_Transaksi'] . "</td>";
                echo "<td class='border px-4 py-2'>" . $row['Jenis_barang'] . "</td>";
                echo "<td class='border px-4 py-2'>" . $row['Nama_Barang'] . "</td>";
                echo "<td class='border px-4 py-2'>" . $row['Jumlah'] . "</td>";


                // Format Harga
                $formatted_harga = "Rp " . number_format($row['Harga'], 0, ',', '.');

                echo "<td class='border px-4 py-2'>" . $formatted_harga . "</td>";

                // Format Total Bayar
                $total_bayar = $row['Jumlah'] * $row['Harga'];
                $formatted_total_bayar = "Rp " . number_format($total_bayar, 0, ',', '.');

                echo "<td class='border px-4 py-2'>" . $formatted_total_bayar . "</td>";

                echo '<td class="border px-4 py-2"><a href="update.php?id=' . $row['id_pembeli'] . '" class="btn btn-primary">Update</a></td>';
                echo '<td class="border px-4 py-2"><a href="delete.php?id=' . $row['id_pembeli'] . '" class="btn btn-danger">Delete</a></td>';
                echo '<td class="border px-4 py-2"><a href="generate_pdf.php?id=' . $row['id_pembeli'] . '" class="btn btn-success">Print Receipt</a></td>';

                echo "</tr>";
            }
        } else {
            echo "<tr><td class='border px-4 py-2' colspan='11'>Tidak ada data transaksi.</td></tr>";
        }

        $koneksi->close();
        ?>
    </table>

    <div class="mt-4 mx-4">
        <?php
        $total_pages = ceil($total_records / $records_per_page);

        if ($total_pages > 1) {
            if ($page > 1) {
                $prev_page = $page - 1;
                echo '<a class="btn btn-secondary" href="manage.php?page=' . $prev_page . '">Previous</a> ';
            }

            for ($i = 1; $i <= $total_pages; $i++) {
                if ($i == $page) {
                    echo '<span class="btn btn-secondary">' . $i . '</span> ';
                } else {
                    echo '<a class="btn btn-secondary" href="manage.php?page=' . $i . '">' . $i . '</a> ';
                }
            }

            if ($page < $total_pages) {
                $next_page = $page + 1;
                echo '<a class="btn btn-secondary" href="manage.php?page=' . $next_page . '">Next</a>';
            }
        }
        ?>
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