<?php
include 'db.php';

if(isset($_POST['update_barang_masuk'])){
    $id = $_POST['id'];
    $nama_barang = $_POST['nama_barang'];
    $keterangan = $_POST['keterangan'];
    $jumlah = $_POST['jumlah'];
    $tanggal = $_POST['tanggal'];
    $pengirim = $_POST['pengirim'];
    $penerima = $_POST['penerima'];
    $ket = $_POST['ket'];

    // Ambil jumlah barang masuk sebelumnya
    $sql = "SELECT jumlah FROM barang_masuk WHERE id='$id'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $jumlah_sebelumnya = $row['jumlah'];

    // Update data barang_masuk
    $updateQuery = "UPDATE barang_masuk SET nama_barang='$nama_barang', keterangan='$keterangan', jumlah=$jumlah, tanggal='$tanggal', pengirim='$pengirim', penerima='$penerima', ket='$ket' WHERE id='$id'";
    
    if(mysqli_query($conn, $updateQuery)){
        // Update stock di tabel barang
        $sql = "UPDATE barang SET stock = stock - $jumlah_sebelumnya + $jumlah WHERE keterangan = '$keterangan' AND nama_barang = '$nama_barang'";
        
        if (mysqli_query($conn, $sql)) {
            header('Location: barangmasuk.php');
        } else {
            echo "Error updating stock: " . mysqli_error($conn);
        }
    } else {
        echo 'Gagal memperbarui data';
    }
}
?>

