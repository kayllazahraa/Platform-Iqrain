{{-- resources/views/layouts/murid.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IQRAIN - Profil Murid</title>
    
    {{-- Tailwind CSS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    {{-- Livewire Styles --}}
    @livewireStyles
    
    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    {{-- SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gray-50 h-screen overflow-hidden">
    
    {{-- Main Content --}}
    {{ $slot }}

    {{-- Footer - Fixed at Bottom --}}
    <div class="fixed bottom-0 left-0 w-full z-0 pointer-events-none">
        <img src="{{ asset('images/games/game-footer.webp') }}" alt="Footer Decoration"
            class="w-full h-auto object-cover block select-none">
    </div>
    
    {{-- Livewire Scripts --}}
    @livewireScripts

    @stack('scripts')
</body>
</html>