<?php
// Include the function.php file to access the getRestaurantData function
include('function.php');

// Fetch restaurant data
$restaurants = getRestaurantData();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Tables - SB Admin</title>
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
                    
                        <h1 class="mt-4">Tables</h1>
                        
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                            
                            <li class="breadcrumb-item active">Tables</li>
                        </ol>
                        
                        <div class="card mb-4">
                    <div class="card-header text-white">
                        <i class="fas fa-table me-1"></i>
                        Restaurant DataTable
                    </div>
                    <div class="card-body container-flex">
                        <!-- Add Button -->
                        <button class ="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#addModal">Add Restaurant</button>
            

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
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($restaurants as $row) {
                        // Construct the image path dynamically using foto column
                        $imagePath = "./assets/img/datagambar/{$row['foto']}";
                        echo "<tr>
                                <td>{$row['id_resto']}</td>
                                <td>{$row['nama_resto']}</td>
                                <td>{$row['jenis_resto']}</td>
                                <td>{$row['jenis_makanan']}</td>
                                <td>{$row['jam_buka']}</td>
                                <td>{$row['jam_tutup']}</td>
                                <td>{$row['lokasi']}</td>
                                <td><img src='{$imagePath}' alt='Foto' width='100'></td>
                                <td>{$row['latitude']}</td>
                                <td>{$row['longitude']}</td>
                                <td>
                                    <a href='edit.php?id={$row['id_resto']}' class= 'btn'>Edit</a>
                                    <a href='delete.php?id={$row['id_resto']}' class= 'btn'>Delete</a>
                                </td>
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
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2022</div>
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
        <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title " id="addModalLabel">Add Restaurant</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="add.php" method="POST">
                        <div class="mb-3">
                            <label for="id_resto" class="form-label">ID Resto</label>
                            <input type="text" class="form-control" name="id_resto" required>
                        </div>
                        <div class="mb-3">
                            <label for="nama_resto" class="form-label">Nama Resto</label>
                            <input type="text" class="form-control" name="nama_resto" required>
                        </div>
                        <!-- Add other fields here -->
                        <button type="submit" class="btn btn-primary">Add Restaurant</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
    </body>
</html>
