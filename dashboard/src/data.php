<?php
header('Content-Type: application/json');

// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "medicine";

$pdo = new mysqli($servername, $username, $password, $dbname);

if ($pdo->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ambil rentang tanggal dari request
$startDate = $_GET['startDate'];
$endDate = $_GET['endDate'];

// Query untuk mengambil frekuensi pengambilan obat berdasarkan rentang tanggal
$sql = "SELECT medicine, COUNT(*) as frequency
        FROM alarms
        WHERE DATE(CONCAT(CURDATE(), ' ', time)) BETWEEN ? AND ?
        GROUP BY medicine";

$stmt = $pdo->prepare($sql);
$stmt->bind_param("ss", $startDate, $endDate);
$stmt->execute();
$result = $stmt->get_result();

// Format data ke dalam JSON
$data = array();
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);

$stmt->close();
$pdo->close();
?>
