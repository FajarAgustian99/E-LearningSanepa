@extends('layouts.admin')

@section('title', 'Detail Kelas')

@section('content')
<div class="container mx-auto p-6">
    <h3 class="text-3xl font-bold text-blue-600 mb-6 border-b-2 border-blue-200 pb-2">
        Detail Kelas: {{ $class->name }}
    </h3>

    <div class="bg-white shadow-lg rounded-xl p-8">

        {{-- DESKRIPSI KELAS --}}
        <h3 class="text-xl font-semibold mb-2 text-gray-700">Deskripsi</h3>
        <p class="text-gray-600 mb-8">
            {{ $class->description ?: '-' }}
        </p>

        {{-- DAFTAR SISWA --}}
        <h3 class="text-xl font-semibold mb-4 text-gray-700">Siswa Terdaftar</h3>

        <div class="overflow-x-auto rounded-lg border border-gray-200 shadow-sm">
            <table class="min-w-full border-collapse divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 uppercase">No</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 uppercase">Email</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 uppercase">Nama Siswa</th>
                        <th class="px-4 py-3 text-center text-xs font-bold text-gray-700 uppercase">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200">
                    @forelse($class->students as $index => $student)
                    <tr class="{{ $index % 2 == 0 ? 'bg-white' : 'bg-blue-50' }} hover:bg-blue-100">
                        <td class="px-4 py-3 text-gray-700">{{ $index + 1 }}</td>
                        <td class="px-4 py-3 text-gray-700">{{ $student->email ?? '-' }}</td>
                        <td class="px-4 py-3 text-gray-700">{{ $student->name }}</td>
                        <td class="px-4 py-3 text-center space-x-2">

                            {{-- EDIT --}}
                            <a href="{{ route('admin.students.edit', $student->id) }}"
                                class="inline-block bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-md text-sm shadow transition font-semibold">
                                Edit
                            </a>

                            {{-- HAPUS --}}
                            <form action="{{ route('admin.students.destroy', $student->id) }}" method="POST"
                                class="inline-block"
                                onsubmit="return confirm('Yakin ingin menghapus siswa ini dari kelas?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md text-sm shadow transition font-semibold">
                                    Hapus
                                </button>
                            </form>

                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-4 py-6 text-center text-gray-500 bg-gray-50">
                            Belum ada siswa yang terdaftar di kelas ini.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- TOMBOL KEMBALI --}}
        <div class="mt-8">
            <a href="{{ route('admin.classes.index') }}"
                class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-lg shadow transition">
                Kembali ke Daftar Kelas
            </a>
        </div>

    </div>
</div>
@endsection