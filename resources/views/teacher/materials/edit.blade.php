@extends('layouts.teacher')

@section('title', 'Edit Materi')

@section('content')
<div class="container mx-auto px-4 py-10 space-y-10 text-gray-800">

    {{-- ✅ Alert sukses --}}
    @if (session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg shadow-sm">
        ✅ {{ session('success') }}
    </div>
    @endif

    {{-- ⚠️ Alert error --}}
    @if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg shadow-sm">
        ⚠️ <strong>Terjadi kesalahan:</strong>
        <ul class="mt-1 list-disc list-inside text-sm">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="bg-white border border-gray-200 p-6 rounded-2xl shadow-md hover:shadow-lg transition-all duration-300">
        <h2 class="text-2xl font-semibold text-blue-600 mb-5 flex items-center gap-2">
            ✏️ Edit Materi: {{ $material->title }}
        </h2>

        <form action="{{ route('teacher.materi.update', $material->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @method('PUT')

            <input type="hidden" name="class_id" value="{{ $class->id }}">

            {{-- 🏷️ Judul --}}
            <div>
                <label class="block text-gray-700 font-medium mb-1">Judul Materi</label>
                <input type="text" name="title" value="{{ old('title', $material->title) }}"
                    class="w-full border border-gray-300 bg-gray-50 rounded-lg px-4 py-2 
                    focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    required>
            </div>

            {{-- 📜 Deskripsi --}}
            <div>
                <label class="block text-gray-700 font-medium mb-1">Deskripsi Materi</label>
                <textarea name="description" rows="4"
                    class="w-full border border-gray-300 bg-gray-50 rounded-lg px-4 py-2 
                    focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    placeholder="Tuliskan deskripsi atau penjelasan singkat materi">{{ old('description', $material->description) }}</textarea>
            </div>

            {{-- 🔗 Link Meeting --}}
            <div>
                <label class="block text-gray-700 font-medium mb-1">Link Pertemuan (Google Meet / Zoom)</label>
                <input type="url" name="meeting_link" value="{{ old('meeting_link', $material->meeting_link) }}"
                    placeholder="https://meet.google.com/xxxx-xxxx-xxx"
                    class="w-full border border-gray-300 bg-gray-50 rounded-lg px-4 py-2 
                    focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>

            {{-- 📎 File Materi --}}
            <div>
                <label class="block text-gray-700 font-medium mb-1">File Materi</label>
                @if($material->file)
                <p class="mb-2 text-sm text-gray-600">
                    📎 File saat ini:
                    <a href="{{ asset('storage/' . $material->file) }}" target="_blank"
                        class="text-blue-600 hover:underline">Lihat / Download</a>
                </p>
                @endif
                <input type="file" name="file"
                    class="block w-full text-gray-700 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 
                    focus:outline-none focus:ring-2 focus:ring-blue-500">
                <p class="text-xs text-gray-400 mt-1">Kosongkan jika tidak ingin mengganti file.</p>
            </div>

            {{-- 🔗 Link Upload Tugas --}}
            <div>
                <label for="link_upload" class="block text-gray-700 font-medium mb-1">
                    🔗 Link Upload Tugas (Google Form / Google Drive)
                </label>
                <input
                    type="url"
                    id="link_upload"
                    name="link_upload"
                    placeholder="https://forms.gle/abcd1234 atau https://drive.google.com/..."
                    class="w-full border border-gray-300 bg-gray-50 rounded-lg px-4 py-2
               focus:ring-2 focus:ring-purple-500 focus:outline-none"
                    pattern="https?://.+"
                    title="Masukkan URL yang valid, misalnya https://forms.gle/abc123 atau https://drive.google.com/...">
                <p class="text-xs text-gray-400 mt-1">
                    Opsional — Kosongkan jika tidak menggunakan link upload tugas.
                </p>
            </div>

            {{-- 📝 Opsi Upload Tugas --}}
            <div class="flex items-center space-x-3 mt-3">
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

            {{-- 🔘 Tombol Aksi --}}
            <div class="flex items-center gap-3">
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-lg shadow-md transition-all">
                    💾 Simpan Perubahan
                </button>

                <a href="{{ route('teacher.materi.index', ['class_id' => $class->id]) }}"
                    class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-6 py-2.5 rounded-lg shadow-md transition-all">
                    ← Kembali
                </a>
            </div>
        </form>
    </div>
</div>
@endsection