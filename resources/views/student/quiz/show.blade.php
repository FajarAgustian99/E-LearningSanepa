@extends('layouts.student')

@section('title', 'Detail Quiz')
@section('page-title', 'Detail Quiz')

@section('content')
<div class="container mx-auto px-4 py-12 min-h-screen">

    {{-- CARD UTAMA --}}
    <div class="bg-white/80 backdrop-blur-xl p-8 rounded-2xl shadow-lg border border-gray-200
                hover:shadow-xl transition-all duration-300">

        {{-- JUDUL QUIZ --}}
        <h1 class="text-3xl font-extrabold text-[#0A1D56] mb-3 tracking-wide flex items-center gap-2">
            📝 {{ $quiz->title }}
        </h1>

        {{-- DESKRIPSI --}}
        <p class="text-gray-700 text-lg mb-6 leading-relaxed">
            {{ $quiz->description ?? '-' }}
        </p>

        {{-- INFO QUIZ --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">

            <div class="bg-blue-50 border border-blue-200 p-4 rounded-xl">
                <p class="text-sm text-blue-700 font-semibold">Durasi</p>
                <p class="text-xl font-bold text-blue-900">{{ $quiz->duration }} menit</p>
            </div>

            <div class="bg-yellow-50 border border-yellow-200 p-4 rounded-xl">
                <p class="text-sm text-yellow-700 font-semibold">Batas Pengumpulan</p>
                <p class="text-xl font-bold text-yellow-900">
                    {{ $quiz->due_date ? \Carbon\Carbon::parse($quiz->due_date)->format('d M Y • H:i') : '-' }}
                </p>
            </div>

        </div>

        {{-- STATUS QUIZ --}}
        @if(isset($submission) && $submission)

        <div class="mb-6 p-4 bg-green-50 border border-green-300 rounded-xl shadow-sm">
            <p class="text-green-700 font-semibold text-lg">
                ✔ Kamu sudah mengerjakan quiz ini.
            </p>
        </div>

        {{-- BUTTON LIHAT HASIL --}}
        <a href="{{ route('student.quiz.result', $quiz->id) }}"
            class="inline-block bg-green-600 text-white px-6 py-3 rounded-xl font-semibold shadow-md
                   hover:bg-green-700 hover:shadow-lg transition">
            📊 Lihat Hasil
        </a>

        @else

        <div class="mb-6 p-4 bg-blue-50 border border-blue-300 rounded-xl shadow-sm text-blue-800">
            Quiz siap dikerjakan. Pastikan memahami materi sebelum memulai.
        </div>

        {{-- BUTTON MULAI QUIZ --}}
        <a href="{{ route('student.quiz.start', $quiz->id) }}"
            class="inline-block bg-blue-600 text-white px-6 py-3 rounded-xl font-semibold shadow-md
                   hover:bg-blue-700 hover:shadow-lg transition">
            🚀 Mulai Mengerjakan Quiz
        </a>

        @endif

    </div>

</div>
@endsection