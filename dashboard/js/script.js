// Fungsi untuk Memuat Riwayat Alarm
function loadHistory() {
    fetch('src/get_history_alarm.php')
        .then(response => response.json())
        .then(data => {
            const tableBody = document.querySelector('#history-table tbody');
            tableBody.innerHTML = ''; // Kosongkan tabel sebelum memuat data baru

            if (data.message) {
                const row = document.createElement('tr');
                const cell = document.createElement('td');
                cell.colSpan = 3;
                cell.textContent = data.message;
                row.appendChild(cell);
                tableBody.appendChild(row);
            } else {
                data.forEach(alarm => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${alarm.time}</td>
                        <td>${alarm.medicine}</td>
                        <td>${alarm.days}</td>
                    `;
                    tableBody.appendChild(row);
                });
            }
        })
        .catch(error => console.error('Terjadi kesalahan:', error));
}

// Fungsi untuk menghapus semua riwayat alarm
function deleteAllHistory() {
    if (confirm("Anda yakin ingin menghapus semua riwayat alarm?")) {
        fetch('src/delete_history.php', {
            method: 'GET'
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            // Reload halaman setelah data dihapus
            loadHistory();
        })
        .catch(error => console.error('Terjadi kesalahan:', error));
}
}
// Panggil fungsi saat halaman dimuat
document.addEventListener('DOMContentLoaded', loadHistory);

// Event listener untuk tombol hapus semua riwayat alarm
document.getElementById('delete-all-history').addEventListener('click', deleteAllHistory);


document.addEventListener('DOMContentLoaded', function () {
    // Event listener untuk tombol refresh
    document.getElementById('refresh-history').addEventListener('click', function () {
        // Panggil ulang `fetch_history.php`
        refreshHistoryData();
    });

    // Fungsi untuk memanggil ulang `fetch_history.php`
    function refreshHistoryData() {
        fetch('src/fetch_history.php')
            .then(response => response.json())
            .then(data => {
                // Tampilkan pesan di konsol untuk memastikan panggilan berhasil
                console.log('Data dari fetch_history.php:', data);
                 // Jika pemanggilan berhasil, reload halaman `history.html`
                 window.location.reload();
            })
            .catch(error => {
                console.error('Error fetching history data:', error);
            });
    }
});

