@extends('layouts.teacher')

@section('title', 'Edit Nilai Siswa')

@section('content')
<div class="max-w-4xl mx-auto py-8">

    {{-- Judul halaman --}}
    <h1 class="text-2xl font-bold text-blue-700 mb-6">
        ✏️ Edit Nilai Siswa
    </h1>

    <div class="bg-white p-6 rounded-xl shadow-md">

        {{-- Form Update Nilai --}}
        <form method="POST" action="{{ route('teacher.grades.update', $grade->id) }}">
            @csrf
            @method('PUT')

            {{-- Nama siswa --}}
            <div class="mb-4">
                <label class="font-semibold text-gray-700">Nama Siswa</label>
                <input
                    type="text"
                    value="{{ $student->name }}"
                    class="border rounded-lg px-3 py-2 w-full bg-gray-100 text-gray-700"
                    readonly>
            </div>

            {{-- Input nilai --}}
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">

                @php
                $fields = [
                'rekap_absensi' => 'Rekap Absensi',
                'lingkup_materi_1' => 'Lingkup Materi 1',
                'lingkup_materi_2' => 'Lingkup Materi 2',
                'lingkup_materi_3' => 'Lingkup Materi 3',
                'lingkup_materi_4' => 'Lingkup Materi 4',
                'sumatif_akhir_semester' => 'Sumatif Akhir Semester',
                'uhb' => 'UHB',
                'psat' => 'PSAT',
                ];
                @endphp

                @foreach($fields as $field => $label)
                <div>
                    <label class="font-medium text-gray-600">{{ $label }}</label>
                    <input
                        type="number"
                        name="{{ $field }}"
                        value="{{ $grade->$field }}"
                        class="border rounded-lg px-3 py-2 w-full">
                </div>
                @endforeach

                {{-- KKTP --}}
                <div>
                    <label class="font-medium text-gray-600">KKTP</label>
                    <input
                        type="text"
                        name="kktp"
                        value="{{ $grade->kktp }}"
                        class="border rounded-lg px-3 py-2 w-full">
                </div>

            </div>

            {{-- Tombol --}}
            <div class="mt-6 flex justify-between items-center">
                <a
                    href="{{ route('teacher.grades.index', ['class_id' => $class->id]) }}"
                    class="bg-gray-400 text-white px-5 py-2 rounded-lg hover:bg-gray-500 transition">
                    ← Kembali
                </a>

                <button
                    type="submit"
                    class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition">
                    💾 Simpan Perubahan
                </button>
            </div>

        </form>
    </div>

</div>
@endsection