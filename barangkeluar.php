<?php

include 'db.php';


if (isset($_POST['tambahbarangkeluar'])) {
    $nama_barang = $_POST['nama_barang'];
    $keterangan = $_POST['keterangan'];
    $jumlah = $_POST['jumlah'];
    $tanggal = $_POST['tanggal'];
    $pengirim = $_POST['pengirim'];
    $penerima = $_POST['penerima'];

    // Menambahkan data ke tabel barang_keluar
    $sql = "INSERT INTO barang_keluar (nama_barang, keterangan, jumlah, tanggal, pengirim, penerima) VALUES ('$nama_barang', '$keterangan', $jumlah, '$tanggal', '$pengirim', '$penerima')";
    if (mysqli_query($conn, $sql)) {
        // Update stock di tabel barang
        $sql = "UPDATE barang SET stock = stock - $jumlah WHERE keterangan = '$keterangan'";
        mysqli_query($conn, $sql);
        
        header('Location: barangkeluar.php');
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}


?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Barang Keluar</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
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
                        </div>
                        
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Logged in as:</div>
                        Admin
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">BARANG KELUAR</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Data barang keluar </li>
                        </ol>
                    
                        <div class="card mb-4">
                            <div class="card-header">
                                <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#myModal">
                                    Tambah Barang Keluar
                                </button>
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Barang</th>
                                            <th>Spesifikasi</th>
                                            <th>Jumlah Barang Keluar</th>
                                            <th>Tanggal Keluar</th>
                                            <th>Pengirim</th>
                                            <th>Penerima</th>
                                            <th>Keterangan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $sql = "SELECT * FROM barang_keluar";
                                            $result = mysqli_query($conn, $sql);

                                            if (mysqli_num_rows($result) > 0) {
                                                $no = 1;
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    echo "<tr>";
                                                    echo "<td>" . $no++ . "</td>";
                                                    echo "<td>" . htmlspecialchars($row['nama_barang']) . "</td>";
                                                    echo "<td>" . htmlspecialchars($row['keterangan']) . "</td>";
                                                    echo "<td>" . htmlspecialchars($row['jumlah']) . "</td>";
                                                    echo "<td>" . htmlspecialchars($row['tanggal']) . "</td>";
                                                    echo "<td>" . htmlspecialchars($row['pengirim']) . "</td>";
                                                    echo "<td>" . htmlspecialchars($row['penerima']) . "</td>";
                                                    echo "<td>" . htmlspecialchars($row['ket']) . "</td>";
                                                    echo "<td>";
                                                    echo "<a href='#' class='btn btn-warning btn-sm btn-edit'
                                                        data-bs-toggle='modal' data-bs-target='#editModalKeluar'
                                                        data-id='" . $row['id'] . "'
                                                        data-nama-barang='" . htmlspecialchars($row['nama_barang']) . "'
                                                        data-keterangan='" . htmlspecialchars($row['keterangan']) . "'
                                                        data-jumlah='" . htmlspecialchars($row['jumlah']) . "'>Ubah</a>";
                                                    echo "<a href='#' class='btn btn-danger btn-sm btn-delete ms-3'
                                                        data-bs-toggle='modal' data-bs-target='#deleteModalKeluar'
                                                        data-id='" . $row['id'] . "'>Hapus</a>";
                                                    echo "</td>";
                                                    echo "</tr>";
                                                    echo "</td>";
                                                    echo "</tr>";
                                                }
                                            } else {
                                                echo "<tr><td colspan='7'>Tidak ada data</td></tr>";
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
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
    
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
        $(document).ready(function() {
            // Ketika dropdown barang diubah
            $('select[name="nama_barang"]').on('change', function() {
                var nama_barang = $(this).val();
                if(nama_barang) {
                    $.ajax({
                        url: "get_specifications.php",
                        type: "POST",
                        data: {nama_barang: nama_barang},
                        success: function(data) {
                            $('select[name="keterangan"]').html(data);
                        }
                    });
                } else {
                    $('select[name="keterangan"]').html('<option value="">Pilih Spesifikasi</option>');
                }
            });
        });
        </script>

        <script>
            document.getElementById('nama_barang').addEventListener('change', function() {
                var namaBarang = this.value;
                var keteranganDropdown = document.getElementById('keterangan');
                
                // Kosongkan dropdown spesifikasi
                keteranganDropdown.innerHTML = '<option value="">Pilih Spesifikasi</option>';

                if (namaBarang) {
                    // AJAX request untuk mengambil spesifikasi berdasarkan nama barang
                    var xhr = new XMLHttpRequest();
                    xhr.open('POST', 'get_specifications.php', true);
                    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                    xhr.onload = function() {
                        if (xhr.status === 200) {
                            var options = JSON.parse(xhr.responseText);
                            options.forEach(function(option) {
                                var opt = document.createElement('option');
                                opt.value = option.keterangan;
                                opt.innerHTML = option.keterangan;
                                keteranganDropdown.appendChild(opt);
                            });
                        }
                    };
                    xhr.send('nama_barang=' + encodeURIComponent(namaBarang));
                }
            });
        </script>

        <!--script ubah dan hapus barang keluar-->
        <script>
        // Script untuk mengisi modal edit dengan data
        document.addEventListener('DOMContentLoaded', function () {
            var editModal = document.getElementById('editModalKeluar');
            editModal.addEventListener('show.bs.modal', function (event) {
                var button = event.relatedTarget;
                var id = button.getAttribute('data-id');
                var nama_barang = button.getAttribute('data-nama-barang');
                var keterangan = button.getAttribute('data-keterangan');
                var jumlah = button.getAttribute('data-jumlah');
                var tanggal = button.getAttribute('data-tanggal');
                var pengirim = button.getAttribute('data-pengirim');
                var penerima = button.getAttribute('data-penerima');
                var ket = button.getAttribute('data-ket');

                var modal = bootstrap.Modal.getInstance(editModal);
                modal.querySelector('#edit_id').value = id;
                modal.querySelector('#edit_nama_barang').value = nama_barang;
                modal.querySelector('#edit_keterangan').value = keterangan;
                modal.querySelector('#edit_jumlah').value = jumlah;
                modal.querySelector('#edit_tanggal').value = tanggal;
                modal.querySelector('#edit_pengirim').value = pengirim;
                modal.querySelector('#edit_penerima').value = penerima;
                modal.querySelector('#edit_ket').value = ket;
            });

            // Script untuk mengisi modal delete dengan ID
            var deleteModal = document.getElementById('deleteModalKeluar');
            deleteModal.addEventListener('show.bs.modal', function (event) {
                var button = event.relatedTarget;
                var id = button.getAttribute('data-id');
                var modal = bootstrap.Modal.getInstance(deleteModal);
                modal.querySelector('#delete_id').value = id;
            });
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function() {
        // Menampilkan data untuk modal edit
        $('#editModalKeluar').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // tombol yang diklik
            var id = button.data('id');
            var namaBarang = button.data('nama-barang');
            var keterangan = button.data('keterangan');
            var jumlah = button.data('jumlah');
            var tanggal = button.data('tanggal');
            var pengirim = button.data('pengirim');
            var penerima = button.data('penerima');
            var ket = button.data('ket');

            var modal = $(this);
            modal.find('#edit_id').val(id);
            modal.find('#edit_nama_barang').val(namaBarang);
            modal.find('#edit_jumlah').val(jumlah);
            modal.find('#edit_tanggal').val(tanggal);
            modal.find('#edit_pengirim').val(pengirim);
            modal.find('#edit_penerima').val(penerima);
            modal.find('#edit_ket').val(ket);

            // Update dropdown spesifikasi saat nama barang berubah
            modal.find('#edit_nama_barang').change(function() {
                var namaBarang = $(this).val();
                if (namaBarang) {
                    $.ajax({
                        url: 'get_specifications.php',
                        type: 'POST',
                        data: {nama_barang: namaBarang},
                        success: function(data) {
                            var keteranganDropdown = $('#edit_keterangan');
                            keteranganDropdown.html(data);
                            keteranganDropdown.val(keterangan);
                        }
                    });
                } else {
                    $('#edit_keterangan').html('<option value="">Pilih Spesifikasi</option>');
                }
            }).trigger('change'); // Trigger change event to load data initially
        });

        // Menampilkan data untuk modal delete
        $('#deleteModalKeluar').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // tombol yang diklik
            var id = button.data('id');
            
            var modal = $(this);
            modal.find('#delete_id').val(id);
        });
    });
    </script>

    </body>
        <!-- Modal Barang Keluar -->
        <div class="modal fade" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Barang Keluar</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <!-- Modal body -->
                <form action="" method="post">
                    <div class="modal-body">
                        <select name="nama_barang" id="nama_barang" class="form-control" required>
                        <option value="">Pilih Barang</option>
                            <?php
                            // Menampilkan dropdown list barang
                            $sql = "SELECT DISTINCT nama_barang FROM barang";
                            $result = mysqli_query($conn, $sql);
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<option value='" . htmlspecialchars($row['nama_barang']) . "'>" . htmlspecialchars($row['nama_barang']) . "</option>";
                            }
                            ?>
                        </select>
                        <br>
                        
                        <select name="keterangan" id="keterangan" class="form-control" required>
                        <option value="">Pilih Spesifikasi </option>
                        </select>

                        <br>
                        <input type="number" name="jumlah" placeholder="Keluarkan jumlah" class="form-control" required>
                        <br>
                        <input type="date" name="tanggal" placeholder="Tanggal" class="form-control" required>
                        <br>
                        <input type="text" name="pengirim" placeholder="Pengirim" class="form-control" required>
                        <br>
                        <input type="text" name="penerima" placeholder="Penerima" class="form-control" required>
                        <br>
                        <input type="text" name="ket" placeholder="Keterangan" class="form-control">
                        <br>
                        <button type="submit" class="btn btn-primary" name="tambahbarangkeluar">Simpan</button>
                    </div>
                </form>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>
    <!-- Modal Ubah Barang Keluar -->
    <div class="modal fade" id="editModalKeluar">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Ubah Barang Keluar</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <!-- Modal body -->
                <form action="update_barang_keluar.php" method="post">
                    <div class="modal-body">
                        <input type="hidden" name="id" id="edit_id">
                        <select name="nama_barang" id="edit_nama_barang" class="form-control" required>
                            <option value="">Pilih Barang</option>
                            <?php
                            $sql = "SELECT DISTINCT nama_barang FROM barang";
                            $result = mysqli_query($conn, $sql);
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<option value='" . htmlspecialchars($row['nama_barang']) . "'>" . htmlspecialchars($row['nama_barang']) . "</option>";
                            }
                            ?>
                        </select>
                        <br>
                        <select name="keterangan" id="edit_keterangan" class="form-control" required>
                            <option value="">Pilih Spesifikasi</option>
                        </select>
                        <br>
                        <input type="number" name="jumlah" id="edit_jumlah" placeholder="Keluarkan jumlah" class="form-control" required>
                        <br>
                        <input type="date" name="tanggal" id="edit_tanggal" placeholder="Tanggal" class="form-control" required>
                        <br>
                        <input type="text" name="pengirim" id="edit_pengirim" placeholder="Pengirim" class="form-control" required>
                        <br>
                        <input type="text" name="penerima" id="edit_penerima" placeholder="Penerima" class="form-control" required>
                        <br>
                        <input type="text" name="ket" id="edit_ket" placeholder="Keterangan" class="form-control">
                        <br>
                        <button type="submit" class="btn btn-primary" name="update_barang_keluar">Simpan</button>
                    </div>
                </form>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Hapus Barang Keluar -->
    <div class="modal fade" id="deleteModalKeluar">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Hapus Barang Keluar</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <!-- Modal body -->
                <form action="delete_barang_keluar.php" method="post">
                    <div class="modal-body">
                        <input type="hidden" name="id" id="delete_id">
                        <p>Apakah Anda yakin ingin menghapus barang ini?</p>
                        <button type="submit" class="btn btn-danger" name="delete_barang_keluar">Hapus</button>
                    </div>
                </form>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>


</html>
