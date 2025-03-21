<?php
include 'database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $time = $_POST['time'];
    $medicine = $_POST['medicine'];
    $days = implode(',', $_POST['days']);

    $sql = "INSERT INTO alarms (time, medicine, days) VALUES (:time, :medicine, :days)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['time' => $time, 'medicine' => $medicine, 'days' => $days]);

    echo "Alarm berhasil dibuat";
} else {
    echo "Alarm gagal dibuat";
}
?>
