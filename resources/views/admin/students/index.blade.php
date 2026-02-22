@extends('layouts.admin')

@section('title', 'Kelola Siswa')

@section('content')
<div class="container mx-auto p-6">

    {{-- ===============================
        FORM IMPORT DATA SISWA
    ================================ --}}
    <div class="bg-white shadow-md rounded-xl p-6 mb-6 border border-gray-200">

        <h2 class="text-lg font-semibold text-gray-700 mb-4 flex items-center gap-2">
            <i class="fas fa-upload text-green-600"></i> Import Data Siswa
        </h2>

        {{-- Alert sukses --}}
        @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-600 text-green-800 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
        @endif

        {{-- Form Upload Excel --}}
        <form action="{{ route('admin.students.import') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf

            {{-- Input file Excel --}}
            <div>
                <label class="block text-gray-700 mb-1 font-medium">Upload File Excel (.xlsx)</label>
                <input
                    type="file"
                    name="file"
                    accept=".xlsx,.xls"
                    class="w-full border border-gray-300 p-2 rounded-lg focus:ring-2 focus:ring-green-400 focus:outline-none"
                    required>
            </div>

            {{-- Tombol Import --}}
            <button
                type="submit"
                class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-lg shadow-md transition duration-200">
                <i class="fas fa-file-import mr-1"></i> Import Data
            </button>

            {{-- Tombol Download Template Excel --}}
            <div class="mt-3">
                <a
                    href="{{ route('admin.students.template') }}"
                    download
                    class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg shadow transition duration-200">
                    <i class="fas fa-download mr-1"></i> Download Template Excel
                </a>
            </div>
        </form>
    </div>



    {{-- ===============================
        TOMBOL TAMBAH & FILTER DATA
    ================================ --}}
    <div class="flex justify-between items-center mb-6">

        {{-- Tombol tambah siswa --}}
        <a
            href="{{ route('admin.students.create') }}"
            class="bg-green-600 hover:bg-green-700 text-white font-medium px-4 py-2 rounded-lg shadow transition duration-200">
            + Tambah Siswa
        </a>

        {{-- Form Filter & Pencarian --}}
        <form
            action="{{ route('admin.students.index') }}"
            method="GET"
            class="flex flex-wrap gap-4 items-center">
            {{-- Search nama/nisn --}}
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Cari nama atau nisn..."
                class="border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none">

            {{-- Dropdown filter kelas --}}
            {{-- Menggunakan ID kelas sebagai value agar lebih aman --}}
            <select
                name="kelas"
                class="border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none">
                <option value="">Semua Kelas</option>

                @foreach($allClasses as $class)
                <option
                    value="{{ $class->id }}"
                    {{ request('kelas') == $class->id ? 'selected' : '' }}>
                    {{ $class->name }}
                </option>
                @endforeach
            </select>

            {{-- Tombol filter --}}
            <button
                type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow transition duration-200">
                <i class="fas fa-search mr-1"></i> Filter
            </button>
        </form>
    </div>



    {{-- ===============================
        TABEL DATA SISWA
    ================================ --}}
    <div class="bg-white shadow-md rounded-lg overflow-hidden">

        <table class="min-w-full border-collapse">
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold">No</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Nama</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">NISN</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Kelas</th>
                    <th class="px-6 py-3 text-center text-sm font-semibold">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-200">
                @forelse($students as $student)

                <tr class="hover:bg-gray-50 transition duration-150">

                    {{-- Nomor urut dengan support pagination --}}
                    <td class="px-6 py-3 text-gray-700">
                        {{ method_exists($students, 'firstItem') 
                            ? $students->firstItem() + $loop->index 
                            : $loop->iteration 
                        }}
                    </td>

                    {{-- Nama siswa --}}
                    <td class="px-6 py-3 text-gray-900 font-medium">
                        {{ $student->name }}
                    </td>

                    {{-- NISN --}}
                    <td class="px-6 py-3 text-gray-600">
                        {{ $student->nisn ?? '-' }}
                    </td>

                    {{-- Nama kelas --}}
                    <td class="px-6 py-3 text-gray-600">
                        {{ $student->class->name ?? '-' }}
                    </td>

                    {{-- Tombol aksi --}}
                    <td class="px-6 py-3 text-center space-x-2">

                        {{-- Lihat detail --}}
                        <a
                            href="{{ route('admin.students.show', $student) }}"
                            class="inline-block bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-md text-sm shadow transition">
                            Lihat
                        </a>

                        {{-- Edit --}}
                        <a
                            href="{{ route('admin.students.edit', $student) }}"
                            class="inline-block bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded-md text-sm shadow transition">
                            Edit
                        </a>

                        {{-- Hapus --}}
                        <form
                            action="{{ route('admin.students.destroy', $student) }}"
                            method="POST"
                            class="inline-block">
                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded-md text-sm shadow transition"
                                onclick="return confirm('Yakin ingin menghapus siswa ini?')">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>

                @empty
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                        Belum ada siswa yang terdaftar.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Pagination --}}
        @if(method_exists($students, 'links'))
        <div class="p-4">
            {{ $students->links() }}
        </div>
        @endif

    </div>
</div>
@endsection