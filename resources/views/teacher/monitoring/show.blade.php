@extends('layouts.teacher')

@section('title', 'Progres Siswa - ' . $class->name)

@section('content')
<h1 class="text-2xl font-bold mb-6">Progres Siswa - {{ $class->name }}</h1>

<div class="overflow-x-auto">
    <table class="min-w-full bg-white rounded-lg shadow overflow-hidden">
        <thead class="bg-blue-900 text-white">
            <tr>
                <th class="px-4 py-2 text-left">Nama Siswa</th>
                <th class="px-4 py-2 text-left">Materi</th>
                <th class="px-4 py-2 text-left">Asesmen</th>
                <th class="px-4 py-2 text-left">Kehadiran</th>
            </tr>
        </thead>
        <tbody>
            @forelse($students as $student)
            <tr class="border-b hover:bg-blue-50 transition">
                <td class="px-4 py-2 font-semibold">{{ $student['name'] }}</td>

                {{-- Materi --}}
                <td class="px-4 py-2">
                    <div class="w-full bg-gray-200 rounded-full h-4">
                        <div class="bg-green-500 h-4 rounded-full text-xs text-white text-center"
                            style="width: {{ $student['materi_progress'] }}%">
                            {{ $student['materi_progress'] }}%
                        </div>
                    </div>
                </td>

                {{-- Quiz --}}
                <td class="px-4 py-2">
                    <div class="w-full bg-gray-200 rounded-full h-4">
                        <div class="bg-yellow-500 h-4 rounded-full text-xs text-white text-center"
                            style="width: {{ $student['quiz_progress'] }}%">
                            {{ $student['quiz_progress'] }}%
                        </div>
                    </div>
                </td>

                {{-- Kehadiran --}}
                <td class="px-4 py-2">
                    <div class="w-full bg-gray-200 rounded-full h-4">
                        <div class="bg-blue-500 h-4 rounded-full text-xs text-white text-center"
                            style="width: {{ $student['attendance_progress'] }}%">
                            {{ $student['attendance_progress'] }}%
                        </div>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="px-4 py-4 text-center text-gray-500 bg-gray-50 rounded-lg">
                    Belum ada siswa di kelas ini.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Tombol kembali --}}
<div class="mt-6">
    <a href="{{ route('teacher.monitoring.index') }}"
        class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium px-5 py-2.5 rounded-lg shadow-sm transition-all">
        ← Kembali ke Daftar Kelas
    </a>
</div>
@endsection