<?php
//menyertakan file koneksi dan cek
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
		<!-- membuat header bar -->
		<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
			<a class="navbar-brand" href="index.html">MeSem</a>
			<button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
		</nav>
		<div id="layoutSidenav">
			<div id="layoutSidenav_nav">
				<!-- membuat navigasi bar samping -->
				<nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
					<div class="sb-sidenav-menu">
						<!-- membuat menu yang ada di navigasi bar -->
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
						<h1 class="mt-4">Admin</h1>
						<div class="card mb-4">
							<div class="card-header">
								<!-- membuat tombol untuk menambahkan akun admin -->
								<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
								  Daftar Admin
								</button>
                                
							</div>
							<div class="card-body">
								<div class="table-responsive">
									<!-- membuat tabel untuk menampilkan daftar akun admin -->
									<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
										<thead>
											<tr>
												<th>Email</th>
												<th>Aksi</th>
											</tr>
										</thead>
										<tbody>
										<?php
											//mengambil data akun dari tabel login
											$ambilsemuadataadmin = mysqli_query($conn, "select * from login");
											while($data = mysqli_fetch_array($ambilsemuadataadmin)){
												$idu = $data['iduser'];
                                                $email = $data['email'];
                                                $password = $data['password'];
											?>

											<tr>
												<td><?=$email;?></td>
												<!-- membuat button untuk ubah password dan delete -->
												<td>
													<button type="button" class="btn btn-warning" data-toggle="modal" data-target="#edit<?=$idu;?>">Ubah Password</button>
													<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete<?=$idu;?>">Delete Account</button>
												</td>
											</tr>
											<!-- menampilkan modal ubah password -->
											 <div class="modal fade" id="edit<?=$idu;?>">
												<div class="modal-dialog">
												  <div class="modal-content">
											<!-- Modal Header -->
												<div class="modal-header">
												  <h4 class="modal-title">Ubah Password</h4>
												  <button type="button" class="close" data-dismiss="modal">&times;</button>
												</div>
												
												<!-- Modal body -->
												<form method="post">
												<div class="modal-body">
                                                <input type="text" name="email" readonly value="<?=$email;?>" class="form-control">
                                                <br>
                                                <input type="password" name="password" placeholder="Kata sandi baru" class="form-control" required>
												<input type="hidden" name="idu" value="<?=$idu;?>">
												<br>
												<button type="submit" class="btn btn-primary" name="updateadmin">Save</button>
												</div>
												</form>
												
												<!-- Modal footer -->
												<div class="modal-footer">
												  <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
												</div>
												
											  </div>
											</div>
										  </div>

										  <!-- menampilkan modal delete akun -->
										  <div class="modal fade" id="delete<?=$idu;?>">
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
												  Apakah anda yakin ingin menghapus akun admin <?=$email;?>?
												  <input type="hidden" name="idu" value="<?=$idu;?>">
												  <br> <br>
												  <button type="submit" class="btn btn-danger" name="hapusadmin">Hapus</button>
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
							<div class="text-muted">Copyright &copy; Website Mesem by Ditha & Icha </div>
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
	<!-- Modal untuk menambah akun -->
	  <div class="modal fade" id="myModal">
		<div class="modal-dialog">
		  <div class="modal-content">
		  
			<!-- Modal Header -->
			<div class="modal-header">
			  <h4 class="modal-title">Tambah Admin</h4>
			  <button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			
			 <!-- Modal body -->
			<form method="post">
			<div class="modal-body">
				<!-- form inputan -->
				<input type="email" name="email" placeholder="Email" class="form-control" required>
				<br>
			  	<input type="password" name="password" placeholder="Isi kata sandi" class="form-control" required>
			  	<br>
			  	<button type="submit" class="btn btn-primary" name="tambahadmin">Submit</button>

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
