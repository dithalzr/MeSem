<?php
session_start();
//membuat koneksi ke database
$conn = mysqli_connect("localhost","root","", "mesem");

//menambah sembako baru (button tambah sembako)
//mengambil nilai pada variabel yang telah diisi
if (isset($_POST['tambahsembakobaru'])) {
	$namasembako = $_POST['namasembako'];
	$kategori = $_POST['kategori'];
	$stok = $_POST['stok'];
	$harga = $_POST['harga'];
    $totalharga = $_POST['totalharga'];

    $totalharga = $stok * $harga;
    //pengisian nilai inputan pada tabel stok
	$tambahketabel = mysqli_query($conn, "insert into stok (namasembako, kategori, stok, harga, totalharga) values ('$namasembako', '$kategori', '$stok', '$harga', $totalharga)");
	if ($tambahketabel) {
		header('location: index.php');
	}else {
		echo 'gagal';
		header('location: index.php');
	}
}

//menambah sembako masuk (tambah pada sembako masuk)
//mengambil nilai pada variabel yang telah diisi
if (isset($_POST['sembakomasuk'])) {
	$sembakonya = $_POST['sembakonya'];
	$penerima = $_POST['penerima'];
	$qty = $_POST['qty'];
	
	//pengambilan data pada tabel stok
    $cekharga = mysqli_query($conn, "select * from stok where idsembako='$sembakonya'");
    //mengambil data harga
    $ambilharga= mysqli_fetch_array($cekharga);
    $hargahitung = $ambilharga['harga'];

    //perhitungan totalharga
    $totalhargamasuk = 0;
    $totalhargamasuk = $qty * $hargahitung;

    //pengambulan data dari tabel stok
	$cekstoksekarang = mysqli_query($conn, "select * from stok where idsembako='$sembakonya'");
	$ambildatanya= mysqli_fetch_array($cekstoksekarang);
	$stoksekarang = $ambildatanya['stok'];
	$totalharga = $ambildatanya['totalharga'];

	//perhitungan penambahan stok
	$tambahkanstok = $stoksekarang+$qty;
	$tambahkanharga = $totalharga+$totalhargamasuk;

	//pengisian nilai inputan pada tabel masuk
	$tambahkemasuk = mysqli_query($conn, "insert into masuk (idsembako, keterangan, qty, harga, totalhargamasuk) values ('$sembakonya', '$penerima',  '$qty' ,'$hargahitung', '$totalhargamasuk')");
	//update tabel stok
	$updatestokmasuk = mysqli_query($conn, "update stok set stok='$tambahkanstok', totalharga='$tambahkanharga' where idsembako='$sembakonya'");

	if ($tambahkemasuk&&$updatestokmasuk) {
		header('location: masuk.php');
	}else {
		echo 'gagal';
		header('location: masuk.php');
	}
}

//menambah sembako keluar (tambah pada sembako keluar)
//mengambil nilai pada variabel yang telah diisi
if (isset($_POST['sembakokeluar'])) {
	$sembakonya = $_POST['sembakonya'];
	$penerima = $_POST['penerima'];
	$qty = $_POST['qty'];
	
	//pengambilan nilai inputan dari tabel stok
    $cekharga = mysqli_query($conn, "select * from stok where idsembako='$sembakonya'");
    $ambilharga= mysqli_fetch_array($cekharga);
    $hargahitung = $ambilharga['harga'];
    //perhitungan totalhargakeluar
    $totalhargakeluar = 0;
    $totalhargakeluar = $qty * $hargahitung;

    //pengambilan nilai dari tabel stok
	$cekstoksekarang = mysqli_query($conn, "select * from stok where idsembako='$sembakonya'");
	$ambildatanya= mysqli_fetch_array($cekstoksekarang);

	$stoksekarang = $ambildatanya['stok'];
	//penampilan alert jika jlh sembako keluar melebihi batas
	//jika sembako masih cukup
	if($stoksekarang >= $qty){
	$kurangstok = $stoksekarang-$qty;
	$kurangkanharga = $totalharga-$totalhargakeluar;

	//pengisian data pada tabel keluar
	$tambahkeluar = mysqli_query($conn, "insert into keluar (idsembako, penerima, qty, harga, totalhargakeluar) values ('$sembakonya', '$penerima',  '$qty' ,'$hargahitung', '$totalhargakeluar')");
	//update tabel keluar
	$updatestokkeluar = mysqli_query($conn, "update stok set stok='$kurangstok', totalharga='$kurangkanharga' where idsembako='$sembakonya'");

	if ($tambahkeluar&&$updatestokkeluar) {
		header('location: keluar.php');
	}else {
		echo 'gagal';
		header('location: keluar.php');
	}
	} else {
		//fungsi if jika sembako tidak lagi cukup
		echo '
		<script>
			alert("Stok saat ini tidak mencukupi");
			window.location.href="keluar.php"
		</script>
		';
	}
}

//update info sembako (edit pada menu stok)
//mengambil nilai pada variabel yang telah diisi
if (isset($_POST['updatesembako'])) {
	$ids = $_POST['ids'];
	$namasembako = $_POST['namasembako'];
	$kategori = $_POST['kategori'];
    $harga = $_POST['harga'];

    //mengambil data stok dari tabel stok
    $lihatstok = mysqli_query($conn, "select * from stok where idsembako='$ids'");
    $stoknya = mysqli_fetch_array($lihatstok);
    $stokskrg = $stoknya['stok'];

    //perhitungan variabel totalharga
    $totalharga = $harga*$stokskrg;

	//update tabel stok
	$update = mysqli_query($conn, "update stok set namasembako='$namasembako', kategori='$kategori', harga='$harga', totalharga='$totalharga' where idsembako='$ids'");
	if ($update) {
		header('location: index.php');
	}else {
		echo 'gagal';
		header('location: index.php');
	}
}

//menghapus sembako dari stok
//mengambil nilai pada variabel yang telah diisi
if (isset($_POST['hapussembako'])) {
	$ids = $_POST['ids'];

	//menghapus data dari tabel stok
	$hapus = mysqli_query($conn, "delete from stok where idsembako='$ids'");
	if ($hapus) {
		header('location: index.php');
	}else {
		echo 'gagal';
		header('location: index.php');
	}
}


//mengubah data barang masuk (button edit)
//mengambil nilai pada variabel yang telah diisi
if(isset($_POST['updatesembakomasuk'])){
    $ids = $_POST['ids'];
    $idm = $_POST['idm'];
    $keterangan = $_POST['keterangan'];
    $qty = $_POST['qty'];

    //mengambil data dari tabel stok
    $cekstoksekarang = mysqli_query($conn, "select * from stok where idsembako='$ids'");
    $ambildatanya= mysqli_fetch_array($cekstoksekarang);
    $stoksekarang = $ambildatanya['stok'];
    $totalharga = $ambildatanya['totalharga'];

    $cekharga = mysqli_query($conn, "select * from stok where idsembako='$ids'");
    $ambilharga= mysqli_fetch_array($cekharga);
    $hargahitung = $ambilharga['harga'];

    //mengambil data dari tabel masuk
    $qtyskrg = mysqli_query($conn, "select * from masuk where idmasuk='$idm'");
    $qtynya = mysqli_fetch_array($qtyskrg);
    $qtyskrg = $qtynya['qty'];

    $totalhargamasuk= 0;
    $totalhargamasuk = $qty * $hargahitung;

    //operasi if jika nilai inputan yang diubah berubah menjadi lebih besar
    if ($qty>$qtyskrg) {
        $selisih = $qty-$qtyskrg;
        $kurangin = ($stoksekarang + $selisih);
        $tambahkanharga = $kurangin*$hargahitung;
        //update tabel stok
        $kurangistoknya = mysqli_query($conn, "update stok set stok='$kurangin', totalharga='$tambahkanharga' where idsembako='$ids'");
        //update tabel masuk
        $updatenya = mysqli_query($conn, "update masuk set qty='$qty', keterangan='$keterangan', harga='$hargahitung', totalhargamasuk='$totalhargamasuk' where idmasuk='$idm'");
        if($kurangistoknya && $updatenya){
            header('location: masuk.php');
        } else {
            echo "Gagal";
            header('location: masuk.php');
        } 
        //operasi if jika nilai inputan yang diubah berubah menjadi lebih kecil
        } else {
            $selisih = $qtyskrg - $qty;
            $kurangin = ($stoksekarang - $selisih);
        	$tambahkanharga = $kurangin*$hargahitung;
        	//update tabel stok
            $kurangistoknya = mysqli_query($conn, "update stok set stok='$kurangin', totalharga='$tambahkanharga' where idsembako='$ids'");
            //update tabel masuk
            $updatenya = mysqli_query($conn, "update masuk set qty='$qty', keterangan='$keterangan', harga='$hargahitung', totalhargamasuk='$totalhargamasuk' where idmasuk='$idm'");
        if($kurangistoknya && $updatenya){
                header('location: masuk.php');
            } else {
                echo "Gagal";
                header('location: masuk.php');
        
        }
}
    }

//menghapus data barang masuk (delete sembako masuk)
//mengambil nilai pada variabel yang telah diisi
if(isset($_POST['hapussembakomasuk'])){
	$ids = $_POST['ids'];
	$idm = $_POST['idm'];
	$qty = $_POST['kty'];

	//pengambilan data dari tabel stok
	$cekharga = mysqli_query($conn, "select * from stok where idsembako='$ids'");
    $ambilharga= mysqli_fetch_array($cekharga);
    $hargahitung = $ambilharga['harga'];

	$getdatastok = mysqli_query($conn, "select * from stok where idsembako ='$ids'");
	$data = mysqli_fetch_array($getdatastok);
	$stok = $data['stok'];
	$totalharga = $ambildatanya['totalharga'];

	//operasi untuk update totalharga
	$selisih = $stok - $qty;
	$tambahkanharga = $selisih*$hargahitung;

	//update data pada tabel stok
	$updatedata = mysqli_query($conn, "update stok set stok='$selisih', totalharga='$tambahkanharga' where idsembako='$ids'");

	//hapus data dari tabel masuk
 	$hapusdata = mysqli_query($conn, "delete from masuk where idmasuk='$idm'");

	if($updatedata && $hapusdata){
		header('location: masuk.php');
	} else {
		echo "Gagal";
		header('location: masuk.php');
		
	}
}

//mengubah data barang keluar (edit sembako keluar)
//mengambil nilai pada variabel yang telah diisi
if(isset($_POST['updatesembakokeluar'])){
	$ids = $_POST['ids'];
	$idk = $_POST['idk'];
	$penerima = $_POST['penerima'];
	$qty = $_POST['qty'];

	//pengambilan nilai dari tabel stok
	$cekstoksekarang = mysqli_query($conn, "select * from stok where idsembako='$ids'");
    $ambildatanya= mysqli_fetch_array($cekstoksekarang);
    $stoksekarang = $ambildatanya['stok'];
    $totalharga = $ambildatanya['totalharga'];

    $cekharga = mysqli_query($conn, "select * from stok where idsembako='$ids'");
    $ambilharga= mysqli_fetch_array($cekharga);
    $hargahitung = $ambilharga['harga'];

    //pengambilan nilai dari tabel keluar
    $qtyskrg = mysqli_query($conn, "select * from keluar where idkeluar='$idk'");
    $qtynya = mysqli_fetch_array($qtyskrg);
    $qtyskrg = $qtynya['qty'];

    //operasi untuk data totalhargakeluar
    $totalhargakeluar= 0;
    $totalhargakeluar = $qty * $hargahitung;

    ////operasi if jika nilai inputan yang diubah berubah menjadi lebih besar
	if ($qty>$qtyskrg) {
        $selisih = $qty-$qtyskrg;
        $kurangin = ($stoksekarang - $selisih);
        $tambahkanharga = $kurangin*$hargahitung;
        //update data pada tabel stok
        $kurangistoknya = mysqli_query($conn, "update stok set stok='$kurangin', totalharga='$tambahkanharga' where idsembako='$ids'");
        //update data pada tabel keluar
        $updatenya = mysqli_query($conn, "update keluar set qty='$qty', penerima='$penerima', harga='$hargahitung', totalhargakeluar='$totalhargakeluar' where idkeluar='$idk'");
        if($kurangistoknya && $updatenya){
            header('location: keluar.php');
        } else {
            echo "Gagal";
            header('location: keluar.php');
        }
        //operasi if jika nilai inputan yang diubah berubah menjadi lebih kecil 
        } else {
            $selisih = $qtyskrg - $qty;
            $kurangin = ($stoksekarang + $selisih);
        	$tambahkanharga = $kurangin*$hargahitung;
        	//update data pada tabel stok
            $kurangistoknya = mysqli_query($conn, "update stok set stok='$kurangin', totalharga='$tambahkanharga' where idsembako='$ids'");
            //update data pada tabel keluar
            $updatenya = mysqli_query($conn, "update keluar set qty='$qty', penerima='$penerima', harga='$hargahitung', totalhargakeluar='$totalhargakeluar' where idkeluar='$idk'");
        if($kurangistoknya && $updatenya){
                header('location: keluar.php');
            } else {
                echo "Gagal";
                header('location: keluar.php');
        
        }
}
	}

//menghapus data barang keluar (button hapus)
//mengambil nilai pada variabel yang telah diisi
if(isset($_POST['hapussembakokeluar'])){
	$ids = $_POST['ids'];
	$idk = $_POST['idk'];
	$qty = $_POST['kty'];

	//pengambilan data dari tabel stok
	$cekharga = mysqli_query($conn, "select * from stok where idsembako='$ids'");
    $ambilharga= mysqli_fetch_array($cekharga);
    $hargahitung = $ambilharga['harga'];

	$getdatastok = mysqli_query($conn, "select * from stok where idsembako ='$ids'");
	$data = mysqli_fetch_array($getdatastok);
	$stok = $data['stok'];
	$totalharga = $ambildatanya['totalharga'];

	//operasi untuk pengubahan totalharga
	$selisih = $stok + $qty;
	$tambahkanharga = $selisih*$hargahitung;

	//update data pada tabel stok
	$updatedata = mysqli_query($conn, "update stok set stok='$selisih', totalharga='$tambahkanharga' where idsembako='$ids'");
	//hapus data dari tabel keluar
 	$hapusdata = mysqli_query($conn, "delete from keluar where idkeluar='$idk'");

	if($updatedata && $hapusdata){
		header('location: keluar.php');
	} else {
		echo "Gagal";
		header('location: keluar.php');
		
	}
}

//menambah admin baru
//mengambil nilai pada variabel yang telah diisi
if (isset($_POST['tambahadmin'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    //pengisian nilai inputan ke tabel login
    $tambahketabel = mysqli_query($conn, "insert into login (email, password) values ('$email', '$password')");
    if ($tambahketabel) {
        header('location: admin.php');
    }else {
        echo 'gagal';
        header('location: admin.php');
    }
}

//update admin
//mengambil nilai pada variabel yang telah diisi
if (isset($_POST['updateadmin'])) {
    $idu = $_POST['idu'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    //pengubahan data password pada tabel login
    $update = mysqli_query($conn, "update login set email='$email', password='$password' where iduser='$idu'");
    if ($update) {
        header('location: admin.php');
    }else {
        echo 'gagal';
        header('location: admin.php');
    }
}

//hapus admin
//mengambil nilai pada variabel yang telah diisi
if (isset($_POST['hapusadmin'])) {
    $idu = $_POST['idu'];

    //hapus data admin
    $hapus = mysqli_query($conn, "delete from login where iduser='$idu'");
    if ($hapus) {
        header('location: admin.php');
    }else {
        echo 'gagal';
        header('location: admin.php');
    }
}


?>