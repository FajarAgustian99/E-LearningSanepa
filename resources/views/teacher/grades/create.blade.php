@extends('layouts.teacher')

{{-- Judul halaman --}}
@section('title', 'Daftar Nilai Kelas')

@section('content')

<div class="bg-white p-6 rounded-xl shadow-md">

    {{-- Heading Halaman --}}
    <h1 class="text-2xl font-bold text-blue-700 mb-4">📊 Daftar Nilai</h1>

    {{-- Notifikasi berhasil --}}
    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded-lg mb-4">
        ✅ {{ session('success') }}
    </div>
    @endif


    {{-- Tabel daftar nilai siswa --}}
    <table class="min-w-full border rounded-lg overflow-hidden shadow">
        <thead class="bg-blue-100">
            <tr>
                <th class="px-4 py-3 text-left font-semibold">No</th>
                <th class="px-4 py-3 text-left font-semibold">Nama Siswa</th>
                <th class="px-4 py-3 text-center font-semibold">Aksi</th>
            </tr>
        </thead>

        <tbody>
            {{-- Loop semua submission tugas --}}
            @foreach($submissions as $index => $submission)
            <tr class="border-t hover:bg-gray-50 transition">

                {{-- Nomor urut --}}
                <td class="px-4 py-3">{{ $index + 1 }}</td>

                {{-- Nama siswa --}}
                <td class="px-4 py-3">
                    {{ $submission->student->name }}
                </td>

                {{-- Tombol aksi untuk input/edit nilai --}}
                <td class="px-4 py-3 text-center">
                    <a
                        href="{{ route('teacher.grades.create', $submission->id) }}"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-1 rounded-md font-semibold">
                        ✏️ Input/Edit
                    </a>
                </td>

            </tr>
            @endforeach
        </tbody>
    </table>

</div>

@endsection