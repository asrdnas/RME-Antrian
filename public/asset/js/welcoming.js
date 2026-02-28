window.addEventListener("load", () => {
  // Memberi jeda 2 detik agar user bisa melihat animasi brand
  setTimeout(() => {
    document.body.classList.add("loaded");

    // Menghapus elemen dari DOM setelah animasi fade-out selesai
    const welcomeScreen = document.getElementById("welcome-screen");
    if (welcomeScreen) {
      setTimeout(() => {
        welcomeScreen.style.display = "none";
      }, 800);
    }
  }, 2000);
});
