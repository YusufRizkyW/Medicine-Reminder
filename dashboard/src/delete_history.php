<?php
include 'database.php'; // Pastikan file ini sesuai dengan struktur folder Anda

try {
    // Query untuk menghapus semua data di tabel alarm_history
    $sql = "DELETE FROM alarm_history";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    // Cek jika berhasil menghapus
    if ($stmt->rowCount() > 0) {
        echo json_encode(['message' => 'Semua data riwayat alarm telah dihapus.']);
    } else {
        echo json_encode(['message' => 'Tidak ada data yang dihapus.']);
    }
} catch (Exception $e) {
    echo json_encode(['error' => 'Terjadi kesalahan saat menghapus data alarm: ' . $e->getMessage()]);
}
?>
