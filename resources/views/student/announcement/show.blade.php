@extends('layouts.student')

@section('title', $announcement->title)
@section('page-title', 'Detail Pengumuman')

@section('content')
<div class="bg-white p-8 rounded-xl shadow-md border border-gray-100">

    {{-- Judul --}}
    <h1 class="text-3xl font-bold text-[#0A1D56] leading-tight">
        {{ $announcement->title }}
    </h1>

    {{-- Tanggal --}}
    <p class="text-sm text-gray-500 mt-2 flex items-center gap-2">
        📅 <span>{{ $announcement->date->format('d M Y') }}</span>
    </p>

    {{-- Isi Pengumuman --}}
    <div class="mt-6 text-gray-800 leading-relaxed prose max-w-none">
        {!! nl2br(e($announcement->description)) !!}
    </div>

    {{-- Tombol Kembali --}}
    <div class="mt-8">
        <a href="{{ route('student.announcements.index') }}"
            class="inline-block px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium rounded-lg transition">
            ← Kembali ke Daftar Pengumuman
        </a>
    </div>

</div>
@endsection