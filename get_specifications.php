<?php
include 'db.php';

if(isset($_POST['nama_barang'])) {
    $nama_barang = $_POST['nama_barang'];
    
    $sql = "SELECT keterangan FROM barang WHERE nama_barang = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $nama_barang);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if(mysqli_num_rows($result) > 0) {
        echo '<option value="">Pilih Spesifikasi</option>';
        while($row = mysqli_fetch_assoc($result)) {
            echo '<option value="'.htmlspecialchars($row['keterangan']).'">'.htmlspecialchars($row['keterangan']).'</option>';
        }
    } else {
        echo '<option value="">Spesifikasi tidak ditemukan</option>';
    }

    mysqli_stmt_close($stmt);
}
?>


