@extends('layouts.teacher')

@section('content')
<div class="container mx-auto px-4 py-6 space-y-8">

    <h1 class="text-3xl font-bold mb-6">📚 Materi: {{ $class->name }}</h1>

    {{-- Form Upload Materi --}}
    <div class="bg-white p-6 rounded-xl shadow-md">
        <h2 class="text-2xl font-semibold text-green-700 mb-4">Upload Materi</h2>
        <form action="{{ route('teacher.materi.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <input type="hidden" name="class_id" value="{{ $class->id }}">
            <input type="text" name="title" placeholder="Judul Materi"
                class="w-full border border-gray-300 rounded px-3 py-2" required>
            <textarea name="content" placeholder="Deskripsi Materi" class="w-full border border-gray-300 rounded px-3 py-2"></textarea>
            <input type="file" name="file" class="w-full">

            {{-- 📝 Opsi Upload Tugas --}}
            <div class="flex items-center space-x-3">
                <input
                    type="checkbox"
                    name="allow_task_upload"
                    id="allow_task_upload"
                    value="1"
                    class="h-5 w-5 text-green-600 focus:ring-green-500 border-gray-300 rounded">
                <label for="allow_task_upload" class="text-gray-700 select-none">
                    📝 Izinkan siswa mengunggah tugas untuk materi ini
                </label>
            </div>

            <button type="submit"
                class="bg-green-500 hover:bg-green-600 text-white px-5 py-2 rounded-md w-full">Upload</button>
        </form>
    </div>

    {{-- Tabel Daftar Materi --}}
    <div class="bg-white p-6 rounded-xl shadow-md">
        <h2 class="text-2xl font-semibold text-gray-700 mb-4">Daftar Materi</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 border-b">#</th>
                        <th class="px-4 py-2 border-b">Judul</th>
                        <th class="px-4 py-2 border-b">File</th>
                        <th class="px-4 py-2 border-b">Tanggal Upload</th>
                        <th class="px-4 py-2 border-b">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($class->materials as $index => $material)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2 border-b">{{ $index + 1 }}</td>
                        <td class="px-4 py-2 border-b">{{ $material->title }}</td>
                        <td class="px-4 py-2 border-b">
                            @if($material->file)
                            <a href="{{ asset('storage/' . $material->file) }}" target="_blank"
                                class="text-blue-600 hover:underline">Download</a>
                            @else
                            -
                            @endif
                        </td>
                        <td class="px-4 py-2 border-b">{{ $material->created_at->format('d M Y H:i') }}</td>
                        <td class="px-4 py-2 border-b">
                            <form action="{{ route('teacher.materi.destroy', $material->id) }}" method="POST"
                                onsubmit="return confirm('Yakin ingin menghapus materi ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-md text-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-4 py-2 text-center text-gray-500">Belum ada materi</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection