<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "resto";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$namaResto = isset($_GET['nama_resto']) ? $_GET['nama_resto'] : '';

if ($namaResto) {
    $query = "SELECT nama_resto, foto, jam_buka, jenis_makanan FROM tbl_resto WHERE nama_resto = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $namaResto);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo json_encode($result->fetch_assoc());
    } else {
        echo json_encode(null);
    }

    $stmt->close();
} else {
    echo json_encode(null);
}

$conn->close();
?>
