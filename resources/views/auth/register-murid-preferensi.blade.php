<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Isi Pertanyaan Dulu Yuk - IQRAIN</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-[var(--color-iqrain-blue)]">

    <div class="max-w-7xl mx-auto py-10 px-6 relative">
        <div class="lg:w-[calc(100%-500px)] lg:pr-10">

        <!-- Judul -->
        <h1 class="text-4xl lg:text-5xl font-titan text-white mb-6"
            style="text-shadow: 2px 2px 4px rgba(0,0,0,0.1);">
            Isi Pertanyaan Dulu Yuk
        </h1>

        <!-- Subjudul -->
        <p class="text-white text-lg mb-4 opacity-90">
            Pertanyaan keamanan jika kamu lupa password
        </p>

        
        <div class="flex items-center mb-8 space-x-3">
            <div class="w-3 h-3 rounded-full bg-white opacity-60"></div> 
            <div class="w-8 h-8 rounded-full bg-yellow-400 text-white flex items-center justify-center font-bold">2</div>
            <div class="w-3 h-3 rounded-full bg-white opacity-60"></div>
        </div>

        <!-- Error -->
        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-100 border-l-4 border-red-600 text-red-700 rounded">
                <ul class="list-disc ml-5 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- FORM -->
        <form method="POST" action="{{ route('register.murid.post') }}">
            @csrf
            <input type="hidden" name="step" value="2">

            <div class="bg-white rounded-2xl p-6 shadow-lg border-2 border-white">

                <!-- Pertanyaan -->
                <label class="text-gray-800 font-semibold block mb-3">
                    Pertanyaan Keamanan
                </label>

                <div class="w-full px-4 py-3 bg-blue-50 border-2 border-blue-300 rounded-xl mb-3">
                    <p class="text-gray-700 font-medium">Apa warna kesukaanmu?</p>
                </div>
                <input type="hidden" name="pertanyaan" value="Apa warna kesukaanmu?">

                <!-- Jawaban -->
                <input 
                    type="text" 
                    name="jawaban"
                    value="{{ old('jawaban') }}"
                    required
                    autofocus
                    class="w-full px-4 py-3 rounded-xl border-2 border-white bg-white text-gray-800 
                           focus:ring-2 focus:ring-yellow-300"
                    placeholder="Contoh: Merah, Biru, Hijau..."
                >

                <p class="text-xs text-gray-600 mt-2">
                    💡 <strong>Tips:</strong> Ingat baik-baik jawabanmu ya! Jawaban ini akan dipakai jika kamu lupa password.
                </p>

                <!-- Info Box -->
                <div class="bg-yellow-50 rounded-xl p-4 mt-4 border border-yellow-300">
                    <p class="text-sm text-gray-700">
                        <strong>Kenapa hanya 1 pertanyaan?</strong><br>
                        Supaya lebih mudah diingat! Cukup ingat warna kesukaanmu saja 🌈
                    </p>
                </div>

            </div>

            <!-- Button -->
            <div class="mt-6 flex space-x-4">
                <a href="{{ route('register.murid') }}"
                    class="bg-gray-300 text-gray-800 font-bold py-3 px-10 rounded-xl shadow-lg 
                           hover:bg-gray-400 transition text-center flex-1">
                    Kembali
                </a>

                <button type="submit"
                    class="flex-1 bg-pink-400 text-white font-bold py-3 px-10 rounded-xl shadow-lg
                           hover:bg-pink-500 transition">
                    Daftar
                </button>
            </div>
        </form>

        <!-- LINE -->
        <div class="border-t border-white mt-10 pt-4">
            <p class="text-white">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="text-yellow-300 underline">Login di sini</a>
            </p>
        </div>
    </div>
</div>

    <!-- Panel Kanan -->
    <div class="absolute top-0 right-0 w-[500px] h-full hidden lg:block overflow-hidden">
        <img src="{{ asset('images/pattern/wafe-regist.webp') }}" 
            class="h-full object-fill"
            style="width: 700px; position: absolute; left: 0px;">
        <img src="{{ asset('images/maskot/ceria.webp') }}" 
            class="absolute bottom-0 right-0 w-[450px]">
    </div>

</body>
</html>
