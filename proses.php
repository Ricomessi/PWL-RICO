<?php
session_start();
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $HP = $_POST['hp']; 
    $Tgl_Transaksi = $_POST['tgl_transaksi']; 
    $Jenis_barang = $_POST['jenis_barang']; 
    $Nama_Barang = $_POST['nama_barang']; 
    $Jumlah = $_POST['jumlah'];
    $Harga = $_POST['harga'];

    $errors = array();

    if (empty($nama)) {
        $errors[] = "Nama tidak boleh kosong";
    } elseif (!preg_match("/^[a-zA-Z ]*$/", $nama)) {
        $errors[] = "Nama hanya boleh berisi huruf dan spasi";
    }

    if (empty($alamat)) {
        $errors[] = "Alamat tidak boleh kosong";
    }

    if (empty($HP)) {
        $errors[] = "Nomor HP tidak boleh kosong";
    }

    if (empty($Tgl_Transaksi)) {
        $errors[] = "Tanggal Transaksi tidak boleh kosong";
    } elseif (!preg_match("/^\d{4}-\d{2}-\d{2}$/", $Tgl_Transaksi)) {
        $errors[] = "Format Tanggal Transaksi tidak valid. Gunakan format YYYY-MM-DD";
    }

    if (empty($Jenis_barang)) {
        $errors[] = "Pilih jenis barang";
    }

    if (empty($Nama_Barang)) {
        $errors[] = "Nama Barang tidak boleh kosong";
    }

    if (empty($Jumlah)) {
        $errors[] = "Jumlah tidak boleh kosong";
    }

    if (empty($Harga)) {
        $errors[] = "Harga tidak boleh kosong";
    }

    if (empty($errors)) {
        // Calculate Total_Bayar
        $Total_Bayar = $Jumlah * $Harga;

        $sql = "INSERT INTO tamba (nama, alamat, HP, Tgl_Transaksi, Jenis_barang, Nama_Barang, Jumlah, Harga) VALUES ('$nama', '$alamat', '$HP', '$Tgl_Transaksi', '$Jenis_barang', '$Nama_Barang', $Jumlah, $Harga  )";

        if ($koneksi->query($sql) === TRUE) {
            $success = "Data Berhasil Disimpan!!";
            $_SESSION['success'] = $success;
            header("Location: form.php");
        } else {
            echo "Error: " . $sql . "<br>" . $koneksi->error;
        }
    } else {
        $_SESSION['errors'] = $errors;
        header("Location: form.php");
    }
}

$koneksi->close();
