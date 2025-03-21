<?php
date_default_timezone_set('Asia/Jakarta'); // Pastikan zona waktu disetel

include 'database.php'; // Pastikan file ini sesuai dengan struktur folder Anda

// Ambil waktu dan hari saat ini
$current_time = date('H:i:s');

// Konversi hari ke bahasa Indonesia
$days_in_indonesian = [
    'Sunday' => 'Minggu',
    'Monday' => 'Senin',
    'Tuesday' => 'Selasa',
    'Wednesday' => 'Rabu',
    'Thursday' => 'Kamis',
    'Friday' => 'Jumat',
    'Saturday' => 'Sabtu'
];
$current_day = $days_in_indonesian[date('l')]; // Konversi ke bahasa Indonesia

try {
    // Query untuk mengambil alarm yang sudah berbunyi
    $sql = "SELECT * FROM alarms 
            WHERE time <= :current_time AND FIND_IN_SET(:current_day, days)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'current_time' => $current_time,
        'current_day' => $current_day
    ]);

    // Ambil data
    $alarms = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Jika ada alarm yang sudah berbunyi
    if (!empty($alarms)) {
        // Loop melalui setiap alarm yang sudah berbunyi
        foreach ($alarms as $alarm) {
            // Cek apakah alarm sudah ada di tabel alarm_history
            $check_sql = "SELECT COUNT(*) FROM alarm_history WHERE time = :time AND medicine = :medicine AND days = :days";
            $check_stmt = $pdo->prepare($check_sql);
            $check_stmt->execute([
                'time' => $alarm['time'],
                'medicine' => $alarm['medicine'],
                'days' => $alarm['days']
            ]);
            $exists = $check_stmt->fetchColumn();

            // Jika alarm belum ada di tabel alarm_history, insert data
            if ($exists == 0) {
                $insert_sql = "INSERT INTO alarm_history (time, medicine, days) VALUES (:time, :medicine, :days)";
                $insert_stmt = $pdo->prepare($insert_sql);
                $insert_stmt->execute([
                    'time' => $alarm['time'],
                    'medicine' => $alarm['medicine'],
                    'days' => $alarm['days']
                ]);
            }
        }
        
        // Kembalikan data alarm yang sudah dipindahkan ke history
        header('Content-Type: application/json');
        echo json_encode($alarms);
    } else {
        // Jika tidak ada data, kirim pesan
        echo json_encode(['message' => 'Tidak ada alarm yang sudah berbunyi.']);
    }
} catch (Exception $e) {
    echo json_encode(['error' => 'Terjadi kesalahan saat mengambil data alarm: ' . $e->getMessage()]);
}
?>
