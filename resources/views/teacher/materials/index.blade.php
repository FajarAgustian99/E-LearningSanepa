@extends('layouts.teacher')

@section('title', 'Materi ' . $class->name)

@section('content')
<div class="container mx-auto px-4 py-10 space-y-12 bg-gray-50 min-h-screen text-gray-800">

    {{-- ✅ Alert Sukses --}}
    @if (session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg shadow-sm">
        ✅ {{ session('success') }}
    </div>
    @endif

    {{-- ⚠️ Alert Error --}}
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

    {{-- 📘 Header --}}
    <div class="flex items-center justify-between flex-wrap gap-4 border-b border-gray-200 pb-4">
        <h1 class="text-3xl font-bold text-gray-900 flex items-center gap-3">
            📚 Materi Kelas: <span class="text-blue-600">{{ $class->name }}</span>
        </h1>
        <div class="flex gap-2">
            {{-- Tombol Buat Quiz --}}
            <a href="{{ route('teacher.quiz.create', $class->id) }}"
                class="bg-yellow-500 hover:bg-yellow-600 text-white font-medium px-5 py-2.5 rounded-lg shadow-sm transition-all">
                🧠 Buat Quiz
            </a>
        </div>
    </div>


    {{-- 📤 Upload Materi --}}
    <div class="bg-white border border-gray-200 p-6 rounded-2xl shadow-md hover:shadow-lg transition-all duration-300">
        <h2 class="text-2xl font-semibold text-green-600 mb-5 flex items-center gap-2">
            📤 Upload Materi Baru
        </h2>

        <form action="{{ route('teacher.materi.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            <input type="hidden" name="class_id" value="{{ $class->id }}">

            {{-- 🏷️ Judul --}}
            <input type="text" name="title" placeholder="Judul Materi"
                class="w-full border border-gray-300 bg-gray-50 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:outline-none"
                required>

            {{-- 📜 Deskripsi --}}
            <textarea name="description" placeholder="Deskripsi Materi"
                class="w-full border border-gray-300 bg-gray-50 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:outline-none"></textarea>

            {{-- 📎 File --}}
            <input type="file" name="file"
                class="block w-full text-gray-700 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none focus:ring-2 focus:ring-green-500">

            {{-- 🔗 Link Pertemuan --}}
            <input type="url" name="meeting_link" placeholder="Link Google Meet atau Zoom"
                class="w-full border border-gray-300 bg-gray-50 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                pattern="https?://.+" title="Masukkan URL yang valid, misalnya https://meet.google.com/...">

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


            {{-- 🔘 Tombol Upload --}}
            <button type="submit"
                class="bg-green-600 hover:bg-green-700 text-white px-6 py-2.5 rounded-lg shadow-md transition-all duration-300">
                🚀 Upload
            </button>
        </form>
    </div>

    {{-- 🗂️ Daftar Materi --}}
    <div class="bg-white border border-gray-200 p-6 rounded-2xl shadow-md hover:shadow-lg transition-all duration-300">
        <h2 class="text-2xl font-semibold text-blue-600 mb-4 flex items-center gap-2">
            🗂️ Daftar Materi
        </h2>

        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-200 text-sm rounded-lg overflow-hidden">
                <thead class="bg-blue-50 text-blue-700 uppercase tracking-wide">
                    <tr>
                        <th class="px-4 py-2 border-b">No</th>
                        <th class="px-4 py-2 border-b">Judul</th>
                        <th class="px-4 py-2 border-b">Deskripsi</th>
                        <th class="px-4 py-2 border-b">File</th>
                        <th class="px-4 py-2 border-b">Tanggal Upload</th>
                        <th class="px-4 py-2 border-b">Link Pertemuan</th>
                        <th class="px-4 py-2 border-b">Upload Tugas</th>
                        <th class="px-4 py-2 border-b text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody class="text-gray-700">
                    @forelse($class->materials as $index => $material)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-4 py-2 border-b text-center text-gray-500">{{ $index + 1 }}</td>
                        <td class="px-4 py-2 border-b font-semibold">{{ $material->title }}</td>
                        <td class="px-4 py-2 border-b">{{ $material->description ?? '-' }}</td>

                        <td class="px-4 py-2 border-b text-center">
                            @if($material->file)
                            <a href="{{ asset('storage/' . $material->file) }}" target="_blank"
                                class="text-blue-600 hover:underline hover:text-blue-800">Download</a>
                            @else
                            <span class="text-gray-400">-</span>
                            @endif
                        </td>

                        <td class="px-4 py-2 border-b text-center text-gray-500">
                            {{ $material->created_at->format('d M Y H:i') }}
                        </td>

                        <td class="px-4 py-2 border-b text-center">
                            @if($material->meeting_link)
                            <a href="{{ $material->meeting_link }}" target="_blank"
                                class="text-blue-600 hover:underline hover:text-blue-800">Join</a>
                            @else
                            <span class="text-gray-400">-</span>
                            @endif
                        </td>

                        <td class="px-4 py-2 border-b text-center">
                            @if($material->link_upload)
                            <a href="{{ $material->link_upload }}" target="_blank"
                                class="text-purple-600 hover:underline hover:text-purple-800">Link Upload</a>
                            @else
                            <span class="text-gray-400">-</span>
                            @endif
                        </td>

                        <td class="px-4 py-2 border-b text-center">
                            <div class="flex justify-center space-x-2">

                                {{-- Tombol Edit --}}
                                <a href="{{ route('teacher.materi.edit', $material->id) }}"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded-md text-sm transition-all">
                                    ✏️ Edit
                                </a>

                                {{-- Tombol Lihat Pengumpulan Tugas (jika upload tugas diaktifkan) --}}
                                @if($material->allow_task_upload)
                                <a href="{{ route('teacher.materi.submission.index', $material->id) }}"
                                    class="bg-purple-600 hover:bg-purple-700 text-white px-3 py-1 rounded-md text-sm transition-all">
                                    📥 Lihat Tugas
                                </a>
                                @endif

                                {{-- Tombol Hapus --}}
                                <form action="{{ route('teacher.materi.destroy', $material->id) }}" method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus materi ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded-md text-sm transition-all">
                                        🗑️ Hapus
                                    </button>
                                </form>

                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-4 py-4 text-center text-gray-500 bg-gray-50 rounded-lg">
                            Belum ada materi di kelas ini.
                        </td>
                    </tr>
                    @endforelse
                </tbody>

            </table>
        </div>
    </div>

    {{-- 🧠 Daftar Quiz --}}
    <div class="bg-white border border-gray-200 p-6 rounded-2xl shadow-md hover:shadow-lg transition-all duration-300 mt-10">
        <h2 class="text-2xl font-semibold text-yellow-600 mb-4 flex items-center gap-2">
            🧠 Daftar Quiz
        </h2>

        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-200 text-sm rounded-lg overflow-hidden">
                <thead class="bg-yellow-50 text-yellow-700 uppercase tracking-wide">
                    <tr>
                        <th class="px-4 py-2 border-b">No</th>
                        <th class="px-4 py-2 border-b">Judul</th>
                        <th class="px-4 py-2 border-b">Deskripsi</th>
                        <th class="px-4 py-2 border-b">Batas Waktu</th>
                        <th class="px-4 py-2 border-b text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody class="text-gray-700">
                    @forelse($class->quizzes as $index => $quiz)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-4 py-2 border-b text-center text-gray-500">{{ $index + 1 }}</td>
                        <td class="px-4 py-2 border-b font-semibold">{{ $quiz->title }}</td>
                        <td class="px-4 py-2 border-b">{{ $quiz->description ?? '-' }}</td>
                        <td class="px-4 py-2 border-b text-center text-gray-600">
                            {{ $quiz->due_date ? \Carbon\Carbon::parse($quiz->due_date)->format('d M Y H:i') : '-' }}
                        </td>
                        <td class="px-4 py-2 border-b text-center">
                            <div class="flex justify-center gap-2">

                                {{-- Tombol Edit --}}
                                <a href="{{ route('teacher.quiz.edit', $quiz->id) }}"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded-md text-sm transition-all">
                                    ✏️ Edit
                                </a>

                                {{-- Tombol Lihat Hasil Quiz --}}
                                <a href="{{ route('teacher.quiz.results', $quiz->id) }}"
                                    class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded-md text-sm transition-all">
                                    📊 Hasil
                                </a>

                                {{-- Tombol Hapus --}}
                                <form action="{{ route('teacher.quiz.destroy', $quiz->id) }}" method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus quiz ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded-md text-sm transition-all">
                                        🗑️ Hapus
                                    </button>
                                </form>

                            </div>
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-4 py-4 text-center text-gray-500 bg-gray-50 rounded-lg">
                            Belum ada quiz untuk kelas ini.
                        </td>
                    </tr>
                    @endforelse
                </tbody>

            </table>
        </div>
    </div>


</div>
@endsection