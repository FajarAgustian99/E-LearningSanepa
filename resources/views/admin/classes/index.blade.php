@extends('layouts.admin')

@section('title', 'Kelola Kelas')

@section('content')
<div class="container mx-auto p-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Daftar Kelas</h2>
        <a href="{{ route('admin.classes.create') }}"
            class="bg-green-600 hover:bg-green-700 text-white font-semibold px-4 py-2 rounded-lg shadow transition">
            + Tambah Kelas
        </a>
    </div>

    <!-- Table -->
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full border-collapse">
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold">No</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Nama Kelas</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Deskripsi</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Kelas</th>
                    <th class="px-6 py-3 text-center text-sm font-semibold w-40">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($classes as $i => $class)
                <tr class="hover:bg-gray-50 transition">

                    <td class="px-6 py-3 text-gray-700">{{ $i + 1 }}</td>

                    <td class="px-6 py-3 text-gray-900 font-medium">
                        {{ $class->name }}
                    </td>

                    <td class="px-6 py-3 text-gray-600 whitespace-normal">
                        {{ $class->description ?? '-' }}
                    </td>

                    <td class="px-6 py-3 text-gray-600 whitespace-normal">
                        {{ $class->grade ?? '-' }}
                    </td>

                    <td class="px-6 py-3 text-center">
                        <div class="flex justify-center items-center space-x-2">

                            <!-- Edit -->
                            <a href="{{ route('admin.classes.edit', $class->id) }}"
                                class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded-md text-sm shadow transition inline-block">
                                Edit
                            </a>

                            <!-- Delete -->
                            <form action="{{ route('admin.classes.destroy', $class->id) }}" method="POST"
                                onsubmit="return confirm('Yakin ingin menghapus kelas ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded-md text-sm shadow transition inline-block">
                                    Hapus
                                </button>
                            </form>

                            <!-- View -->
                            <!-- <a href="{{ route('admin.classes.show', $class->id) }}"
                                class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-md text-sm shadow transition inline-block">
                                Lihat
                            </a> -->

                        </div>
                    </td>
                </tr>
                @endforeach

                @if($classes->isEmpty())
                <tr>
                    <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                        Belum ada kelas tersedia.
                    </td>
                </tr>
                @endif

            </tbody>
        </table>
    </div>
</div>
@endsection