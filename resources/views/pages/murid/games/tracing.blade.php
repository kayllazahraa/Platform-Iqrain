<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Tracing Huruf Hijaiyah - IQRain</title>

    <link rel="stylesheet" href="{{ asset('css/game-tracing.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Font Kustom */
        @font-face {
            font-family: 'Tegak Bersambung_IWK';
            src: url("{{ asset('fonts/TegakBersambung_IWK.ttf') }}") format('truetype');
        }

        .font-cursive-iwk {
            font-family: 'Tegak Bersambung_IWK', cursive !important;
        }

        /* Font Mooli untuk Skor */
        .font-mooli {
            font-family: 'Mooli', sans-serif !important;
        }
    </style>

    <script>
        var ASSET_BASE = "{{ asset('') }}";
        var REDIRECT_URL = "{{ route('murid.games.index', $tingkatan->tingkatan_id) }}";

        // ID Game (Dari $jenisGame)
        var JENIS_GAME_ID = {{ $jenisGame->jenis_game_id }};
        var TINGKATAN_ID = {{ $tingkatan->tingkatan_id }};

        // Data Huruf (Convert PHP Array ke JSON)
        // Asumsi: materiPembelajarans punya kolom 'huruf_arab' dan 'nama_latin'
        var ALL_HIJAIYAH_DATA = @json($materiPembelajarans);
    </script>

</head>

<body>
    <div id="welcome-backdrop" class="welcome-backdrop"></div>

    <h1 id="welcome-message" class="welcome-message welcome-title">Selamat Bermain</h1>


    <!-- Game Container -->
    <div id="game-container" class="game-container">

        <!-- Header with Exit Button -->
        <div class="game-header">
            <a href="{{ route('murid.games.index', $tingkatan->tingkatan_id) }}" class="btn-kembali">
                <div class="btn-kembali-icon">
                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="3"
                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </div>
                <span class="font-mooli font-semibold text-white text-[18px] font-normal leading-none pl-4">
                    Kembali
                </span>
            </a>
            <div class="letter-info-display">
                <span id="current-letter-arabic" class="arabic-letter" style="color:white;">ا</span>
                <span id="current-letter-name" class="letter-name-display phrase-putih"
                    style="color: white;">Alif</span>
            </div>
        </div>

        <!-- Main Game Area -->
        <div class="game-main">

            {{-- Balon kiri --}}
            <div class="balloon balloon-left">
                <img src="{{ asset('images/icon/balon.webp') }}" alt="Balon Kiri" style="width:100%; height:auto;">
            </div>

            <!-- Canvas Area (Left Side) -->
            <div class="canvas-section">
                <div class="canvas-wrapper relative w-full bg-white rounded-3xl shadow-lg overflow-hidden" 
                    style="aspect-ratio: 4/3;">
                    
                    {{-- HAPUS class 'object-contain', ganti jadi 'block' --}}
                    <canvas id="guideCanvas" width="400" height="300" 
                            class="absolute top-0 left-0 w-full h-full block"></canvas>
                    
                    <canvas id="tracingCanvas" width="400" height="300" 
                            class="absolute top-0 left-0 w-full h-full block cursor-crosshair"></canvas>
                </div>

                <div class="canvas-controls"> {{-- Hapus font-cursive-iwk dari sini --}}
                    {{-- Tambahkan font-mooli font-semibold di tombol --}}
                    <button id="clear-button" class="control-btn btn-clear font-mooli font-semibold">Hapus</button>
                    <button id="replay-button" class="control-btn btn-replay font-mooli font-semibold">Ulang
                        Animasi</button>
                </div>
            </div>

            <!-- Animation Preview (Right Side) -->
            <div class="preview-section font-cursive-iwk">
                <div class="preview-wrapper">
                    <div id="letter-display" class="letter-display">ا</div>
                    <canvas id="animationCanvas" width="400" height="300"></canvas>
                </div>
            </div>

            <h2 id="final-score" class="text-2xl font-titan mt-4" style="display:none;">Skor Akhir: 0</h2>
            {{-- Tombol untuk menyimpan skor (muncul setelah game selesai) --}}
            {{-- PENTING: data-tingkatan-id harus diisi dari controller --}}
            <!-- <button id="save-score-btn"
                    class="btn bg-indigo-500 hover:bg-indigo-600 text-white mt-4"
                    data-tingkatan-id="{{ $tingkatan->tingkatan_id ?? 0 }}" {{-- Pastikan $tingkatan tersedia dari controller tracing() --}}
                    style="display:none;"
                    onclick="saveTracingScore()">
                Simpan Skor
            </button> -->

            {{-- Tombol kembali ke menu --}}
            <a href="{{ route('murid.games.index', ['tingkatan_id' => $tingkatan->tingkatan_id ?? 0]) }}"
                class="btn bg-gray-500 hover:bg-gray-600 text-white mt-4 ml-2 font-titan" style="display:none;"
                id="back-to-menu-btn">
                Kembali ke Menu Game
            </a>

            <!-- Balon kanan -->
            <div class="balloon balloon-right">
                <img src="{{ asset('images/icon/balon.webp') }}" alt="Balon Kanan" style="width:100%; height:auto;">
            </div>



        </div>



        <!-- Progress Footer -->
        <div class="game-footer">
            <div class="progress-container">
                {{-- UBAH font-titan JADI font-cursive-iwk --}}
                <div class="progress-label font-cursive-iwk text-[40px] hidden">Progress:</div>
                <div class="font-cursive-iwk font-semibold text-[30px] text-iqrain-pink phrase-pink">Progress</div>
                <div class="progress-bar">
                    <div id="progress-fill" class="progress-fill"></div>
                </div>
                {{-- UBAH font-titan JADI font-cursive-iwk --}}
                <div id="progress-text" class="progress-text font-mooli font-semibold text-xl">0%</div>
            </div>

            <div class="score-container">
                {{-- Pastikan ini tetap font-cursive-iwk --}}
                <div class="score-label font-cursive-iwk text-[40px] hidden">Akurasi:</div>
                <div class="font-cursive-iwk font-semibold text-[30px]  text-iqrain-pink phrase-pink">Akurasi</div>
                <div id="score-display" class="score-display font-mooli font-semibold text-xl">0%</div>
                <div id="stars-display" class="stars-display">☆☆☆</div>
            </div>

            <div class="navigation-buttons">
                {{-- UBAH Tombol Navigasi jadi font-mooli --}}
                <button id="prev-button"
                    class="nav-btn btn-prev font-mooli font-semibold"><span>←</span>Sebelumnya</button>
                <button id="next-button" class="nav-btn btn-next font-mooli font-semibold">Berikutnya
                    <span>→</span></button>
            </div>
        </div>

        <!-- <button id="finish-button" class="btn btn-success" style="display:none;">Selesai & Simpan Skor</button> -->
    </div>



    <!-- Success Modal (Hidden by default) -->
    <div id="success-modal" class="custom-modal">
        <div class="modal-overlay"></div>

        <div class="modal-card">
            {{-- Ikon Piala --}}
            <div class="modal-icon animate-bounce">
                <img src="{{ asset('images/icon/piala.webp') }}" alt="Piala">
            </div>

            <h2 class="modal-title font-cursive-iwk text-4xl text-pink-500 font-bold mb-2">
                <span class="phrase-pink-kontras">Luar </span>
                <span class="phrase-pink-kontras">Biasa!</span>
            </h2>

            <p class="modal-subtitle font-cursive-iwk text-[gray-600] mb-6 text-2xl">
                <span class="phrase-hitam">Kamu </span>
                <span class="phrase-hitam">berhasil </span>
                <span class="phrase-hitam">menyelesaikan </span>
                <span class="phrase-hitam">huruf </span>
                <span class="phrase-hitam">ini!</span>
            </p>

            {{-- WADAH BINTANG (Perbaikan Class) --}}
            <div id="final-stars" class="modal-stars">⭐⭐⭐</div>

            {{-- Kotak Skor --}}
            <div class="score-box">
                <p class="score-label">Akurasi</p>
                <p class="score-value" id="modal-score">0%</p>
            </div>

            {{-- Tombol Aksi --}}
            <div class="modal-actions">

                {{-- 1. Tombol Lanjut (Primary - Pink) --}}
                <button id="btn-next-letter" onclick="loadNextLetter()"
                    class="btn-action btn-pink font-mooli font-semibold">
                    Huruf Berikutnya ➔
                </button>

                {{-- 2. Tombol Ulangi (Secondary - Putih Border Pink) --}}
                <button onclick="restartCurrentLetter()" class="btn-action btn-outline-pink font-mooli font-semibold">
                    Ulangi Huruf Ini ↺
                </button>

                {{-- 3. Tombol Menu (Tertiary - Abu) --}}
                <a href="{{ route('murid.games.index', $tingkatan->tingkatan_id) }}"
                    class="btn-action btn-ghost font-mooli font-semibold">
                    Kembali ke Menu
                </a>
            </div>
        </div>
    </div>

    <!-- <div id="score-modal" class="modal d-none">
        <div class="modal-content">
            <h4>Skor tracing berhasil disimpan!</h4>
            <p id="modal-skor"></p>
            <p id="modal-total"></p>
            <button onclick="closeScoreModal()">Lanjut</button>
        </div>
    </div> -->




    <script>
        // Variabel global yang akan diisi oleh logika game Anda
        window.gameFinalScore = 0; // Skor yang akan masuk ke DB (misalnya, total poin)
        window.gameAccuracyPercentage = 0; // Akurasi (0-100) untuk tampilan

        // PENTING: Fungsi ini HARUS dipanggil oleh logika game tracing Anda 
        // saat tracing selesai.
        function showGameResults(finalScore, accuracyPercentage) {
            showSuccessModal(accuracyPercentage);
            // window.gameFinalScore = finalScore; 
            // window.gameAccuracyPercentage = accuracyPercentage;

            // // 1. Update Tampilan Modal
            // document.getElementById('final-accuracy').innerText = `Akurasi: ${accuracyPercentage}%`; 
            // document.getElementById('success-modal').style.display = 'flex'; 

            // // 2. Langsung Panggil Fungsi Penyimpanan Skor
            // saveTracingScore(); // Didefinisikan di game-tracing.js
        }
    </script>



    <script src="{{ asset('js/game-tracing.js') }}"></script>
</body>

</html>
