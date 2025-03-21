// Inisialisasi variabel untuk grafik Chart.js
let chartInstance = null;

document.getElementById('dateRangeForm').addEventListener('submit', function(event) {
    event.preventDefault();

    // Ambil rentang tanggal dari form
    const startDate = document.getElementById('startDate').value;
    const endDate = document.getElementById('endDate').value;

    // Fetch data dari server berdasarkan rentang tanggal
    fetch(`src/data.php?startDate=${startDate}&endDate=${endDate}`)
        .then(response => response.json())
        .then(data => {
            console.log('Data yang diterima:', data);

            // Siapkan data untuk Chart.js
            const labels = data.map(item => item.medicine);
            const frequencies = data.map(item => item.frequency);

            // Hapus grafik lama jika sudah ada
            if (chartInstance) {
                chartInstance.destroy();
            }

            // Buat atau update grafik
            const ctx = document.getElementById('medicineChart').getContext('2d');
            chartInstance = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Frekuensi Pengambilan Obat',
                        data: frequencies,
                        backgroundColor: 'rgba(54, 162, 235, 0.6)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        })
        .catch(error => console.error('Error fetching data:', error));
});
