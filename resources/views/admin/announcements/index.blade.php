@extends('layouts.admin')

{{-- Judul Halaman --}}
@section('title', 'Daftar Pengumuman')

@section('content')
<h1 class="text-2xl font-bold mb-6">Daftar Pengumuman</h1>

{{-- Tombol Tambah Pengumuman --}}
<a
    href="{{ route('admin.announcements.create') }}"
    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded mb-4 inline-block shadow">
    + Tambah Pengumuman
</a>

{{-- Notifikasi sukses setelah create / update / delete --}}
@if(session('success'))
<div class="bg-green-100 text-green-700 p-3 rounded mb-4">
    {{ session('success') }}
</div>
@endif

{{-- Tabel daftar pengumuman --}}
<table class="w-full bg-white shadow rounded text-center">
    <thead class="bg-gray-200">
        <tr>
            <th class="px-4 py-2">No</th>
            <th class="px-4 py-2">Judul</th>
            <th class="px-4 py-2">Deskripsi</th>
            <th class="px-4 py-2">Tanggal</th>
            <th class="px-4 py-2">Aksi</th>
        </tr>
    </thead>

    <tbody>
        @foreach($announcements as $a)
        <tr class="border-t hover:bg-gray-50 transition">

            {{-- Nomor Urut --}}
            <td class="px-4 py-2">
                {{ $loop->iteration }}
            </td>

            {{-- Judul Pengumuman --}}
            <td class="px-4 py-2">
                {{ $a->title }}
            </td>

            {{-- Deskripsi Singkat 
                Jika deskripsi panjang, boleh dipotong menggunakan Str::limit()
                contoh: {{ Str::limit($a->description, 50) }}
            --}}
            <td class="px-4 py-2">
                {{ $a->description }}
            </td>

            {{-- Format Tanggal --}}
            <td class="px-4 py-2">
                {{ \Carbon\Carbon::parse($a->date)->format('d M Y') }}
            </td>

            {{-- Tombol Aksi --}}
            <td class="px-4 py-2 space-x-2">

                {{-- Tombol Edit --}}
                <a
                    href="{{ route('admin.announcements.edit', $a->id) }}"
                    class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded shadow">
                    Edit
                </a>

                {{-- Tombol Hapus --}}
                <form
                    action="{{ route('admin.announcements.destroy', $a->id) }}"
                    method="POST"
                    class="inline-block"
                    onsubmit="return confirm('Yakin ingin menghapus pengumuman ini?');">
                    @csrf
                    @method('DELETE')

                    <button
                        class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded shadow">
                        Hapus
                    </button>
                </form>

            </td>
        </tr>
        @endforeach
    </tbody>

</table>
@endsection