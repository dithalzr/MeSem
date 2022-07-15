<?php
//menyertakan file koneksi dan cek
//memastikan bahwa sudah terkoneksi dan sudah login
include 'koneksi.php';
include 'cek.php';
?>
<html>
<head>
  <title>Stock Barang</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
</head>

<body>
<div class="container">
    <!-- Pembuatan tabel -->
	<h2>Tabel Stok Sembako Keluar</h2>
		<div class="data-tables datatable-dark">
            <table class="table table-bordered" id="tabelsembakokeluar" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Nama</th>
                        <th>Penerima</th>
                        <th>Stok</th>
                        <th>Harga</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- pengisian data pada tabel dengan memanggil nilai variabel dari tabel keluar dan stok -->
                    <?php
                        $ambilsemuadatastok = mysqli_query($conn, "select * from keluar k, stok s where s.idsembako = k.idsembako");
                        while($data = mysqli_fetch_array($ambilsemuadatastok)){
                            $tanggal = $data['tanggal'];
                            $namasembako = $data['namasembako'];
                            $penerima = $data['penerima'];
                            $qty = $data['qty'];
                            $harga = $data['harga'];
                            $ids = $data['idsembako'];
                            $idk = $data['idkeluar'];
                    ?>

                    <tr>
                        <td><?=$tanggal;?></td>
                        <td><?=$namasembako;?></td>
                        <td><?=$penerima;?></td>
                        <td><?=$qty;?></td>
                        <td><?=$harga;?></td>
                    </tr>
                                           
                    <?php
                        };

                    ?>
                </tbody>
            </table>
        </div>
<script>
//pembuatan menu ekspor data
$(document).ready(function() {
    $('#tabelsembakokeluar').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'copy','csv','excel', 'pdf', 'print'
        ]
    } );
} );

</script>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>

	

</body>

</html>
