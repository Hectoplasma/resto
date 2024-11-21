<?php
include('function.php');

// Check if the ID is provided in the query string
if (isset($_GET['id'])) {
    $id_resto = $_GET['id'];
    // Fetch the current restaurant data from the database
    $conn = connectDB();
    $query = "SELECT * FROM tbl_resto WHERE id_resto = '$id_resto'";
    $result = mysqli_query($conn, $query);
    $restaurant = mysqli_fetch_assoc($result);
    mysqli_close($conn);
}

// If the form is submitted, update the restaurant data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_resto = $_POST['id_resto'];
    $nama_resto = $_POST['nama_resto'];
    $jenis_resto = $_POST['jenis_resto'];
    $jenis_makanan = $_POST['jenis_makanan'];
    $jam_buka = $_POST['jam_buka'];
    $jam_tutup = $_POST['jam_tutup'];
    $lokasi = $_POST['lokasi'];
    $foto = $_FILES['foto']['name'] ? $_FILES['foto']['name'] : $_POST['existing_foto']; // If no new photo, keep the existing one
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];

    // Handle file upload
    if ($_FILES['foto']['name']) {
        move_uploaded_file($_FILES['foto']['tmp_name'], "./assets/img/datagambar/{$foto}");
    }

    // Update the restaurant data in the database
    if (editRestaurant($id_resto, $nama_resto, $jenis_resto, $jenis_makanan, $jam_buka, $jam_tutup, $lokasi, $foto, $latitude, $longitude)) {
        header("Location: tables.php");
    } else {
        echo "Failed to update restaurant.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Restaurant</title>
</head>
<body>
    <h2>Edit Restaurant</h2>
    <form action="edit.php?id=<?php echo $id_resto; ?>" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id_resto" value="<?php echo $restaurant['id_resto']; ?>">
        
        <div class="mb-3">
            <label for="nama_resto" class="form-label">Restaurant Name</label>
            <input type="text" class="form-control" name="nama_resto" value="<?php echo $restaurant['nama_resto']; ?>" required>
        </div>

        <div class="mb-3">
            <label for="jenis_resto" class="form-label">Restaurant Type</label>
            <input type="text" class="form-control" name="jenis_resto" value="<?php echo $restaurant['jenis_resto']; ?>" required>
        </div>

        <div class="mb-3">
            <label for="jenis_makanan" class="form-label">Food Type</label>
            <input type="text" class="form-control" name="jenis_makanan" value="<?php echo $restaurant['jenis_makanan']; ?>" required>
        </div>

        <div class="mb-3">
            <label for="jam_buka" class="form-label">Opening Time</label>
            <input type="text" class="form-control" name="jam_buka" value="<?php echo $restaurant['jam_buka']; ?>" required>
        </div>

        <div class="mb-3">
            <label for="jam_tutup" class="form-label">Closing Time</label>
            <input type="text" class="form-control" name="jam_tutup" value="<?php echo $restaurant['jam_tutup']; ?>" required>
        </div>

        <div class="mb-3">
            <label for="lokasi" class="form-label">Location</label>
            <input type="text" class="form-control" name="lokasi" value="<?php echo $restaurant['lokasi']; ?>" required>
        </div>

        <div class="mb-3">
            <label for="foto" class="form-label">Restaurant Photo</label>
            <input type="file" class="form-control" name="foto">
            <small>Current photo: <img src="./assets/img/datagambar/<?php echo $restaurant['foto']; ?>" alt="Current Photo" width="100"></small>
            <input type="hidden" name="existing_foto" value="<?php echo $restaurant['foto']; ?>"> <!-- Pass the existing photo name -->
        </div>

        <div class="mb-3">
            <label for="latitude" class="form-label">Latitude</label>
            <input type="text" class="form-control" name="latitude" value="<?php echo $restaurant['latitude']; ?>" required>
        </div>

        <div class="mb-3">
            <label for="longitude" class="form-label">Longitude</label>
            <input type="text" class="form-control" name="longitude" value="<?php echo $restaurant['longitude']; ?>" required>
        </div>

        <button type="submit" class="btn btn-primary">Update Restaurant</button>
    </form>
</body>
</html>
