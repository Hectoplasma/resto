<?php
include('function.php');

if (isset($_GET['id'])) {
    $id_resto = $_GET['id'];
    if (deleteRestaurant($id_resto)) {
        header("Location: tables.php");
    } else {
        echo "Failed to delete restaurant";
    }
}
?>
