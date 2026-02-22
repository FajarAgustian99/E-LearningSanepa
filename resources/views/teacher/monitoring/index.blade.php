@extends('layouts.teacher')

@section('title', 'Monitoring Kelas')

@section('content')
<div class="container mx-auto px-6 py-6">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Monitoring Kelas</h1>
    </div>

    {{-- Jika tidak ada kelas --}}
    @if($classes->isEmpty())
    <div class="bg-yellow-100 text-yellow-800 p-4 rounded-lg">
        Belum ada kelas untuk dimonitoring.
    </div>
    @else
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($classes as $class)
        <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition duration-200 border border-gray-100">

            {{-- Nama Kelas --}}
            <h2 class="font-semibold text-xl text-gray-800 mb-2">
                {{ $class->name }}
            </h2>

            {{-- Jumlah Siswa --}}
            <p class="text-gray-600 mb-3">
                Jumlah siswa:
                <span class="font-semibold text-gray-800">
                    {{ $class->students_count ?? 0 }}
                </span>
            </p>

            {{-- Tombol --}}
            <a href="{{ route('teacher.monitoring.show', $class->id) }}"
                class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium mt-2">
                Lihat Progres
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 ml-1" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </div>
        @endforeach
    </div>
    @endif

</div>
@endsection