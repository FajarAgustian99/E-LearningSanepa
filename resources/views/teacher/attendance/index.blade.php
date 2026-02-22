@extends('layouts.teacher')

@section('title', 'Absensi')

@section('content')

<div class="mb-4 flex gap-3">

    {{-- Tombol Absensi Guru --}}
    @php
    $classId = optional($classes->first())->id;
    @endphp

    @if($classId)
    <a href="{{ route('teacher.attendance.guru', $classId) }}"
        class="inline-flex items-center bg-purple-600 hover:bg-purple-700 text-white px-3 py-2 rounded-lg text-sm font-medium transition">
        👨‍🏫 Absensi Guru
    </a>
    @endif

    @if($classId)
    <a href="{{ route('teacher.attendance.show', $classId) }}"
        class="inline-flex items-center bg-green-600 hover:bg-green-700 text-white px-3 py-2 rounded-lg text-sm font-medium transition">
        🗒️ <span class="ml-1">Absen Siswa</span>
    </a>
    @endif
    @if($classId)
    <a href="{{ route('teacher.attendance.rekap', $classId) }}"
        class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded-lg text-sm font-medium transition">
        📊 <span class="ml-1">Rekap</span>
    </a>
    @endif
</div>

<table class="min-w-80 bg-white border border-gray-200 shadow-sm rounded-lg">
    <thead class="bg-gray-100">
        <tr>
            <th class="px-6 py-3 text-center">No</th>
            <th class="px-24 py-3 text-center">Kelas</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($classes as $index => $class)
        <tr class="border-t hover:bg-gray-50">
            <td class="px-6 py-3 text-center">{{ $index + 1 }}</td>
            <td class="px-6 py-3 text-center font-medium text-gray-800">
                {{ $class->name }}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection