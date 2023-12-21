<?php
session_start();

if (!isset($_SESSION['username2'])) {
    $errorsu = "Anda harus login terlebih dahulu untuk dapat mengakses URL Tersebut";
    $_SESSION['errorsu'] = $errorsu;
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

?>

<!DOCTYPE html>
<html>

<head>
    <title>Form Profil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">

    <style>
        body {
            padding-bottom: 70px;
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
    <h1 class="text-4xl text-center my-8">Formulir Pendataan</h1>
    <form method="post" class="max-w-4xl mx-auto p-8 bg-gray-100 rounded-lg shadow-md" onsubmit="return sendData()">
        <div class="mb-4">
            <label for="nama" class="block text-gray-700">Nama:</label>
            <input type="text" name="nama" id="nama" class="w-full form-input">
        </div>

        <div class="mb-4">
            <label for="alamat" class="block text-gray-700">Alamat:</label>
            <textarea name="alamat" id="alamat" rows="4" class="w-full form-input"></textarea>
        </div>

        <div class="mb-4">
            <label for="hp" class="block text-gray-700">Nomor HP:</label>
            <input type="text" name="hp" id="hp" class="w-full form-input">
        </div>

        <div class="mb-4">
            <label for="tgl_transaksi" class="block text-gray-700">Tanggal Transaksi:</label>
            <input type="date" name="tgl_transaksi" id="tanggal" class="w-full form-input">
        </div>

        <div class="mb-4">
            <label for="jenis_barang" class="block text-gray-700">Jenis Barang:</label>
            <select name="jenis_barang" id="jenis" class="w-full form-select">
                <option value="Elektronik">Elektronik</option>
                <option value="Pakaian">Pakaian</option>
                <option value="Makanan">Makanan</option>
                <option value="Alat Tulis">Alat Tulis</option>
                <option value="Mainan">Mainan</option>
                <option value="Otomotif">Otomotif</option>
                <option value="Perabotan">Perabotan</option>
                <option value="Barang Antik">Barang Antik</option>
            </select>
        </div>

        <div class="mb-4">
            <label for="nama_barang" class="block text-gray-700">Nama Barang:</label>
            <input type="text" name="nama_barang" id="namabarang" class="w-full form-input">
        </div>

        <div class="mb-4">
            <label for="jumlah" class="block text-gray-700">Jumlah:</label>
            <input type="number" name="jumlah" id="jumlah" class="w-full form-input">
        </div>

        <div class="mb-4">
            <label for="harga" class="block text-gray-700">Harga:</label>
            <input type="number" name="harga" id="harga" class="w-full form-input">
        </div>

        <div class="mb-4">
            <input type="submit" value="Simpan" onsubmit="return sendData()" class=" w-full btn btn-primary bg-gray-600">
        </div>
    </form>




    <nav class="navbar fixed-bottom navbar-dark bg-dark">
        <div class="container">
            <span class="navbar-text">
                &copy; <?php echo date("Y"); ?> Made by Rico Mesias Tamba
            </span>
        </div>
    </nav>


    <script>
        function sendData() {
            var xhr = new XMLHttpRequest();
            var url = "https://jsonplaceholder.typicode.com/posts";

            var data = JSON.stringify({
                nama: document.getElementById("nama").value,
                alamat: document.getElementById("alamat").value,
                hp: document.getElementById("hp").value,
                tanggal: document.getElementById("tanggal").value,
                jenis: document.getElementById("jenis").value,
                namabarang: document.getElementById("namabarang").value,
                jumlah: document.getElementById("jumlah").value,
                harga: document.getElementById("harga").value,
            });

            xhr.open("POST", url, true);
            xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
            xhr.onload = function() {
                console.log(this.responseText);
            };
            xhr.send(data);
            return false;
        }
    </script>
</body>

</html>