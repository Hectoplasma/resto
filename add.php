<?php
include('function.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $id_resto = $_POST['id_resto'];
    $nama_resto = $_POST['nama_resto'];
    $jenis_resto = $_POST['jenis_resto'];
    $jenis_makanan = $_POST['jenis_makanan'];
    $jam_buka = $_POST['jam_buka'];
    $jam_tutup = $_POST['jam_tutup'];
    $lokasi = $_POST['lokasi'];
    $foto = $_FILES['foto']['name'];  // Handle file upload here
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];

    // Upload file logic (you may want to move the file to the correct folder)
    move_uploaded_file($_FILES['foto']['tmp_name'], "./assets/img/datagambar/{$foto}");

    if (addRestaurant($id_resto, $nama_resto, $jenis_resto, $jenis_makanan, $jam_buka, $jam_tutup, $lokasi, $foto, $latitude, $longitude)) {
        header("Location: tables.php");
    } else {
        echo "Failed to add restaurant";
    }
}
?>
