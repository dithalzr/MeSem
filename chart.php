<?php
//menyertakan file koneksi dan cek
//memastikan bahwa sudah terkoneksi dan sudah login
include 'koneksi.php';
include 'cek.php';

//mendeklarasikan variabel untuk memilih all dari tabel stok
$case = mysqli_query($conn, "select * from stok");
//menangambil data dalam bentu array
while($row = mysqli_fetch_array($case)){
    $namasembako[] = $row['namasembako'];
    $query = mysqli_query($conn,"select stok from stok where idsembako='".$row['idsembako']."'");
    $row = $query->fetch_array();
    $stok[] = $row['stok'];
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
        <title>MeSem</title>
        <!-- menghubungkan ke file css -->
        <link href="css/styles.css" rel="stylesheet" />
        <!-- menghubungkan ke tautan bootstrap -->
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
        <script type="text/javascript" src="chart.js"></script>
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
                        <h1 class="mt-4">Grafik Stok Sembako</h1>
                        <div class="card mb-4">
                            <div class="card-header">
                                <!-- Button untuk membuka chart, ketika di klik maka akan terhubung dgn function masing2 -->
                                <button type="radio" id="btnbar" class="btn btn-danger" onclick="BarChart()">
                                  Bar Chart
                                </button>
                                <button type="button" id="btnline" class="btn btn-info" onclick="LineChart()">
                                  Line Chart
                                </button>
                                <button type="button" class="btn btn-warning" onclick="PieChart()">
                                  Pie Chart
                                </button>
                                <button type="button" class="btn btn-success" onclick="DoughnutChart()">
                                  Doughnut Chart
                                </button>
                            </div>

                            <div class="card-body">
                                <div class="container" align="center">
                                <div style="width: 800px;">
                                <!-- canvas untuk menampilkan diagram/chart -->
                                <canvas id="myChart"></canvas>   

                                <!-- menampilkan bar chart -->
                                <script id="bar">
                                    function BarChart() {
                                    //deklarasikan variable untuk mengambil data dari id myChart, canvasnya
                                    var ctx = document.getElementById("myChart").getContext('2d');
                                    var myChart = new Chart (ctx, {
                                        //tipe chart yg digunakan adalah bar chart atau diagram bar
                                        type: 'bar',
                                        data: {
                                            //memberikan label pada chart
                                            labels: <?php echo json_encode($namasembako);?>,
                                            datasets: [{
                                                label: 'Grafik Stok Sembako',
                                                data: <?php echo json_encode($stok);?>,
                                                //warnai bar dengan warna pink
                                                backgroundColor: 'rgba(255,99,132,0.2)',
                                                //warnai bar dengan warna merah
                                                borderColor: 'rgba(255,99,132,1)',
                                                borderWidth: 1
                                            }]
                                        },
                                        options: {
                                            scales: {
                                                yAxes: [{
                                                    ticks: {
                                                        beginAtZero: true
                                                    }
                                                }]
                                            }
                                        }
                                    });
                                    }
                                </script>

                                <!-- menampilkan line chart -->
                                <script id="line">
                                    function LineChart() {
                                        var myChart2 = new Chart(
                                            //masukan chart ke element canvas dengan id myChart
                                            document.getElementById('myChart'),
                                            {
                                                //tipe chart yg digunakan adalah line chart atau diagram garis
                                                type: 'line',
                                                data: {
                                                    labels: <?php echo json_encode($namasembako); ?>,
                                                    datasets: [{
                                                        label: 'Jumlah Stok Sembako',
                                                        data: <?php echo json_encode($stok); ?>,
                                                        //line akan diwarnai dengan warna merah
                                                        backgroundColor: [
                                                        'rgb(255, 99, 132)',
                                                        ],
                                                        hoverOffset: 4
                                                    }]
                                                }
                                            }
                                        );
                                    }
                                    </script>

                                <!-- menampilkan pie chart -->
                                <script id="pie">
                                    function PieChart() {
                                        //deklarasikan variable untuk mengambil data dari id myChart, canvasnya
                                        var ctx = document.getElementById("myChart").getContext("2d");
                                        var data = {
                                            //memberikan label pada chart
                                            labels: <?php echo json_encode($namasembako); ?>,
                                            datasets: [
                                            {
                                              label: "Data Sembako",
                                              data: <?php echo json_encode($stok); ?>,
                                              backgroundColor: [
                                            'rgba(255, 99, 132, 0.2)',
                                            'rgba(54, 162, 235, 0.2)',
                                            'rgba(255, 206, 86, 0.2)',
                                            'rgba(75, 192, 192, 0.2)'
                                            ],
                                            borderColor: [
                                            'rgba(255,99,132,1)',
                                            'rgba(54, 162, 235, 1)',
                                            'rgba(255, 206, 86, 1)',
                                            'rgba(75, 192, 192, 1)'
                                            ],
                                            }
                                            ]
                                            };
                                        //tipe chart yg digunakan adalah pie chart atau diagram pie
                                        var mypiechart = new Chart(ctx, {
                                                  type: 'pie',
                                                  data: data,
                                                  options: {
                                                    responsive: true
                                                }
                                              }); 
                                    }
                                </script>  

                                <!-- menampilkan doughnut chart -->
                                <script id="doughnut">
                                    function DoughnutChart(){
                                        //deklarasikan variable untuk mengambil data dari id myChart, canvasnya
                                        var ctx = document.getElementById("myChart").getContext("2d");
                                        var data = {
                                            //memberikan label pada chart
                                            labels: <?php echo json_encode($namasembako); ?>,
                                            datasets: [
                                            {
                                              label: "Data Sembako",
                                              data: <?php echo json_encode($stok); ?>,
                                              backgroundColor: [
                                                '#29B0D0',
                                                '#2A516E',
                                                '#F07124',
                                                '#CBE0E3',
                                                '#979193'
                                              ]
                                            }
                                            ]
                                            };
                                        //tipe chart yg digunakan adalah doughnut chart atau diagram donat
                                        var mydoughnutchart = new Chart(ctx, {
                                                  type: 'doughnut',
                                                  data: data,
                                                  options: {
                                                    responsive: true
                                                }
                                              }); 
                                    }
                                </script>
                                </div>
                            </div>
                    </div>
                </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center justify-content-between small">
                            <!-- membuat watermark-->
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