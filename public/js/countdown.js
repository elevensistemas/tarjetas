document.addEventListener('DOMContentLoaded', function() {
    const countdownElement = document.getElementById('countdown-container');
    if (!countdownElement) return;

    const targetDateStr = countdownElement.getAttribute('data-date');
    if (!targetDateStr) return;

    // Convertir string de fecha ('YYYY-MM-DD HH:MM:SS') a objeto Date
    const targetDate = new Date(targetDateStr.replace(/-/g, '/')).getTime();

    const dElement = document.getElementById('days');
    const hElement = document.getElementById('hours');
    const mElement = document.getElementById('minutes');
    const sElement = document.getElementById('seconds');

    function updateCountdown() {
        const now = new Date().getTime();
        const difference = targetDate - now;

        if (difference < 0) {
            clearInterval(timerInterval);
            if (countdownElement) {
                countdownElement.innerHTML = `<div class="w-100 text-center py-3"><span class="title-font fs-3 text-uppercase text-secondary">¡Llegó el gran día!</span></div>`;
            }
            return;
        }

        // Cálculos de tiempo
        const days = Math.floor(difference / (1000 * 60 * 60 * 24));
        const hours = Math.floor((difference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((difference % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((difference % (1000 * 60)) / 1000);

        // Actualizar el DOM agregando un cero a la izquierda si el valor es menor a 10
        if (dElement) dElement.innerText = days < 10 ? '0' + days : days;
        if (hElement) hElement.innerText = hours < 10 ? '0' + hours : hours;
        if (mElement) mElement.innerText = minutes < 10 ? '0' + minutes : minutes;
        if (sElement) sElement.innerText = seconds < 10 ? '0' + seconds : seconds;
    }

    // Ejecutar inmediatamente
    updateCountdown();

    // Actualizar cada 1 segundo
    const timerInterval = setInterval(updateCountdown, 1000);
});
