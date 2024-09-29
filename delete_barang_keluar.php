<?php
include 'db.php';

if(isset($_POST['delete_barang_keluar'])){
    $id = $_POST['id'];

    // Ambil data barang yang akan dihapus
    $selectQuery = "SELECT nama_barang, keterangan, jumlah FROM barang_keluar WHERE id='$id'";
    $result = mysqli_query($conn, $selectQuery);
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        $nama_barang = $row['nama_barang'];
        $keterangan = $row['keterangan'];
        $jumlah = $row['jumlah'];

        // Hapus data dari barang_keluar
        $deleteQuery = "DELETE FROM barang_keluar WHERE id='$id'";
        if(mysqli_query($conn, $deleteQuery)){
            // Update stock di tabel barang
            $updateStockQuery = "UPDATE barang SET stock = stock + $jumlah WHERE nama_barang = '$nama_barang' AND keterangan = '$keterangan'";
            mysqli_query($conn, $updateStockQuery);
            
            header('Location: barangkeluar.php');
        } else {
            echo 'Gagal menghapus data';
        }
    } else {
        echo 'Data tidak ditemukan';
    }
}
?>


