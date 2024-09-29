<?php

include 'db.php';

//menambah barang baru
if(isset($_POST['tambahbarang'])){
    $nama_barang = $_POST['nama_barang'];
    $keterangan = $_POST['keterangan'];
    $stock = $_POST['stock'];

    $addtotable = mysqli_query($conn, "INSERT INTO barang(nama_barang, keterangan, stock) VALUES ('$nama_barang','$keterangan','$stock')");
    if($addtotable){
        header('Location:index.php');

    }else {
        echo 'Gagal';
        header('Location:index.php');
    }
}

// Mengubah barang
if(isset($_POST['ubahbarang'])){
    $id = $_POST['id'];
    $nama_barang = $_POST['nama_barang'];
    $keterangan = $_POST['keterangan'];
    $stock = $_POST['stock'];

    $update = mysqli_query($conn, "UPDATE barang SET nama_barang='$nama_barang', keterangan='$keterangan', stock='$stock' WHERE id='$id'");
    if($update){
        header('Location:index.php');
    } else {
        echo 'Gagal';
        header('Location:index.php');
    }
}

// Menghapus barang
if(isset($_POST['hapusbarang'])){
    $id = $_POST['id'];

    $delete = mysqli_query($conn, "DELETE FROM barang WHERE id='$id'");
    if($delete){
        header('Location:index.php');
    } else {
        echo 'Gagal';
        header('Location:index.php');
    }
}

//=========================================================================================================================================


?>