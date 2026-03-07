@extends('layouts.teacher')

@section('title', 'Rekap Absensi - ' . $class->description)

@section('content')
<div class="bg-white p-4 sm:p-6 rounded-xl shadow-md">

    {{-- Judul --}}
    <h1 class="text-xl sm:text-2xl font-bold text-blue-700 mb-6">
        📊 Rekap Absensi - {{ $class->description }}
    </h1>

    {{-- FILTER --}}
    <div class="flex flex-col lg:flex-row lg:items-end gap-4 mb-6">

        {{-- Pilihan Kelas --}}
        <div class="w-full sm:w-auto">
            <label class="block text-sm font-semibold text-gray-700 mb-1">
                📚 Pilih Kelas
            </label>
            <select
                class="border rounded-lg px-3 py-2 w-full"
                onchange="if(this.value) window.location.href = this.value">
                @foreach ($classes ?? [] as $item)
                <option
                    value="{{ route('teacher.attendance.rekap', $item->id) }}?month={{ $month }}"
                    {{ $item->id == $class->id ? 'selected' : '' }}>
                    {{ $item->description }}
                </option>
                @endforeach
            </select>
        </div>

        {{-- Filter Bulan --}}
        <form method="GET"
            action="{{ route('teacher.attendance.rekap', $class->id) }}"
            class="flex flex-col sm:flex-row gap-3 w-full">

            <div class="w-full sm:w-auto">
                <label for="month" class="block text-sm font-semibold text-gray-700 mb-1">
                    📅 Pilih Bulan
                </label>
                <input type="month"
                    name="month"
                    id="month"
                    value="{{ $month }}"
                    class="border rounded-lg px-3 py-2 text-sm w-full">
            </div>

            <div class="flex flex-wrap gap-2 items-end">
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-semibold w-full sm:w-auto">
                    🔍 Tampilkan
                </button>

                {{-- Export Excel --}}
                <a href="{{ route('teacher.attendance.export', [$class->id, 'month' => $month]) }}"
                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-semibold w-full sm:w-auto text-center">
                    📥 Excel
                </a>

                {{-- Export PDF --}}
                <a href="{{ route('teacher.attendance.pdf', $class->id) }}?month={{ request('month') }}&course_id={{ request('course_id') }}"
                    class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-semibold w-full sm:w-auto text-center">
                    📄 PDF
                </a>
            </div>
        </form>
    </div>

    {{-- TABEL --}}
    <div class="overflow-x-auto">
        <table class="min-w-full border rounded-lg shadow text-sm">
            <thead class="bg-blue-100">
                <tr>
                    <th class="px-3 py-2 text-left">No</th>
                    <th class="px-3 py-2 text-left">Nama</th>
                    <th class="px-3 py-2 text-center text-green-700">H</th>
                    <th class="px-3 py-2 text-center text-yellow-600">I</th>
                    <th class="px-3 py-2 text-center text-blue-600">S</th>
                    <th class="px-3 py-2 text-center text-red-600">A</th>
                    <th class="px-3 py-2 text-center font-semibold">Total</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($students as $index => $student)
                @php
                $r = $rekap[$student->id] ?? [
                'Hadir'=>0,'Izin'=>0,'Sakit'=>0,'Alpa'=>0
                ];
                $total = array_sum($r);
                @endphp
                <tr class="border-t hover:bg-gray-50">
                    <td class="px-3 py-2">{{ $index + 1 }}</td>
                    <td class="px-3 py-2 font-medium whitespace-nowrap">{{ $student->name }}</td>
                    <td class="px-3 py-2 text-center text-green-600 font-semibold">{{ $r['Hadir'] }}</td>
                    <td class="px-3 py-2 text-center text-yellow-600 font-semibold">{{ $r['Izin'] }}</td>
                    <td class="px-3 py-2 text-center text-blue-600 font-semibold">{{ $r['Sakit'] }}</td>
                    <td class="px-3 py-2 text-center text-red-600 font-semibold">{{ $r['Alpha'] }}</td>
                    <td class="px-3 py-2 text-center font-bold">{{ $total }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-4 py-6 text-center text-gray-500">
                        Tidak ada data absensi untuk bulan ini.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- NAVIGASI --}}
    <div class="mt-6 flex flex-col sm:flex-row gap-4">
        <a href="{{ route('teacher.attendance.index') }}"
            class="px-6 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg shadow">
            ⬅️ Kembali
        </a>

        <a href="{{ route('teacher.attendance.show', $class->id) }}"
            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold shadow">
            📋 Lihat & Edit Absensi
        </a>
    </div>

</div>
@endsection