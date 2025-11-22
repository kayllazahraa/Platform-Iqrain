@extends('layouts.murid')

{{-- Judul halaman diambil dari $tingkatan --}}
@section('title', 'Games - Iqra ' . $tingkatan->level)

{{-- 1. Style & Font --}}
@push('styles')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mooli&family=Titan+One&display=swap" rel="stylesheet">

    <style>

        /* Font Khusus Angka (Nanum Myeongjo) */
        @font-face {
            font-family: 'NanumMyeongjo';
            src: url('{{ asset('fonts/NanumMyeongjo-Regular.ttf') }}') format('truetype');
        }

        .font-nanum {
            font-family: 'NanumMyeongjo', serif;
            padding-left: 4px;
        }

        body {
            background-color: #E4F2FF;
            background-image: url('{{ asset('images/games/game-pattern.webp') }}');
            background-size: 500px;
            background-repeat: repeat;
            background-attachment: fixed;
            background-position: center;
        }

        /* Animasi Goyang */
        @keyframes wiggle {

            0%,
            100% {
                transform: rotate(-3deg);
            }

            50% {
                transform: rotate(3deg);
            }
        }

        .btn-goyang {
            /* Warna Pink */
            background-color: #AC3F61;
            /* Jalankan animasi */
            animation: wiggle 0.8s ease-in-out infinite;
        }

        /* Saat di-hover: Stop goyang & perbesar sedikit */
        .btn-goyang:hover {
            background-color: #963653;
            /* Pink lebih gelap dikit */
            animation: none;
            transform: scale(1.05);
        }
    </style>
    
@endpush

{{-- 2. Konten Utama --}}
@section('content')

    {{-- ========================================= --}}
    {{-- MODAL POP-UP (VIDEO + LANGKAH) --}}
    {{-- ========================================= --}}
    <div id="gameModal" class="fixed inset-0 bg-black bg-opacity-60 hidden items-center justify-center z-50"
        style="display: none;">

        {{-- Container Modal --}}
        <div class="bg-gradient-to-br from-pink-100 to-white rounded-[30px] p-1 w-full max-w-5xl mx-4 shadow-2xl relative">

            {{-- Tombol Close --}}
            <button onclick="closeGameModal()"
                class="absolute -top-4 -right-4 bg-pink-500 text-white w-10 h-10 rounded-full hover:bg-pink-600 text-2xl font-bold shadow-lg flex items-center justify-center z-10 transition-transform hover:scale-110">
                &times;
            </button>

            <div class="bg-white rounded-[26px] p-6 md:p-8">
                {{-- Judul Game --}}
                <h3 class="text-3xl md:text-4xl font-titan text-[#234275] text-center mb-6" id="modalGameTitle">
                    Panduan Bermain
                </h3>

                {{-- Layout Grid: Kiri Video, Kanan Teks --}}
                <div class="flex flex-col lg:flex-row gap-8 mb-8">

                    {{-- BAGIAN KIRI: VIDEO --}}
                    <div class="w-full lg:w-1/2 flex flex-col justify-center">
                        <div
                            class="relative w-full pt-[56.25%] rounded-2xl overflow-hidden shadow-lg border-2 border-gray-100 bg-black">
                            <iframe id="gameVideoIframe" class="absolute top-0 left-0 w-full h-full" src=""
                                title="YouTube video player" frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                allowfullscreen>
                            </iframe>
                        </div>
                        <p class="text-center text-gray-500 text-xl mt-3 font-cursive-iwk text-lg">Tonton video untuk
                            panduan lengkap</p>
                    </div>

                    {{-- BAGIAN KANAN: LANGKAH-LANGKAH --}}
                    <div class="w-full lg:w-1/2 flex flex-col justify-center">
                        <div class="space-y-4">
                            {{-- Step 1 --}}
                            {{-- PERUBAHAN: items-start -> items-center, w-10 -> w-12, text-xl -> text-2xl --}}
                            <div class="flex items-center gap-4 p-3 rounded-xl hover:bg-pink-50 transition-colors">
                                <div
                                    class="bg-pink-500 text-white rounded-full w-12 h-12 flex items-center justify-center font-nanum text-2xl flex-shrink-0 shadow-md">
                                    1
                                </div>
                                <p class="text-pink-900 font-cursive-iwk text-2xl leading-snug pt-1" id="step1">
                                </p>
                            </div>

                            {{-- Step 2 --}}
                            <div class="flex items-center gap-4 p-3 rounded-xl hover:bg-pink-50 transition-colors">
                                <div
                                    class="bg-pink-500 text-white rounded-full w-12 h-12 flex items-center justify-center font-nanum text-2xl flex-shrink-0 shadow-md">
                                    2
                                </div>
                                <p class="text-pink-900 font-cursive-iwk text-2xl leading-snug pt-1" id="step2">
                                </p>
                            </div>

                            {{-- Step 3 --}}
                            <div class="flex items-center gap-4 p-3 rounded-xl hover:bg-pink-50 transition-colors">
                                <div
                                    class="bg-pink-500 text-white rounded-full w-12 h-12 flex items-center justify-center font-nanum text-2xl flex-shrink-0 shadow-md">
                                    3
                                </div>
                                <p class="text-pink-900 font-cursive-iwk text-2xl leading-snug pt-1" id="step3">
                                </p>
                            </div>

                            {{-- Step 4 --}}
                            <div class="flex items-center gap-4 p-3 rounded-xl hover:bg-pink-50 transition-colors">
                                <div
                                    class="bg-pink-500 text-white rounded-full w-12 h-12 flex items-center justify-center font-nanum text-2xl flex-shrink-0 shadow-md">
                                    4
                                </div>
                                <p class="text-pink-900 font-cursive-iwk text-2xl leading-snug pt-1" id="step4">
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Tombol Main --}}
                <div class="flex justify-center">
                    <button onclick="startGame()"
                        class="btn-goyang w-full md:w-1/4 text-2xl md:text-3xl py-4 text-white font-cursive-iwk rounded-2xl shadow-lg transition-transform duration-200 hover:shadow-xl">
                        Mainkan Sekarang!
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- ========================================= --}}
    {{-- HEADER HALAMAN --}}
    {{-- ========================================= --}}
    <div class="container mx-auto px-6 py-12">
        <div class="flex flex-col md:flex-row items-center justify-between gap-8">
            <div class="md:w-1/2">
                <h1 class="font-titan text-[60px] lg:text-[80px] text-[#234275] leading-none">
                    Siap untuk Berpetualang?
                </h1>
                <h2 class="font-cursive-iwk text-[45px] lg:text-[55px] text-gray-700 leading-tight mt-2">
                    Mainkan dan Raih Skormu
                </h2>
            </div>
            <div class="md:w-1/2 flex justify-center md:justify-end">
                <img src="/images/games/qira-game.webp" alt="Qira Game" class="max-w-sm md:max-w-md">
            </div>
        </div>
    </div>

    {{-- ========================================= --}}
    {{-- GRID PILIHAN GAME --}}
    {{-- ========================================= --}}
    <div class="container mx-auto px-6 py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

            {{-- Kartu 1: Kartu Memori --}}
            <div class="block p-8 rounded-[20px] shadow-lg bg-[#6DC2FF] text-[#234275] transition-transform hover:scale-105 cursor-pointer"
                onclick="showGameModal('memory-card')">
                <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                    <div class="md:w-1/2 text-center md:text-left">
                        <h3 class="font-titan text-3xl mb-3">Kartu Memori</h3>
                        <p class="font-cursive-iwk text-3xl">
                            <span class="phrase">Yuk</span> cocokin huruf yang sama. Buka kartunya dan ingat di mana
                            hurufnya tersembunyi!
                        </p>
                    </div>
                    <div class="md:w-1/2 flex justify-center">
                        <img src="/images/games/KartuMemori.webp" alt="Kartu Memori" class="max-w-[180px]">
                    </div>
                </div>
            </div>

            {{-- Kartu 2: Labirin Hijaiyah --}}
            <div class="block p-8 rounded-[20px] shadow-lg bg-[#FFCE6B] text-[#234275] transition-transform hover:scale-105 cursor-pointer"
                onclick="showGameModal('labirin')">
                <div class="flex flex-col md:flex-row-reverse items-center justify-between gap-6">
                    <div class="md:w-1/2 text-center md:text-left">
                        <h3 class="font-titan text-3xl mb-3">Labirin Hijaiyah</h3>
                        <p class="font-cursive-iwk text-3xl">
                            Temukan jalan menuju huruf hijaiyah yang dicari! Hati-hati jangan tersesat di labirin
                        </p>
                    </div>
                    <div class="md:w-1/2 flex justify-center">
                        <img src="/images/games/LabirinHijaiyah.webp" alt="Labirin Hijaiyah" class="max-w-[180px]">
                    </div>
                </div>
            </div>

            {{-- Kartu 3: Seret & Lepas --}}
            <div class="block p-8 rounded-[20px] shadow-lg bg-[#F387A9] text-[#234275] transition-transform hover:scale-105 cursor-pointer"
                onclick="showGameModal('drag-drop')">
                <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                    <div class="md:w-1/2 text-center md:text-left">
                        <h3 class="font-titan text-3xl mb-3">Seret & Lepas</h3>
                        <p class="font-cursive-iwk text-3xl">
                            Seret huruf hijaiyah ke tempat huruf latinnya yang cocok. Yuk, pasangkan dengan benar!
                        </p>
                    </div>
                    <div class="md:w-1/2 flex justify-center">
                        <img src="/images/games/SeretLepas.webp" alt="Seret & Lepas" class="max-w-[180px]">
                    </div>
                </div>
            </div>

            {{-- Kartu 4: Tulis Huruf --}}
            <div class="block p-8 rounded-[20px] shadow-lg bg-[#BEFA70] text-[#234275] transition-transform hover:scale-105 cursor-pointer"
                onclick="showGameModal('tracing')">
                <div class="flex flex-col md:flex-row-reverse items-center justify-between gap-6">
                    <div class="md:w-1/2 text-center md:text-left">
                        <h3 class="font-titan text-3xl mb-3">Tulis Huruf</h3>
                        <p class="font-cursive-iwk text-3xl">
                            Ikuti garis titik-titik dan tulis huruf hijaiyah dengan rapi. Yuk belajar menulis sambil
                            bermain!
                        </p>
                    </div>
                    <div class="md:w-1/2 flex justify-center">
                        <img src="/images/games/TulisHuruf.webp" alt="Tulis Huruf" class="max-w-[180px]">
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

{{-- 3. JavaScript --}}
@push('scripts')
    <script>
        let selectedGame = '';
        const tingkatanId = {{ $tingkatan->tingkatan_id }};

        // ==========================================
        // DATA GAME: VIDEO & INSTRUKSI TEKS
        // Ganti 'YOUR_VIDEO_ID_HERE' dengan ID Video YouTube yang benar
        // ==========================================
        const gameData = {
            'memory-card': {
                title: 'Panduan Kartu Memori',
                videoId: 'YOUR_VIDEO_ID_HERE', // Ganti ID Youtube
                steps: [
                    'Klik kartu untuk membuka dan lihat hurufnya',
                    'Cari pasangan huruf yang sama',
                    'Cocokkan semua pasangan untuk menang',
                    'Semakin cepat, semakin tinggi skormu!'
                ]
            },
            'labirin': {
                title: 'Panduan Labirin Hijaiyah',
                videoId: 'YOUR_VIDEO_ID_HERE', // Ganti ID Youtube
                steps: [
                    'Gunakan tombol panah untuk bergerak',
                    'Cari huruf yang diminta di labirin',
                    'Hindari jalan buntu dan temukan jalan keluar',
                    'Kumpulkan semua huruf untuk menyelesaikan level'
                ]
            },
            'drag-drop': {
                title: 'Panduan Seret & Lepas',
                videoId: 'YOUR_VIDEO_ID_HERE', // Ganti ID Youtube
                steps: [
                    'Lihat huruf hijaiyah di layar',
                    'Seret huruf ke huruf latin yang cocok',
                    'Lepaskan di tempat yang benar',
                    'Jawab semua soal dengan benar!'
                ]
            },
            'tracing': {
                title: 'Panduan Tulis Huruf',
                videoId: 'YOUR_VIDEO_ID_HERE', // Ganti ID Youtube
                steps: [
                    'Lihat huruf yang akan kamu tulis',
                    'Ikuti garis titik-titik dengan jarimu',
                    'Tulis dengan rapi mengikuti panduan',
                    'Selesaikan semua huruf untuk lanjut!'
                ]
            }
        };

        // Fungsi Buka Modal
        function showGameModal(gameType) {
            selectedGame = gameType;
            const modal = document.getElementById('gameModal');
            const data = gameData[gameType];

            // 1. Update Judul
            document.getElementById('modalGameTitle').textContent = data.title;

            // 2. Update Video Youtube
            const embedUrl = `https://www.youtube.com/embed/${data.videoId}?rel=0&autoplay=1`;
            document.getElementById('gameVideoIframe').src = embedUrl;

            // 3. Update Langkah-langkah (Step 1-4)
            document.getElementById('step1').textContent = data.steps[0];
            document.getElementById('step2').textContent = data.steps[1];
            document.getElementById('step3').textContent = data.steps[2];
            document.getElementById('step4').textContent = data.steps[3];

            // 4. Tampilkan Modal
            modal.style.display = 'flex';
        }

        // Fungsi Tutup Modal
        function closeGameModal() {
            const modal = document.getElementById('gameModal');
            modal.style.display = 'none';

            // Reset src iframe agar video berhenti
            document.getElementById('gameVideoIframe').src = '';
        }

        // Fungsi Mulai Game
        function startGame() {
            const gameUrls = {
                'memory-card': `{{ route('murid.games.memory-card', ['tingkatan_id' => $tingkatan->tingkatan_id]) }}`,
                'labirin': `{{ route('murid.games.labirin', ['tingkatan_id' => $tingkatan->tingkatan_id]) }}`,
                'drag-drop': `{{ route('murid.games.drag-drop', ['tingkatan_id' => $tingkatan->tingkatan_id]) }}`,
                'tracing': `{{ route('murid.games.tracing', ['tingkatan_id' => $tingkatan->tingkatan_id]) }}`
            };

            window.location.href = gameUrls[selectedGame];
        }

        // Tutup modal jika klik di luar area putih
        document.getElementById('gameModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeGameModal();
            }
        });

        // Simpan session
        sessionStorage.setItem('current_tingkatan_id', tingkatanId);
    </script>
@endpush
