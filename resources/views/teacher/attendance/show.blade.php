@extends('layouts.teacher')

@section('title', 'Input Absensi' )

@section('content')
<div class="bg-white p-6 rounded-xl shadow-md">
    <h1 class="text-2xl font-bold text-blue-700 mb-4">
        🗒️ Input Absensi - {{ $class->description }}
    </h1>

    {{-- Notifikasi --}}
    @if (session('success'))
    <div class="bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded-lg mb-4">
        ✅ {{ session('success') }}
    </div>
    @endif

    {{-- Tombol Kunci / Buka Absensi --}}
    <form action="{{ route('teacher.attendance.toggleLock', $class->id) }}" method="POST" class="mb-4">
        @csrf
        <button type="submit"
            class="px-4 py-2 rounded-lg font-semibold shadow
                   {{ $locked ? 'bg-gray-500 hover:bg-gray-600 text-white' : 'bg-red-500 hover:bg-red-600 text-white' }}">
            {{ $locked ? '🔒 Absensi Terkunci' : '🔓 Absensi Terbuka' }}
        </button>
    </form>

    {{-- Form Input Absensi --}}
    <form action="{{ route('teacher.attendance.store') }}" method="POST">
        @csrf
        <input type="hidden" name="class_id" value="{{ $class->id }}">
        <input type="hidden" name="date" value="{{ $date }}">
        {{-- Pilihan Kelas --}}
        <div class="mb-6">
            <label for="class_select" class="block mb-2 font-semibold text-gray-700">
                📚 Pilih Kelas
            </label>

            <select
                id="class_select"
                class="border rounded-lg px-4 py-2 w-64"
                onchange="if(this.value) window.location.href = this.value">
                <option value="">-- Pilih Kelas --</option>
                @foreach ($classes as $item)
                <option
                    value="{{ route('teacher.attendance.show', $item->id) }}"
                    {{ $item->id == $class->id ? 'selected' : '' }}>
                    {{ $item->description }}
                </option>
                @endforeach
            </select>
        </div>

        <table class="min-w-full border rounded-lg overflow-hidden shadow">
            <thead class="bg-blue-100">
                <tr>
                    <th class="px-4 py-3 text-left text-gray-700 font-semibold">No</th>
                    <th class="px-4 py-3 text-left text-gray-700 font-semibold">Nama Siswa</th>
                    <th class="px-4 py-3 text-center text-gray-700 font-semibold">Status Kehadiran</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($students as $index => $student)
                @php
                $status = $attendances[$student->id]->status ?? '';
                @endphp
                <tr class="border-t hover:bg-gray-50">
                    <td class="px-4 py-3">{{ $index + 1 }}</td>
                    <td class="px-4 py-3 font-medium">{{ $student->name }}</td>
                    <td class="px-4 py-3 text-center">
                        <select name="status[{{ $student->id }}]"
                            class="status-select border rounded-lg px-3 py-2 w-40 {{ $locked ? 'bg-gray-200 cursor-not-allowed' : '' }}"
                            {{ $locked ? 'disabled' : '' }}>
                            <option value="">-- Pilih --</option>
                            <option value="Hadir" {{ $status === 'Hadir' ? 'selected' : '' }}>Hadir</option>
                            <option value="Izin" {{ $status === 'Izin' ? 'selected' : '' }}>Izin</option>
                            <option value="Sakit" {{ $status === 'Sakit' ? 'selected' : '' }}>Sakit</option>
                            <option value="Alpa" {{ $status === 'Alpa' ? 'selected' : '' }}>Alpa</option>
                        </select>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="px-4 py-6 text-center text-gray-500">
                        Tidak ada siswa di kelas ini.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-6 flex  gap-4">
            <a href="{{ route('teacher.attendance.index') }}"
                class="px-6 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg shadow">← Kembali</a>

            <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold shadow"
                {{ $locked ? 'disabled' : '' }}>
                💾 Simpan Absensi
            </button>
        </div>
    </form>
</div>

{{-- Script warna otomatis untuk select --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selects = document.querySelectorAll('.status-select');

        selects.forEach(select => {
            function updateColor() {
                select.classList.remove(
                    'bg-green-500', 'bg-yellow-400', 'bg-blue-500', 'bg-red-500',
                    'text-white', 'text-black'
                );

                switch (select.value) {
                    case 'Hadir':
                        select.classList.add('bg-green-500', 'text-white');
                        break;
                    case 'Izin':
                        select.classList.add('bg-yellow-400', 'text-black');
                        break;
                    case 'Sakit':
                        select.classList.add('bg-blue-500', 'text-white');
                        break;
                    case 'Alpa':
                        select.classList.add('bg-red-500', 'text-white');
                        break;
                    default:
                        select.classList.remove(
                            'bg-green-500', 'bg-yellow-400', 'bg-blue-500', 'bg-red-500',
                            'text-white', 'text-black'
                        );
                }
            }

            // Jalankan saat load dan saat perubahan
            updateColor();
            select.addEventListener('change', updateColor);
        });
    });
</script>
@endsection