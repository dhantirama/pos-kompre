<?php
// get-harga-paket.php
include '../../koneksi.php';

$id = $_GET['id_service'];
$query = mysqli_query($koneksi, "SELECT price FROM type_of_service WHERE id = '$id'");
$row = mysqli_fetch_assoc($query);

echo json_encode(['price' => $row['price']]);
