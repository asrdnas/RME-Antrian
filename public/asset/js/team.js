function filterSelection(category) {
    // 1. Ambil semua elemen yang diperlukan
    const buttons = document.querySelectorAll('.btn-filter');
    const cards = document.querySelectorAll('.team-item');
    const rows = document.querySelectorAll('.schedule-table tbody tr');

    // 2. Atur tombol aktif (Warna berubah saat diklik)
    buttons.forEach(btn => {
        btn.classList.remove('active');
        // Jika teks tombol mengandung kategori (misal 'gigi'), beri class active
        if (btn.innerText.toLowerCase().includes(category)) {
            btn.classList.add('active');
        }
    });

    // 3. Filter Kartu Dokter
    cards.forEach(card => {
        if (card.classList.contains(category)) {
            card.style.display = "block"; // Munculkan
            // Jika kamu pakai CSS .hide, ganti jadi: card.classList.remove('hide');
        } else {
            card.style.display = "none"; // Sembunyikan
            // Jika kamu pakai CSS .hide, ganti jadi: card.classList.add('hide');
        }
    });

    // 4. Filter Baris Tabel Jadwal
    rows.forEach(row => {
        if (row.classList.contains(category)) {
            row.style.display = ""; // Munculkan (default table row)
        } else {
            row.style.display = "none"; // Sembunyikan
        }
    });
}

// Tambahkan ini agar saat halaman pertama kali dibuka, otomatis menampilkan Dokter Umum
document.addEventListener('DOMContentLoaded', () => {
    filterSelection('umum');
});