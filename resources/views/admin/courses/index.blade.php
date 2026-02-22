@extends('layouts.admin')

@section('title', 'Kelola Mata Pelajaran')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex items-center justify-between gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-semibold text-gray-800">Daftar Mata Pelajaran</h2>
            <!-- <p class="text-sm text-gray-500 mt-1">Kelola data mata pelajaran — tambah, sunting, atau hapus.</p> -->
        </div>

        <div class="shrink-0">
            <a href="{{ route('admin.courses.create') }}"
                class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-green-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Mapel
            </a>
        </div>
    </div>

    {{-- Filter & Search --}}
    <div class="p-4 border-b">
        <form action="{{ route('admin.courses.index') }}" method="GET" class="flex gap-3 items-center">
            <label for="q" class="sr-only">Cari Mapel</label>
            <input id="q" name="q" value="{{ request('q') }}" placeholder="Cari judul atau nama guru..."
                class="form-input w-full md:w-1/2 rounded-md border-gray-200 focus:ring-1 focus:ring-blue-400" />
            <button type="submit" class="bg-gray-100 hover:bg-gray-200 px-3 py-2 rounded-md text-sm">Cari</button>
            <a href="{{ route('admin.courses.index') }}" class="ml-auto text-sm text-gray-500 hover:underline">Reset</a>
        </form>
    </div>

    {{-- Tabel --}}
    <div class="overflow-x-auto bg-white shadow-sm rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-200">
                <tr class="text-center text-sm text-white-600">
                    <th class="px-4 py-3 w-28">No</th>
                    <th class="px-4 py-3 w-28">Foto</th>
                    <th class="px-4 py-3">Judul</th>
                    <th class="px-4 py-3">Kelas</th>
                    <th class="px-4 py-3">Guru</th>
                    <th class="px-4 py-3">Kode Mapel</th>
                    <th class="px-4 py-3 w-40">Aksi</th>
                </tr>
            </thead>

            <tbody class="bg-white divide-y divide-gray-100">
                @forelse($courses as $i => $c)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 text-sm text-center text-gray-700 align-top">
                        {{ $courses->firstItem() + $i }}
                    </td>

                    <td class="px-4 py-3 w-28 text-center align-top">
                        @if(!empty($c->image) && file_exists(storage_path('app/public/' . $c->image)))
                        <img src="{{ asset('storage/'.$c->image) }}" class="h-16 w-16 object-cover rounded-md shadow-sm">
                        @else
                        <div class="h-16 w-16 bg-gray-100 rounded-md flex items-center justify-center text-gray-400 text-xs">
                            Tidak ada
                        </div>
                        @endif
                    </td>

                    <td class="px-4 py-3 text-center align-top">
                        <div class="text-sm font-medium text-gray-800">{{ $c->title }}</div>
                        @if($c->description)
                        <div class="text-xs text-gray-500 mt-1 line-clamp-2">
                            {{ Str::limit($c->description, 100) }}
                        </div>
                        @endif
                    </td>

                    <td class="px-4 py-3 text-center align-top">
                        <div class="text-sm font-medium text-gray-800">{{ $c->grade }}</div>
                        <!-- @if($c->description)
                        <div class="text-xs text-gray-500 mt-1 line-clamp-2">
                            {{ Str::limit($c->description, 100) }}
                        </div>
                        @endif -->
                    </td>

                    <td class="px-4 text-center py-3 align-top text-sm text-gray-700">
                        {{ $c->teacher?->name ?? '-' }}
                    </td>

                    {{-- Kode Gabung --}}
                    <td class="px-4 text-center py-3 align-top text-sm text-gray-700">
                        {{ $c->join_code ?? '-' }}
                    </td>

                    <td class="px-4 py-3 align-top">
                        <div class="flex items-center gap-2 justify-center">
                            <a href="{{ route('admin.courses.edit', $c) }}"
                                class="px-3 py-1.5 rounded-md bg-yellow-500 hover:bg-yellow-600 text-white text-sm">
                                Edit
                            </a>

                            <form action="{{ route('admin.courses.destroy', $c) }}" method="POST" class="inline"
                                onsubmit="return confirm('Yakin ingin menghapus mapel: {{ addslashes($c->title) }}?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="px-3 py-1.5 rounded-md bg-red-600 hover:bg-red-700 text-white text-sm">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-10 text-center text-gray-500">
                        <div class="space-y-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-10 w-10 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 7v4a1 1 0 001 1h3m10 0h3a1 1 0 001-1V7M7 21h10M7 7h10" />
                            </svg>
                            <div class="text-sm font-medium">Belum ada mata pelajaran</div>
                            <div class="text-xs text-gray-400">Klik "Tambah Mapel" untuk menambahkan data baru.</div>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Pagination --}}
        <div class="flex items-center justify-between p-4 bg-gray-50">
            <div class="text-sm text-gray-600">
                Menampilkan
                <span class="font-medium">{{ $courses->firstItem() ?? 0 }}</span>
                sampai
                <span class="font-medium">{{ $courses->lastItem() ?? 0 }}</span>
                dari
                <span class="font-medium">{{ $courses->total() }}</span>
            </div>

            <div>
                {{ $courses->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>
@endsection