@extends('layouts.app')

@section('content')
<!-- 3D Background -->
<div id="vanta-bg" class="fixed inset-0"></div>

<!-- Tech overlay -->
<div class="tech-overlay fixed inset-0 pointer-events-none">
    <div class="tech-grid"></div>
    <div class="tech-scanner"></div>
</div>

<div class="min-h-screen flex items-center justify-center px-4 relative z-10">
    <div class="w-full max-w-4xl">
        <div class="relative group">
            <div class="absolute -inset-0.5 bg-gradient-to-r from-white/50 via-[#7EB2FF]/20 to-white/50 rounded-[32px] blur-2xl opacity-70 group-hover:opacity-100 transition-all duration-700"></div>
            
            <div class="relative bg-white/20 backdrop-blur-2xl rounded-[32px] px-16 py-14 border border-white/30 shadow-[0_8px_32px_rgba(126,178,255,0.15)]">
                <div class="text-center max-w-2xl mx-auto">
                    <p class="text-[#7EB2FF] text-4xl font-light leading-relaxed mb-6">
                        "{{ $content }}"
                    </p>
                    <p class="text-[#7EB2FF]/70 italic text-lg">
                        - {{ $author }}
                    </p>
                </div>
            </div>
        </div>
        
        <div class="text-center mt-8">
            <a href="{{ route('home') }}" class="text-[#7EB2FF] hover:text-[#7EB2FF]/80 transition-colors">
                ← {{ __('messages.back_to_home') }}
            </a>
        </div>
    </div>
</div>

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
</style>

<script>
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
</script>
@endsection 