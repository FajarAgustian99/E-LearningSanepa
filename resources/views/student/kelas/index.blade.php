@extends('layouts.student')

@section('title', 'Kelas Saya')

@section('content')
<div class="container mx-auto px-4 py-10">
    <!-- Page Title -->
    <div class="mb-10 text-center">
        <h1 class="text-4xl font-extrabold text-[#0A1D56] tracking-wide animate-fadeIn">
            🎓 Kelas Saya
        </h1>
        <p class="text-gray-600 mt-2 text-lg animate-fadeIn animate-delay-100">
            Pilih kelas untuk mulai belajar.
        </p>
    </div>

    @if($kelas)

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        <div class="bg-white/80 backdrop-blur border border-gray-200 rounded-2xl shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden group animate-fadeIn">
            <!-- Header Card -->
            <div class="h-32 bg-gradient-to-r from-blue-600 to-blue-800 flex items-center justify-center relative">
                <h2 class="text-white text-2xl font-bold group-hover:scale-105 transition">
                    {{ $kelas->name }}
                </h2>
                @if($kelas->teacher)
                <span class="absolute top-2 right-2 bg-white/30 text-white text-xs px-2 py-1 rounded-full backdrop-blur-sm">
                    👨‍🏫 {{ Str::limit($kelas->teacher->name, 15) }}
                </span>
                @endif
            </div>
            <!-- Body Card -->
            <div class="p-6 flex flex-col justify-center items-center text-center">
                <p class="text-gray-700 mb-4 leading-relaxed line-clamp-3">
                    {{ Str::limit($kelas->description, 120) }}
                </p>
                {{-- Tombol Masuk Kelas --}}
                <a href="{{ route('student.courses.index') }}"
                    class="block w-full text-center bg-[#0A1D56] text-white py-2.5 rounded-lg font-semibold hover:bg-[#081a47] transition">
                    Masuk Kelas
                </a>
            </div>
        </div>
    </div>
    @else
    <!-- Tidak ada kelas -->
    <div class="text-center py-20 animate-fadeIn">
        <div class="text-6xl mb-4">📭</div>
        <p class="text-gray-600 text-lg">
            Belum ada kelas tersedia.
            <a href="{{ route('kelas.join.form') }}" class="text-blue-600 hover:underline">
                Gabung kelas sekarang
            </a>
        </p>
    </div>
    @endif
</div>

<style>
    @keyframes fadeIn {
        0% {
            opacity: 0;
            transform: translateY(20px);
        }

        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fadeIn {
        animation: fadeIn 0.5s ease-out forwards;
    }

    .animate-delay-100 {
        animation-delay: 0.1s;
    }
</style>

@endsection