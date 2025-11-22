<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Memory Card Game</title>

    <script>
        var ASSET_BASE = "{{ asset('') }}";            
        var JENIS_GAME_ID = {{ $jenisGame->jenis_game_id }};
        var POIN_MAKSIMAL = {{ $jenisGame->poin_maksimal ?? 100 }};
    </script> 

    @vite(['resources/css/app.css', 'resources/js/memory-card.js'])           
</head>
<body>
    {{-- Main --}}
    <div class="font-sans text-center min-h-screen flex flex-col bg-gradient-to-b from-[#56B1F3] to-[#D3F2FF]">
        {{-- Tombol Kembali --}}
        <div class="p-4">    
            <a href="{{ route('murid.games.index', $tingkatan->tingkatan_id) }}"
                class="relative flex items-center justify-center w-[140px] h-[45px] rounded-full bg-pink-400 shadow-md transition-transform hover:scale-105">        
                {{-- icon < --}}
                <div class="absolute left-4 flex items-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </div>                    
                <span class="font-['TegakBersambung'] text-white text-[25px] font-normal leading-none pt-2 pl-4">
                    Kembali
                </span>
            </a>
        </div>

        {{-- Balon kiri --}}
        <div class="fixed left-4 top-1/3 w-40 md:w-50 h-auto animate-bounce-slow z-10 pointer-events-none">
            <img src="{{ asset('images/icon/balon.webp') }}" alt="Balon Kiri" class="w-full h-auto drop-shadow-lg">
        </div>

        {{-- Letak Game utama nya --}}
        <main class="relative z-20 flex-grow flex flex-col items-center pt-8">        
            <div class="flex justify-between items-center w-full max-w-[420px] mb-5 px-3">
                <div class="flex items-center gap-2.5">
                    <span class="font-['TegakBersambung'] text-3xl font-bold text-[#ffffff]">Poin :</span>
                    <div class="bg-gradient-to-br from-[#E897BA] to-[#D084A8] text-white px-7 py-2 rounded-full text-xl font-bold shadow-md">
                        <span id="poin-benar">0</span>
                    </div>
                </div>
                <div class="text-2xl font-bold text-[#ffffff]">
                    <span id="current-matches">0</span>/6
                </div>
                <button
                    id="reset-button"
                    class="font-['TegakBersambung'] bg-white text-[#D084A8] border-2 border-[#D084A8] px-5 py-2 rounded-full text-base font-bold cursor-pointer shadow-sm transition-all duration-300 hover:bg-[#D084A8] hover:text-white"
                >
                    ↻ Main lagi
                </button>
            </div>

            <div id="board" class="w-fit mx-auto grid grid-cols-4 gap-3 p-5 bg-white border-[12px] border-pink-200 rounded-3xl shadow-2xl">
            </div>

        </main>

        {{-- Balon kanan --}}
        <div class="fixed right-4 top-1/4 w-40 md:w-50 h-auto animate-bounce-slow z-10 pointer-events-none">
            <img src="{{ asset('images/icon/balon.webp') }}" alt="Balon Kanan" class="w-full h-auto drop-shadow-lg transform scale-x-[-1]"> 
        </div>

        {{-- Ucapan selamat datang --}}
        <div id="welcome-backdrop" class="fixed inset-0 z-40 transition-opacity duration-1000" style="background-color: rgba(0, 0, 0, 0.6);"></div>
        <h1 id="welcome-message" class="font-['TegakBersambung'] fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 z-50 
                                    font-sans text-7xl md:text-8xl font-bold text-white 
                                    opacity-0 transition-opacity duration-1000 ease-out"
                                    style="text-shadow: 0 4px 10px rgba(0, 0, 0, 0.5);">
            Selamat Datang!
        </h1> 
    </div>    
</body>
</html>