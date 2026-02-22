@extends('layouts.admin')

@section('title', 'Kelola User')

@section('content')
<div class="container mx-auto px-4">

    {{-- ================================
         HEADER + BUTTON TAMBAH USER
    ================================= --}}
    <h2 class="text-2xl font-bold mb-6">Kelola User</h2>

    <a href="{{ route('admin.users.create') }}"
        class="inline-block mb-6 px-4 py-2 bg-green-600 text-white font-semibold rounded hover:bg-green-700">
        + Tambah User
    </a>

    {{-- ======================================================
         SECTION 1: DAFTAR GURU
    ======================================================= --}}
    <h3 class="text-xl font-semibold mb-2">Daftar Guru</h3>

    {{-- Form Pencarian Guru --}}
    <form method="GET" action="{{ route('admin.users.index') }}" class="flex gap-2 mb-4">
        <input type="text" name="search_guru" value="{{ $searchGuru }}"
            placeholder="Cari guru..."
            class="border px-3 py-2 rounded w-full md:w-1/3">

        <button type="submit"
            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            Cari
        </button>
    </form>

    {{-- Tabel Daftar Guru --}}
    <div class="overflow-x-auto mb-6">
        <table class="min-w-full border border-gray-200">
            <thead class="bg-blue-600 text-white">
                <tr>
                    <th class="px-4 py-2">No</th>
                    <th class="px-4 py-2">Nama</th>
                    <th class="px-4 py-2">NIP</th>
                    <th class="px-4 py-2">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($gurus as $i => $guru)
                <tr class="hover:bg-gray-50">
                    {{-- Nomor urut sesuai pagination --}}
                    <td class="px-4 py-2 text-center">{{ $gurus->firstItem() + $i }}</td>

                    {{-- Nama Guru --}}
                    <td class="px-4 py-2">{{ $guru->name }}</td>

                    {{-- NIP Guru --}}
                    <td class="px-4 py-2 text-center">{{ $guru->nip ?? '-' }}</td>

                    {{-- Tombol Aksi --}}
                    <td class="px-4 py-2 text-center space-x-2">

                        {{-- Edit --}}
                        <a href="{{ route('admin.users.edit', $guru) }}"
                            class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded-md text-sm shadow transition inline-block">
                            Edit
                        </a>

                        {{-- Delete --}}
                        <form action="{{ route('admin.users.destroy', $guru) }}"
                            method="POST"
                            class="inline-block"
                            onsubmit="return confirm('Yakin hapus data ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded-md text-sm shadow transition inline-block">
                                Delete
                            </button>
                        </form>

                        {{-- Detail --}}
                        <a href="{{ route('admin.users.show', $guru) }}"
                            class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-md text-sm shadow transition inline-block">
                            Detail
                        </a>
                    </td>
                </tr>

                @empty
                <tr>
                    <td colspan="4"
                        class="px-4 py-2 text-center text-gray-500">
                        Tidak ada data guru
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination Guru --}}
    <div class="mt-4">
        {{ $gurus->appends(['search_guru' => $searchGuru])->links('pagination::tailwind') }}
    </div>

    {{-- ======================================================
         SECTION 2: DAFTAR SISWA
    ======================================================= --}}
    <h3 class="text-xl font-semibold mt-8 mb-2">Daftar Siswa</h3>

    {{-- Form Pencarian Siswa --}}
    <form method="GET" action="{{ route('admin.users.index') }}" class="flex gap-2 mb-4">
        <input type="text" name="search_siswa" value="{{ $searchSiswa }}"
            placeholder="Cari siswa..."
            class="border px-3 py-2 rounded w-full md:w-1/3">

        <button type="submit"
            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            Cari
        </button>
    </form>

    {{-- Tabel Daftar Siswa --}}
    <div class="overflow-x-auto ">
        <table class="min-w-full border border-gray-200">
            <thead class="bg-blue-600 text-white">
                <tr>
                    <th class="px-4 py-2">No</th>
                    <th class="px-4 py-2">Nama</th>
                    <th class="px-4 py-2">NISN</th>
                    <th class="px-4 py-2">Kelas</th>
                    <th class="px-4 py-2">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($siswas as $i => $siswa)
                <tr class="hover:bg-gray-50">
                    {{-- Nomor --}}
                    <td class="px-4 py-2 text-center">{{ $siswas->firstItem() + $i }}</td>

                    {{-- Nama --}}
                    <td class="px-4 py-2">{{ $siswa->name }}</td>

                    {{-- NISN --}}
                    <td class="px-4 py-2 text-center">{{ $siswa->nisn ?? '-' }}</td>

                    {{-- Kelas --}}
                    <td class="px-4 py-2 text-center">
                        {{ $siswa->class?->description ?? '-' }}
                    </td>

                    {{-- Aksi --}}
                    <td class="px-4 py-2 text-center space-x-2">

                        <a href="{{ route('admin.users.edit', $siswa) }}"
                            class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded-md text-sm shadow transition inline-block">
                            Edit
                        </a>

                        <form action="{{ route('admin.users.destroy', $siswa) }}"
                            method="POST"
                            class="inline-block"
                            onsubmit="return confirm('Yakin hapus data ini?')">
                            @csrf @method('DELETE')
                            <button type="submit"
                                class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded-md text-sm shadow transition inline-block">
                                Delete
                            </button>
                        </form>

                        <a href="{{ route('admin.users.show', $siswa) }}"
                            class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-md text-sm shadow transition inline-block">
                            Detail
                        </a>
                    </td>
                </tr>

                @empty
                <tr>
                    <td colspan="5"
                        class="px-4 py-2 text-center text-gray-500">
                        Tidak ada data siswa
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination Siswa --}}
    <div class="mt-4">
        {{ $siswas->appends(['search_siswa' => $searchSiswa])->links('pagination::tailwind') }}
    </div>

    {{-- ======================================================
         SECTION 3: DAFTAR ADMIN
    ======================================================= --}}
    <h3 class="text-xl font-semibold mb-2">Daftar Admin</h3>

    {{-- Form Pencarian Admin --}}
    <form method="GET" action="{{ route('admin.users.index') }}" class="flex gap-2 mb-4">
        <input type="text" name="search_admin" value="{{ $searchAdmin }}"
            placeholder="Cari admin..."
            class="border px-3 py-2 rounded w-full md:w-1/3">

        <button type="submit"
            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            Cari
        </button>
    </form>

    {{-- Tabel Daftar Admin --}}
    <div class="overflow-x-auto mb-6">
        <table class="min-w-full border border-gray-200">
            <thead class="bg-blue-600 text-white">
                <tr>
                    <th class="px-4 py-2">No</th>
                    <th class="px-4 py-2">Nama</th>
                    <th class="px-4 py-2">NPSN</th>
                    <th class="px-4 py-2">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($admins as $i => $admin)
                <tr class="hover:bg-gray-50">
                    {{-- Nomor --}}
                    <td class="px-4 py-2 text-center">{{ $admins->firstItem() + $i }}</td>

                    {{-- Nama --}}
                    <td class="px-4 py-2">{{ $admin->name }}</td>

                    {{-- NPSN Admin --}}
                    <td class="px-4 py-2 text-center">{{ $admin->npsn ?? '-' }}</td>

                    {{-- Tombol Aksi --}}
                    <td class="px-4 py-2 text-center space-x-2">
                        <a href="{{ route('admin.users.edit', $admin) }}"
                            class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded-md text-sm shadow transition inline-block">
                            Edit
                        </a>
                        <form action="{{ route('admin.users.destroy', $admin) }}"
                            method="POST"
                            class="inline-block"
                            onsubmit="return confirm('Yakin hapus data ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded-md text-sm shadow transition inline-block">
                                Delete
                            </button>
                        </form>

                        <a href="{{ route('admin.users.show', $admin) }}"
                            class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-md text-sm shadow transition inline-block">
                            Detail
                        </a>
                    </td>
                </tr>

                @empty
                <tr>
                    <td colspan="4"
                        class="px-4 py-2 text-center text-gray-500">
                        Tidak ada data admin
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination Admin --}}
    <div class="mt-4">
        {{ $admins->appends(['search_admin' => $searchAdmin])->links('pagination::tailwind') }}
    </div>

</div>
@endsection