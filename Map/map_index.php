<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "resto";

// Buat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Ambil data wilayah
$wilayahQuery = "SELECT DISTINCT lokasi FROM tbl_resto";
$wilayahResult = $conn->query($wilayahQuery);

// Ambil data rumah makan berdasarkan wilayah yang dipilih
$restoQuery = "SELECT nama_resto, latitude, longitude FROM tbl_resto"; // Memperoleh latitude dan longitude
$restoResult = $conn->query($restoQuery);

// Convert ke format JSON untuk wilayah
$wilayahData = [];
if ($wilayahResult->num_rows > 0) {
  while ($row = $wilayahResult->fetch_assoc()) {
    $wilayahData[] = $row['lokasi'];
  }
}

// Convert ke format JSON untuk rumah makan (termasuk latitude dan longitude)
$restoData = [];
if ($restoResult->num_rows > 0) {
  while ($row = $restoResult->fetch_assoc()) {
    $restoData[] = [
      'nama_resto' => $row['nama_resto'],
      'latitude' => $row['latitude'],
      'longitude' => $row['longitude']
    ];
  }
}
$nama_resto = isset($_GET['nama_resto']) ? $conn->real_escape_string($_GET['nama_resto']) : '';

if ($nama_resto) {
  // Query to fetch restaurant details
  $query = "SELECT nama_resto, gambar, jam_buka, jenis_makanan FROM tbl_resto WHERE nama_resto = '$nama_resto'";
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

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>OSRM Route with Distance Display</title>
  <link rel="stylesheet" href="stylemap.css" />
  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
  <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="font-sans bg-gray-100">
  <!-- Controls Container -->
  <div class="absolute right-0 top-0 z-10 bg-gray-500/[.8] shadow-xl p-4 rounded-md flex flex-col max-w-xl h-screen overflow-y-auto">
    <label for="styleSelect" class="block text-white font-semibold">Map Style:</label>
    <select id="styleSelect" class="mb-4 border rounded p-2">
      <option value="default">Default</option>
      <option value="dark">Dark</option>
      <option value="light">Light</option>
      <option value="terrain">Terrain</option>
    </select>

    <label for="wilayahSelect" class="block text-white font-semibold">Wilayah:</label>
    <select id="wilayahSelect" class="mb-4 border rounded p-2">
      <option value="">Pilih Wilayah</option>
      <?php foreach ($wilayahData as $wilayah): ?>
        <option value="<?= $wilayah ?>"><?= $wilayah ?></option>
      <?php endforeach; ?>
    </select>

    <label for="restoSelect" class="block text-white font-semibold">Rumah Makan:</label>
    <select id="restoSelect" class="mb-4 border rounded p-2">
      <option value="">Pilih Rumah Makan</option>
    </select>

    <label for="profileSelect" class="block text-white font-semibold">Travel Mode:</label>
    <select id="profileSelect" class="border rounded p-2 mb-4">
      <option value="driving">Drive🚗</option>
      <option value="bicycle">Bicycle🚲</option>
      <option value="foot">Walk🚶🏽</option>
    </select>

    <button id="getDirectionsButton" class="bg-blue-700 text-white p-2 rounded">
      Get Directions
    </button>
    <div>
  <img id="restoImage" src="./assets/default-image.png" alt="Restaurant Image" class="w-32 h-32 object-cover" />
  <p><strong>Nama Rumah Makan:</strong> <span id="restoName">N/A</span></p>
  <p><strong>Jam Buka:</strong> <span id="restoHours">N/A</span></p>
  <p><strong>Jenis Makanan:</strong> <span id="restoCuisine">N/A</span></p>
</div>


  </div>

  <!-- Map Container -->
  <div id="map" class="h-screen z-0"></div>

  <script src="main.js"></script>

  <!-- AJAX untuk memuat daftar resto berdasarkan wilayah -->
  <script>
    document.getElementById("wilayahSelect").addEventListener("change", async (event) => {
      const wilayah = event.target.value;
      
      if (wilayah) {
        // Kirim request ke server untuk mendapatkan restoran berdasarkan wilayah
        const response = await fetch(`getRestos.php?wilayah=${encodeURIComponent(wilayah)}`);
        const restos = await response.json();

        // Clear existing options in the resto dropdown
        const restoSelect = document.getElementById("restoSelect");
        restoSelect.innerHTML = '<option value="">Pilih Rumah Makan</option>'; // Reset the dropdown

        // Populate the resto dropdown with options
        restos.forEach((resto) => {
          const option = document.createElement("option");
          option.value = resto.nama_resto;
          option.textContent = resto.nama_resto;
          restoSelect.appendChild(option);
        });
      } else {
        // If no wilayah is selected, reset the dropdown
        document.getElementById("restoSelect").innerHTML = '<option value="">Pilih Rumah Makan</option>';
      }
      // Function to display restaurant details
async function displayRestoDetails(namaResto) {
  try {
    // Fetch details for the selected restaurant
    const response = await fetch(`getRestoDetails.php?nama_resto=${encodeURIComponent(namaResto)}`);
    const data = await response.json();

    if (data) {
      // Display restaurant details
      const imagePath = `/assets/img/datagambar/${data.gambar}`;

      document.getElementById("restoImage").src = imagePath || "./assets/default-image.png"; // Use constructed path
      document.getElementById("restoName").textContent = data.nama_resto || "N/A";
      document.getElementById("restoHours").textContent = data.jam_buka || "N/A";
      document.getElementById("restoCuisine").textContent = data.jenis_makanan || "N/A";
    } else {
      alert("Restaurant details not found.");
    }
  } catch (error) {
    console.error("Error fetching restaurant details:", error);
    alert("An error occurred while fetching restaurant details.");
  }
}

// Add a change event listener to the restoSelect dropdown
document.getElementById("restoSelect").addEventListener("change", (event) => {
  const selectedResto = event.target.value;
  if (selectedResto) {
    displayRestoDetails(selectedResto);
  }
})

    });
  </script>
</body>
<footer>
  <a href="https://www.flaticon.com/free-icons/person" title="person icons">
    Person icons created by Freepik - Flaticon
  </a>
  <a href="https://www.flaticon.com/free-icons/marker" title="marker icons">
    Marker icons created by Freepik - Flaticon
  </a>
</footer>
</html>
