@extends('layouts.teacher')

@section('title', 'Beranda')

@section('content')
<div class="min-h-screen bg-gray-50 px-4 md:px-8 py-6 text-gray-800">

    {{-- Judul Halaman --}}
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-blue-900">Beranda Guru</h1>
        <p class="text-gray-600 mt-1">
            Halo, <span class="font-medium">{{ auth()->user()->name }}</span> 👋
        </p>
        <p class="text-gray-500 text-sm">
            Selamat datang di Learning Management System SMAN 1 Pabuaran
        </p>
    </div>

    {{-- Navigasi Cepat --}}
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4 mb-10 auto-rows-fr"
        role="navigation" aria-label="Navigasi Cepat">

        <a href="{{ route('teacher.dashboard') }}"
            class="bg-white p-5 rounded-xl shadow hover:bg-blue-50 transition text-center">
            <span class="block text-blue-900 font-semibold">📊 Dashboard</span>
        </a>

        <a href="{{ route('teacher.kelas.index') }}"
            class="bg-white p-5 rounded-xl shadow hover:bg-blue-50 transition text-center">
            <span class="block text-blue-900 font-semibold">📚 Kelas Saya</span>
        </a>

        <a href="{{ route('teacher.attendance.index') }}"
            class="bg-white p-5 rounded-xl shadow hover:bg-blue-50 transition text-center">
            <span class="block text-blue-900 font-semibold">🕒 Absensi</span>
        </a>

        <a href="{{ route('teacher.grades.index') }}"
            class="bg-white p-5 rounded-xl shadow hover:bg-blue-50 transition text-center">
            <span class="block text-blue-900 font-semibold">📅 Agenda Kelas</span>
        </a>

        <a href="{{ route('teacher.discussions.index') }}"
            class="bg-white p-5 rounded-xl shadow hover:bg-blue-50 transition text-center">
            <span class="block text-blue-900 font-semibold">💬 Forum Diskusi</span>
        </a>

        <a href="{{ route('teacher.monitoring.index') }}"
            class="bg-white p-5 rounded-xl shadow hover:bg-blue-50 transition text-center">
            <span class="block text-blue-900 font-semibold">📈 Monitoring Kelas</span>
        </a>

        <a href="{{ route('teacher.profile.index') }}"
            class="bg-white p-5 rounded-xl shadow hover:bg-blue-50 transition text-center">
            <span class="block text-blue-900 font-semibold">👤 Profil</span>
        </a>

    </div>

    {{-- Pengumuman --}}
    <div class="bg-white p-6 rounded-2xl shadow">
        <h2 class="text-lg font-semibold text-gray-700 mb-4">📢 Pengumuman Terbaru</h2>

        <ul class="space-y-4">
            @foreach ($announcements as $a)
            <li class="border-l-4 border-blue-800 pl-4">
                <p class="font-medium text-blue-900">{{ $a['title'] }}</p>
                <p class="text-sm text-gray-600">{{ $a['desc'] }}</p>
                <p class="text-xs text-gray-400 mt-1">📅 {{ $a['date'] }}</p>
            </li>
            @endforeach
        </ul>
    </div>

</div>
@endsection