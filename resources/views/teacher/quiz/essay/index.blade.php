@extends('layouts.teacher')

@section('title', 'Penilaian Essay: ' . $quiz->title)

@section('content')
<div class="max-w-5xl mx-auto p-6">

    {{-- Judul Halaman --}}
    <h1 class="text-2xl font-bold text-blue-700 mb-6">
        📘 Penilaian Essay — {{ $quiz->title }}
    </h1>

    {{-- Tabel Penilaian --}}
    <div class="bg-white rounded-xl shadow overflow-hidden">
        <table class="min-w-full text-left">
            <thead class="bg-blue-50 border-b">
                <tr>
                    <th class="p-3 font-semibold">Siswa</th>
                    <th class="p-3 font-semibold">Nilai</th>
                    <th class="p-3 font-semibold">Status</th>
                    <th class="p-3 font-semibold text-center">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($submissions as $s)
                <tr class="border-b hover:bg-gray-50">

                    {{-- Nama Siswa --}}
                    <td class="p-3">
                        {{ $s->user->name }}
                    </td>

                    {{-- Nilai --}}
                    <td class="p-3">
                        {{ $s->score ?? '-' }}
                    </td>

                    {{-- Status Penilaian --}}
                    <td class="p-3">
                        @if($s->score === null)
                        <span class="text-red-600 font-medium">Belum dinilai</span>
                        @else
                        <span class="text-green-600 font-medium">Sudah dinilai</span>
                        @endif
                    </td>

                    {{-- Tombol Aksi --}}
                    <td class="p-3 text-center">
                        <a href="{{ route('teacher.quiz.essay.show', [$quiz->id, $s->id]) }}"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-1.5 rounded-lg shadow-sm transition">
                            Lihat Jawaban
                        </a>
                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
@endsection