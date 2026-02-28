document.addEventListener('DOMContentLoaded', () => {
    const grid = document.getElementById('facilityGrid');
    const cards = document.querySelectorAll('.facility-card');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    
    let currentIndex = 0;
    const gap = 25; 
    const autoPlayInterval = 6000;
    let timer;

    // --- DETEKSI DEVICE ---
    const isMobile = () => window.innerWidth <= 768;

    // --- LOGIKA INFINITE CLONING (Hanya Desktop) ---
    if (!isMobile()) {
        const cardsInView = 3;
        for (let i = 0; i < cardsInView; i++) {
            const clone = cards[i].cloneNode(true);
            grid.appendChild(clone);
        }
    }

    const moveSlider = () => {
        if (isMobile()) return; // Matikan auto-move di mobile

        currentIndex++;
        grid.style.transition = "transform 0.5s cubic-bezier(0.4, 0, 0.2, 1)";
        
        const cardWidth = cards[0].offsetWidth + gap;
        grid.style.transform = `translateX(-${currentIndex * cardWidth}px)`;

        if (currentIndex >= cards.length) {
            setTimeout(() => {
                grid.style.transition = "none";
                currentIndex = 0;
                grid.style.transform = `translateX(0)`;
            }, 500);
        }
    };

    const movePrev = () => {
        if (isMobile()) return; 

        if (currentIndex <= 0) {
            currentIndex = cards.length;
            grid.style.transition = "none";
            const cardWidth = cards[0].offsetWidth + gap;
            grid.style.transform = `translateX(-${currentIndex * cardWidth}px)`;
            grid.offsetHeight; 
        }
        
        currentIndex--;
        grid.style.transition = "transform 0.5s cubic-bezier(0.4, 0, 0.2, 1)";
        const cardWidth = cards[0].offsetWidth + gap;
        grid.style.transform = `translateX(-${currentIndex * cardWidth}px)`;
    };

    // --- CONTROLS ---
    const startAutoPlay = () => {
        if (!isMobile()) timer = setInterval(moveSlider, autoPlayInterval);
    };
    const stopAutoPlay = () => clearInterval(timer);

    // Tombol Navigasi hanya aktif di desktop
    nextBtn.addEventListener('click', () => { 
        if (!isMobile()) { stopAutoPlay(); moveSlider(); startAutoPlay(); }
    });
    prevBtn.addEventListener('click', () => { 
        if (!isMobile()) { stopAutoPlay(); movePrev(); startAutoPlay(); }
    });

    // Reset posisi jika user resize browser dari desktop ke mobile
    window.addEventListener('resize', () => {
        if (isMobile()) {
            stopAutoPlay();
            grid.style.transform = "none";
            grid.style.transition = "none";
        } else {
            if (!timer) startAutoPlay();
        }
    });

    startAutoPlay();
});