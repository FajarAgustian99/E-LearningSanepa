@extends('layouts.student')

@section('title', 'Mata Pelajaran')

@section('content')
<div class="container mx-auto px-4 py-10">

    <!-- ==========================
         HEADER HALAMAN
    =========================== -->
    <div class="mb-10 text-center">
        <h1 class="text-4xl font-extrabold text-[#0A1D56] tracking-wide animate-fadeIn">
            📚 Mata Pelajaran
        </h1>
        <p class="text-gray-600 mt-2 text-lg animate-fadeIn animate-delay-100">
            Pilih mata pelajaran untuk mulai belajar.
        </p>
    </div>

    <!-- ==========================
         DAFTAR MATA PELAJARAN
    =========================== -->
    @if($courses->count())
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">

        @foreach($courses as $course)
        <div class="bg-white/80 backdrop-blur border border-gray-200 rounded-2xl shadow-md
                    hover:shadow-xl hover:-translate-y-1 transition-all duration-300
                    overflow-hidden group animate-fadeIn">

            <!-- ======================
                 HEADER KARTU (GAMBAR)
            ======================= -->
            <div class="h-40 relative overflow-hidden">

                {{-- Gambar Mapel --}}
                @if($course->image)
                <img
                    src="{{ asset('storage/' . $course->image) }}"
                    alt="Gambar {{ $course->title }}"
                    class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                @else
                {{-- Fallback jika tidak ada gambar --}}
                <div class="w-full h-full bg-gradient-to-r from-blue-600 to-blue-800
                                flex items-center justify-center">
                    <span class="text-white text-xl font-bold text-center px-2">
                        {{ $course->title }}
                    </span>
                </div>
                @endif

                {{-- Overlay --}}
                <div class="absolute inset-0 bg-black/40 flex items-center justify-center">
                    <h2 class="text-white text-2xl font-bold text-center px-3">
                        {{ $course->title }}
                    </h2>
                </div>

                {{-- Nama Guru --}}
                @if($course->teacher)
                <span class="absolute top-2 right-2 bg-white/30 text-white text-xs px-2 py-1
                             rounded-full backdrop-blur-sm">
                    👨‍🏫 {{ Str::limit($course->teacher->name, 15) }}
                </span>
                @endif

            </div>

            <!-- ======================
                 ISI KARTU
            ======================= -->
            <div class="p-6 flex flex-col justify-between h-[230px]">

                <!-- Deskripsi -->
                <p class="text-gray-700 mb-4 leading-relaxed line-clamp-3">
                    {{ Str::limit($course->description, 120) }}
                </p>

                <!-- Tombol -->
                @if(in_array($course->id, $enrolledCourseIds))
                <a href="{{ route('student.courses.show', $course) }}"
                    class="block text-center bg-green-600 hover:bg-green-700
                              text-white font-semibold py-2 rounded-lg shadow-md
                              transition transform hover:scale-105">
                    Masuk Mapel
                </a>
                @else
                <!-- Modal Gabung Kelas -->
                <div x-data="{ open: false }">

                    <button @click="open = true"
                        class="w-full bg-blue-600 hover:bg-blue-700
                                   text-white font-semibold py-2 rounded-lg shadow-md
                                   transition transform hover:scale-105">
                        Gabung Mapel
                    </button>

                    <!-- Overlay -->
                    <div x-show="open"
                        class="fixed inset-0 bg-black bg-opacity-50 flex items-center
                                    justify-center z-50">

                        <div @click.away="open = false"
                            class="bg-white rounded-xl shadow-lg w-96 p-6">

                            <h3 class="text-xl font-bold mb-4">
                                Masukkan Kode Mapel
                            </h3>

                            <form action="{{ route('student.courses.requestJoin', $course) }}"
                                method="POST">
                                @csrf

                                <input type="text" name="join_code"
                                    placeholder="Kode Kelas"
                                    class="w-full px-3 py-2 border rounded-lg mb-4
                                                  focus:outline-none focus:ring-2
                                                  focus:ring-blue-500"
                                    required>

                                @error('join_code')
                                <p class="text-red-600 text-sm mb-2">
                                    {{ $message }}
                                </p>
                                @enderror

                                <div class="flex justify-end gap-2">
                                    <button type="button" @click="open = false"
                                        class="px-4 py-2 bg-gray-200 rounded-lg
                                                       hover:bg-gray-300 transition">
                                        Batal
                                    </button>
                                    <button type="submit"
                                        class="px-4 py-2 bg-blue-600 text-white rounded-lg
                                                       hover:bg-blue-700 transition">
                                        Gabung
                                    </button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
                @endif

            </div>
        </div>
        @endforeach

    </div>
    @else
    <!-- Jika kosong -->
    <div class="text-center py-20 animate-fadeIn">
        <div class="text-6xl mb-4">📭</div>
        <p class="text-gray-600 text-lg">
            Belum ada mata pelajaran tersedia.
        </p>
    </div>
    @endif

</div>

<!-- ==========================
     ANIMASI FADE IN
========================== -->
<style>
    .animate-fadeIn {
        animation: fadeIn 0.5s ease-out forwards;
    }

    .animate-delay-100 {
        animation-delay: 0.1s;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
@endsection