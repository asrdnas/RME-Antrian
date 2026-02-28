let currentIndex = 0;
const autoPlaySpeed = 6000;
let slideInterval;

// Konfigurasi slider
const visibleCards = 5;
const gap = 20;

// --- 1. Fungsi Cerdas Deteksi Layar ---
const isMobile = () => window.innerWidth <= 768;

function setupInfiniteSlider() {
    const track = document.getElementById('sliderTrack');
    const cards = document.querySelectorAll('.slide-card');
    
    if (cards.length === 0) return;

    // Hanya cloning jika di desktop. 
    // Di mobile, cloning justru merusak urutan swipe natural.
    if (!isMobile()) {
        for (let i = 0; i < visibleCards; i++) {
            const clone = cards[i].cloneNode(true);
            track.appendChild(clone);
        }
        startAutoPlay();
    }
}

function moveSlide(direction) {
    // --- 2. Proteksi Mobile ---
    // Jika di mobile, hentikan fungsi ini agar tidak bertabrakan dengan CSS Scroll
    if (isMobile()) return;

    const track = document.getElementById('sliderTrack');
    const cards = document.querySelectorAll('.slide-card');
    const totalOriginalCards = cards.length - visibleCards;
    
    const cardWidth = cards[0].offsetWidth;
    const moveAmount = cardWidth + gap;

    currentIndex += direction;

    track.style.transition = "transform 0.5s ease-in-out";
    track.style.transform = `translateX(-${currentIndex * moveAmount}px)`;

    if (currentIndex >= totalOriginalCards && direction > 0) {
        setTimeout(() => {
            track.style.transition = "none";
            currentIndex = 0;
            track.style.transform = `translateX(0)`;
        }, 500);
    } 
    else if (currentIndex < 0) {
        setTimeout(() => {
            track.style.transition = "none";
            currentIndex = totalOriginalCards - 1;
            track.style.transform = `translateX(-${currentIndex * moveAmount}px)`;
        }, 500);
    }

    resetAutoPlay();
}

function startAutoPlay() {
    // Jangan jalankan interval di mobile agar hemat baterai dan tidak mengganggu user
    if (isMobile()) return;
    
    slideInterval = setInterval(() => {
        moveSlide(1);
    }, autoPlaySpeed);
}

function resetAutoPlay() {
    if (isMobile()) return;
    clearInterval(slideInterval);
    startAutoPlay();
}

// Inisialisasi
setupInfiniteSlider();

// Event listener mouse
const sliderContainer = document.getElementById('sliderContainer');
if (sliderContainer) {
    sliderContainer.addEventListener('mouseenter', () => {
        if (!isMobile()) clearInterval(slideInterval);
    });
    sliderContainer.addEventListener('mouseleave', () => {
        if (!isMobile()) startAutoPlay();
    });
}

// --- 3. Listener Penyelamat Saat Resize ---
window.addEventListener('resize', () => {
    const track = document.getElementById('sliderTrack');
    if (isMobile()) {
        // Jika layar mengecil ke HP, bersihkan sisa-sisa style JS
        clearInterval(slideInterval);
        track.style.transform = "none";
        track.style.transition = "none";
    } else {
        // Jika balik ke desktop dan belum ada interval, nyalakan lagi
        if (!slideInterval) startAutoPlay();
    }
});