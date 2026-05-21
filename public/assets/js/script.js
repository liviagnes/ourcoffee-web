/* ================= CART ================= */
function updateCart(id, action) {
    fetch('cart.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `id=${id}&action=${action}`
    })
        .then(res => res.text())
        .then(qty => {
            const el = document.getElementById('qty-' + id);
            if (el) el.innerText = qty;
        });
}

/* ================= NAV MOBILE ================= */
function toggleMenu() {
    document.getElementById("navMenu").classList.toggle("active");
}

/* TOGGLE DROPDOWN PROFILE */
function toggleProfile() {
    const dropdown = document.getElementById("profileDropdown");
    dropdown.classList.toggle("show-dropdown");
}

/* TUTUP DROPDOWN KALAU KLIK DI LUAR */
window.onclick = function (event) {
    // Jika yang diklik BUKAN tombol profile atau elemen di dalamnya
    if (!event.target.matches('.profile-btn') && !event.target.closest('.profile-btn')) {
        const dropdown = document.getElementById("profileDropdown");
        if (dropdown && dropdown.classList.contains('show-dropdown')) {
            dropdown.classList.remove('show-dropdown');
        }
    }
}

/* ================= ABOUT TOGGLE ================= */
function toggleAbout() {
    const more = document.getElementById("aboutMore");
    const btn = document.querySelector(".about-toggle");

    if (!more || !btn) return;

    if (more.style.display === "block") {
        more.style.display = "none";
        btn.innerText = "Read More";
    } else {
        more.style.display = "block";
        btn.innerText = "Show Less";
    }
}

/* ================= DOM READY ================= */
document.addEventListener("DOMContentLoaded", () => {

    /* ===== MENU FILTER ===== */
    const buttons = document.querySelectorAll(".menu-filter button");
    const cards = document.querySelectorAll(".menu-card");

    buttons.forEach(btn => {
        btn.addEventListener("click", () => {
            buttons.forEach(b => b.classList.remove("active"));
            btn.classList.add("active");

            const type = btn.dataset.type;

            cards.forEach(card => {
                card.style.display =
                    type === "all" || card.dataset.type === type
                        ? "block"
                        : "none";
            });
        });
    });

    /* ===== ABOUT US FADE RIGHT ON SCROLL ===== */
    const aboutText = document.querySelector(".about-text");

    if (aboutText) {
        const observer = new IntersectionObserver(entries => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    aboutText.classList.add("show");
                    observer.unobserve(aboutText); // animasi sekali aja
                }
            });
        }, {
            threshold: 0.3
        });

        observer.observe(aboutText);
    }

});

console.log("SCRIPT FIXED & AKTIF");
