@extends('layouts.admin')
@section('title', 'Edit Siswa')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold text-center text-gray-800 mb-6">Edit Siswa</h1>

    <div class="bg-white shadow-md rounded-lg p-6 mx-auto w-full max-w-lg">

        {{-- ALERT SUKSES --}}
        @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
        @endif

        <form id="editStudentForm" action="{{ route('admin.students.update', $student) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name', $student->name) }}" required
                    class="mt-1 block w-full border border-gray-300 rounded-md p-2">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">NISN</label>
                <input type="text" name="nisn" value="{{ old('nisn', $student->nisn) }}" required
                    class="mt-1 block w-full border border-gray-300 rounded-md p-2">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Password (kosongkan jika tidak diubah)</label>
                <input type="password" name="password"
                    class="mt-1 block w-full border border-gray-300 rounded-md p-2">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Kelas</label>
                <select name="class_id" required class="mt-1 block w-full border border-gray-300 rounded-md p-2">
                    <option value="">Pilih Kelas</option>
                    @foreach($classes as $class)
                    <option value="{{ $class->id }}" {{ $student->class_id == $class->id ? 'selected' : '' }}>
                        {{ $class->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="flex justify-end space-x-4">
                <a href="{{ route('admin.students.index') }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white font-medium px-4 py-2 rounded-lg transition">
                    Batal
                </a>

                {{-- Tombol: Memicu modal --}}
                <button type="button" onclick="showConfirmModal()"
                    class="bg-blue-500 hover:bg-blue-600 text-white font-medium px-4 py-2 rounded-lg transition">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ======================== MODAL KONFIRMASI ======================== --}}
<div id="confirmModal"
    class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">

    <div class="bg-white w-full max-w-md rounded-lg shadow-lg p-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-3">Konfirmasi Penyimpanan</h2>
        <p class="text-gray-600 mb-5">
            Apakah Anda yakin data siswa sudah benar dan ingin disimpan?
        </p>

        <div class="flex justify-end space-x-3">
            <button onclick="hideConfirmModal()"
                class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400 transition">
                Cek Lagi
            </button>

            <button onclick="submitForm()"
                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                Ya, Simpan
            </button>
        </div>
    </div>
</div>

{{-- SCRIPT MODAL --}}
<script>
    function showConfirmModal() {
        document.getElementById('confirmModal').classList.remove('hidden');
    }

    function hideConfirmModal() {
        document.getElementById('confirmModal').classList.add('hidden');
    }

    function submitForm() {
        document.getElementById('editStudentForm').submit();
    }
</script>

@endsection