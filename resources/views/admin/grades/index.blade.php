@extends('layouts.admin')

@section('content')
<div class="container mx-auto mt-8 px-4">

    <!-- Header -->
    <h2 class="text-3xl font-bold text-gray-900 mb-6 flex items-center gap-2">
        📘 Kelola Nilai Siswa
    </h2>

    <!-- Filter Form -->
    <form action="{{ route('admin.grades.index') }}" method="GET"
        class="grid grid-cols-1 md:grid-cols-3 gap-6 bg-white p-6 rounded-lg shadow mb-8">

        {{-- PILIH KELAS --}}
        <div>
            <label for="class_id" class="block text-sm font-semibold text-gray-700 mb-1">Pilih Kelas:</label>
            <select name="class_id" id="class_id" required
                class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                <option value="">-- Pilih Kelas --</option>
                @foreach ($classes as $class)
                <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>
                    {{ $class->name }}
                </option>
                @endforeach
            </select>
        </div>

        {{-- PILIH MAPEL --}}
        <div>
            <label for="course_id" class="block text-sm font-semibold text-gray-700 mb-1">Pilih Mata Pelajaran:</label>
            <select name="course_id" id="course_id" required
                class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                <option value="">-- Pilih Mapel --</option>
                @foreach ($courses as $course)
                <option value="{{ $course->id }}" {{ request('course_id') == $course->id ? 'selected' : '' }}>
                    {{ $course->title }}
                </option>
                @endforeach
            </select>
        </div>

        {{-- TOMBOL --}}
        <div class="flex items-end">
            <button type="submit"
                class="w-full px-4 py-2 bg-indigo-600 text-white font-semibold rounded-lg shadow hover:bg-indigo-700 transition-colors">
                Tampilkan Nilai
            </button>
        </div>
    </form>

    @if ($grades->count() > 0)

    <!-- Action Bar -->
    <div class="flex flex-col md:flex-row justify-between items-center mb-4 gap-2">
        <h5 class="text-lg font-semibold text-gray-800 flex items-center gap-1">📋 Daftar Nilai</h5>

        <div class="flex gap-2">
            <a href="{{ route('admin.grades.export.excel', request()->query()) }}"
                class="px-3 py-2 bg-green-500 text-white rounded-lg text-sm font-medium hover:bg-green-600 transition-colors">
                📥 Download Excel
            </a>
            <a href="{{ route('admin.grades.export.pdf', request()->query()) }}"
                class="px-3 py-2 bg-red-500 text-white rounded-lg text-sm font-medium hover:bg-red-600 transition-colors">
                📄 Download PDF
            </a>
        </div>
    </div>

    <!-- Tabel Nilai -->
    <div class="overflow-x-auto bg-white shadow rounded-lg">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-3 py-2 text-left font-semibold text-gray-700">No</th>
                    <th class="px-3 py-2 text-left font-semibold text-gray-700">Nama Siswa</th>
                    <th class="px-3 py-2 text-left font-semibold text-gray-700">Mata Pelajaran</th>
                    <th class="px-3 py-2 text-center font-semibold text-gray-700">Rekap Absensi</th>
                    <th class="px-3 py-2 text-center font-semibold text-gray-700">LM 1</th>
                    <th class="px-3 py-2 text-center font-semibold text-gray-700">LM 2</th>
                    <th class="px-3 py-2 text-center font-semibold text-gray-700">LM 3</th>
                    <th class="px-3 py-2 text-center font-semibold text-gray-700">LM 4</th>
                    <th class="px-3 py-2 text-center font-semibold text-gray-700">Sumatif Akhir</th>
                    <th class="px-3 py-2 text-center font-semibold text-gray-700">PSAT</th>
                    <th class="px-3 py-2 text-center font-semibold text-gray-700">NA</th>
                    <th class="px-3 py-2 text-center font-semibold text-gray-700">KKTP</th>
                    <th class="px-3 py-2 text-left font-semibold text-gray-700">Tanggal Input</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-200">
                @forelse ($grades as $index => $grade)
                <tr class="hover:bg-gray-50">
                    <td class="px-3 py-2">{{ $index + 1 }}</td>
                    <td class="px-3 py-2">
                        {{ $grade->student->name ?? '-' }}
                    </td>
                    <td class="px-3 py-2">
                        {{ $grade->course->title ?? '-' }}
                    </td>

                    <td class="px-3 py-2 text-center">{{ $grade->rekap_absensi ?? '-' }}</td>
                    <td class="px-3 py-2 text-center">{{ $grade->lingkup_materi_1 ?? '-' }}</td>
                    <td class="px-3 py-2 text-center">{{ $grade->lingkup_materi_2 ?? '-' }}</td>
                    <td class="px-3 py-2 text-center">{{ $grade->lingkup_materi_3 ?? '-' }}</td>
                    <td class="px-3 py-2 text-center">{{ $grade->lingkup_materi_4 ?? '-' }}</td>
                    <td class="px-3 py-2 text-center">{{ $grade->sumatif_akhir_semester ?? '-' }}</td>
                    <td class="px-3 py-2 text-center">{{ $grade->psat ?? '-' }}</td>

                    <td class="px-3 py-2 text-center font-semibold text-indigo-600">
                        {{ $grade->na ?? '-' }}
                    </td>
                    <td class="px-3 py-2 text-center">
                        {{ $grade->kktp ?? '-' }}
                    </td>

                    <td class="px-3 py-2">
                        {{ optional($grade->created_at)->format('d/m/Y') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="13" class="px-4 py-6 text-center text-gray-500">
                        Data nilai belum tersedia.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>


    @else
    <p class="text-gray-500 mt-4">Silakan pilih kelas dan mapel untuk menampilkan nilai.</p>
    @endif

</div>
@endsection