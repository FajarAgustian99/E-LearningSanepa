@extends('layouts.student')

@section('title', 'Materi ' . $course->title)

@section('content')
<div class="container mx-auto px-4 py-12 space-y-12 bg-gray-50 min-h-screen text-gray-800">

    {{-- HEADER PAGE --}}
    <div class="flex flex-col md:flex-row items-start md:items-center justify-between 
            pb-6 border-b border-gray-300 gap-4 md:gap-0 animate-fadeIn">
        <div class="flex flex-col md:flex-row items-start md:items-center gap-4">
            <div>
                <h1 class="text-4xl font-extrabold text-[#0A1D56] tracking-wide">
                    📚 {{ $course->title }}
                </h1>
                <p class="text-gray-500 mt-1">Materi & Quiz • Informasi lengkap mata pelajaran</p>
            </div>
        </div>

        {{-- Tombol Absensi --}}
        @if($class)
        <div class="flex gap-3">
            <a href="{{ route('student.absensi.index', $class->id) }}"
                class="bg-pink-600 text-white px-6 py-3 rounded-xl shadow-sm font-medium hover:bg-pink-700 transition transform hover:scale-105">
                📝 Absensi
            </a>
            <a href="{{ route('student.kelas.index', $class->id) }}"
                class="bg-white border border-gray-300 hover:bg-gray-100 px-6 py-3 rounded-xl shadow-sm font-medium transition transform hover:scale-105">
                ← Kembali ke Kelas
            </a>
        </div>
        @endif
    </div>

    {{-- INFO COURSE --}}
    <div class="bg-white/80 backdrop-blur-lg rounded-2xl shadow-md border p-8 hover:shadow-lg transition animate-fadeIn">
        <h2 class="text-2xl font-bold text-blue-700 mb-2">{{ $course->title }}</h2>
        <p class="text-gray-600 leading-relaxed mb-4">{{ $course->description ?? '-' }}</p>
        <p class="text-gray-500">
            👨‍🏫 <span class="font-semibold text-gray-700">
                Guru Pengampu: {{ $course->teacher->name ?? '-' }}
            </span>
        </p>
    </div>

    {{-- DAFTAR MATERI --}}
    <div class="bg-white rounded-2xl shadow-md border p-8 animate-fadeIn">
        <h2 class="text-2xl font-bold text-blue-600 mb-6 flex items-center gap-2">📘 Daftar Materi</h2>

        @if($class && $class->materials->count())
        <div class="overflow-x-auto rounded-xl border border-gray-200">
            <table class="min-w-full text-sm">
                <thead>
                    <tr class="bg-blue-600 text-white text-left">
                        <th class="px-5 py-3">Judul</th>
                        <th class="px-5 py-3">File</th>
                        <th class="px-5 py-3">Meeting</th>
                        <th class="px-5 py-3">Upload Tugas</th> {{-- kolom baru --}}
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    @foreach($class->materials as $m)
                    <tr class="hover:bg-blue-50 transition">
                        <td class="px-5 py-3 font-medium">{{ $m->title }}</td>
                        <td class="px-5 py-3">
                            @if($m->file)
                            <span class="inline-block bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs font-semibold">
                                <a href="{{ asset('storage/'.$m->file) }}" class="hover:underline">🔽 Download</a>
                            </span>
                            @else
                            -
                            @endif
                        </td>
                        <td class="px-5 py-3">
                            @if($m->meeting_link)
                            <span class="inline-block bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs font-semibold">
                                <a href="{{ $m->meeting_link }}" target="_blank" class="hover:underline">🎥 Join Meeting</a>
                            </span>
                            @else
                            -
                            @endif
                        </td>
                        <td class="px-5 py-3">
                            @if($m->link_upload)
                            <span class="inline-block bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-xs font-semibold">
                                <a href="{{ $m->link_upload }}" target="_blank" class="hover:underline">📤 Upload Tugas</a>
                            </span>
                            @else
                            -
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="text-gray-500 text-center py-6">Belum ada materi tersedia.</div>
        @endif
    </div>



    {{-- DAFTAR ASESMEN --}}
    <div class="bg-white rounded-2xl shadow-md border p-8 animate-fadeIn">
        <h2 class="text-2xl font-bold text-yellow-600 mb-6 flex items-center gap-2">🧠 Daftar Assesmen</h2>

        @if($class && $class->quizzes->count())
        <div class="overflow-x-auto rounded-xl border border-gray-200">
            <table class="min-w-full text-sm">
                <thead>
                    <tr class="bg-yellow-500 text-white text-left">
                        <th class="px-5 py-3">Judul</th>
                        <th class="px-5 py-3">Batas Waktu</th>
                        <th class="px-5 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    @foreach($class->quizzes as $q)
                    <tr class="hover:bg-yellow-50 transition">
                        <td class="px-5 py-3 font-medium">{{ $q->title }}</td>
                        <td class="px-5 py-3">{{ $q->due_date ? \Carbon\Carbon::parse($q->due_date)->format('d M Y H:i') : '-' }}</td>
                        <td class="px-5 py-3">
                            <a href="{{ route('student.quiz.show', $q->id) }}"
                                class="text-blue-600 hover:text-blue-800 font-semibold">
                                🚀 Kerjakan
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="text-gray-500 text-center py-6">Belum ada quiz tersedia.</div>
        @endif
    </div>

</div>

<!-- Tailwind Animations -->
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
</style>
@endsection