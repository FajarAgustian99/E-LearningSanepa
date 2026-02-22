@extends('layouts.admin')

@section('title', 'Detail Siswa')

@section('content')
<div class="max-w-2xl mx-auto p-6">

    {{-- ===============================
        CARD DETAIL SISWA
    ================================ --}}
    <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">
        Detail Siswa
    </h2>

    <div class="bg-white shadow-md rounded-lg p-6">


        {{-- Judul Halaman --}}

        {{-- Informasi Siswa --}}
        <div class="space-y-4 text-gray-700">

            {{-- Nama --}}
            <p>
                <span class="font-semibold">Nama:</span>
                {{ $student->name }}
            </p>

            {{-- NISN --}}
            <p>
                <span class="font-semibold">NISN:</span>
                {{ $student->nisn ?? '-' }}
            </p>

            {{-- Kelas --}}
            <p>
                <span class="font-semibold">Kelas:</span>
                {{ $student->class?->name ?? 'Belum ada kelas' }}
            </p>

            {{-- NISN --}}
            <p>
                <span class="font-semibold">NISN:</span>
                {{ $student->nisn ?? '-' }}
            </p>

            {{-- Nomor Telepon --}}
            <p>
                <span class="font-semibold">Nomor Telepon:</span>
                {{ $student->phone ?? '-' }}
            </p>

            {{-- Alamat --}}
            <p>
                <span class="font-semibold">Alamat:</span>
                {{ $student->address ?? '-' }}
            </p>

        </div>

        {{-- Tombol Kembali --}}
        <div class="mt-6">
            <a
                href="{{ route('admin.students.index') }}"
                class="inline-block px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition duration-200">
                ← Kembali ke Daftar Siswa
            </a>
        </div>

    </div>
</div>
@endsection