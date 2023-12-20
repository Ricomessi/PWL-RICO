<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $HP = $_POST['HP'];
    $Tgl_Transaksi = $_POST['Tgl_Transaksi'];
    $Jenis_barang = $_POST['Jenis_barang'];
    $Nama_Barang = $_POST['Nama_Barang'];
    $Jumlah = $_POST['Jumlah'];
    $Harga = $_POST['Harga'];

    $errorsu = array();

    if (empty($nama)) {
        $errorsu[] = "Nama tidak boleh kosong";
    } elseif (!preg_match("/^[a-zA-Z ]*$/", $nama)) {
        $errorsu[] = "Nama hanya boleh berisi huruf dan spasi";
    }

    if (empty($alamat)) {
        $errorsu[] = "Alamat tidak boleh kosong";
    }

    if (empty($HP)) {
        $errorsu[] = "Nomor HP tidak boleh kosong";
    } elseif (!preg_match("/^[+]?[0-9-]+$/", $HP)) {
        $errorsu[] = "Nomor HP tidak valid";
    }

    if (empty($Tgl_Transaksi)) {
        $errorsu[] = "Tanggal Transaksi tidak boleh kosong";
    }

    if (empty($Jenis_barang)) {
        $errorsu[] = "Pilih jenis barang";
    }

    if (empty($Nama_Barang)) {
        $errorsu[] = "Nama Barang tidak boleh kosong";
    } elseif (!preg_match("/^[a-zA-Z0-9 ]*$/", $Nama_Barang)) {
        $errorsu[] = "Nama Barang hanya boleh berisi huruf, angka, dan spasi";
    }

    if (empty($Jumlah) || !is_numeric($Jumlah) || $Jumlah < 0) {
        $errorsu[] = "Jumlah tidak boleh bernilai minus";
    }

    if (empty($Harga) || !is_numeric($Harga) || $Harga < 0) {
        $errorsu[] = "Harga tidak boleh bernilai minus";
    }

    if (empty($errorsu)) {
        $sql = "UPDATE tamba SET 
            nama='$nama', 
            alamat='$alamat', 
            HP='$HP', 
            Tgl_Transaksi='$Tgl_Transaksi', 
            Jenis_barang='$Jenis_barang', 
            Nama_Barang='$Nama_Barang', 
            Jumlah=$Jumlah, 
            Harga=$Harga
      
            WHERE id_pembeli=$id";

        if ($koneksi->query($sql) === TRUE) {
            header("Location: manage.php");
        } else {
            echo "Error: " . $sql . "<br>" . $koneksi->error;
        }
    } else {
        session_start();
        $_SESSION['errorsu'] = $errorsu;
        header("Location: update.php?id=" . $id);
    }
}

$koneksi->close();
