<?php
require 'function.php';
$restaurants = getRestaurantData();
$totalRestaurants = getTotalRestaurants();
// Fetch jenis_makanan counts
$categoryCounts = getJenisMakananCounts($conn);

// Encode the counts as JSON for JavaScript
$categoryCountsJson = json_encode($categoryCounts);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Dashboard - SB Admin</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="index.php">Restaurant</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
            
            <!-- Navbar-->
            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="login.php">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Core</div>
                            <a class="nav-link" href="index.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Dashboard
                            </a>
                            
                            
                            <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="layout-static.html">Static Navigation</a>
                                    <a class="nav-link" href="layout-sidenav-light.html">Light Sidenav</a>
                                </nav>
                            </div>
                            
                            <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseAuth" aria-expanded="false" aria-controls="pagesCollapseAuth">
                                        Authentication
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                        <nav class="sb-sidenav-menu-nested nav">
                                            <a class="nav-link" href="login.php">Login</a>
                                            <a class="nav-link" href="register.html">Register</a>
                                            <a class="nav-link" href="password.html">Forgot Password</a>
                                        </nav>
                                    </div>
                                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseError" aria-expanded="false" aria-controls="pagesCollapseError">
                                        Error
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    
                                </nav>
                            </div>
                            <div class="sb-sidenav-menu-heading">Add</div>
                            <a class="nav-link" href="tables.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                Tables
                            </a>
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Logged in as:</div>
                        ADMIN
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Dashboard</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                        <div class="row">
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-primary text-white mb-4">
                                <div class="card-body">Total Tempat Makan</div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <div class="small text-white">Jumlah: <?php echo $totalRestaurants; ?></div>
                                </div>
                            </div>
                        </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-warning text-white mb-4">
                                    <div class="card-body">Jenis Tempat Makan</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <div class="small text-white stretched-link">3</div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        <div class="row">
                            <div class="col-xl-6">
                                <div class="card mb-4">
                                    <div class="card-header text-white">
                                        <i class="fas fa-chart-pie me-1 text-white"></i>
                                        Lokasi
                                    </div>
                                    <div class="card-body"><canvas id="myPieChart" width="100%" height="40"></canvas></div>
                                </div>
                            </div>
                            <div class="col-xl-6">
        <div class="card mb-4">
            <div class="card-header text-white">
                <i class="fas fa-chart-bar me-1 text-white"></i>
                Jenis Makanan
            </div>
            <div class="card-body"><canvas id="myBarChart" width="100%" height="40"></canvas></div>
        </div>
    </div>
    <script>
        // Pass PHP data to JavaScript
        const jenisMakananCounts = <?php echo $categoryCountsJson; ?>;

        // Bar Chart
        document.addEventListener("DOMContentLoaded", function () {
            var ctx = document.getElementById("myBarChart").getContext("2d");

            var myBarChart = new Chart(ctx, {
                type: "bar",
                data: {
                    labels: ["Sarapan", "Makanan Ringan", "Makanan Berat"],
                    datasets: [{
                        label: "Jumlah Jenis Makanan",
                        backgroundColor: ["#22242A", "#22242A", "#22242A"],
                        borderColor: ["#22242A", "#22242A", "#22242A"],
                        data: [
                            jenisMakananCounts.sarapan,
                            jenisMakananCounts["makanan ringan"],
                            jenisMakananCounts["makanan berat"]
                        ],
                    }],
                },
                options: {
                    scales: {
                        xAxes: [{
                            gridLines: { display: false },
                            ticks: { maxTicksLimit: 3 },
                        }],
                        yAxes: [{
                            ticks: { beginAtZero: true, maxTicksLimit: 5 },
                            gridLines: { display: true },
                        }],
                    },
                    legend: { display: false },
                },
            });
        });
    </script>
                        </div>
                        <div class="card mb-4">
                            <div class="card-header text-white">
                                <i class="fas fa-table me-1 "></i>
                                Restaurant DataTable
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>ID Resto</th>
                                            <th>Nama Resto</th>
                                            <th>Jenis Resto</th>
                                            <th>Jenis Makanan</th>
                                            <th>Jam Buka</th>
                                            <th>Jam Tutup</th>
                                            <th>Lokasi</th>
                                            <th>Foto</th>
                                            <th>Latitude</th>
                                            <th>Longitude</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        // Loop through the fetched restaurant data and display it in the table
                                        foreach ($restaurants as $row) {
                                            // Construct the image path dynamically using id_resto
                                            $imagePath = "./assets/img/datagambar/{$row['foto']}";
                                            echo "<tr>
                                                    <td>{$row['id_resto']}</td>
                                                    <td>{$row['nama_resto']}</td>
                                                    <td>{$row['jenis_resto']}</td>
                                                    <td>{$row['jenis_makanan']}</td>
                                                    <td>{$row['jam_buka']}</td>
                                                    <td>{$row['jam_tutup']}</td>
                                                    <td>{$row['lokasi']}</td>
                                                    <td>
                                                        <img src='{$imagePath}' alt='Foto' width='100'>
                                                    </td>
                                                    <td>{$row['latitude']}</td>
                                                    <td>{$row['longitude']}</td>
                                                </tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
        <script src="assets/demo/chart-pie-demo.js"></script>
    </body>
</html>
