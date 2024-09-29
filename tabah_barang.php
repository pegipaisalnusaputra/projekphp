<?php

include 'db.php';

if (isset($_POST['submit'])){
    $nama_barang = $_POST ['nama_barang'];
    $keterangan = $_POST ['keterangan'];
    $stock = $_POST['stock'];

    $sql = "INSERT INTO barang (nama_barang, keterangan, stock) VALUES ('$nama_barang', '$keterangan', '$stock')";
    if (mysqli_query($conn, $sql)) {
        header('Location: index.php');
        exit();
    } else {
        echo "Error: ". $sql . "<br>". mysqli_error($conn);
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tambah Barang</title>
</head>
<body>
    <h1>Tambah Barang</h1>
    <form method="POST" action="">
        Nama Barang: <input type="text" name="nama_barang" required><br>
        Keterangan: <textarea name="keterangan"></textarea><br>
        Stock: <input type="number" name="stock" required><br>
        <input type="submit" name="submit" value="Tambah Barang">
    </form>
    <br>
    <a href="index.php">Kembali</a>
</body>
</html>