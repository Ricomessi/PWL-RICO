<?php
session_start();
if (!isset($_SESSION['username2'])) {
    echo 'Attempting to redirect...';
    header('Location: userver.php');
    exit();
}

$errors = array();
if (isset($_SESSION['errorsu'])) {
    if (is_array($_SESSION['errorsu'])) {
        $errors = $_SESSION['errorsu'];
    } else {
        // Convert the string to an array
        $errors[] = $_SESSION['errorsu'];
    }
    unset($_SESSION['errorsu']);
}




?>
<!DOCTYPE html>
<html>

<head>
    <title>Update Profil</title>

    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
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
                        <a class="nav-link" href="manage.php">Kembali</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <h1 class="text-4xl text-center my-8">Update Data</h1>
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
    }
    ?>
    <?php
    include 'koneksi.php';

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $sql = "SELECT * FROM tamba WHERE id_pembeli = $id";
        $result = $koneksi->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
    ?>
            <form action="prosesupdate.php" method="post" class="max-w-4xl mx-auto p-8 bg-gray-100 rounded-lg shadow-md">
                <input type="hidden" name="id" value="<?php echo $row['id_pembeli']; ?>">
                <div class="mb-4">
                    <label for="nama" class="block text-gray-700">Nama:</label>
                    <input type="text" name="nama" value="<?php echo $row['nama']; ?>" required class="w-full form-input">
                </div>

                <div class="mb-4">
                    <label for="alamat" class="block text-gray-700">Alamat:</label>
                    <textarea name="alamat" rows="4" cols="50" class="w-full form-input"><?php echo $row['alamat']; ?></textarea>
                </div>

                <div class="mb-4">
                    <label for="HP" class="block text-gray-700">Nomor HP:</label>
                    <input type="text" name="HP" value="<?php echo $row['HP']; ?>" required class="w-full form-input">
                </div>

                <div class="mb-4">
                    <label for="Tgl_Transaksi" class="block text-gray-700">Tanggal Transaksi:</label>
                    <input type="date" name="Tgl_Transaksi" value="<?php echo $row['Tgl_Transaksi']; ?>" required class="w-full form-input">
                </div>

                <div class="mb-4">
                    <label for="Jenis_barang" class="block text-gray-700">Jenis Barang:</label>
                    <select name="Jenis_barang" class="w-full form-select">
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
                    <label for="Nama_Barang" class="block text-gray-700">Nama Barang:</label>
                    <input type="text" name="Nama_Barang" value="<?php echo $row['Nama_Barang']; ?>" required class="w-full form-input">
                </div>

                <div class="mb-4">
                    <label for="Jumlah" class="block text-gray-700">Jumlah:</label>
                    <input type="number" name="Jumlah" value="<?php echo $row['Jumlah']; ?>" required class="w-full form-input">
                </div>

                <div class="mb-4">
                    <label for="Harga" class="block text-gray-700">Harga:</label>
                    <input type="number" name="Harga" value="<?php echo $row['Harga']; ?>" required class="w-full form-input">
                </div>

                <div class="mb-4">
                    <input type="submit" value="Update" class="w-full btn btn-primary  bg-gray-600">
                </div>
            </form>
    <?php
        }
    }
    $koneksi->close();
    ?>
    <nav class="navbar fixed-bottom navbar-dark bg-dark">
        <div class="container">
            <span class="navbar-text">
                &copy; <?php echo date("Y"); ?> Made by Rico Mesias Tamba
            </span>
        </div>
    </nav>
</body>

</html>