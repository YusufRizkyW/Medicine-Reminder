<?php
date_default_timezone_set('Asia/Jakarta'); // Pastikan zona waktu disetel

include 'database.php'; // Pastikan file ini sesuai dengan struktur folder Anda

// Ambil waktu saat ini
$current_time = date('H:i:s');
$current_day = date('l'); // Mendapatkan hari saat ini (contoh: 'Monday')

// Hitung waktu 5 menit sebelumnya dan 5 menit ke depan
$five_minutes_earlier = date('H:i:s', strtotime('-5 minutes', strtotime($current_time)));
$five_minutes_later = date('H:i:s', strtotime('+5 minutes', strtotime($current_time)));

// Debugging untuk memeriksa nilai waktu dan hari
error_log('Current Time: ' . $current_time);  // Periksa waktu saat ini
error_log('Current Day: ' . $current_day);    // Periksa hari saat ini

// Mengubah nama hari menjadi bahasa yang sesuai jika perlu
// Misalnya, mengonversi nama hari dalam bahasa Indonesia jika diperlukan
$days_mapping = [
    'Monday' => 'Senin',
    'Tuesday' => 'Selasa',
    'Wednesday' => 'Rabu',
    'Thursday' => 'Kamis',
    'Friday' => 'Jumat',
    'Saturday' => 'Sabtu',
    'Sunday' => 'Minggu'
];
$current_day = isset($days_mapping[$current_day]) ? $days_mapping[$current_day] : $current_day;

try {
    // Query untuk mengambil alarm yang waktunya antara 5 menit yang lalu hingga 5 menit ke depan
    // dan yang harinya mengandung hari saat ini
    $sql = "SELECT * FROM alarms 
            WHERE time BETWEEN :five_minutes_earlier AND :five_minutes_later 
            AND days LIKE :current_day";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'five_minutes_earlier' => $five_minutes_earlier,
        'five_minutes_later' => $five_minutes_later,
        'current_day' => '%' . $current_day . '%' // Mencari hari dalam kolom `days`
    ]);

    // Ambil data sebagai array
    $alarms = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Debugging untuk memeriksa hasil query
    error_log('Alarms Data: ' . json_encode($alarms));  // Periksa data yang diambil dari query

    // Mengubah data menjadi format JSON
    header('Content-Type: application/json');

    // Jika tidak ada alarm ditemukan, kirimkan pesan error dalam format JSON
    if (empty($alarms)) {
        echo json_encode(['error' => 'Tidak ada alarm ditemukan.']);
    } else {
        echo json_encode($alarms);
    }

} catch (Exception $e) {
    // Jika terjadi kesalahan, kirim pesan error dalam format JSON
    echo json_encode(['error' => 'Terjadi kesalahan saat mengambil data alarm: ' . $e->getMessage()]);
}
?>
