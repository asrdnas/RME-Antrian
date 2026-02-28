const menuToggle = document.querySelector('.menu-toggle');
const navLinks = document.querySelector('.nav-links');
const navCta = document.querySelector('.nav-cta');

menuToggle.addEventListener('click', () => {
    // Toggle class 'active' untuk memunculkan/menyembunyikan menu
    navLinks.classList.toggle('active');
    navCta.classList.toggle('active');
    
    // Opsional: ganti icon burger jadi 'X' (jika pakai FontAwesome)
    const icon = menuToggle.querySelector('i');
    icon.classList.toggle('fa-bars');
    icon.classList.toggle('fa-times');
});