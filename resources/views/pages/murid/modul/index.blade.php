@extends('layouts.murid')

@section('title', 'Modul Pembelajaran - Iqra ' . $tingkatan->level)

@section('content')
{{-- OUTER BACKGROUND: BIRU --}}
<div class="pt-4 sm:pt-8 pb-0 px-4 flex items-start justify-center relative overflow-hidden">
    
    {{-- Pattern Background --}}
    <img src="{{ asset('images/pattern/pattern1.webp') }}" class="absolute top-0 left-0 w-full h-full object-cover opacity-10 pointer-events-none mix-blend-overlay" alt="pattern">

    {{-- KONTEN UTAMA: BLOK KREM BESAR --}}
    <div class="w-full max-w-6xl bg-[#FDF6E9] rounded-[3rem] shadow-2xl border-[6px] border-white/30 relative z-10 overflow-hidden flex flex-col min-h-[75vh] mb-0">
        
        {{-- HEADER --}}
        <div class="bg-white/50 backdrop-blur-sm p-6 border-b border-orange-100/50 text-center">
            <h1 class="text-3xl font-bold text-indigo-900 inline-flex items-center gap-3">
                <img src="{{ asset('images/icon/bintang.webp') }}" class="w-8 h-8 animate-spin-slow" alt="star">
                Modul Pembelajaran Iqra Jilid {{ $tingkatan->level }}
                <img src="{{ asset('images/icon/bintang.webp') }}" class="w-8 h-8 animate-spin-slow" alt="star">
            </h1>
        </div>

        {{-- CONTENT AREA: TERINTEGRASI (VIDEO KIRI, MATERI KANAN) --}}
        <div class="flex-1 p-6 md:p-10 overflow-y-auto relative flex flex-col justify-between">
            
            {{-- Navigation and Integrated View --}}
            <div class="flex items-center justify-between w-full">
                
                {{-- Tombol PREV --}}
                <button onclick="prevMateri()" class="group relative z-20 p-4 transition-transform hover:scale-110 focus:outline-none">
                    <div class="absolute inset-0 bg-white rounded-full shadow-lg opacity-70 group-hover:opacity-100 transition-opacity"></div>
                    <img src="{{ asset('images/icon/next.webp') }}" 
                         class="w-12 h-12 relative z-10 transform rotate-180 opacity-80 filter drop-shadow-sm" 
                         alt="Previous">
                </button>

                {{-- KONTEN UTAMA SPLIT (VIDEO KIRI, HURUF KANAN) --}}
                <div class="flex flex-col lg:flex-row gap-6 w-full max-w-5xl mx-auto">
                    
                    {{-- KIRI: Main Player & Info (Sesuai Video Prototype) --}}
                    <div class="w-full lg:w-2/3 flex flex-col gap-4">
                        <div class="bg-black rounded-3xl overflow-hidden shadow-lg aspect-video border-4 border-white ring-1 ring-gray-200 relative">
                            {{-- Video Player (Placeholder) --}}
                            <iframe id="main-video-player" class="w-full h-full" src="" title="Video Player" frameborder="0" allowfullscreen></iframe>
                        </div>
                        
                        <div class="bg-white p-4 rounded-xl shadow-sm border border-indigo-50">
                            <h2 id="main-video-title" class="text-xl font-bold text-gray-800">Video Pembelajaran</h2>
                            <p id="main-video-desc" class="text-gray-600 text-sm mt-1">Materi Video</p>
                        </div>
                    </div>

                    {{-- KANAN: Kartu Materi Aktif (Sesuai Materi Prototype) --}}
                    <div class="w-full lg:w-1/3 flex justify-center items-center">
                        <div id="materi-card" class="relative bg-white rounded-3xl shadow-2xl border-4 border-white p-6 text-center transform transition-all duration-500 w-full aspect-square flex flex-col justify-center items-center">
                            
                            {{-- Image Container --}}
                            <div class="relative h-32 w-32 flex items-center justify-center mb-4">
                                <img id="materi-image" src="" class="h-full w-auto object-contain drop-shadow-lg relative z-10" alt="Huruf">
                                <div id="materi-fallback" class="hidden text-6xl font-arabic text-indigo-600 font-bold">?</div>
                            </div>

                            {{-- Text Info --}}
                            <h3 id="materi-title" class="text-3xl font-bold text-indigo-900 font-comic tracking-wide mb-1">...</h3>
                            <p id="materi-desc-short" class="text-indigo-600 font-medium text-sm">...</p>
                            
                            {{-- Progress Badge --}}
                            <div class="absolute top-3 right-3 bg-indigo-500 text-white px-3 py-1 rounded-full text-xs font-bold">
                                Huruf <span id="materi-counter">1/1</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Tombol NEXT --}}
                <button onclick="nextMateri()" class="group relative z-20 p-4 transition-transform hover:scale-110 focus:outline-none">
                    <div class="absolute inset-0 bg-white rounded-full shadow-lg opacity-70 group-hover:opacity-100 transition-opacity"></div>
                    <img src="{{ asset('images/icon/next.webp') }}" 
                         class="w-12 h-12 relative z-10 opacity-80 group-hover:opacity-100 filter drop-shadow-sm" 
                         alt="Next">
                </button>
            </div>

            {{-- FOOTER KONTEN UTAMA: PROGRESS BAR --}}
            <div class="w-full mt-8 pt-4 border-t border-gray-100">
                <h3 class="text-lg font-bold text-gray-800 mb-2">
                    Progres Tingkatan {{ $tingkatan->level }}
                </h3>
                <div class="bg-gray-200 rounded-full h-4 relative overflow-hidden">
                    {{-- Progress Fill --}}
                    <div class="bg-indigo-500 h-full rounded-full transition-all duration-500" style="width: {{ $progressPercentage }}%;"></div>
                    
                    {{-- Progress Text --}}
                    <span class="absolute inset-0 text-center text-xs font-bold text-white leading-4 tracking-wider" style="text-shadow: 1px 1px 2px rgba(0,0,0,0.2);">
                        {{ $completedMaterialsCount }} / {{ $totalMaterials }} Materi Selesai ({{ $progressPercentage }}%)
                    </span>
                </div>
            </div>

        </div>
    </div>
</div>


<script>
    // === DATA STATIC MATERI (DI LOAD LANGSUNG DI SINI) ===
    // Nama file disesuaikan persis dengan yang ada di folder public/images/hijaiyah/
    const staticMateriData = [
        { judul: 'Alif', desc: 'Huruf Alif', file: 'alif.webp',video: '{{ $videos->count() > 0 ? $videos[0]->url_video : "" }}' },
        { judul: 'Ba', desc: 'Huruf Ba', file: 'ba.webp', video: '{{ $videos->count() > 1 ? $videos[1]->url_video : "" }}'  },
        { judul: 'Ta', desc: 'Huruf Ta', file: 'ta.webp', video: '{{ $videos->count() > 2 ? $videos[2]->url_video : "" }}' },
        { judul: 'Tsa', desc: 'Huruf Tsa', file: 'tsa.webp', video: '{{ $videos->count() > 3 ? $videos[3]->url_video : "" }}' },
        { judul: 'Jim', desc: 'Huruf Jim', file: 'jim.webp', video: '{{ $videos->count() > 4 ? $videos[4]->url_video : "" }}' },
        { judul: 'Kha', desc: 'Huruf Kha', file: 'Kha.webp', video: '{{ $videos->count() > 5 ? $videos[5]->url_video : "" }}' }, 
        { judul: 'Kho', desc: 'Huruf Kho', file: 'kho.webp', video: '{{ $videos->count() > 6 ? $videos[6]->url_video : "" }}' },
        { judul: 'Dal', desc: 'Huruf Dal', file: 'dal.webp', video: '{{ $videos->count() > 7 ? $videos[7]->url_video : "" }}' },
        { judul: 'Dzal', desc: 'Huruf Dzal', file: 'dzal.webp', video: '{{ $videos->count() > 8 ? $videos[8]->url_video : "" }}' },
        { judul: 'Ra', desc: 'Huruf Ra', file: 'ra.webp', video: '{{ $videos->count() > 9 ? $videos[9]->url_video : "" }}' },
        { judul: 'Za', desc: 'Huruf Za', file: 'Za.webp', video: '{{ $videos->count() > 10 ? $videos[10]->url_video : "" }}' }, // Sesuai aset Zayn.webp
        { judul: 'Sin', desc: 'Huruf Sin', file: 'sin.webp', video: '{{ $videos->count() > 11 ? $videos[11]->url_video : "" }}' },
        { judul: 'Syin', desc: 'Huruf Syin', file: 'syin.webp', video: '{{ $videos->count() > 12 ? $videos[12]->url_video : "" }}' },
        { judul: 'Sad', desc: 'Huruf Sad', file: 'Shod.webp', video: '{{ $videos->count() > 13 ? $videos[13]->url_video : "" }}' }, // Sesuai aset Sad.webp
        { judul: 'Dhod', desc: 'Huruf Dhod', file: 'Dhod.webp', video: '{{ $videos->count() > 14 ? $videos[14]->url_video : "" }}' }, // Sesuai aset Dhad.webp
        { judul: 'Tho', desc: 'Huruf Tha', file: 'Tho.webp', video: '{{ $videos->count() > 15 ? $videos[15]->url_video : "" }}' }, // Sesuai aset Tha.webp
        { judul: 'Dhlo', desc: 'Huruf Dhlo', file: 'Dhlo.webp', video: '{{ $videos->count() > 16 ? $videos[16]->url_video : "" }}' }, // Sesuai aset Zha.webp
        { judul: 'Ain', desc: 'Huruf Ain', file: 'ain.webp', video: '{{ $videos->count() > 17 ? $videos[17]->url_video : "" }}' },
        { judul: 'Ghoin', desc: 'Huruf Ghoin', file: 'Ghoin.webp', video: '{{ $videos->count() > 18 ? $videos[18]->url_video : "" }}' }, // Sesuai aset Ghain.webp
        { judul: 'Fa', desc: 'Huruf Fa', file: 'fa.webp', video: '{{ $videos->count() > 19 ? $videos[19]->url_video : "" }}' },
        { judul: 'Qof', desc: 'Huruf Qof', file: 'Qof.webp', video: '{{ $videos->count() > 20 ? $videos[20]->url_video : "" }}' }, // Sesuai aset Qaf.webp
        { judul: 'Kaf', desc: 'Huruf Kaf', file: 'kaf.webp', video: '{{ $videos->count() > 21 ? $videos[21]->url_video : "" }}' },
        { judul: 'Lam', desc: 'Huruf Lam', file: 'lam.webp', video: '{{ $videos->count() > 22 ? $videos[22]->url_video : "" }}' },
        { judul: 'Mim', desc: 'Huruf Mim', file: 'mim.webp', video: '{{ $videos->count() > 23 ? $videos[23]->url_video : "" }}' },
        { judul: 'Nun', desc: 'Huruf Nun', file: 'nun.webp', video: '{{ $videos->count() > 24 ? $videos[24]->url_video : "" }}' },
        { judul: 'Wawu', desc: 'Huruf Wawu', file: 'Wawu.webp', video: '{{ $videos->count() > 25 ? $videos[25]->url_video : "" }}' }, // Sesuai aset Waw.webp
        { judul: 'Ha', desc: 'Huruf Ha', file: 'Ha.webp', video: '{{ $videos->count() > 26 ? $videos[26]->url_video : "" }}' }, // Sesuai aset
        { judul: 'Lam Alif', desc: 'Huruf Lam Alif', file: 'Lamalif.webp', video: '{{ $videos->count() > 27 ? $videos[27]->url_video : "" }}' }, // Sesuai aset
        { judul: 'Hamzah', desc: 'Huruf Hamzah', file: 'hamzah.webp', video: '{{ $videos->count() > 28 ? $videos[28]->url_video : "" }}' },
        { judul: 'Ya', desc: 'Huruf Ya', file: 'ya.webp', video: '{{ $videos->count() > 29 ? $videos[29]->url_video : "" }}' }
    ];

    let currentIndex = 0;

    // === 1. LOGIKA UTAMA DISPLAY ===
    function updateMateriDisplay() {
        if (staticMateriData.length === 0) {
            document.getElementById('materi-card').innerHTML = '<p class="text-gray-400">Belum ada materi statis ditemukan.</p>';
            return;
        }
        
        const materi = staticMateriData[currentIndex];
        const card = document.getElementById('materi-card');
        const imgEl = document.getElementById('materi-image');
        const fallbackEl = document.getElementById('materi-fallback');
        
        // Animasi
        card.classList.add('opacity-50', 'scale-95');

        setTimeout(() => {
            // Update Teks
            document.getElementById('materi-title').innerText = materi.judul;
            document.getElementById('materi-desc-short').innerText = materi.desc;
            document.getElementById('materi-counter').innerText = `${currentIndex + 1} / ${staticMateriData.length}`;
            
            // Update Gambar
            const imagePath = `{{ asset('images/hijaiyah/') }}/${materi.file}`;
            imgEl.src = imagePath;
            fallbackEl.innerText = materi.judul;
            
            // Update Video Player (Integrated Logic)
            if (materi.video) {
                document.getElementById('main-video-player').src = materi.video;
                document.getElementById('main-video-title').innerText = `Video Pembelajaran: Huruf ${materi.judul}`;
                document.getElementById('main-video-desc').innerText = materi.desc;
            } else {
                document.getElementById('main-video-player').src = ''; // Clear video
                document.getElementById('main-video-title').innerText = 'Video tidak tersedia';
                document.getElementById('main-video-desc').innerText = 'Silakan hubungi mentor Anda.';
            }

            card.classList.remove('opacity-50', 'scale-95');
        }, 200);
    }

    // Handle image error for Materi Card
    function handleImageError(img) {
        img.style.display = 'none';
        document.getElementById('materi-fallback').style.display = 'block';
    }

    function nextMateri() {
        currentIndex = (currentIndex + 1) % staticMateriData.length;
        updateMateriDisplay();
    }

    function prevMateri() {
        currentIndex = (currentIndex - 1 + staticMateriData.length) % staticMateriData.length;
        updateMateriDisplay();
    }

    // === 2. LOGIKA VIDEO (Hanya untuk list di kanan, tidak terpakai lagi untuk main player) ===
    function changeVideo(url, title, desc) {
        // Ini adalah logic jika mengklik list video di sidebar (yang sudah dihapus layoutnya, 
        // tapi logikanya bisa dipakai jika nanti ditambahkan lagi)
        // Di layout baru ini, logic ini hanya perlu mengupdate Main Player di kiri.
        
        document.getElementById('main-video-player').src = url;
        document.getElementById('main-video-title').innerText = title;
        document.getElementById('main-video-desc').innerText = desc;
        if(window.innerWidth < 1024) {
            document.getElementById('main-video-player').scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    }

    async function saveProgressAsync(materiId) {
        const realMateriId = parseInt(materiId);
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        if (isNaN(realMateriId) || realMateriId < 1) return;

        try {
            // PERUBAHAN DISINI: Gunakan route 'modul.progress' yang sudah ada di web.php
            const response = await fetch('{{ route("modul.progress") }}', { 
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify({ materi_id: realMateriId })
            });

            const result = await response.json();
            if (result.success) {
                console.log(`Progress tersimpan untuk Materi ID: ${realMateriId}`);
            } 

        } catch (error) {
            console.error('Gagal menyimpan progress:', error);
        }
    }

    // === INIT ===
    document.addEventListener('DOMContentLoaded', () => {
        // Inisialisasi tampilan pertama
        updateMateriDisplay(); 
        
        // Keyboard Navigation
        document.addEventListener('keydown', (e) => {
            if (e.key === 'ArrowRight') nextMateri();
            if (e.key === 'ArrowLeft') prevMateri();
        });
    });
</script>

<style>
    .font-comic { font-family: 'Comic Sans MS', 'Comic Sans', cursive; }
    .font-arabic { font-family: 'Amiri', serif; }
    @keyframes spin-slow {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    .animate-spin-slow { animation: spin-slow 10s linear infinite; }
    .custom-scrollbar::-webkit-scrollbar { width: 6px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 4px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
</style>
@endsection