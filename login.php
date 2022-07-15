<?php
//menyertakan file koneksi
//memastikan bahwa sudah terkoneksi
include 'koneksi.php';

//cek login
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    //mencocokan data ke database
    $cekdatabase = mysqli_query($conn, "SELECT * FROM login where email='$email' and password='$password'");

    //hitung jumlah data yang cocok
    $hitung = mysqli_num_rows($cekdatabase);
    //jika data lebih dari 0 maka login berhasil
    if ($hitung>0) {
        $_SESSION['log'] = 'True';
        header('location: index.php');
    } else {
        header('location: login.php');
    } 
}

//jika sudah login
if (!isset($_SESSION['log'])) {
    
} else {
    header('location: index.php');
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
        <title>Login</title>
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
        <style>
        /* pengaturan style background */
        .bg-primary {
            background: url(beranda.png);
            background-position: center;
            background-size: cover;
        }
        /* pengaturan style body */
        body{
            font-family: Calibri;
        }
        /* pengaturan animasi loading */
        #loader {
          position: absolute;
          left: 50%;
          top: 50%;
          z-index: 1;
          width: 120px;
          height: 120px;
          margin: -76px 0 0 -76px;
          border: 16px solid #f3f3f3;
          border-radius: 50%;
          border-top: 16px solid #3498db;
          -webkit-animation: spin 2s linear infinite;
          animation: spin 2s linear infinite;
        }

        @-webkit-keyframes spin {
          0% { -webkit-transform: rotate(0deg); }
          100% { -webkit-transform: rotate(360deg); }
        }

        @keyframes spin {
          0% { transform: rotate(0deg); }
          100% { transform: rotate(360deg); }
        }

        /* mengatur animasi */
        .animate-bottom {
          position: relative;
          -webkit-animation-name: animatebottom;
          -webkit-animation-duration: 1s;
          animation-name: animatebottom;
          animation-duration: 1s
        }

        @-webkit-keyframes animatebottom {
          from { bottom:-100px; opacity:0 } 
          to { bottom:0px; opacity:1 }
        }

        @keyframes animatebottom { 
          from{ bottom:-100px; opacity:0 } 
          to{ bottom:0; opacity:1 }

        }
        </style>
    </head>
    <!-- ketika halaman dimuat maka akan loading terlebih dahulu, myFunction() -->
    <body class="bg-primary" onload="myFunction()">
        <div id="loader"></div>
        <div id="layoutAuthentication" style="display: none;">
            <div id="layoutAuthentication_content">
                <main>
                    <br>
                    <br>
                    <br>
                    <!-- membuat form login -->
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Login</h3></div>
                                    <div class="card-body">
                                        <form method="post">
                                            <div class="form-group">
                                                <label class="small mb-1" for="inputEmailAddress">Email</label>
                                                <input class="form-control py-4" name="email" id="inputEmailAddress" type="email" placeholder="Enter email address" />
                                            </div>
                                            <div class="form-group">
                                                <label class="small mb-1" for="inputPassword">Password</label>
                                                <input class="form-control py-4" name="password" id="inputPassword" type="password" placeholder="Enter password" />
                                            </div>
                                            <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                                                <button class="btn btn-primary" name="login">Login</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
        <!-- membuat script untuk memunculkan animasi loading -->
        <script>
        var myVar;

        function myFunction() {
          myVar = setTimeout(showPage, 3000);
        }
        //ketika loader dimuat maka halaman login akan ditutup sementara dalam 3 detik / 3000 ms
        function showPage() {
          document.getElementById("loader").style.display = "none";
          document.getElementById("layoutAuthentication").style.display = "block";
        }
        </script>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
    </body>
</html>
