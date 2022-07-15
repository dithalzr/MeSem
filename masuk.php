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
			<a class="navbar-brand" href="index.php">MeSem</a>
			<button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
		</nav>
		<div id="layoutSidenav">
			<div id="layoutSidenav_nav">
                <!-- menampilkan nafigasi bar samping-->
				<nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
					<div class="sb-sidenav-menu">
                        <!-- menampilkan menu pada navigasi bar samping -->
						<div class="nav">
                            <a class="nav-link" href="index.php">
                                <!-- i untuk menampilkan icon -->
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
						<h1 class="mt-4">Sembako Masuk</h1>
						<div class="card mb-4">
							<div class="card-header">
								<!-- membuat tombol untuk tambah data sembako masuk -->
								<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
								  Tambah Data
								</button>
                                <!-- tautkan button export data ke file exportmasuk.php -->
                                <a href="exportmasuk.php" class="btn btn-info">Export Data</a>
							</div>
							<div class="card-body">
								<div class="table-responsive">
                                    <!-- membuat tabel untuk menampilkan data sembako masuk -->
									<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
										<thead>
											<tr>
												<th>Tanggal</th>
												<th>Nama</th>
												<th>Keterangan</th>
												<th>Stok</th>
												<th>Harga/satuan</th>
                                                <th>Total Harga</th>
												<th>Aksi</th>
											</tr>
										</thead>
										<tbody>
										
                                        <?php
                                            // deklarasikan variabel untuk mengambil data dari tabel masuk dan stok
											$ambilsemuadatastok = mysqli_query($conn, "select * from masuk m, stok s where s.idsembako = m.idsembako");
                                            // mengambil data berupa array
											while($data = mysqli_fetch_array($ambilsemuadatastok)){
												$ids = $data['idsembako'];
												$idm = $data['idmasuk'];
                                                $namasembako = $data['namasembako'];
												$tanggal = $data['tanggal'];
												$keterangan = $data['keterangan'];
												$qty = $data['qty'];
												$harga = $data['harga'];  
                                                $totalhargamasuk = $data['totalhargamasuk'];  
											?>


											<tr>
                                                <!-- mengambil data dari database untuk ditampilkan -->
												<td><?=$tanggal;?></td>
												<td><?=$namasembako;?></td>
												<td><?=$keterangan;?></td>
												<td><?=$qty;?></td>
												<td><?=$harga;?></td>
                                                <td><?=$totalhargamasuk;?></td>
												<td>
													<button type="button" class="btn btn-warning" data-toggle="modal" data-target="#edit<?=$idm;?>">Edit</button>
													<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete<?=$idm;?>">Delete</button>
												</td>
											</tr>
											<!-- modal untuk edit/update data sembako masuk -->
											 <div class="modal fade" id="edit<?=$idm;?>">
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
                                                <input type="text" name="namasembako" readonly value="<?=$namasembako;?>" class="form-control">
                                                  <br>
												  <input type="text" name="keterangan" value="<?=$keterangan;?>" placeholder="Penerima" class="form-control" required>
												  <br>
												  <input type="number" name="qty" value="<?=$qty;?>" class="form-control" placeholder="Stok" required>
												  <br>
												  <input type="hidden" name="ids" value="<?=$ids;?>">
												  <input type="hidden" name="idm" value="<?=$idm;?>">
                                                  <input type="hidden" name="harga">
                                                  <input type="hidden" name="totalhargamasuk">

												  <button type="submit" class="btn btn-primary" name="updatesembakomasuk">Save</button>
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
										  <div class="modal fade" id="delete<?=$idm;?>">
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
                                                  <input type="hidden" name="idm" value="<?=$idm;?>">
												  <input type="hidden" name="kty" value="<?=$qty;?>">
												  <br> <br>
												  <button type="submit" class="btn btn-danger" name="hapussembakomasuk">Hapus</button>
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
							<div class="text-muted">Copyright &copy; Website Mesem by Ditha & Icha</div>
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
	<!-- The Modal -->
	  <div class="modal fade" id="myModal">
		<div class="modal-dialog">
		  <div class="modal-content">
		  
			<!-- Modal Header untuk menambah data sembako masuk -->
			<div class="modal-header">
			  <h4 class="modal-title">Tambah Data</h4>
			  <button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			
			 <!-- Modal body -->
			<form method="post">
			<div class="modal-body" >
			  <select name="sembakonya" class="form-control">
				<?php
                    // deklarasikan variabel untuk mengambil data dari tabel stok
					$ambildatanya = mysqli_query($conn, "select * from stok");
                    // ambil data berupa array
					while($fetcharray = mysqli_fetch_array($ambildatanya)){
						$namasembakonya = $fetcharray['namasembako'];
						$idsembakonya = $fetcharray['idsembako'];
                        $harga = $fetcharray['harga'];
				?>
                <!-- nama sembako akan ditampilkan otomatis diambil dari tabel stok -->
				<option value="<?=$idsembakonya;?>"><?=$namasembakonya;?></option>

				<?php
					}
				  ?>
			 </select>

              <!-- form input data sembako masuk -->
			  <br>
			  <input type="text" name="penerima" placeholder="Penerima" class="form-control" required>
			  <br>
			  <input type="number" name="qty" placeholder="Kuantitas" class="form-control" required>
			  <br>
              <input type="hidden" name="idm" value="<?=$idm;?>">
              <input type="hidden" name="harga">
              <input type="hidden" name="totalhargamasuk" value="<?=$totalhargamasuk;?>">
			  <button type="submit" class="btn btn-primary" name="sembakomasuk">Submit</button>

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
