<?php
function getJenisMakananCounts() {
    $conn = mysqli_connect("localhost", "root", "", "resto");
    if (!$conn) {
        die("Database connection failed: " . mysqli_connect_error());
    }

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
                $type = trim($type);
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

    mysqli_close($conn);

    // Return counts as JSON
    return json_encode($categoryCounts);
}
?>
