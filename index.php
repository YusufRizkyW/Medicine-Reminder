<?php
// Inisialisasi session
session_start();

// Mengecek username pada session
if (!isset($_SESSION['username'])) {
  $_SESSION['msg'] = 'Anda harus login untuk mengakses halaman ini';
  header('Location: login.php');
  exit();
}

// Set timezone ke Jakarta
date_default_timezone_set('Asia/Jakarta');

include 'dashboard/src/database.php'; // Pastikan file ini sesuai dengan struktur folder Anda

// Ambil waktu saat ini
$current_time = date('H:i:s');

// Ambil waktu 30 menit ke depan
$thirty_minutes_later = date('H:i:s', strtotime('+30 minutes'));

// Ambil hari saat ini dalam bahasa Indonesia
$days_in_indonesian = [
    'Sunday' => 'Minggu',
    'Monday' => 'Senin',
    'Tuesday' => 'Selasa',
    'Wednesday' => 'Rabu',
    'Thursday' => 'Kamis',
    'Friday' => 'Jumat',
    'Saturday' => 'Sabtu'
];
$current_day = $days_in_indonesian[date('l')];

try {
    // Query untuk mengambil alarm yang akan berbunyi dalam 30 menit ke depan
    $sql = "SELECT * FROM alarms 
            WHERE time BETWEEN :current_time AND :thirty_minutes_later
            AND FIND_IN_SET(:current_day, days)
            ORDER BY time ASC
            LIMIT 1"; // Mengambil alarm terdekat

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'current_time' => $current_time,
        'thirty_minutes_later' => $thirty_minutes_later,
        'current_day' => $current_day
    ]);

    // Ambil alarm yang ditemukan
    $next_alarm = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($next_alarm) {
        // Jika ada alarm yang ditemukan, simpan informasinya
        $next_alarm_time = $next_alarm['time'];
        $next_alarm_medicine = $next_alarm['medicine'];
        $next_alarm_days = $next_alarm['days'];
    } else {
        // Jika tidak ada alarm dalam 30 menit ke depan
        $next_alarm_time = null;
    }
} catch (Exception $e) {
    echo 'Terjadi kesalahan saat mengambil data alarm: ' . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>IoT Medicine Reminder Dashboard - Home</title>
  <link rel="stylesheet" href="./dashboard/css/styles.css">
  <script src="script.js" defer></script>
</head>
<body>
  <div class="container">
    <!-- Navigasi Bar -->
    <nav class="sidebar">
      <div class="logo">
        <p>Medicine Reminder</p>
      </div>
      <ul>
        <li><a href="index.php"><i class="icon-home"></i>Home</a></li>
        <li><a href="./dashboard/create.html"><i class="icon-alarm"></i>Create</a></li>
        <li><a href="./dashboard/alarm_list.html"><i class="icon-alarm"></i> Daftar Alarm</a></li>
        <li><a href="./dashboard/history.html"><i class="icon-history"></i>History</a></li>
        <li><a href="./dashboard/data.html"><i class="icon-data"></i>Data</a></li>
        <li><a href="logout.php"><i class="icon-logout"></i>Log Out</a></li>
      </ul>
    </nav>
  </div>

      <!-- Konten Utama -->
    <div class="main-content">
      <h1>Selamat Datang di Dashboard Medicine Reminder</h1>
        <div class="time">
          <h2>Waktu Sekarang : <span id="current-time"></span></h2>
        </div>
        <div class="next-alarm-container">
          <div class="upcoming-alarm">
            <h2>Alarm yang akan datang :</h2>
              <?php if ($next_alarm_time): ?>
                <p>Waktu Alarm : <?php echo $next_alarm_time; ?></p>
                <p>Obat : <?php echo $next_alarm_medicine; ?></p>
                <p>Hari : <?php echo $next_alarm_days; ?></p>
              <?php else: ?>
                <p>Tidak ada alarm dalam 30 menit ke depan</p>
              <?php endif; ?>
          </div>
        </div>
    </div>
</body>
</html>
