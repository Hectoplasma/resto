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
    
    // Check if a new image was uploaded
    if ($_FILES['foto']['name']) {
        // Get the new image filename and move it to the correct directory
        $foto = $_FILES['foto']['name'];
        move_uploaded_file($_FILES['foto']['tmp_name'], "./assets/img/datagambar/{$foto}");
    } else {
        // If no new image is uploaded, retain the existing photo
        $foto = $_POST['existing_foto'];
    }

    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];

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
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 30px auto;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .header {
            background-color: #22242A;
            color: #fff;
            padding: 20px;
            text-align: center;
        }
        .header h2 {
            margin: 0;
            font-size: 24px;
        }
        .form-group {
            padding: 15px;
            margin-bottom: 15px;
        }
        .form-label {
            display: block;
            font-weight: bold;
            margin-bottom: 8px;
        }
        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .form-control:focus {
            outline: none;
            border-color: #626064;
            box-shadow: 0 0 4px rgba(98, 96, 100, 0.5);
        }
        .current-photo {
            display: flex;
            align-items: center;
            margin-top: 5px;
        }
        .current-photo img {
            margin-left: 10px;
            max-width: 100px;
        }
        .btn-primary {
            background-color: #626064;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn-primary:hover {
            background-color: #4e4c4e;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Edit Restaurant</h2>
        </div>
        <form action="edit.php?id=<?php echo $id_resto; ?>" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nama_resto" class="form-label">Nama Restoran</label>
                <input type="text" class="form-control" name="nama_resto" value="<?php echo $restaurant['nama_resto']; ?>" required>
            </div>

            <div class="form-group">
                <label for="jenis_resto" class="form-label">Jenis Restoran</label>
                <input type="text" class="form-control" name="jenis_resto" value="<?php echo $restaurant['jenis_resto']; ?>" required>
            </div>

            <div class="form-group">
                <label for="jenis_makanan" class="form-label">Jenis Makanan</label>
                <input type="text" class="form-control" name="jenis_makanan" value="<?php echo $restaurant['jenis_makanan']; ?>" required>
            </div>

            <div class="form-group">
                <label for="jam_buka" class="form-label">Jam Buka</label>
                <input type="text" class="form-control" name="jam_buka" value="<?php echo $restaurant['jam_buka'] ?: '00:00:00'; ?>" 
                       pattern="^([01]\d|2[0-3]):([0-5]\d):([0-5]\d)$" required>
                <small class="text-muted">Format: HH:MM:SS</small>
            </div>

            <div class="form-group">
                <label for="jam_tutup" class="form-label">Jam Tutup</label>
                <input type="text" class="form-control" name="jam_tutup" value="<?php echo $restaurant['jam_tutup'] ?: '00:00:00'; ?>" 
                       pattern="^([01]\d|2[0-3]):([0-5]\d):([0-5]\d)$" required>
                <small class="text-muted">Format: HH:MM:SS</small>
            </div>

            <div class="form-group">
                <label for="lokasi" class="form-label">Lokasi</label>
                <select class="form-control" name="lokasi" required>
                    <option value="Sekupang" <?php echo ($restaurant['lokasi'] == 'Sekupang') ? 'selected' : ''; ?>>Sekupang</option>
                    <option value="Bengkong" <?php echo ($restaurant['lokasi'] == 'Bengkong') ? 'selected' : ''; ?>>Bengkong</option>
                </select>
            </div>


            <div class="form-group">
                <label for="foto" class="form-label">Foto Restoran</label>
                <input type="file" class="form-control" name="foto">
                <div class="current-photo">
                    <small>Current photo:</small>
                    <img src="./assets/img/datagambar/<?php echo $restaurant['foto']; ?>" alt="Current Photo">
                </div>
                <input type="hidden" name="existing_foto" value="<?php echo $restaurant['foto']; ?>">
            </div>

            <div class="form-group">
                <label for="latitude" class="form-label">Latitude</label>
                <input type="text" class="form-control" name="latitude" value="<?php echo $restaurant['latitude']; ?>" required>
            </div>

            <div class="form-group">
                <label for="longitude" class="form-label">Longitude</label>
                <input type="text" class="form-control" name="longitude" value="<?php echo $restaurant['longitude']; ?>" required>
            </div>

            <div class="form-group">
                <button type="submit" class="btn-primary">Update Restoran</button>
            </div>
        </form>
    </div>
</body>
</html>
