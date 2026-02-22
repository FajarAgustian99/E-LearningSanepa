<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'E-Learning Sanepa') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800" rel="stylesheet">

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 text-gray-800 font-['Instrument_Sans'] antialiased">

    <!-- ==================== HEADER ==================== -->
    <header class="bg-white shadow-sm sticky top-0 z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">

            <!-- Logo -->
            <a href="/" class="text-2xl font-extrabold text-[#DC143C] tracking-tight flex items-center">
                <i class="fas fa-graduation-cap mr-2"></i>
                E-Learning Sanepa
            </a>
            <div class="flex justify-center lg:justify-start mb-3 lg:mb-0">
                <img src="{{ asset('storage/banner/kcdiv.png') }}" alt="" class="w-28 md:w-36 lg:w-28 h-auto object-contain">
                <img src="{{ asset('storage/banner/sanepa.png') }}" alt="" class="w-14 md:w-18 lg:w-15 h-auto object-contain">
            </div>
            <!-- <div class="flex justify-center lg:justify-start mb-3 lg:mb-0">
                
            </div> -->
            <!-- Navigation -->
            <nav class="space-x-4">
                @if (Route::has('login'))
                <a href="{{ route('login') }}"
                    class="px-4 py-2 text-sm font-semibold bg-[#00008B] text-white rounded-lg shadow-md hover:bg-[#1546cc] transition">
                    Masuk
                </a>
                @endif
            </nav>

        </div>
    </header>

    <!-- ==================== HERO SECTION ==================== -->
    <section class="py-5 lg:py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-4 grid lg:grid-cols-2 gap-12 items-center">

            <!-- LEFT TEXT -->
            <div>
                <span class="text-sm font-bold uppercase tracking-widest text-[#1a56ff] bg-[#e6eeff] px-3 py-1 rounded-full inline-block mb-4">
                    #sanepajuara
                </span>

                <h1 class="text-5xl lg:text-6xl font-extrabold text-gray-900 leading-tight mb-6">
                    Sistem Informasi <span class="text-[#1a56ff]">Pembelajaran</span> Digital.
                    <br>SMA Negeri 1 Pabuaran
                </h1>

                <p class="text-xl text-gray-500 max-w-lg mb-8">
                    Sanepa Juara Sanepa Untuk Indonesia
                </p>

                <a href="{{ route('login') }}"
                    class="px-6 py-3 bg-[#00008B] text-white font-semibold rounded-lg shadow-md hover:bg-[#1546cc] transition">
                    Mulai Belajar Sekarang
                </a>
            </div>

            <!-- RIGHT IMAGE -->
            <div class="flex justify-center">
                <img src="{{ asset('storage/banner/banner.png') }}"
                    alt="Sanepa Hero Image">
            </div>


        </div>
    </section>

    <hr class="border-gray-200">

    <!-- ==================== FEATURES ==================== -->
    <section id="features" class="py-16 lg:py-24 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <h2 class="text-3xl font-bold text-center text-gray-900 mb-4">
                Fitur Unggulan Kami
            </h2>

            <p class="text-lg text-center text-gray-500 mb-12">
                Fasilitas terbaik untuk pengalaman belajar yang optimal.
            </p>

            <div class="grid md:grid-cols-3 gap-10">

                <!-- Card 1 -->
                <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition border border-gray-100">
                    <div class="text-4xl text-green-500 mb-4">
                        <i class="fas fa-laptop-code"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Akses Seumur Hidup</h3>
                    <p class="text-gray-500">Bayar sekali, dan semua materi dapat diakses selamanya termasuk update terbaru.</p>
                </div>

                <!-- Card 2 -->
                <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition border border-gray-100">
                    <div class="text-4xl text-[#1a56ff] mb-4">
                        <i class="fas fa-certificate"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Sertifikat Resmi</h3>
                    <p class="text-gray-500">Selesaikan kursus dan dapatkan sertifikat yang meningkatkan nilai portofolio Anda.</p>
                </div>

                <!-- Card 3 -->
                <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition border border-gray-100">
                    <div class="text-4xl text-yellow-500 mb-4">
                        <i class="fas fa-users-cog"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Dukungan Tutor</h3>
                    <p class="text-gray-500">Bertanya langsung kepada tutor ahli kapan pun Anda mengalami kesulitan.</p>
                </div>

            </div>
        </div>
    </section>

    <!-- ==================== FOOTER ==================== -->
    <footer class="bg-gray-800 text-white py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">

            <p class="text-sm">
                &copy; {{ date('Y') }}.
                <span class="text-gray-400">Hak Cipta Fajar Agustian.</span>
            </p>

            <div class="mt-2 space-x-4 text-xs">
                <a href="#" class="text-gray-400 hover:text-[#1a56ff] transition">Kebijakan Privasi</a>
                <a href="#" class="text-gray-400 hover:text-[#1a56ff] transition">Syarat & Ketentuan</a>
            </div>

        </div>
    </footer>
    <!-- ==================== ANIMASI CSS ==================== -->
    <style>
        @keyframes fadeUp {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeRight {
            0% {
                opacity: 0;
                transform: translateX(20px);
            }

            100% {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .animate-fade-up {
            opacity: 0;
            transform: translateY(20px);
            animation-fill-mode: forwards;
        }

        .animate-fade-right {
            opacity: 0;
            transform: translateX(20px);
            animation-fill-mode: forwards;
        }
    </style>
</body>

</html>