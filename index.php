<?php
//menyertakan file koneksi dan cek
//memastikan bahwa sudah terkoneksi dan sudah login
include 'koneksi.php';
include 'cek.php';
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>MeSem</title>
        <link href="css/styles.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
    <style>
        body{
            font-family: Calibri;
        }
        </style>
    </head>
    <body class="sb-nav-fixed">
        <!-- menampilkan header bar -->
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand" href="index.html">MeSem</a>
            <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <!-- menampilkan menu pada navigasi bar samping -->
                        <div class="nav">
                            <a class="nav-link" href="index.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-folder-open"></i></div>
                                Stok Sembako
                            </a>
                            <a class="nav-link" href="masuk.php">
                                <div class="sb-nav-link-icon"><i class="fa fa-plus-square"></i></div>
                                Sembako Masuk
                            </a>
                            <a class="nav-link" href="keluar.php">
                                <div class="sb-nav-link-icon"><i class="fa fa-minus-square"></i></div>
                                Sembako Keluar
                            </a>
                            <a class="nav-link" href="chart.php">
                                <div class="sb-nav-link-icon"><i class="far fa-chart-bar"></i></div>
                                Grafik Stok
                            </a>
                            <a class="nav-link" href="admin.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-user-cog"></i></div>
                                Kelola Admin
                            </a>
                            <a class="nav-link" href="logout.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-user-times"></i></div>
                                Logout
                            </a>
                        </div>
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <h1 class="mt-4">Stok Sembako</h1>
                        <div class="card mb-4">
                            <div class="card-header">
                                <!-- membuat tombol untuk tambah data sembako  -->
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                                  Tambah Data
                                </button>
                                <!-- tautkan button export data ke file exportstok.php -->
                                <a href="exportstok.php" class="btn btn-info">Export Data</a>
                            </div>
                            <div class="card-body">
                                <?php
                                $ambildatastok = mysqli_query($conn, "select * from stok where stok < 1");
                                while($fetch=mysqli_fetch_array($ambildatastok)){
                                    $sembako = $fetch['namasembako'];
                                
                                ?>
                                <div class="alert alert-danger alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    <strong>Perhatian!</strong> Stok Sembako <?=$sembako;?> Telah Habis
                                </div>
                                <?php
                                    }
                                ?>

                                <!-- membuat tabel untuk menampilkan data sembako -->
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>No ID</th>
                                                <th>Nama</th>
                                                <th>Kategori</th>
                                                <th>Stok</th>
                                                <th>Harga/Satuan</th>
                                                <th>Total</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                             <!-- deklarasikan variabel untuk mengambil data dari tabel stok -->
                                            <?php
                                            $ambilsemuadatastok = mysqli_query($conn, "select * from stok");
                                            $i = 1;
                                            while($data = mysqli_fetch_array($ambilsemuadatastok)){
                                                $namasembako = $data['namasembako'];
                                                $kategori = $data['kategori'];
                                                $stok = $data['stok'];
                                                $harga = $data['harga'];
                                                $totalharga = $data['totalharga'];
                                                $ids = $data['idsembako'];

                                            ?>

                                            <tr>
                                                <!-- mengambil data dari database untuk ditampilkan -->
                                                <td><?=$i++;?></td>
                                                <td><?=$namasembako;?></td>
                                                <td><?=$kategori;?></td>
                                                <td><?=$stok;?></td>
                                                <td><?=$harga;?></td>
                                                <td><?=$totalharga;?></td>
                                                <td>
                                                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#edit<?=$ids;?>">Edit</button>
                                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete<?=$ids;?>">Delete</button>
                                                </td>
                                            </tr>
                                            <!-- modal untuk edit/update data stok sembako -->
                                             <div class="modal fade" id="edit<?=$ids;?>">
                                                <div class="modal-dialog">
                                                  <div class="modal-content">
                                            <!-- Modal Header -->
                                                <div class="modal-header">
                                                  <h4 class="modal-title">Update Data</h4>
                                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>
                                                
                                                <!-- Modal body -->
                                                <form method="post">
                                                <div class="modal-body">
                                                  <input type="text" name="namasembako" value="<?=$namasembako;?>" class="form-control" required>
                                                  <br>
                                                  <input type="text" name="kategori" value="<?=$kategori;?>" class="form-control" required>
                                                  <br>
                                                  <input type="text" name="harga" placeholder="harga" class="form-control" required>
                                                  <br>
                                                  <input type="hidden" name="ids" value="<?=$ids;?>">
                                                  <button type="submit" class="btn btn-primary" name="updatesembako">Submit</button>
                                                </div>
                                                </form>
                                                
                                                <!-- Modal footer -->
                                                <div class="modal-footer">
                                                  <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                                                </div>
                                                
                                              </div>
                                            </div>
                                          </div>

                                        <!-- modal untuk menghapus data sembako masuk -->
                                          <div class="modal fade" id="delete<?=$ids;?>">
                                                <div class="modal-dialog">
                                                  <div class="modal-content">
                                            <!-- Modal Header -->
                                                <div class="modal-header">
                                                  <h4 class="modal-title">Hapus Data</h4>
                                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>
                                                
                                                <!-- Modal body -->
                                                <form method="post">
                                                <div class="modal-body">
                                                  Apakah anda yakin ingin menghapus data sembako <?=$namasembako;?>?
                                                  <input type="hidden" name="ids" value="<?=$ids;?>">
                                                  <br> <br>
                                                  <button type="submit" class="btn btn-danger" name="hapussembako">Hapus</button>
                                                </div>
                                                </form>
                                                
                                              </div>
                                            </div>
                                          </div>
                                            <?php
                                            };

                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Website Mesem by Icha and Ditha</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/datatables-demo.js"></script>
    </body>
    <!-- modal untuk menghapus data stok sembako -->
      <div class="modal fade" id="myModal">
        <div class="modal-dialog">
          <div class="modal-content">
          
            <!-- Modal Header -->
            <div class="modal-header">
              <h4 class="modal-title">Tambah Data</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            
            <!-- Modal body -->
            <form method="post">
            <div class="modal-body">
              <input type="text" name="namasembako" placeholder="Nama Sembako" class="form-control" required>
              <br>
              <input type="text" name="kategori" placeholder="Kategori" class="form-control" required>
              <br>
              <input type="number" name="stok" placeholder="Stok" class="form-control" required>
              <br>
              <input type="number" name="harga" placeholder="Harga" class="form-control" required>
              <br>
              <button type="submit" class="btn btn-primary" name="tambahsembakobaru">Submit</button>
            </div>
            </form>
            
            <!-- Modal footer -->
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
            
          </div>
        </div>
      </div>
</html>