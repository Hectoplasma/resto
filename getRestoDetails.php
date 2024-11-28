<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "resto";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get restaurant name
$nama_resto = isset($_GET['nama_resto']) ? $conn->real_escape_string($_GET['nama_resto']) : '';

if ($nama_resto) {
    // Query to fetch restaurant details
    $query = "SELECT nama_resto, foto, jam_buka, jenis_makanan FROM tbl_resto WHERE nama_resto = '$nama_resto'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        echo json_encode($data);
    } else {
        echo json_encode(null); // No data found
    }
} else {
    echo json_encode(null); // Invalid request
}

$conn->close();
?>
