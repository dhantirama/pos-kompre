<?php
$hostname   = "localhost";
$username   = "root";
$password   = "";
$database   = "londri_ujikom";

$koneksi    = mysqli_connect($hostname, $username, $password, $database);

if (!$koneksi) {
    echo "Koneksi Gagal";
}
