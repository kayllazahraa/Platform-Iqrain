@extends('layouts.murid')

@section('title', 'Modul Pembelajaran - Iqra ' . $tingkatan->level)

@section('content')
<div class="min-h-screen bg-[#FDF6E9] py-8 relative overflow-hidden">
    
    {{-- Hiasan Background (Opsional) --}}
    <img src="{{ asset('images/pattern/pattern1.webp') }}" class="absolute top-0 left-0 w-full h-full object-cover opacity-5 pointer-events-none" alt="pattern">

    <div class="container mx-auto px-4 relative z-10">
        
        {{-- HEADER & TABS --}}
        <div class="max-w-4xl mx-auto mb-8 text-center">
            <h1 class="text-3xl font-bold text-gray-800 mb-6 flex justify-center items-center gap-3">
                <img src="{{ asset('images/icon/bintang.webp') }}" class="w-8 h-8 animate-spin-slow" alt="bintang">
                Belajar Iqra {{ $tingkatan->level }}
                <img src="{{ asset('images/icon/bintang.webp') }}" class="w-8 h-8 animate-spin-slow" alt="bintang">
            </h1>

            {{-- Tab Buttons (Mirip Prototype) --}}
            <div class="inline-flex bg-white p-2 rounded-full shadow-lg">
                <button onclick="switchTab('video')" 
                        id="tab-video" 
                        class="px-8 py-3 rounded-full font-bold text-lg transition-all duration-300 flex items-center gap-2">
                    Video Belajar
                </button>
                <button onclick="switchTab('materi')" 
                        id="tab-materi" 
                        class="px-8 py-3 rounded-full font-bold text-lg transition-all duration-300 flex items-center gap-2">
                    Materi Modul
                </button>
            </div>
        </div>

        {{-- KONTEN: MATERI MODUL --}}
        <div id="content-materi" class="tab-content max-w-6xl mx-auto">
            <div class="flex flex-col md:flex-row gap-8 items-start">
                
                {{-- Kolom Kiri: Maskot (Hiasan) --}}
                <div class="hidden md:block w-1/3 sticky top-24">
                    <div class="bg-white/50 backdrop-blur-sm p-6 rounded-3xl border-4 border-white shadow-xl text-center">
                        <img src="{{ asset('images/maskot/ceria.webp') }}" alt="Maskot Ceria" class="w-full h-auto max-w-[250px] mx-auto hover:scale-105 transition-transform duration-500">
                        <p class="mt-4 font-comic text-lg text-indigo-600 font-bold">
                            "Ayo pilih huruf yang ingin kamu pelajari!"
                        </p>
                    </div>
                </div>

                {{-- Grid Materi --}}
                <div class="w-full md:w-2/3">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @forelse($tingkatan->materiPembelajarans as $materi)
                            <div onclick="openMateriModal({{ $materi->materi_id }})" 
                                 class="group bg-white rounded-2xl p-4 shadow-md border-b-4 border-indigo-100 hover:border-indigo-400 hover:-translate-y-1 transition-all cursor-pointer flex items-center justify-between">
                                
                                <div class="flex items-center gap-4">
                                    {{-- Icon/Gambar Huruf (Asumsi ada folder hijaiyah) --}}
                                    <div class="w-16 h-16 bg-indigo-50 rounded-xl flex items-center justify-center text-3xl font-arabic text-indigo-600 group-hover:bg-indigo-100 transition-colors">
                                        {{-- Jika ada gambar spesifik per huruf --}}
                                        {{-- <img src="{{ asset('images/hijaiyah/' . strtolower($materi->judul_materi) . '.webp') }}" alt="{{ $materi->judul_materi }}"> --}}
                                        <img src="{{ asset('public/images/hijaiyah/alif.webp' . strtolower($materi->judul_materi) . '.webp') }}" alt="{{ $materi->judul_materi }}">
                                        {{-- Fallback text jika gambar belum ada --}}
                                        {{ $materi->judul_materi }} 
                                    </div>
                                    
                                    <div class="text-left">
                                        <h3 class="font-bold text-lg text-gray-800 group-hover:text-indigo-600 transition-colors">
                                            Huruf {{ $materi->judul_materi }}
                                        </h3>
                                        <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded-md">
                                            Ketuk untuk belajar
                                        </span>
                                    </div>
                                </div>

                                <div class="bg-indigo-500 text-white p-2 rounded-full group-hover:bg-indigo-600 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-2 text-center py-10">
                                <p class="text-gray-500">Belum ada materi untuk tingkatan ini.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        {{-- KONTEN: VIDEO PEMBELAJARAN --}}
        <div id="content-video" class="tab-content max-w-6xl mx-auto hidden">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($videos as $video)
                    <div class="bg-white rounded-2xl overflow-hidden shadow-lg border-4 border-white hover:border-pink-200 transition-all group">
                        <div class="relative aspect-video bg-gray-200">
                            {{-- Thumbnail Video (Bisa dari Youtube atau Upload) --}}
                            <iframe class="w-full h-full" src="{{ $video->url_video }}" title="{{ $video->judul_video }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </div>
                        <div class="p-5">
                            <h3 class="font-bold text-lg text-gray-800 mb-2 group-hover:text-pink-500 transition-colors">
                                {{ $video->judul_video }}
                            </h3>
                            <p class="text-sm text-gray-600 line-clamp-2">
                                {{ $video->deskripsi ?? 'Tonton video ini untuk memperlancar bacaanmu.' }}
                            </p>
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 text-center py-10 bg-white rounded-3xl opacity-70">
                        <img src="{{ asset('images/maskot/bawa-hp.webp') }}" class="w-32 mx-auto mb-4 opacity-50" alt="Kosong">
                        <p class="text-gray-500 font-bold">Belum ada video pembelajaran saat ini.</p>
                    </div>
                @endforelse
            </div>
        </div>

    </div>
</div>

{{-- MODAL MATERI (Placeholder untuk logic buka materi) --}}
<div id="materi-modal" class="fixed inset-0 z-50 hidden bg-black/50 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl w-full max-w-4xl h-[80vh] flex flex-col shadow-2xl transform transition-all scale-95 opacity-0" id="materi-modal-content">
        {{-- Header Modal --}}
        <div class="p-4 border-b flex justify-between items-center bg-indigo-50 rounded-t-3xl">
            <h3 id="modal-title" class="text-xl font-bold text-indigo-800">Detail Materi</h3>
            <button onclick="closeMateriModal()" class="p-2 hover:bg-indigo-100 rounded-full text-indigo-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        {{-- Body Modal (Isi konten diload via JS) --}}
        <div class="flex-1 overflow-y-auto p-6 bg-[#FDF6E9]" id="modal-body">
            <div class="flex justify-center items-center h-full">
                <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-indigo-600"></div>
            </div>
        </div>
    </div>
</div>

<footer class="w-full mt-12">
    <img src="/images/games/game-footer.webp" alt="Footer Hiasan" class="w-full object-cover">
</footer>

<script>
    // === LOGIC TABS ===
    function switchTab(tabName) {
        const contentMateri = document.getElementById('content-materi');
        const contentVideo = document.getElementById('content-video');
        const btnMateri = document.getElementById('tab-materi');
        const btnVideo = document.getElementById('tab-video');

        if (tabName === 'materi') {
            contentMateri.classList.remove('hidden');
            contentVideo.classList.add('hidden');
            
            // Style Active
            btnMateri.classList.add('bg-indigo-500', 'text-white', 'shadow-md');
            btnMateri.classList.remove('text-gray-500', 'hover:bg-gray-100');
            
            // Style Inactive
            btnVideo.classList.remove('bg-pink-500', 'text-white', 'shadow-md');
            btnVideo.classList.add('text-gray-500', 'hover:bg-gray-100');
        } else {
            contentMateri.classList.add('hidden');
            contentVideo.classList.remove('hidden');
            
            // Style Active
            btnVideo.classList.add('bg-pink-500', 'text-white', 'shadow-md');
            btnVideo.classList.remove('text-gray-500', 'hover:bg-gray-100');
            
            // Style Inactive
            btnMateri.classList.remove('bg-indigo-500', 'text-white', 'shadow-md');
            btnMateri.classList.add('text-gray-500', 'hover:bg-gray-100');
        }
    }

    // === LOGIC MODAL ===
    const modal = document.getElementById('materi-modal');
    const modalContent = document.getElementById('materi-modal-content');
    const tingkatanId = "{{ $tingkatan->tingkatan_id }}";

    function openMateriModal(materiId) {
        modal.classList.remove('hidden');
        // Animasi masuk
        setTimeout(() => {
            modalContent.classList.remove('scale-95', 'opacity-0');
            modalContent.classList.add('scale-100', 'opacity-100');
        }, 10);

        // Fetch Data Materi (Sesuai Controller ModulController@materi)
        fetch(`/murid/modul/${tingkatanId}/materi/${materiId}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('modal-title').innerText = 'Belajar Huruf: ' + data.materi.judul_materi;
                
                // Render Konten di sini (Contoh sederhana)
                let htmlContent = `
                    <div class="text-center space-y-6">
                        <div class="text-8xl font-arabic text-indigo-600 mb-4 animate-bounce-slow">
                            ${data.materi.judul_materi}
                        </div>
                        <div class="bg-white p-6 rounded-xl shadow-sm border-2 border-indigo-50 text-left">
                            <h4 class="font-bold text-lg mb-2">Deskripsi:</h4>
                            <p class="text-gray-700 text-lg leading-relaxed">${data.materi.deskripsi || 'Tidak ada deskripsi.'}</p>
                        </div>
                        
                        <div class="flex justify-between mt-8 pt-4 border-t border-gray-200">
                            ${data.prev ? `<button onclick="openMateriModal(${data.prev.materi_id})" class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300">← Sebelumnya</button>` : '<div></div>'}
                            ${data.next ? `<button onclick="openMateriModal(${data.next.materi_id})" class="px-4 py-2 bg-indigo-500 text-white rounded-lg hover:bg-indigo-600">Selanjutnya →</button>` : '<div></div>'}
                        </div>
                    </div>
                `;
                document.getElementById('modal-body').innerHTML = htmlContent;
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('modal-body').innerHTML = '<p class="text-red-500 text-center">Gagal memuat materi.</p>';
            });
    }

    function closeMateriModal() {
        modalContent.classList.remove('scale-100', 'opacity-100');
        modalContent.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            modal.classList.add('hidden');
            document.getElementById('modal-body').innerHTML = '<div class="flex justify-center items-center h-full"><div class="animate-spin rounded-full h-12 w-12 border-b-2 border-indigo-600"></div></div>';
        }, 300);
    }

    // Initialize Default Tab
    document.addEventListener('DOMContentLoaded', function() {
        switchTab('materi');
    });
</script>

<style>
    /* Custom Animations */
    @keyframes spin-slow {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    .animate-spin-slow {
        animation: spin-slow 8s linear infinite;
    }
    .font-arabic {
        font-family: 'Amiri', serif; /* Pastikan font arab diload di layout utama jika perlu */
    }
</style>
@endsection