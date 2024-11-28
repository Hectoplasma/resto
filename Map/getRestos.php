<?php
// Koneksi database
$servername = "localhost";
$username = "root"; // Ganti dengan username DB Anda
$password = ""; // Ganti dengan password DB Anda
$dbname = "resto"; // Ganti dengan nama database Anda

// Buat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ambil wilayah dari query string
$wilayah = isset($_GET['wilayah']) ? $_GET['wilayah'] : '';

// Ambil data rumah makan berdasarkan wilayah yang dipilih
if ($wilayah) {
    // Memperbarui query untuk mengambil nama restoran, latitude, dan longitude
    $restoQuery = "SELECT nama_resto, latitude, longitude FROM tbl_resto WHERE lokasi = '$wilayah'";
    $restoResult = $conn->query($restoQuery);

    $restoData = [];
    if ($restoResult->num_rows > 0) {
        while ($row = $restoResult->fetch_assoc()) {
            // Menambahkan data latitude dan longitude ke dalam array
            $restoData[] = [
                'nama_resto' => $row['nama_resto'],
                'latitude' => $row['latitude'],
                'longitude' => $row['longitude']
            ];
        }
    }

    // Kirimkan hasil sebagai JSON
    echo json_encode($restoData);
} else {
    // Jika tidak ada wilayah yang dipilih, kirimkan array kosong
    echo json_encode([]);
}

$conn->close();
?>
