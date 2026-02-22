@extends('layouts.teacher')

@section('title', 'Daftar Siswa ' . $class->name)

@section('content')
<div class="container mx-auto px-4 py-8">

    {{-- Judul Halaman --}}
    <h1 class="text-3xl font-bold text-blue-700 mb-6">
        👩‍🎓 Daftar Siswa — {{ $class->name }}
    </h1>

    {{-- Notifikasi Sukses --}}
    @if (session('success'))
    <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded-lg mb-6">
        ✅ {{ session('success') }}
    </div>
    @endif

    {{-- Tombol Tambah Siswa --}}
    <a href="{{ route('teacher.students.create', $class->id) }}"
        class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg font-semibold shadow inline-block mb-6 transition">
        ➕ Tambah Siswa
    </a>

    {{-- Jika Kosong --}}
    @if ($class->students->isEmpty())
    <div class="bg-white border p-6 rounded-lg shadow text-gray-600">
        Belum ada siswa di kelas ini.
    </div>
    @else

    {{-- Tabel Daftar Siswa --}}
    <table class="min-w-full bg-white border rounded-lg shadow-md">
        <thead class="bg-blue-100">
            <tr>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">No</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Nama</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Email</th>
                <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">Aksi</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($class->students as $index => $student)
            <tr class="border-t hover:bg-gray-50 transition">
                <td class="px-6 py-3">{{ $index + 1 }}</td>
                <td class="px-6 py-3">{{ $student->name }}</td>
                <td class="px-6 py-3">{{ $student->email }}</td>

                <td class="px-6 py-3 text-center">
                    <form
                        action="{{ route('teacher.students.destroy', [$class->id, $student->id]) }}"
                        method="POST"
                        onsubmit="return confirm('Yakin ingin menghapus siswa ini?');">
                        @csrf
                        @method('DELETE')

                        <button type="submit"
                            class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-md text-sm shadow transition">
                            🗑️ Hapus
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    {{-- Tombol Kembali --}}
    <div class="mt-6">
        <a href="{{ route('teacher.kelas.index') }}"
            class="text-blue-600 hover:underline font-medium">
            ⬅️ Kembali ke Daftar Kelas
        </a>
    </div>

</div>
@endsection