<?php
// Konfigurasi Database
$host     = "localhost";
$username = "root";
$password = ""; // Default Laragon biasanya kosong
$database = "sipacab_db";

// Membuat koneksi ke MySQL menggunakan mysqli
$koneksi = mysqli_connect($host, $username, $password, $database);

// Cek apakah koneksi berhasil
if (!$koneksi) {
    die("Koneksi Database Gagal: " . mysqli_connect_error());
}

// Set charset ke UTF-8 agar karakter spesial aman
mysqli_set_charset($koneksi, "utf8");

// Jika berhasil, variabel $koneksi siap digunakan di file lain
?>