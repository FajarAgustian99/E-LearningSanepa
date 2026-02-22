@extends('layouts.admin')

{{-- Judul Halaman --}}
@section('title', 'Kelola Absensi')

@section('content')
<div class="container mx-auto mt-10 px-4">

    {{-- Header Halaman --}}
    <div class="mb-8">
        <h3 class="text-3xl font-bold text-gray-900">Kelola Absensi</h3>
        <p class="text-gray-500 mt-1">Kelola absensi siswa dan guru dengan mudah.</p>
    </div>

    {{-- Card Form --}}
    <div class="bg-white shadow-lg rounded-xl p-8">

        {{-- Form Filter Absensi --}}
        <form action="{{ route('admin.attendance.show') }}" method="GET" class="space-y-8">

            <form action="{{ route('admin.attendance.show') }}" method="GET" class="space-y-8">

                {{-- Row Input --}}
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

                    {{-- Pilih Kelas --}}
                    <div>
                        <label for="class_id" class="block text-sm font-semibold text-gray-700 mb-2">
                            Pilih Kelas
                        </label>
                        <select
                            name="class_id"
                            id="class_id"
                            required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm 
                       focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">

                            <option value="">-- Pilih Kelas --</option>

                            @foreach($classes as $class)
                            <option value="{{ $class->id }}" {{ request('class_id')==$class->id?'selected':'' }}>
                                {{ $class->name }}
                            </option>
                            @endforeach

                        </select>
                    </div>

                    {{-- Pilih Mata Pelajaran --}}
                    <div>
                        <label for="course_id" class="block text-sm font-semibold text-gray-700 mb-2">
                            Pilih Mata Pelajaran
                        </label>
                        <select
                            name="course_id"
                            id="course_id"
                            required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm 
                       focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">

                            <option value="">-- Pilih Mapel --</option>

                            @foreach($courses as $course)
                            <option value="{{ $course->id }}" {{ request('course_id')==$course->id?'selected':'' }}>
                                {{ $course->title }}
                            </option>
                            @endforeach

                        </select>
                    </div>

                    {{-- Jenis Absensi --}}
                    <div>
                        <label for="type" class="block text-sm font-semibold text-gray-700 mb-2">
                            Jenis Absensi
                        </label>
                        <select
                            name="type"
                            id="type"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm 
                       focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">

                            <option value="student" {{ request('type')=='student'?'selected':'' }}>Siswa</option>
                            <option value="teacher" {{ request('type')=='teacher'?'selected':'' }}>Guru</option>

                        </select>
                    </div>

                    {{-- Pilih Tanggal --}}
                    <div>
                        <label for="date" class="block text-sm font-semibold text-gray-700 mb-2">
                            Tanggal Absensi
                        </label>
                        <input
                            type="date"
                            name="date"
                            id="date"
                            value="{{ request('date', now()->toDateString()) }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm 
                       focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                </div>

                {{-- Tombol Submit --}}
                <div class="text-right">
                    <button
                        type="submit"
                        class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-indigo-500 to-green-600 
                   text-white font-semibold rounded-lg shadow-lg hover:from-indigo-600 hover:to-green-700 
                   transition-colors duration-300 focus:outline-none focus:ring-4 focus:ring-indigo-300">

                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5 mr-2"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>

                        Lihat Absensi
                    </button>
                </div>

            </form>
        </form>
    </div>
</div>
@endsection