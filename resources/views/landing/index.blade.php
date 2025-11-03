<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IQRAIN - Belajar Hijaiyah Bersama Qira</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Fredoka', sans-serif;
        }
        .gradient-bg {
            background: linear-gradient(135deg, #F387A9 0%, #56B1F3 50%, #FFC801 100%);
        }
        .floating {
            animation: floating 3s ease-in-out infinite;
        }
        @keyframes floating {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        .bounce {
            animation: bounce 2s infinite;
        }
        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
            40% { transform: translateY(-30px); }
            60% { transform: translateY(-15px); }
        }
        .pulse {
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        .text-shadow {
            text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
        }
        .speech-bubble {
            position: relative;
            background: white;
            border-radius: 12px;
            padding: 16px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            border: 4px solid #F387A9;
            max-width: 300px;
        }
        .speech-bubble:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 0;
            border: 15px solid transparent;
            border-top-color: #F387A9;
            border-bottom: 0;
            margin-left: -15px;
            margin-bottom: -15px;
        }
        .qira-character {
            width: 200px;
            height: 200px;
            position: relative;
        }
    </style>
</head>
<body class="gradient-bg min-h-screen overflow-x-hidden">
    <!-- Decorative Elements -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-10 left-10 w-20 h-20 bg-iqrain-yellow rounded-full opacity-20 floating"></div>
        <div class="absolute top-32 right-20 w-16 h-16 bg-iqrain-pink rounded-full opacity-30 floating" style="animation-delay: 1s;"></div>
        <div class="absolute bottom-20 left-20 w-24 h-24 bg-iqrain-blue rounded-full opacity-25 floating" style="animation-delay: 2s;"></div>
        <div class="absolute top-1/2 right-10 w-12 h-12 bg-iqrain-yellow rounded-full opacity-20 floating" style="animation-delay: 0.5s;"></div>
    </div>

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-8 relative z-10">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-6xl md:text-7xl font-bold text-iqrain-dark-blue mb-4 text-shadow">
                IQRAIN
            </h1>
            <p class="text-2xl md:text-3xl text-iqrain-dark-blue font-medium">
                🌈 Platform Belajar Hijaiyah untuk Anak Istimewa 🌈
            </p>
        </div>

        <!-- Main Section with Qira -->
        <div class="flex flex-col lg:flex-row items-center justify-center gap-12 mb-12">
            <!-- Qira Character -->
            <div class="relative">
                <div class="qira-character bounce">
                    <!-- Qira SVG Character -->
                    <svg viewBox="0 0 200 200" class="w-full h-full">
                        <!-- Body -->
                        <ellipse cx="100" cy="140" rx="60" ry="45" fill="#E5E7EB" stroke="#234275" stroke-width="3"/>
                        
                        <!-- Head -->
                        <ellipse cx="100" cy="90" rx="45" ry="38" fill="#E5E7EB" stroke="#234275" stroke-width="3"/>
                        
                        <!-- Ears -->
                        <ellipse cx="70" cy="75" rx="18" ry="25" fill="#E5E7EB" stroke="#234275" stroke-width="3"/>
                        <ellipse cx="130" cy="75" rx="18" ry="25" fill="#E5E7EB" stroke="#234275" stroke-width="3"/>
                        
                        <!-- Eyes -->
                        <circle cx="88" cy="82" r="6" fill="#234275"/>
                        <circle cx="112" cy="82" r="6" fill="#234275"/>
                        <circle cx="90" cy="80" r="2" fill="white"/>
                        <circle cx="114" cy="80" r="2" fill="white"/>
                        
                        <!-- Trunk -->
                        <path d="M 100 105 Q 85 125 90 145 Q 95 165 85 185" stroke="#234275" stroke-width="6" fill="none" stroke-linecap="round"/>
                        
                        <!-- Legs -->
                        <ellipse cx="80" cy="170" rx="8" ry="15" fill="#E5E7EB" stroke="#234275" stroke-width="3"/>
                        <ellipse cx="120" cy="170" rx="8" ry="15" fill="#E5E7EB" stroke="#234275" stroke-width="3"/>
                        
                        <!-- Cute blush -->
                        <ellipse cx="65" cy="85" rx="6" ry="4" fill="#F387A9" opacity="0.6"/>
                        <ellipse cx="135" cy="85" rx="6" ry="4" fill="#F387A9" opacity="0.6"/>
                    </svg>
                </div>
                
                <!-- Speech Bubble -->
                <div class="speech-bubble absolute -top-16 -left-10" id="speechBubble">
                    <p class="text-iqrain-dark-blue font-medium text-center" id="qiraMessage">
                        Halo! Aku Qira, teman belajarmu! 🐘
                    </p>
                </div>
            </div>

            <!-- Welcome Content -->
            <div class="text-center lg:text-left max-w-md">
                <h2 class="text-4xl font-bold text-iqrain-dark-blue mb-6 text-shadow">
                    Bertemu dengan Qira! 🐘
                </h2>
                
                <div class="space-y-4 text-lg text-iqrain-dark-blue">
                    <p class="flex items-center justify-center lg:justify-start gap-3">
                        <span class="text-2xl">👂</span>
                        <span>Qira mendengar dengan cara istimewa, sama sepertimu!</span>
                    </p>
                    <p class="flex items-center justify-center lg:justify-start gap-3">
                        <span class="text-2xl">🧠</span>
                        <span>Qira punya ingatan visual yang super kuat!</span>
                    </p>
                    <p class="flex items-center justify-center lg:justify-start gap-3">
                        <span class="text-2xl">🎮</span>
                        <span>Mari bermain game seru sambil belajar!</span>
                    </p>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center mt-16 text-iqrain-dark-blue">
            <p class="text-lg font-medium">
                🏫 Dikembangkan untuk Yayasan Santi Rama
            </p>
            <p class="text-sm opacity-75 mt-2">
                Platform pembelajaran inklusif untuk anak berkebutuhan khusus
            </p>
        </div>
    </div>

    <!-- Floating Hearts -->
    <div class="fixed bottom-0 left-0 w-full h-full pointer-events-none overflow-hidden">
        <div class="absolute bottom-10 left-1/4 text-iqrain-pink text-3xl floating" style="animation-delay: 0s;">💖</div>
        <div class="absolute bottom-20 left-1/2 text-iqrain-yellow text-2xl floating" style="animation-delay: 1s;">⭐</div>
        <div class="absolute bottom-16 left-3/4 text-iqrain-blue text-3xl floating" style="animation-delay: 2s;">🌟</div>
    </div>

    <script>
        // Qira's rotating messages
        const qiraMessages = [
            "Halo! Aku Qira, teman belajarmu! 🐘",
            "Mari belajar huruf hijaiyah yang seru! ✨", 
            "Dengan aku, belajar jadi lebih menyenangkan! 🎮",
            "Ayo mulai petualangan belajar kita! 🌟"
        ];

        let currentMessageIndex = 0;
        const messageElement = document.getElementById('qiraMessage');

        // Change Qira's message every 3 seconds
        setInterval(() => {
            currentMessageIndex = (currentMessageIndex + 1) % qiraMessages.length;
            messageElement.textContent = qiraMessages[currentMessageIndex];
            
            // Add a little animation
            messageElement.style.opacity = '0';
            setTimeout(() => {
                messageElement.style.opacity = '1';
            }, 200);
        }, 3000);

        // Sound effects (placeholder functions)
        function playClickSound() {
            console.log('Click sound!');
            // You can add actual audio here later
        }

        function playHoverSound() {
            console.log('Hover sound!');
            // You can add actual audio here later
        }

        // Add fade-in animation on page load
        document.addEventListener('DOMContentLoaded', function() {
            document.body.style.opacity = '0';
            document.body.style.transition = 'opacity 1s ease-in-out';
            
            setTimeout(() => {
                document.body.style.opacity = '1';
            }, 100);
        });
    </script>
</body>
</html>