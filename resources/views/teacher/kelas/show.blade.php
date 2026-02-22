@extends('layouts.teacher')

@section('title', 'Kelas ' . $class->name)

@section('content')
<div class="container mx-auto px-6 py-6">

    {{-- ============================= --}}
    {{-- HEADER --}}
    {{-- ============================= --}}
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-[#0A1D56]">
            Kelas {{ $class->name }}
        </h1>
    </div>

    {{-- ============================= --}}
    {{-- KETERANGAN KELAS --}}
    {{-- ============================= --}}
    <!-- <div class="bg-white p-5 rounded-xl shadow border border-gray-200 mb-6">
        <p class="text-gray-700">
            <strong>Mapel:</strong> {{ $class->course->name ?? '-' }}
        </p>

        <p class="text-gray-700">
            <strong>Dibuat oleh:</strong> {{ $class->creator->name ?? 'Admin' }}
        </p>

        @if($class->meet_link)
        <p class="text-gray-700">
            <strong>Link Google Meet:</strong>
            <a href="{{ $class->meet_link }}" target="_blank" class="text-blue-600 underline">
                {{ $class->meet_link }}
            </a>
        </p>
        @endif
    </div> -->

    {{-- ============================= --}}
    {{-- ACTION BUTTONS --}}
    {{-- ============================= --}}
    <div class="flex flex-wrap gap-3 mb-8">

        {{-- Materi --}}
        <a href="{{ route('teacher.materi.index', $class->id) }}"
            class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg shadow">
            📚 Buat Materi
        </a>

        {{-- Quiz --}}
        <a href="{{ route('teacher.quiz.create', $class->id) }}"
            class="px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-lg shadow flex items-center gap-1">
            📝 Buat Quiz
        </a>

        {{-- Absensi --}}
        <a href="{{ route('teacher.attendance.show', $class->id) }}"
            class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow flex items-center gap-1">
            ✔️ Absensi
        </a>

        <a href="{{ route('teacher.kelas.index') }}"
            class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg shadow">
            ← Kembali
        </a>

    </div>

    {{-- ============================= --}}
    {{-- MATERI --}}
    {{-- ============================= --}}
    <h2 class="section-title">Materi</h2>

    @if($class->materials->count())
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        @foreach ($class->materials as $material)
        <div class="card">
            <h3 class="card-title">{{ $material->title }}</h3>
            <p class="card-desc">{{ $material->description ?? '-' }}</p>

            @if($material->file)
            <a href="{{ asset('storage/'.$material->file) }}" target="_blank"
                class="text-blue-600 underline block mb-1">
                Download File
            </a>
            @endif

            @if($material->meeting_link)
            <a href="{{ $material->meeting_link }}" target="_blank"
                class="text-blue-600 underline block">
                Link Pertemuan
            </a>
            @endif
        </div>
        @endforeach
    </div>
    @else
    <p class="no-data">Belum ada materi di kelas ini.</p>
    @endif

    {{-- ============================= --}}
    {{-- QUIZ --}}
    {{-- ============================= --}}
    <h2 class="section-title">Quiz</h2>

    @if($class->quizzes->count())
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        @foreach ($class->quizzes as $quiz)
        <div class="card">
            <h3 class="card-title">{{ $quiz->title }}</h3>
            <p class="card-desc">{{ $quiz->description ?? '-' }}</p>

            <p class="text-gray-500 text-sm"><strong>Durasi:</strong> {{ $quiz->duration }} menit</p>
            <p class="text-gray-500 text-sm"><strong>Batas waktu:</strong> {{ $quiz->due_date ?? '-' }}</p>

            <a href="{{ route('teacher.quiz.results', $quiz->id) }}"
                class="text-blue-600 underline block mt-2">
                Lihat Hasil
            </a>
        </div>
        @endforeach
    </div>
    @else
    <p class="no-data">Belum ada quiz di kelas ini.</p>
    @endif

    {{-- ============================= --}}
    {{-- ABSENSI --}}
    {{-- ============================= --}}
    <!-- <h2 class="section-title">Absensi</h2>

    @if($class->attendances->count())
    <div class="overflow-x-auto mb-8">
        <table class="w-full table-auto border-collapse border border-gray-200">
            <thead>
                <tr class="bg-gray-100 text-gray-700">
                    <th class="th">Tanggal</th>
                    <th class="th">Siswa</th>
                    <th class="th">Status</th>
                    <th class="th">Guru</th>
                </tr>
            </thead>

            <tbody>
                @foreach($class->attendances as $attendance)
                <tr class="text-gray-700">
                    <td class="td">{{ $attendance->date }}</td>
                    <td class="td">{{ $attendance->student->name ?? '-' }}</td>
                    <td class="td">{{ ucfirst($attendance->status) }}</td>
                    <td class="td">{{ $attendance->teacher->name ?? '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <p class="no-data">Belum ada data absensi.</p>
    @endif -->

</div>
@endsection