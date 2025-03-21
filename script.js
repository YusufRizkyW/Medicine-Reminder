document.addEventListener("DOMContentLoaded", function () {
 // Menampilkan waktu saat ini
    function updateTime() {
        const now = new Date();
        const timeString = now.toLocaleTimeString();
        const currentTimeElement = document.getElementById('current-time');
        if (currentTimeElement) {
            currentTimeElement.textContent = timeString;
        } else {
            console.error('Element with ID "current-time" not found.');
        }
    }

    setInterval(updateTime, 1000);
    updateTime();
});