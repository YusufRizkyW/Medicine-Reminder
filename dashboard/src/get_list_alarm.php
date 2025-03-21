<?php
include 'database.php';

$sql = "SELECT * FROM alarms ORDER BY id DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$alarms = $stmt->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($alarms);
?>
