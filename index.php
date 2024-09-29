<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

include 'db.php';
include 'cek.php';
include 'function.php';

//Query untuk mendapatkan total stock barang
$sql_total_stock = "SELECT SUM(stock) AS total_stock FROM barang";
$result_total_stock = mysqli_query($conn, $sql_total_stock);
$row_total_stock = mysqli_fetch_assoc($result_total_stock);
$total_stock = $row_total_stock['total_stock'];

//Query untuk mendapatkan total barang masuk
$sql_total_masuk = "SELECT SUM(jumlah) AS total_masuk FROM barang_masuk";
$result_total_masuk = mysqli_query($conn, $sql_total_masuk);
$row_total_masuk = mysqli_fetch_assoc($result_total_masuk);
$total_masuk = $row_total_masuk['total_masuk'];

//Query untuk mendapatkan total barang keluar
$sql_barang_keluar = "SELECT SUM(jumlah) AS total_keluar FROM barang_keluar";
$result_total_keluar = mysqli_query($conn, $sql_barang_keluar);
$row_total_keluar = mysqli_fetch_assoc($result_total_keluar);
$total_keluar = $row_total_keluar['total_keluar'];

//menampilkan nama yang login
$sql_users = "SELECT * FROM users";
$result_users = mysqli_query($conn, $sql_users);
$ambil_users = mysqli_fetch_assoc($result_users);

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Dashboard</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

        <!-- Tambahkan CSS untuk tampilan cetak -->
        <style>
            @media print {
                body * {
                    visibility: hidden; /* Sembunyikan semua elemen */
                }
                #print-area, #print-area * {
                    visibility: visible; /* Kecuali bagian print-area */
                }
                #print-area {
                    position: absolute;
                    top: 0;
                    left: 0;
                    width: 100%;
                    padding: 20px;
                }
                /* Desain cetak tabel */
                table {
                    width: 100%;
                    border-collapse: collapse;
                    margin-bottom: 20px;
                }
                table, th, td {
                    border: 1px solid black;
                }
                th, td {
                    padding: 5px;
                    text-align: left;
                    font-size: 12px;
                }
                th {
                    background-color: #f2f2f2;
                }
                
            }
            /* untuk tampilan cetak di layar */
            .info-section {
                margin-bottom: 20px;
            }
            .info-section h3 {
                margin: 0;
                font-size: 16px;
            }
        
            /*CSS untuk memperkecil lebar kolom No */
            .col-no {
                width: 40px; /* ubah sesuai kebutuhan */
                text-align: center;
            }

            /* CSS untuk mengatur lebar kolom */
            .col-nama {
                width:auto;
                min-width: 100px;
                text-align: center;
            }
            .col-jumlah {
                width: 100px;
                text-align: center;
            }
            .col-pengirim {
                width:auto;
                min-width: 100px;
                text-align: center;
            }
            .col-penerima {
                width: auto;
                min-width: 100px;
                text-align: center;
            }
            .st {
                text-decoration-color: blue;
            }
        </style>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="index.html">Inventory ATK</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
                        
            <!-- Navbar-->
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Menu</div>
                            <a class="nav-link" href="index.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Dashboard
                            </a>
                            <a class="nav-link" href="index.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Stock Barang
                            </a>
                            <a class="nav-link" href="barangmasuk.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Barang Masuk
                            </a>
                            <a class="nav-link" href="barangkeluar.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Barang Keluar
                            </a>
                            <a class="nav-link" href="login.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Login
                            </a>
                        </div>
                        
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Login Sebagai:</div>
                                <h5>
                                    Admin
                                </h5>
                        <br>
                        <a href="logout.php">Logout</a>
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">STOCK BARANG</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                        <div class="row">
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-primary text-white mb-4">
                                    <div class="card-body">Stock Barang Tersedia :<br> <h3><?=$total_stock;?></h3></div>
                                    <div class="card-footer">
                                        <h6 class="text-white">Total jumlah seluruh Stock</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-success text-white mb-4">
                                    <div class="card-body">Total Barang Masuk :<br> <h3><?=$total_masuk;?></h3></div>
                                    <div class="card-footer">
                                        <h6 class="text-white">Total seluruh barang masuk</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-danger text-white mb-4">
                                    <div class="card-body">Total Barang Keluar :<br> <h3><?=$total_keluar;?></h3></div>
                                    <div class="card-footer">
                                        <h6 class="text-white">Total seluruh barang keluar</h6>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- Tombol Cetak Laporan -->
                    <div class="mb-3">
                        <button class="btn btn-secondary" onclick="printLaporan()">Cetak Laporan</button>
                    </div>

                    <!-- Area yang akan dicetak -->
                    <div id="print-area" style="display: none;">
                        <div class="info-section">
                            <h3 class="st">Stock Tersedia: <?= $total_stock ?></h3>
                            <h3 class="st">Total Barang Masuk: <?= $total_masuk ?></h3>
                            <h3 class="st">Total Barang Keluar: <?= $total_keluar ?></h3>
                        </div>

                        <!-- Tabel Barang Masuk -->
                        <h3>Barang Masuk</h3>
                        <table>
                            <thead>
                                <tr>
                                    <th class="col-no">No</th>
                                    <th class="col-nama">Nama Barang</th>
                                    <th class="col-jumlah">Jumlah</th>
                                    <th class="col-pengirim">Pengirim</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql_masuk = "SELECT * FROM barang_masuk";
                                $result_masuk = mysqli_query($conn, $sql_masuk);
                                if (mysqli_num_rows($result_masuk) > 0) {
                                    $no = 1;
                                    while ($row = mysqli_fetch_assoc($result_masuk)) {
                                        echo "<tr>";
                                        echo "<td>" . $no++ . "</td>";
                                        echo "<td>" . htmlspecialchars($row['nama_barang']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['jumlah']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['pengirim']) . "</td>";
                                        echo "</tr>";
                                    }
                                }
                                ?>
                            </tbody>
                        </table>

                        <!-- Tabel Barang Keluar -->
                        <h3>Barang Keluar</h3>
                        <table>
                            <thead>
                                <tr>
                                    <th class="col-no">No</th>
                                    <th class="col-nama">Nama Barang</th>
                                    <th class="col-jumlah">Jumlah</th>
                                    <th class="col-penerima">Penerima</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql_keluar = "SELECT * FROM barang_keluar";
                                $result_keluar = mysqli_query($conn, $sql_keluar);
                                if (mysqli_num_rows($result_keluar) > 0) {
                                    $no = 1;
                                    while ($row = mysqli_fetch_assoc($result_keluar)) {
                                        echo "<tr>";
                                        echo "<td>" . $no++ . "</td>";
                                        echo "<td>" . htmlspecialchars($row['nama_barang']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['jumlah']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['penerima']) . "</td>";
                                        echo "</tr>";
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>

                        
                        <div class="card mb-4">
                            <div class="card-header">
                                <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#myModal">
                                    Tambah Barang
                                </button>
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th class="col-no">No</th>
                                            <th>Nama barang</th>
                                            <th>Spesifikasi</th>
                                            <th>Stock Tersedia</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $sql = "SELECT * FROM barang";
                                            $result = mysqli_query($conn, $sql);

                                            if (mysqli_num_rows($result) > 0) {
                                                $no = 1;
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    echo "<tr>";
                                                    echo "<td>" . $no++ . "</td>";
                                                    echo "<td>" . htmlspecialchars($row['nama_barang']) . "</td>";
                                                    echo "<td>" . htmlspecialchars($row['keterangan']) . "</td>";
                                                    echo "<td>" . htmlspecialchars($row['stock']) . "</td>";
                                                    echo "<td>";
                                                    echo "<a href='#' class='btn btn-warning btn-sm btn-edit'
                                                        data-bs-toggle='modal' data-bs-target='#editModal'
                                                        data-id='" . $row['id'] . "'
                                                        data-nama-barang='" . htmlspecialchars($row['nama_barang']) . "'
                                                        data-keterangan='" . htmlspecialchars($row['keterangan']) . "'
                                                        data-stock='" . htmlspecialchars($row['stock']) . "'>Ubah</a>";
                                                    echo "<a href='#' class='btn btn-danger btn-sm btn-delete ms-3'
                                                        data-bs-toggle='modal' data-bs-target='#deleteModal'
                                                        data-id='" . $row['id'] . "'>Hapus</a>";
                                                    echo "</td>";
                                                    echo "</tr>";
                                            }
                                            } else {
                                                echo "<tr><td colspan='4'>Tidak ada data</td></tr>";
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </main>
                
            </div>
        </div>

        <!-- Tambahkan JavaScript untuk mencetak laporan -->
        <script>
            function printLaporan() {
            // Tampilkan area cetak
            document.getElementById('print-area').style.display = 'block';

            // Lakukan perintah cetak
            window.print();

            // Sembunyikan kembali area cetak setelah selesai mencetak
            document.getElementById('print-area').style.display = 'none';
        }
    </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                document.querySelectorAll('.btn-edit').forEach(button => {
                    button.addEventListener('click', function () {
                        const id = this.getAttribute('data-id');
                        const nama_barang = this.getAttribute('data-nama-barang');
                        const keterangan = this.getAttribute('data-keterangan');
                        const stock = this.getAttribute('data-stock');

                        document.getElementById('editId').value = id;
                        document.getElementById('editNamaBarang').value = nama_barang;
                        document.getElementById('editKeterangan').value = keterangan;
                        document.getElementById('editStock').value = stock;
                    });
                });
            });
        </script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                document.querySelectorAll('.btn-delete').forEach(button => {
                    button.addEventListener('click', function () {
                        const id = this.getAttribute('data-id');

                        document.getElementById('deleteId').value = id;
                    });
                });
            });
        </script>

    </body>

    <!-- Modal TAMBAH BARANG -->
    <div class="modal fade" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Barang</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <!-- Modal body -->
                <form action="" method="post">
                    <div class="modal-body">
                        <input type="text" name="nama_barang" placeholder="Nama Barang" class="form-control">
                        <br>
                        <input type="text" name="keterangan" placeholder="Keterangan/Spek" class="form-control">
                        <br>
                        
                        <button type="submit" class="btn btn-primary" name="tambahbarang">Simpan</button>
                    </div>
                </form>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>
    <!-- Modal UBAH BARANG -->
    <div class="modal fade" id="editModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Ubah Barang</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <!-- Modal body -->
                <form id="editForm" action="function.php" method="post">
                    <div class="modal-body">
                        <input type="hidden" name="id" id="editId">
                        <input type="text" name="nama_barang" id="editNamaBarang" placeholder="Nama Barang" class="form-control">
                        <br>
                        <input type="text" name="keterangan" id="editKeterangan" placeholder="Keterangan/Spek" class="form-control">
                        <br>
                    
                        <button type="submit" class="btn btn-primary" name="ubahbarang">Simpan</button>
                    </div>
                </form>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>
    <!-- Modal HAPUS BARANG -->
    <div class="modal fade" id="deleteModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Hapus Barang</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus barang ini?</p>
                    <form id="deleteForm" action="function.php" method="post">
                        <input type="hidden" name="id" id="deleteId">
                        <button type="submit" class="btn btn-danger" name="hapusbarang">Hapus</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</html>