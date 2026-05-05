<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login Admin/Petugas - SPP Bersama</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .navy-blue { background-color: #061a35; }
        .navy-blue-text { color: #061a35; }

        /* Background Slider */
        .bg-slide {
            position: absolute;
            inset: 0;
            opacity: 0;
            transform: translate3d(3%, 0, 0);
            transition: opacity 1.2s cubic-bezier(0.4, 0, 0.2, 1), transform 1.2s cubic-bezier(0.4, 0, 0.2, 1);
            will-change: opacity, transform;
        }
        .bg-slide.active {
            opacity: 1;
            transform: translate3d(0, 0, 0);
        }
        .bg-slide.prev {
            opacity: 0;
            transform: translate3d(-3%, 0, 0);
        }
    </style>
</head>
<body class="font-sans antialiased min-h-screen relative overflow-hidden bg-slate-100">

    <!-- Background Slider -->
    <div id="bg-slider" class="absolute inset-0 z-0 overflow-hidden bg-slate-900">
        <img src="{{ asset('image/sekolah1.jpg') }}" class="bg-slide active w-full h-full object-cover" />
        <img data-src="https://images.unsplash.com/photo-1523050854058-8df90110c9f1?q=80&w=1920&auto=format&fit=crop" class="bg-slide w-full h-full object-cover" />
        <img data-src="https://images.unsplash.com/photo-1509062522246-3755977927d7?q=80&w=1920&auto=format&fit=crop" class="bg-slide w-full h-full object-cover" />
        <img data-src="https://images.unsplash.com/photo-1541339907198-e08756dedf3f?q=80&w=1920&auto=format&fit=crop" class="bg-slide w-full h-full object-cover" />
    </div>

    <!-- Bottom Left Dark Blue Triangle -->
    <div class="absolute inset-0 z-10 navy-blue opacity-[0.98]" style="clip-path: polygon(0 45%, 40% 100%, 0 100%);"></div>

    <!-- Bottom Left Content (Tut Wuri Handayani Logo + Text) -->
    <div class="absolute bottom-8 left-8 z-20 flex items-center gap-4">
        <img src="https://upload.wikimedia.org/wikipedia/commons/9/9c/Logo_of_Ministry_of_Education_and_Culture_of_Republic_of_Indonesia.svg" alt="Tut Wuri Handayani" class="w-[85px] h-auto drop-shadow-xl" />
        <div class="bg-black text-white px-4 py-1.5 rounded-full font-bold text-sm tracking-wider shadow-lg">
            SPP BERSAMA
        </div>
    </div>

    <!-- Center Login Card -->
    <div class="absolute inset-0 z-30 flex items-center justify-center">
        <div class="navy-blue rounded-lg shadow-2xl w-[340px] h-[440px] flex flex-col relative overflow-hidden">
            
            <!-- School Logo -->
            <div class="mt-8 mx-auto flex h-[90px] w-[90px] items-center justify-center bg-transparent">
                <img src="{{ asset('image/logo.png') }}" class="h-full w-full object-contain drop-shadow-lg" alt="School Logo">
            </div>

            <form method="POST" action="{{ route('login') }}" class="px-8 mt-10 flex-1 flex flex-col">
                @csrf
                
                @if($errors->any())
                <div class="mb-4 text-center text-[11px] text-red-400 font-medium bg-red-500/10 py-1 rounded">
                    {{ $errors->first() }}
                </div>
                @endif

                <!-- Username Input -->
                <div class="relative mb-5">
                    <input type="text" name="username" value="{{ old('username') }}" required placeholder="Username Admin/Petugas"
                           class="w-full h-9 px-3 pr-8 text-[13px] text-slate-800 bg-white border-none focus:ring-0 rounded-sm shadow-inner" />
                    <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none text-slate-500">
                        <!-- User Icon -->
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                    </div>
                </div>

                <!-- Password Input -->
                <div class="relative mb-8">
                    <input type="password" name="password" id="password-admin" required placeholder="Password"
                           class="w-full h-9 px-3 pr-8 text-[13px] text-slate-800 bg-white border-none focus:ring-0 rounded-sm shadow-inner" />
                    <button type="button" onclick="togglePassword('password-admin', 'eye-icon-admin')" class="absolute inset-y-0 right-3 flex items-center text-slate-500 hover:text-slate-700">
                        <!-- Eye Slash Icon -->
                        <svg id="eye-icon-admin" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                    </button>
                </div>

                <!-- Login Button -->
                <div class="flex justify-center mt-auto mb-12">
                    <button type="submit" class="border border-white text-white font-bold text-[14px] tracking-wider px-10 py-1.5 rounded-full hover:bg-white hover:text-[#0b213f] transition duration-300">
                        LOGIN
                    </button>
                </div>
            </form>

            <!-- Login as Siswa Link -->
            <a href="{{ route('siswa.login') }}" class="absolute bottom-5 left-6 text-[12px] italic text-[#4ea8de] hover:text-white transition">
                Login sebagai Siswa
            </a>
        </div>
    </div>

    <script>
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            if (input.type === 'password') {
                input.type = 'text';
                icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.543 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />';
            } else {
                input.type = 'password';
                icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>';
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const slides = document.querySelectorAll('#bg-slider .bg-slide');
            if (!slides.length) return;

            // Preload external images
            slides.forEach(slide => {
                if (slide.dataset.src) {
                    const img = new Image();
                    img.onload = () => { slide.src = slide.dataset.src; };
                    img.src = slide.dataset.src;
                }
            });

            let current = 0;
            setInterval(() => {
                const prev = current;
                current = (current + 1) % slides.length;

                // Old slide exits to the left
                slides[prev].classList.remove('active');
                slides[prev].classList.add('prev');

                // New slide enters from the right
                slides[current].classList.remove('prev');
                slides[current].classList.add('active');

                // Clean up prev class after transition ends
                setTimeout(() => {
                    slides[prev].classList.remove('prev');
                }, 1300);
            }, 5000);
        });
    </script>
</body>
</html>
