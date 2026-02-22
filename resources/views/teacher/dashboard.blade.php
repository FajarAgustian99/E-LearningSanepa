@extends('layouts.teacher')

@section('title', 'Dashboard Guru')

@section('content')
<div class="min-h-screen bg-gray-50 px-2 md:px-8 py-3 text-gray-800">
    {{-- Header --}}
    <div class="mb-3">
        <h1 class="text-2xl md:text-3xl font-bold text-blue-900">Dashboard Guru</h1>
        <p class="text-gray-600 mt-1 text-sm md:text-base">
            Selamat datang, <span class="font-medium">{{ auth()->user()->name }}</span> 👋
        </p>
    </div>

    {{-- Statistik --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        <div class="bg-blue-900 text-white rounded-2xl shadow-lg p-6 flex flex-col items-center justify-center hover:scale-105 transition-transform duration-200">
            <span class="text-5xl font-bold">{{ $total_kelas }}</span>
            <span class="mt-2 text-sm uppercase tracking-wide">Kelas yang Diampu</span>
        </div>

        <div class="bg-blue-600 text-white rounded-2xl shadow-lg p-6 flex flex-col items-center justify-center hover:scale-105 transition-transform duration-200">
            <span class="text-5xl font-bold">{{ $total_tugas }}</span>
            <span class="mt-2 text-sm uppercase tracking-wide">Total Materi</span>
        </div>

        <div class="bg-gray-800 text-white rounded-2xl shadow-lg p-6 flex flex-col items-center justify-center hover:scale-105 transition-transform duration-200">
            <span class="text-5xl font-bold">{{ $total_diskusi }}</span>
            <span class="mt-2 text-sm uppercase tracking-wide">Forum Diskusi</span>
        </div>
    </div>

    {{-- Daftar Tugas Terbaru --}}
    <div class="bg-white p-6 rounded-2xl shadow border border-gray-200">
        <h3 class="text-lg font-semibold text-gray-700 mb-4 flex items-center gap-2">
            📘 <span>Daftar Materi</span>
        </h3>

        @if($assignments->isEmpty())
        <p class="text-gray-500 italic">Belum ada tugas yang tersedia.</p>
        @else
        <ul class="divide-y divide-gray-200">
            @foreach ($assignments as $a)
            <li class="py-4 flex flex-col md:flex-row justify-between md:items-center hover:bg-gray-50 transition rounded-lg px-2 md:px-4">
                <div>
                    <p class="font-medium text-gray-800">{{ $a->title }}</p>
                </div>
            </li>
            @endforeach
        </ul>
        @endif
    </div>

</div>
@endsection