# Medicine Reminder

Aplikasi web untuk membantu pengguna mengelola jadwal minum obat dengan sistem alarm terukur dan tracking riwayat pengambilan obat.

---

## 🎯 Fitur Utama

### 1. **Autentikasi Pengguna**

- Registrasi akun baru dengan validasi
- Login dengan password yang terenkripsi
- Logout untuk keluar dari sistem

### 2. **Manajemen Alarm Obat**

- **Create**: Buat alarm baru dengan:
  - Waktu pengambilan obat
  - Nama obat
  - Hari aktif (Senin-Minggu)
- **Daftar Alarm**: Lihat semua alarm yang aktif
- **Delete**: Hapus alarm yang tidak diperlukan

### 3. **Notifikasi Alarm**

- Halaman home menampilkan alarm terdekat dalam 30 menit ke depan
- Alarm ditampilkan otomatis berdasarkan waktu dan hari aktif

### 4. **Riwayat Pengambilan Obat**

- Catat setiap pengambilan obat
- Lihat history pengambilan dalam bentuk tabel
- Hapus riwayat jika diperlukan

### 5. **Visualisasi Data**

- Grafik frekuensi pengambilan obat menggunakan Chart.js
- Filter data berdasarkan rentang tanggal
- Monitoring compliance pengambilan obat

---

## 📋 Requirement

- PHP 7.4+
- MySQL/MariaDB
- Web Server (Apache/Nginx)
- Browser modern

---

## ⚙️ Cara Instalasi & Setup

### 1. Clone/Download Proyek

```bash
# Pindahkan folder ke htdocs (XAMPP) atau www (Laragon)
# Contoh untuk Laragon:
c:\laragon\www\Medicine-Reminder
```

### 2. Setup Database

```bash
# Buka phpMyAdmin (http://localhost/phpmyadmin)
# Buat database baru atau import file SQL
# File: database/medicine.sql
```

Atau jalankan query manual:

```sql
CREATE DATABASE medicine;
USE medicine;

CREATE TABLE users (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(70),
    username VARCHAR(50),
    email VARCHAR(50),
    password VARCHAR(255)
);

CREATE TABLE alarms (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    time TIME,
    medicine VARCHAR(50),
    days VARCHAR(100),
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE alarm_history (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    time TIME,
    medicine VARCHAR(50),
    date_taken DATETIME,
    FOREIGN KEY (user_id) REFERENCES users(id)
);
```

### 3. Konfigurasi Koneksi Database

Edit file `koneksi.php`:

```php
$con = mysqli_connect("localhost", "root", "", "medicine");
// Sesuaikan username, password, dan nama database sesuai setup Anda
```

---

## 🚀 Cara Menjalankan

### 1. Start Web Server

**Untuk Laragon:**

```bash
# Buka Laragon dan klik tombol Start
# atau jalankan dari terminal
laragon start
```

**Untuk XAMPP:**

```bash
# Buka XAMPP Control Panel dan start Apache + MySQL
```

### 2. Akses Aplikasi

```
http://localhost/Medicine-Reminder
# atau
http://localhost:8080/Medicine-Reminder (sesuai port Anda)
```

### 3. Registrasi & Login

- Halaman pertama adalah login
- Klik "Daftar di sini" untuk membuat akun baru
- Isi: Nama, Username, Email, Password
- Login dengan username dan password yang sudah dibuat

---

## 📖 Panduan Penggunaan

### 🏠 Home Page

- Menampilkan alarm terdekat yang akan berbunyi dalam 30 menit
- Menunjukkan jam terkini dan hari aktif

### ➕ Create Alarm

1. Pilih waktu pengambilan obat
2. Masukkan nama obat
3. Pilih hari aktif (bisa lebih dari 1 hari)
4. Klik "Simpan Alarm"

### 📋 Daftar Alarm

- Lihat semua alarm yang sudah dibuat
- Menampilkan waktu, nama obat, dan hari aktif
- Bisa menghapus alarm yang tidak perlu

### 📜 History

- Lihat riwayat pengambilan obat
- Tampil dalam bentuk tabel dengan waktu, obat, dan hari
- Tombol "Refresh" untuk memperbarui data
- Tombol "Hapus Semua" untuk menghapus seluruh history

### 📊 Data

- Visualisasi grafik pengambilan obat
- Pilih rentang tanggal untuk filter data
- Menampilkan frekuensi pengambilan dalam bentuk chart
- Membantu monitoring compliance

---

## 📁 Struktur Folder

```
Medicine-Reminder/
├── index.php              # Home page (utama)
├── login.php              # Halaman login
├── register.php           # Halaman registrasi
├── logout.php             # Proses logout
├── koneksi.php            # Konfigurasi database
├── style.css              # CSS untuk login/register
├── script.js              # JavaScript umum
├── dashboard/
│   ├── create.html        # Buat alarm
│   ├── alarm_list.html    # Daftar alarm
│   ├── history.html       # Riwayat alarm
│   ├── data.html          # Visualisasi data
│   ├── create-style.css   # CSS create alarm
│   ├── script.js          # JS dashboard
│   ├── data.js            # JS untuk grafik
│   ├── css/styles.css     # CSS dashboard
│   ├── js/script.js       # JS tambahan
│   └── src/               # Backend API
│       ├── database.php   # Database config
│       ├── create_simpan_alarm.php    # Simpan alarm
│       ├── get_list_alarm.php         # Ambil daftar alarm
│       ├── delete_alarm.php           # Hapus alarm
│       ├── fetch_history.php          # Ambil riwayat
│       └── ...
└── database/
    ├── medicine.sql       # Database backup
    └── medicine.txt       # Dokumentasi database
```

---

## 🔒 Keamanan

- Password dienkripsi dengan `password_hash()`
- Validasi input dengan `mysqli_real_escape_string()` dan `stripslashes()`
- Session-based authentication
- SQL Injection prevention

---

## 📝 Catatan

- Timezone sudah diatur ke Asia/Jakarta
- Format waktu: 24 jam (HH:MM)
- Hari dalam bahasa Indonesia
- Data alarm bersifat per user (login diperlukan)

---

## 🤝 Support

Untuk pertanyaan atau issue, silahkan hubungi developer atau buka issue baru.
