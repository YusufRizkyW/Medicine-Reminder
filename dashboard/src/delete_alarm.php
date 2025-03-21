<?php
include 'database.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM alarms WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);

    echo "Alarm berhasil dihapus!";
} else {
    echo "ID alarm tidak ditemukan.";
}
?>


