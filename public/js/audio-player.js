document.addEventListener('DOMContentLoaded', function() {
    const audio = document.getElementById('background-audio');
    const musicBtn = document.getElementById('music-btn');
    const spotifyPlayBtn = document.getElementById('btn-spotify-play');
    
    if (!audio) return;

    const musicIcon = musicBtn ? musicBtn.querySelector('i') : null;
    const waves = musicBtn ? musicBtn.querySelectorAll('.wave') : [];
    const spotifyPlayIcon = spotifyPlayBtn ? spotifyPlayBtn.querySelector('i') : null;
    const isAutoplayEnabled = audio.getAttribute('data-autoplay') === '1';

    let isPlaying = false;

    function startMusic() {
        audio.play().then(() => {
            isPlaying = true;
            if (musicIcon) musicIcon.className = 'bi bi-volume-up-fill';
            if (musicBtn) musicBtn.classList.add('vinyl-rotate');
            waves.forEach(w => w.style.display = 'block');
            
            if (spotifyPlayIcon) {
                spotifyPlayIcon.className = 'bi bi-pause-circle-fill fs-1';
                spotifyPlayBtn.classList.add('animate-pulse');
            }
        }).catch(error => {
            console.log('Autoplay bloqueado por el navegador. Esperando interacción del usuario...');
            window.addEventListener('click', firstInteractionPlay, { once: true });
        });
    }

    function stopMusic() {
        audio.pause();
        isPlaying = false;
        if (musicIcon) musicIcon.className = 'bi bi-volume-mute-fill';
        if (musicBtn) musicBtn.classList.remove('vinyl-rotate');
        waves.forEach(w => w.style.display = 'none');
        
        if (spotifyPlayIcon) {
            spotifyPlayIcon.className = 'bi bi-play-circle-fill fs-1';
            spotifyPlayBtn.classList.remove('animate-pulse');
        }
    }

    function toggleMusic() {
        if (isPlaying) {
            stopMusic();
        } else {
            window.removeEventListener('click', firstInteractionPlay);
            startMusic();
        }
    }

    function firstInteractionPlay() {
        if (!isPlaying) {
            startMusic();
        }
    }

    waves.forEach(w => w.style.display = 'none');

    if (isAutoplayEnabled) {
        startMusic();
    }

    if (musicBtn) {
        musicBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            toggleMusic();
        });
    }

    if (spotifyPlayBtn) {
        spotifyPlayBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            toggleMusic();
        });
    }
});
