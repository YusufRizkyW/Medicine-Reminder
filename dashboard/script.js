document.addEventListener("DOMContentLoaded", function () {
    // Fungsi untuk Menambahkan Elemen Baru
    function addElement(tag, content, containerId) {
        const container = document.getElementById(containerId);
        if (container) {
            const newElement = document.createElement(tag);
            newElement.textContent = content;
            container.appendChild(newElement);
        } else {
            console.error(`Container with ID "${containerId}" not found.`);
        }
    }


    // Fungsi untuk Mengubah Gaya Elemen
    function changeElementStyle(elementId, styleProperty, value) {
        const element = document.getElementById(elementId);
        if (element) {
            element.style[styleProperty] = value;
        } else {
            console.error(`Element with ID "${elementId}" not found.`);
        }
    }

    // Fungsi untuk Menambahkan Event Listener
    function addClickListener(elementId, callback) {
        const element = document.getElementById(elementId);
        if (element) {
            element.addEventListener('click', callback);
        } else {
            console.error(`Element with ID "${elementId}" not found.`);
        }
    }

    // Fungsi untuk Menampilkan atau Menyembunyikan Elemen
    function toggleVisibility(elementId) {
        const element = document.getElementById(elementId);
        if (element) {
            if (element.style.display === 'none') {
                element.style.display = 'block';
            } else {
                element.style.display = 'none';
            }
        } else {
            console.error(`Element with ID "${elementId}" not found.`);
        }
    }

    // Fungsi untuk Mengubah Konten HTML Elemen
    function setElementHTML(elementId, htmlContent) {
        const element = document.getElementById(elementId);
        if (element) {
            element.innerHTML = htmlContent;
        } else {
            console.error(`Element with ID "${elementId}" not found.`);
        }
    }

    // Memuat daftar alarm di halaman Daftar Alarm
    if (window.location.pathname.endsWith('alarm_list.html')) {
        fetch('src/get_list_alarm.php')
            .then(response => response.json())
            .then(data => {
                const alarmList = document.getElementById('alarm-list');
                if (alarmList) {
                    alarmList.innerHTML = '';

                    if (data.length > 0) {
                        data.forEach(alarm => {
                            const alarmItem = document.createElement('div');
                            alarmItem.classList.add('alarm-list');
                            alarmItem.innerHTML = `
                                <p>Waktu : ${alarm.time}</p>
                                <p>Nama Obat : ${alarm.medicine}</p>
                                <p>Hari :  ${alarm.days}</p>
                                <button class="delete-btn" data-id="${alarm.id}">Hapus</button>
                            `;
                            alarmList.appendChild(alarmItem);
                        });

                        // Tambahkan Event Listener untuk Tombol Delete
                        document.querySelectorAll('.delete-btn').forEach(button => {
                            button.addEventListener('click', function () {
                                const alarmId = this.getAttribute('data-id');
                                deleteAlarm(alarmId);
                            });
                        });
                    } else {
                        alarmList.innerHTML = '<p>No alarms found.</p>';
                    }
                } else {
                    console.error('Element with ID "alarm-list" not found.');
                }
            })
            .catch(error => console.error('Error fetching alarms:', error));
    }

    // Fungsi untuk Menghapus Alarm
    function deleteAlarm(id) {
        fetch(`src/delete_alarm.php?id=${id}`, {
            method: 'GET'
        })
        .then(response => response.text())
        .then(message => {
            alert(message);
            // Refresh halaman setelah alarm dihapus
            window.location.reload();
        })
        .catch(error => console.error('Error deleting alarm:', error));
    }
});
