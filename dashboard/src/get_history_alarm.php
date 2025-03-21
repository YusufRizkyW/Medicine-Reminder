<?php

// Koneksi ke database
$servername = "localhost";
$username = "root"; // Ganti dengan username database Anda
$password = ""; // Ganti dengan password database Anda
$dbname = "medicine"; // Nama database

// Membuat koneksi
$pdo = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($pdo->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Query untuk mengambil data dari tabel alarm_history
$sql = "SELECT * FROM alarm_history ORDER BY id DESC";
$result = $pdo->query($sql);

// Memeriksa apakah ada data
if ($result->num_rows > 0) {
    $alarms = [];
    while($row = $result->fetch_assoc()) {
        $alarms[] = $row;
    }
    // Mengirim data sebagai JSON
    header('Content-Type: application/json');
    echo json_encode($alarms);
} else {
    echo json_encode(["message" => "Tidak ada riwayat alarm"]);
}

// Menutup koneksi
$pdo->close();
?>
