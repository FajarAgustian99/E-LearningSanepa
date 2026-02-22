@extends('layouts.admin')
@section('title', 'Tambah Siswa')
@section('content')
<div class="max-w-2xl mx-auto p-6">
    <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">
        + Tambah Siswa Baru
    </h2>

    <div class="bg-white shadow-md rounded-lg p-6">
        <form action="{{ route('admin.students.store') }}" method="POST" class="space-y-4">
            @csrf

            <!-- Nama Lengkap -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                <input type="text" name="name" id="name" required
                    class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- NISN -->
            <div>
                <label for="nisn" class="block text-sm font-medium text-gray-700">NISN</label>
                <input type="text" name="nisn" id="nisn" required
                    class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password" id="password" required
                    class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Kelas -->
            <div>
                <label for="class_id" class="block text-sm font-medium text-gray-700">Kelas</label>
                <select name="class_id" id="class_id" required
                    class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="" disabled selected>Pilih Kelas</option>
                    @foreach($classes as $class)
                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Tombol aksi -->
            <div class="flex justify-end space-x-3 mt-4">
                <a href="{{ route('admin.students.index') }}"
                    class="px-4 py-2 bg-gray-500 text-white rounded-lg shadow hover:bg-gray-600 transition duration-200">
                    Batal
                </a>
                <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition duration-200">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection