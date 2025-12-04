import confetti from 'canvas-confetti';

var poinBenar = 0;
var pasanganDitemukan = 0;
var totalPasangan = 6; 

// var gameStaticId = typeof GAME_STATIC_ID !== 'undefined' ? GAME_STATIC_ID : null;
var jenisGameId = typeof JENIS_GAME_ID !== 'undefined' ? JENIS_GAME_ID : null;
var poinMaksimal = typeof POIN_MAKSIMAL !== 'undefined' ? POIN_MAKSIMAL : 60;
var POIN_PER_MATCH = poinMaksimal / totalPasangan;

var cardMasterList = [
    { id: "ain", latin: "Ain" },
    { id: "alif", latin: "Alif" },
    { id: "ba", latin: "Ba" },
    { id: "dal", latin: "Dal" },
    { id: "Dhlo", latin: "Dlho" },
    { id: "Dhod", latin: "Dhod" },
    { id: "dzal", latin: "Dzal" },
    { id: "fa", latin: "Fa" },
    { id: "Ghoin", latin: "Ghoin" },
    { id: "Ha", latin: "Ha" },

    { id: "hamzah", latin: "Hamzah" },
    { id: "jim", latin: "Jim" },
    { id: "kaf", latin: "Kaf" },
    { id: "kha", latin: "Kha" },
    { id: "kho", latin: "Kho" },
    { id: "lam", latin: "Lam" },
    { id: "Lamalif", latin: "Lam Alif" },
    { id: "mim", latin: "Mim" },
    { id: "nun", latin: "Nun" },
    { id: "Qof", latin: "Qof" },

    { id: "ra", latin: "Ra" },
    { id: "Shod", latin: "Shod" },
    { id: "sin", latin: "Sin" },
    { id: "syin", latin: "Syin" },
    { id: "ta", latin: "Ta" },
    { id: "Tho", latin: "Tho" },
    { id: "tsa", latin: "Tsa" },
    { id: "Wawu", latin: "Wawu" },
    { id: "ya", latin: "Ya" },
    { id: "Za", latin: "Za" }
];


var cardSet; 

var card1Selected = null;
var card2Selected = null;
var lockBoard = false; 

window.onload = function () {
    shuffleCards();
    startGame();
    
    document.getElementById("current-matches").innerText = pasanganDitemukan;
    
    // Untuk mengatur murid pas mau restart
    document.getElementById("reset-button").addEventListener("click", () => {
        shuffleCards();
        startGame();
    });

    // Welcome message
    const welcomeBackdrop = document.getElementById("welcome-backdrop");
    const welcomeMessage = document.getElementById("welcome-message");

    if (welcomeBackdrop && welcomeMessage) {
        // 1. Tampilkan teks (fade in)
        // Kita beri sedikit delay biar CSS awal opacity-0 kebaca dulu
        setTimeout(() => {
            welcomeMessage.classList.remove("opacity-0"); // Tampilkan teks
            welcomeMessage.classList.add("opacity-100"); // Pastikan opacity penuh
        }, 100); // Delay kecil agar transisi opacity-0 -> opacity-100 bekerja

        // 2. Setel alarm untuk menyembunyikan (fade out)
        setTimeout(() => {
            welcomeMessage.classList.remove("opacity-100"); // Mulai fade out teks
            welcomeMessage.classList.add("opacity-0"); // Pastikan opacity nol
            
            welcomeBackdrop.classList.remove("opacity-100"); // Mulai fade out backdrop
            welcomeBackdrop.classList.add("opacity-0"); // Pastikan opacity nol

            // 3. Setelah animasi fade out selesai, baru sembunyikan sepenuhnya (display: none)
            setTimeout(() => {
                welcomeBackdrop.classList.add("hidden");
                welcomeMessage.classList.add("hidden");
            }, 1000); // Tunggu selama durasi animasi (duration-1000ms = 1 detik)
            
        }, 2000); // Alarm utama: mulai fade out setelah 2 detik
    }
};

function shuffleCards() {

    // Mengacak kartu
    cardMasterList.sort(() => 0.5 - Math.random());

    // 2. Ambil 6 kartu pertama
    let gameCards = cardMasterList.slice(0, totalPasangan); 
    
    // 3. Buat "cardSet" (isi 12 kartu)
    cardSet = [];
    let basePath = (typeof ASSET_BASE !== "undefined" ? ASSET_BASE : "");

    gameCards.forEach((kartu) => {
        // Tambah kartu Tipe HIJAIYAH (Gambar)
        cardSet.push({
            id: kartu.id,
            type: "hijaiyah",
            content: `<img src="${basePath}images/hijaiyah/${kartu.id}.webp" alt="${kartu.id}">`
        });
        
        // Tambah kartu Tipe LATIN (Teks)
        cardSet.push({
            id: kartu.id,
            type: "latin",
            content: `<span class="font-tegak text-4xl font-bold text-pink-500">${kartu.latin}</span>`
        });
    });

    // Acak 12 kartu yang akan dimainkan
    for (let i = cardSet.length - 1; i > 0; i--) {
        let j = Math.floor(Math.random() * (i + 1));
        [cardSet[i], cardSet[j]] = [cardSet[j], cardSet[i]];
    }
}

function startGame() {
    // Reset papan & skor
    pasanganDitemukan = 0;
    poinBenar = 0;
    lockBoard = true; 
        
    document.getElementById("poin-benar").innerText = 0;    
    document.getElementById("current-matches").innerText = pasanganDitemukan;

    const boardEl = document.getElementById("board");
    boardEl.innerHTML = ""; // Kosongkan papan

    // Loop untuk 12 kartu
    for (let cardData of cardSet) {
        
        // --- Bikin Kartu ---
        let card = document.createElement("div");
        card.classList.add("card");
        
        // ▼▼▼ TAMBAHAN BARU ▼▼▼
        card.classList.add("is-flipped"); // <-- 2. KARTU LANGSUNG KEBUKA
        
        card.dataset.id = cardData.id;
        card.dataset.type = cardData.type;

        let inner = document.createElement("div");
        inner.classList.add("card-inner");

        let front = document.createElement("div");
        front.classList.add("card-front");
        let basePath = (typeof ASSET_BASE !== "undefined" ? ASSET_BASE : ""); 
        
        front.innerHTML = `
            <img src="${basePath}images/icon/tanda-tanya.webp" 
                 alt="?" 
                 class="w-12 h-12 sm:w-14 sm:h-14 object-contain opacity-80"
            >
        `;

        let back = document.createElement("div");
        back.classList.add("card-back");
        back.innerHTML = cardData.content; 

        // Rakit
        inner.appendChild(front);
        inner.appendChild(back);
        card.appendChild(inner);
        
        card.addEventListener("click", selectCard);
        boardEl.append(card);
    }

    // Ngintip 2 detik
    setTimeout(() => {
                        
        let allCards = document.querySelectorAll('#board .card'); 
        
        allCards.forEach(card => {        
            card.classList.remove("is-flipped");
        });

        // 5. BUKA KUNCI PAPAN, game siap dimainkan!
        lockBoard = false; 
        
    }, 3000); 
} 

function selectCard() {
    // 'this' sekarang adalah <div class="card">
    
    // Pengecekan baru: Jangan klik jika papan dikunci ATAU kartu sudah kebuka
    if (lockBoard || this.classList.contains("is-flipped")) {
        return;
    }

    // BALIK KARTU (secara visual)
    this.classList.add("is-flipped");

    if (!card1Selected) {
        // Ini klik pertama
        card1Selected = this;
    } else {
        // Ini klik kedua
        card2Selected = this;
        lockBoard = true; // Kunci papan
        setTimeout(update, 1000); // Cek kecocokan
    }
}

// Fungsi update
async function update() {
        
    let isMatch = false;
    
    // Cek: Apakah ID-nya sama? (misal: 'alif' === 'alif')
    if (card1Selected.dataset.id === card2Selected.dataset.id) {
        // Cek: Apakah tipenya BEDA? (misal: 'hijaiyah' !== 'latin')
        if (card1Selected.dataset.type !== card2Selected.dataset.type) {
            isMatch = true;
        }
    }

    if (!isMatch) { 
        // Jika kedua kartu tidak cocok
        card1Selected.classList.remove("is-flipped");
        card2Selected.classList.remove("is-flipped");               
        
    } else { 
        // --- JIKA COCOK! ---
        // "Matikan" kartu biar nggak bisa diklik lagi
        card1Selected.removeEventListener("click", selectCard);
        card2Selected.removeEventListener("click", selectCard);
        
        // Update skor
        pasanganDitemukan += 1;
        poinBenar += POIN_PER_MATCH; // (Nanti bisa diubah skornya, misal +10)
        
        document.getElementById("poin-benar").innerText = Math.round(poinBenar);
        document.getElementById("current-matches").innerText = pasanganDitemukan;

        // Cek Menang
        if (pasanganDitemukan === totalPasangan) {
            // Langsung diberitahu kemenangan dahulu baru cek database
            showSuccessModal(Math.round(poinBenar)); 

            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
                        
            fetch('/murid/game/save-score', { 
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    jenis_game_id: jenisGameId, 
                    skor: pasanganDitemukan,
                    total_poin: Math.round(poinBenar)
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log("Data berhasil disimpan ke database!");                     
                } else {
                    console.error("Gagal simpan:", data);
                }
            })
            .catch(error => {
                console.error("Error koneksi:", error);
            });
            
        }
    }

    // Reset untuk giliran berikutnya
    card1Selected = null;
    card2Selected = null;
    lockBoard = false; // Buka kunci papan
}



// FUngsi untuk memunculkan pop up dan confeti 
function showSuccessModal(skorAkhir) {
    const modal = document.getElementById('success-modal');
    const scoreText = document.getElementById('modal-score');
    
    // Update teks skor di dalam modal
    if (scoreText) scoreText.innerText = skorAkhir;

    // Tampilkan Modal (Hapus class hidden)
    modal.classList.remove('hidden');
    
    // Animasi Masuk (Opsional, biar smooth)
    const modalBox = modal.querySelector('div.relative');
    setTimeout(() => {
        modalBox.classList.remove('scale-90');
        modalBox.classList.add('scale-100');
    }, 10);

    // TEMBAK CONFETTI YANG MERIAH! 🎉
    var duration = 3 * 1000; // 3 detik
    var animationEnd = Date.now() + duration;
    var defaults = { startVelocity: 30, spread: 360, ticks: 60, zIndex: 60 };

    function randomInOut(min, max) {
      return Math.random() * (max - min) + min;
    }

    var interval = setInterval(function() {
      var timeLeft = animationEnd - Date.now();

      if (timeLeft <= 0) {
        return clearInterval(interval);
      }

      var particleCount = 50 * (timeLeft / duration);
      // Tembak dari kiri dan kanan
      confetti({ ...defaults, particleCount, origin: { x: randomInOut(0.1, 0.3), y: Math.random() - 0.2 } });
      confetti({ ...defaults, particleCount, origin: { x: randomInOut(0.7, 0.9), y: Math.random() - 0.2 } });
    }, 250);
}

// 2. Fungsi Restart Game (Dipanggil tombol di modal)
// Kita bikin global biar bisa dipanggil onclick HTML
window.restartGame = function() {
    const modal = document.getElementById('success-modal');
    modal.classList.add('hidden'); // Sembunyikan modal
    
    // Reset logika game
    shuffleCards();
    startGame();
}