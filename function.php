<?php
session_start();
$db="resto";
$conn = mysqli_connect("localhost","root","",$db);
// Database connection
function connectDB() {
    $db = "resto";
    $conn = mysqli_connect("localhost", "root", "", $db);
    if (!$conn) {
        die("Database connection failed: " . mysqli_connect_error());
    }
    return $conn;
}

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
//LOGIN
//testing user abc password abc
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query to check if the user exists
    $result = mysqli_query($conn, "SELECT * FROM user WHERE name = '$username'");

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_array($result);
        if ($password === $user['password']) { // Compare plain text password
            // Redirect to index.php
            header('Location: index.php');
            exit();
        } else {
            echo '<script>
                    alert("Password Salah");
                    window.location.href = "login.php";
                  </script>';
        }
    } else {
        echo '<script>
                alert("Login Gagal: Username tidak ditemukan");
                window.location.href = "login.php";
              </script>';
    }
}

function getRestaurantData() {
    // Database connection
    $db = "resto";
    $conn = mysqli_connect("localhost", "root", "", $db);

    if (!$conn) {
        die("Database connection failed: " . mysqli_connect_error());
    }

    // Query to fetch data from tbl_resto
    $query = "SELECT * FROM tbl_resto";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    }

    // Fetch all rows from the result
    $restaurants = mysqli_fetch_all($result, MYSQLI_ASSOC);

    // Close the connection
    mysqli_close($conn);

    return $restaurants;
}

// Add a new restaurant
function addRestaurant($id_resto, $nama_resto, $jenis_resto, $jenis_makanan, $jam_buka, $jam_tutup, $lokasi, $foto, $latitude, $longitude) {
    $conn = connectDB();
    $query = "INSERT INTO tbl_resto (id_resto, nama_resto, jenis_resto, jenis_makanan, jam_buka, jam_tutup, lokasi, foto, latitude, longitude) 
              VALUES ('$id_resto', '$nama_resto', '$jenis_resto', '$jenis_makanan', '$jam_buka', '$jam_tutup', '$lokasi', '$foto', '$latitude', '$longitude')";
    if (mysqli_query($conn, $query)) {
        return true;
    } else {
        return false;
    }
    mysqli_close($conn);
}

// Edit a restaurant's details
function editRestaurant($id_resto, $nama_resto, $jenis_resto, $jenis_makanan, $jam_buka, $jam_tutup, $lokasi, $foto, $latitude, $longitude) {
    $conn = connectDB();

    // Check if the photo filename is not empty, implying a new file was uploaded
    if ($foto) {
        // If a new file has been uploaded, update the photo filename
        $query = "UPDATE tbl_resto SET nama_resto='$nama_resto', jenis_resto='$jenis_resto', jenis_makanan='$jenis_makanan', 
                  jam_buka='$jam_buka', jam_tutup='$jam_tutup', lokasi='$lokasi', foto='$foto', latitude='$latitude', longitude='$longitude' 
                  WHERE id_resto='$id_resto'";
    } else {
        // No new photo uploaded, so keep the old photo filename
        $query = "UPDATE tbl_resto SET nama_resto='$nama_resto', jenis_resto='$jenis_resto', jenis_makanan='$jenis_makanan', 
                  jam_buka='$jam_buka', jam_tutup='$jam_tutup', lokasi='$lokasi', latitude='$latitude', longitude='$longitude' 
                  WHERE id_resto='$id_resto'";
    }

    if (mysqli_query($conn, $query)) {
        return true;
    } else {
        return false;
    }

    mysqli_close($conn);
}




// Delete a restaurant
function deleteRestaurant($id_resto) {
    $conn = connectDB();
    $query = "DELETE FROM tbl_resto WHERE id_resto='$id_resto'";
    if (mysqli_query($conn, $query)) {
        return true;
    } else {
        return false;
    }
    mysqli_close($conn);
}

function getTotalRestaurants() {
    $conn = connectDB(); // Ensure you have a function to connect to the database
    $query = "SELECT COUNT(*) AS total FROM tbl_resto";
    $result = mysqli_query($conn, $query);
    $total = 0;

    if ($row = mysqli_fetch_assoc($result)) {
        $total = $row['total'];
    }

    mysqli_close($conn);
    return $total;
}


function getJenisMakananCounts($conn) {
    // Query to fetch all jenis_makanan from the database
    $query = "SELECT jenis_makanan FROM tbl_resto";
    $result = mysqli_query($conn, $query);

    $categoryCounts = [
        'sarapan' => 0,
        'makanan ringan' => 0,
        'makanan berat' => 0,
    ];

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $makananTypes = explode(',', strtolower($row['jenis_makanan'])); // Split by comma, lowercase
            foreach ($makananTypes as $type) {
                $type = trim($type); // Trim whitespace
                if ($type === 'sarapan') {
                    $categoryCounts['sarapan']++;
                } 
                if ($type === 'makanan ringan') {
                    $categoryCounts['makanan ringan']++;
                } 
                if ($type === 'makanan berat') {
                    $categoryCounts['makanan berat']++;
                }
                
            }
        }
    }
    return $categoryCounts;
}







?>