<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cloud of Kindness</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@200;300;400&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vanta@latest/dist/vanta.fog.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-outfit bg-[#F8FBFF] min-h-screen overflow-hidden">
    <!-- 3D Background -->
    <div id="vanta-bg" class="fixed inset-0"></div>

    <!-- Add these new elements right after the opening <body> tag -->
    <div class="tech-overlay fixed inset-0 pointer-events-none">
        <div class="tech-grid"></div>
        <div class="tech-scanner"></div>
    </div>

    <!-- Add this right after the opening body tag -->
    <div class="fixed top-4 right-4 z-50 flex gap-2">
        <form action="{{ url('language/en') }}" method="POST" class="inline" onsubmit="handleLanguageSwitch(event)">
            @csrf
            <button type="submit" 
                class="px-3 py-1 rounded-md bg-white/20 backdrop-blur-xl text-[#7EB2FF] hover:bg-white/30 transition-all duration-300 {{ app()->getLocale() === 'en' ? 'border-2 border-[#7EB2FF]/50' : '' }}">
                EN
            </button>
        </form>
        <form action="{{ url('language/sq') }}" method="POST" class="inline" onsubmit="handleLanguageSwitch(event)">
            @csrf
            <button type="submit" 
                class="px-3 py-1 rounded-md bg-white/20 backdrop-blur-xl text-[#7EB2FF] hover:bg-white/30 transition-all duration-300 {{ app()->getLocale() === 'sq' ? 'border-2 border-[#7EB2FF]/50' : '' }}">
                SQ
            </button>
        </form>
    </div>

    <main class="relative z-10 min-h-screen flex flex-col items-center justify-between py-16 px-6">
        <!-- Refined Title Section -->
        <div class="w-full text-center mb-12">
            <div class="relative inline-block">
                <!-- Tech decorative elements - back to 1px thin lines -->
                <div class="absolute -left-8 top-1/2 w-16 h-[1px] bg-gradient-to-r from-[#7EB2FF]/0 via-[#7EB2FF]/80 to-[#7EB2FF]/0"></div>
                <div class="absolute -right-8 top-1/2 w-16 h-[1px] bg-gradient-to-l from-[#7EB2FF]/0 via-[#7EB2FF]/80 to-[#7EB2FF]/0"></div>
                
                <h1 class="text-[84px] sm:text-[96px] font-extralight tracking-[0.25em] leading-tight text-[#7EB2FF] title-glow title-animation crisp-text">
                    {{ __('messages.title') }}
                </h1>

                <!-- Keep the tech circles -->
                <div class="absolute -left-4 -top-4 w-8 h-8 rounded-full border-2 border-[#7EB2FF]/60 tech-circle"></div>
                <div class="absolute -right-4 -bottom-4 w-8 h-8 rounded-full border-2 border-[#7EB2FF]/60 tech-circle"></div>
            </div>
        </div>

        <!-- Add this right before the main card -->
        <div class="tech-status absolute top-6 left-6 text-xs font-light tracking-wider text-[#7EB2FF]/70">
            <div class="flex items-center gap-2 mb-1">
                <div class="w-2 h-2 rounded-full bg-[#7EB2FF]/50 pulse-dot"></div>
                <span>{{ __('messages.sys_status') }}</span>
            </div>
            <div class="flex items-center gap-2">
                <div class="h-[1px] w-12 bg-gradient-to-r from-[#7EB2FF]/0 via-[#7EB2FF]/50 to-[#7EB2FF]/0"></div>
                <span class="typewriter">{{ __('messages.initializing') }}</span>
            </div>
        </div>

        <!-- Add this right after your title -->
        <script>
            window.routes = {
                random: '{{ route('compliments.random') }}'
            };
        </script>

        <!-- Enhanced Main Card Section -->
        <div class="w-full max-w-4xl transform hover:scale-[1.01] transition-all duration-700">
            <div class="relative group">
                <!-- Premium Glow Effect -->
                <div class="absolute -inset-0.5 bg-gradient-to-r from-white/50 via-[#7EB2FF]/20 to-white/50 rounded-[32px] blur-2xl opacity-70 group-hover:opacity-100 transition-all duration-700"></div>
                
                <!-- Refined Card Design -->
                <div class="relative bg-white/20 backdrop-blur-2xl rounded-[32px] px-16 py-14 border border-white/30 shadow-[0_8px_32px_rgba(126,178,255,0.15)]">
                    <div id="compliment-display" class="text-center max-w-2xl mx-auto">
                        <p class="text-[#7EB2FF] text-4xl font-light leading-relaxed mb-6">
                            "{{ $randomCompliment->content }}"
                        </p>
                        <p class="text-[#7EB2FF]/70 italic text-lg mb-4">
                            - {{ $randomCompliment->author ?? 'Cloud of Kindness' }}
                        </p>
                        <!-- Add share button -->
                        <div class="flex justify-center mt-6">
                            <button onclick="shareCompliment()" class="group relative inline-flex items-center transform hover:scale-105 transition-all duration-500">
                                <div class="absolute -inset-1 bg-gradient-to-r from-[#7EB2FF]/30 via-white/40 to-[#7EB2FF]/30 rounded-xl blur-xl opacity-75 group-hover:opacity-100 transition-all duration-500"></div>
                                <div class="relative flex items-center gap-4 px-8 py-3 bg-white/30 backdrop-blur-xl rounded-xl border border-white/40">
                                    <i class="fas fa-share-alt text-[#7EB2FF]"></i>
                                    <span class="text-[#7EB2FF] text-sm tracking-[0.3em] font-light">{{ __('messages.share') }}</span>
                                </div>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Premium Generate Button -->
            <div class="text-center -mb-6 mt-12 relative z-10">
                <button id="new-compliment" class="group relative inline-flex items-center transform hover:scale-105 transition-all duration-500">
                    <div class="absolute -inset-1 bg-gradient-to-r from-[#7EB2FF]/30 via-white/40 to-[#7EB2FF]/30 rounded-xl blur-xl opacity-75 group-hover:opacity-100 transition-all duration-500"></div>
                    <div class="relative flex items-center gap-4 px-8 py-3 bg-white/30 backdrop-blur-xl rounded-xl border border-white/40">
                        <span class="text-[#7EB2FF]/70 text-xs tracking-[0.3em] font-light">sys.32</span>
                        <span class="text-[#7EB2FF] text-sm tracking-[0.3em] font-light">{{ __('messages.generate') }}</span>
                    </div>
                </button>
            </div>

            <!-- Add this to your existing style section -->
            <style>
                .tech-grid {
                    position: fixed;
                    inset: 0;
                    background-image: 
                        linear-gradient(to right, rgba(126, 178, 255, 0.03) 1px, transparent 1px),
                        linear-gradient(to bottom, rgba(126, 178, 255, 0.03) 1px, transparent 1px);
                    background-size: 50px 50px;
                    mask-image: radial-gradient(circle at center, black, transparent);
                }

                .tech-scanner {
                    position: fixed;
                    top: 0;
                    left: 0;
                    right: 0;
                    height: 100vh;
                    background: linear-gradient(
                        to bottom,
                        transparent 0%,
                        rgba(126, 178, 255, 0.05) 50%,
                        transparent 100%
                    );
                    animation: scan 8s ease-in-out infinite;
                    transform: translateY(-100%);
                }

                @keyframes scan {
                    0%, 100% { transform: translateY(-100%); }
                    50% { transform: translateY(100%); }
                }

                .pulse-dot {
                    animation: pulse 2s infinite;
                }

                .typewriter {
                    overflow: hidden;
                    white-space: nowrap;
                    border-right: 2px solid rgba(126, 178, 255, 0.5);
                    animation: typing 3s steps(30) infinite, blink 1s step-end infinite;
                    width: fit-content;
                }

                @keyframes typing {
                    from { width: 0 }
                    to { width: 100% }
                }

                @keyframes blink {
                    50% { border-color: transparent }
                }

                /* Enhanced card interactions */
                .group:hover .backdrop-blur-2xl {
                    backdrop-filter: blur(32px) saturate(200%);
                    transition: all 0.5s ease-out;
                }

                /* Add data visualization effect */
                .data-stream {
                    position: absolute;
                    top: 0;
                    right: 0;
                    width: 1px;
                    height: 100%;
                    background: linear-gradient(to bottom, 
                        transparent,
                        rgba(126, 178, 255, 0.5),
                        transparent
                    );
                    animation: dataFlow 2s ease-in-out infinite;
                    opacity: 0;
                }

                .group:hover .data-stream {
                    opacity: 1;
                }

                @keyframes dataFlow {
                    0% { transform: translateY(-100%); }
                    100% { transform: translateY(100%); }
                }
            </style>

            <!-- Add this to your main card div -->
            <div class="data-stream"></div>
        </div>

        <!-- Optimized Category Grid -->
        <div class="w-full max-w-6xl px-4 mt-20">
            <div class="grid grid-cols-5 gap-4">
                @foreach($categories as $category)
                <div class="group transform hover:scale-[1.03] transition-all duration-500 hover:-translate-y-1">
                    <button 
                        type="button"
                        onclick="generateCompliment('{{ $category->id }}')"
                        class="w-full text-left focus:outline-none"
                    >
                        <div class="relative">
                            <!-- Refined card glow -->
                            <div class="absolute -inset-0.5 bg-gradient-to-b from-white/30 to-[#7EB2FF]/10 rounded-2xl blur-lg opacity-0 group-hover:opacity-100 transition-all duration-500"></div>
                            
                            <!-- Optimized card design -->
                            <div class="relative bg-white/20 backdrop-blur-xl rounded-2xl p-5 border border-white/30 shadow-lg h-[200px] flex flex-col items-center justify-between">
                                <!-- Icon container -->
                                <div class="w-12 h-12 flex items-center justify-center bg-white/40 rounded-xl mb-4
                                          transform transition-all duration-500 group-hover:scale-110 group-hover:bg-white/50
                                          shadow-[0_8px_16px_rgba(126,178,255,0.1)]">
                                    <i class="fas {{ $category->icon }} text-[#7EB2FF] text-xl"></i>
                                </div>
                                
                                <div class="text-center">
                                    <h3 class="text-[#7EB2FF] font-light text-base mb-2">
                                        {{ __("messages.categories.{$category->slug}.name") }}
                                    </h3>
                                    <p class="text-[#7EB2FF]/70 text-xs leading-relaxed">
                                        {{ __("messages.categories.{$category->slug}.description") }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </button>
                </div>
                @endforeach
            </div>
        </div>
    </main>

    <!-- Add this right after your main card div -->
    <div id="voice-control" class="fixed bottom-6 right-6 flex items-center gap-4">
        <div id="voice-status" class="text-[#7EB2FF] text-sm hidden">
            <span class="animate-pulse">Listening...</span>
        </div>
        <button 
            onclick="toggleVoiceRecognition()"
            class="group relative inline-flex items-center transform hover:scale-105 transition-all duration-500"
        >
            <div class="absolute -inset-1 bg-gradient-to-r from-[#7EB2FF]/30 via-white/40 to-[#7EB2FF]/30 rounded-full blur-xl opacity-75 group-hover:opacity-100 transition-all duration-500"></div>
            <div class="relative p-4 bg-white/30 backdrop-blur-xl rounded-full border border-white/40">
                <i id="mic-icon" class="fas fa-microphone text-[#7EB2FF] text-xl"></i>
            </div>
        </button>
    </div>

    <style>
        .crisp-text {
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            text-rendering: geometricPrecision;
        }

        .title-glow {
            text-shadow: 
                0 0 30px rgba(126, 178, 255, 0.4),
                0 0 60px rgba(126, 178, 255, 0.2),
                0 0 90px rgba(126, 178, 255, 0.1),
                0 1px 0 rgba(255, 255, 255, 0.4),
                0 -1px 0 rgba(255, 255, 255, 0.2);
            position: relative;
            color: rgba(126, 178, 255, 1);  /* Solid color instead of gradient */
            letter-spacing: 0.25em;
            font-weight: 300;
        }

        .title-animation {
            animation: titleFloat 6s ease-in-out infinite;
            will-change: transform;
            backface-visibility: hidden;
            -webkit-backface-visibility: hidden;
            transform: translateZ(0);
            -webkit-transform: translateZ(0);
        }

        @keyframes titleFloat {
            0%, 100% { transform: translateY(0) translateX(0); }
            50% { transform: translateY(-10px) translateX(5px); }
        }

        .tech-circle {
            animation: pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        .tech-circle:nth-child(2) {
            animation-delay: 2s;
        }

        @keyframes pulse {
            0%, 100% { 
                transform: scale(1);
                opacity: 0.2;
            }
            50% { 
                transform: scale(1.5);
                opacity: 0;
            }
        }

        /* Enhanced backdrop blur for better text rendering */
        .backdrop-blur-xl {
            backdrop-filter: blur(24px) saturate(180%);
            -webkit-backdrop-filter: blur(24px) saturate(180%);
        }

        #compliment-display {
            transition: all 0.7s cubic-bezier(0.4, 0, 0.2, 1);
        }
    </style>

    <script>
        // Initialize VANTA background
        VANTA.FOG({
            el: "#vanta-bg",
            mouseControls: true,
            touchControls: true,
            gyroControls: false,
            minHeight: 200.00,
            minWidth: 200.00,
            highlightColor: 0x7eb2ff,
            midtoneColor: 0xffffff,
            lowlightColor: 0xebf5ff,
            baseColor: 0xffffff,
            blurFactor: 0.6,
            speed: 1.00,
            zoom: 1.50
        });

        // Global variables
        const complimentDisplay = document.getElementById('compliment-display');
        const newComplimentBtn = document.getElementById('new-compliment');
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
        let currentComplimentId;

        // Generate compliment function
        async function generateCompliment(categoryId = null) {
            try {
                gsap.to(complimentDisplay, {
                    opacity: 0,
                    y: 20,
                    duration: 0.3,
                    ease: "power2.inOut",
                    onComplete: async () => {
                        try {
                            let url = window.routes.random;
                            if (categoryId) {
                                url += `?category=${categoryId}`;
                            }

                            const response = await fetch(url);
                            if (!response.ok) throw new Error('Failed to fetch compliment');
                            
                            const data = await response.json();
                            currentComplimentId = data.id;

                            complimentDisplay.innerHTML = `
                                <p class="text-[#7EB2FF] text-4xl font-light leading-relaxed mb-6">
                                    "${data.content}"
                                </p>
                                <p class="text-[#7EB2FF]/70 italic text-lg mb-4">
                                    - ${data.author}
                                </p>
                                <div class="flex justify-center mt-6">
                                    <button onclick="shareCompliment()" class="group relative inline-flex items-center transform hover:scale-105 transition-all duration-500">
                                        <div class="absolute -inset-1 bg-gradient-to-r from-[#7EB2FF]/30 via-white/40 to-[#7EB2FF]/30 rounded-xl blur-xl opacity-75 group-hover:opacity-100 transition-all duration-500"></div>
                                        <div class="relative flex items-center gap-4 px-8 py-3 bg-white/30 backdrop-blur-xl rounded-xl border border-white/40">
                                            <i class="fas fa-share-alt text-[#7EB2FF]"></i>
                                            <span class="text-[#7EB2FF] text-sm tracking-[0.3em] font-light">{{ __('messages.share') }}</span>
                                        </div>
                                    </button>
                                </div>
                            `;
                            
                            gsap.to(complimentDisplay, {
                                opacity: 1,
                                y: 0,
                                duration: 0.5,
                                ease: "power2.out"
                            });
                        } catch (error) {
                            console.error('Fetch error:', error);
                            complimentDisplay.innerHTML = `
                                <p class="text-[#7EB2FF] text-4xl font-light leading-relaxed mb-6">
                                    "Something went wrong. Please try again."
                                </p>
                                <p class="text-[#7EB2FF]/70 italic text-lg">
                                    - System
                                </p>
                            `;
                            gsap.to(complimentDisplay, {
                                opacity: 1,
                                y: 0,
                                duration: 0.5
                            });
                        }
                    }
                });
            } catch (error) {
                console.error('Animation error:', error);
            }
        }

        // Share function
        async function shareCompliment() {
            try {
                const complimentText = document.querySelector('#compliment-display p:first-child').textContent;
                
                if (navigator.share) {
                    await navigator.share({
                        title: 'Cloud of Kindness',
                        text: complimentText,
                        url: window.location.origin
                    });
                } else {
                    await navigator.clipboard.writeText(complimentText);
                    alert('Compliment copied to clipboard!');
                }
            } catch (error) {
                console.error('Error sharing:', error);
            }
        }

        // Event Listeners
        newComplimentBtn.addEventListener('click', () => generateCompliment());

        // Add loading state to buttons
        document.querySelectorAll('button').forEach(button => {
            button.addEventListener('click', function() {
                this.classList.add('pointer-events-none', 'opacity-75');
                setTimeout(() => {
                    this.classList.remove('pointer-events-none', 'opacity-75');
                }, 1000);
            });
        });

        // Add smooth parallax effect
        document.addEventListener('mousemove', (e) => {
            const cards = document.querySelectorAll('.group');
            const mouseX = (e.clientX / window.innerWidth - 0.5) * 20;
            const mouseY = (e.clientY / window.innerHeight - 0.5) * 20;

            cards.forEach(card => {
                card.style.transform = `translate(${mouseX}px, ${mouseY}px)`;
            });
        });

        // Add keyboard shortcuts
        document.addEventListener('keydown', (e) => {
            if (e.code === 'Space') {
                e.preventDefault();
                generateCompliment();
            }
        });

        // Add performance monitoring
        const perfMonitor = {
            start: performance.now(),
            measure() {
                const duration = performance.now() - this.start;
                console.log(`Render time: ${duration.toFixed(2)}ms`);
                this.start = performance.now();
            }
        };

        // Monitor performance every second
        setInterval(() => perfMonitor.measure(), 1000);

        function handleLanguageSwitch(event) {
            event.preventDefault();
            const form = event.target;
            
            fetch(form.action, {
                method: 'POST',
                body: new FormData(form),
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            }).then(() => {
                window.location.reload();
            });
        }

        let recognition = null;
        let isListening = false;

        function initializeVoiceRecognition() {
            if (!('webkitSpeechRecognition' in window) && !('SpeechRecognition' in window)) {
                console.error('Voice recognition not supported');
                return;
            }

            recognition = new (window.SpeechRecognition || window.webkitSpeechRecognition)();
            recognition.continuous = false;
            recognition.interimResults = false;
            recognition.lang = '{{ app()->getLocale() === "sq" ? "sq-AL" : "en-US" }}';

            recognition.onstart = () => {
                isListening = true;
                document.getElementById('voice-status').classList.remove('hidden');
                document.getElementById('mic-icon').classList.add('text-red-500');
                
                // Add visual feedback
                gsap.to('#voice-control', {
                    scale: 1.1,
                    duration: 0.3
                });
            };

            recognition.onend = () => {
                isListening = false;
                document.getElementById('voice-status').classList.add('hidden');
                document.getElementById('mic-icon').classList.remove('text-red-500');
                
                gsap.to('#voice-control', {
                    scale: 1,
                    duration: 0.3
                });
            };

            recognition.onresult = async (event) => {
                const command = event.results[0][0].transcript.toLowerCase();
                
                try {
                    const response = await fetch('{{ route("voice.command") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({ command })
                    });

                    const data = await response.json();
                    
                    if (data.success && data.action === 'generate') {
                        complimentDisplay.innerHTML = `
                            <p class="text-[#7EB2FF] text-4xl font-light leading-relaxed mb-6">
                                "${data.content}"
                            </p>
                            <p class="text-[#7EB2FF]/70 italic text-lg mb-4">
                                - ${data.author}
                            </p>
                        `;
                    }
                } catch (error) {
                    console.error('Voice command error:', error);
                }
            };

            recognition.onerror = (event) => {
                console.error('Voice recognition error:', event.error);
                isListening = false;
            };
        }

        function toggleVoiceRecognition() {
            if (!recognition) {
                initializeVoiceRecognition();
            }
            
            if (isListening) {
                recognition.stop();
            } else {
                recognition.start();
            }
        }

        // Initialize voice recognition when the page loads
        document.addEventListener('DOMContentLoaded', initializeVoiceRecognition);
    </script>

    <!-- Add this temporarily somewhere visible in your view -->
    <div class="fixed bottom-4 left-4 text-[#7EB2FF] text-xs">
        Current locale: {{ app()->getLocale() }}<br>
        Session locale: {{ session()->get('locale') }}
    </div>
</body>
</html> 