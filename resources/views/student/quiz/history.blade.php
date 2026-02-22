@extends('layouts.student')

@section('title','Riwayat Nilai Quiz')

@section('content')
<div class="container mx-auto px-4 py-10">

    <div class="bg-white shadow-lg rounded-xl overflow-hidden">

        {{-- HEADER --}}
        <div class="bg-[#0A1D56] px-6 py-4">
            <h3 class="text-xl font-bold text-white">
                📘 Riwayat Nilai Quiz
            </h3>
        </div>

        <div class="p-6 overflow-x-auto">
            <table class="min-w-full border divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold text-gray-700">No</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Quiz</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Kelas</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Skor</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Status</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Dikerjakan Pada</th>
                    </tr>
                </thead>

                <tbody class="divide-y">
                    @forelse ($quizhistory as $item)
                    <tr class="hover:bg-gray-50 transition">

                        {{-- Nomor --}}
                        <td class="px-4 py-3">{{ $loop->iteration }}</td>

                        {{-- Judul Quiz --}}
                        <td class="px-4 py-3 font-medium text-gray-800">
                            {{ $item->quiz->title }}
                        </td>

                        {{-- Nama Kelas --}}
                        <td class="px-4 py-3 text-gray-700">
                            {{ $item->quiz->course->name ?? '-' }}
                        </td>

                        {{-- Score --}}
                        <td class="px-4 py-3">
                            @if ($item->score !== null)
                            <span class="px-3 py-1 text-xs font-semibold bg-green-100 text-green-700 rounded-full">
                                {{ $item->score }}
                            </span>
                            @else
                            <span class="px-3 py-1 text-xs font-semibold bg-gray-200 text-gray-600 rounded-full">
                                Belum Dinilai
                            </span>
                            @endif
                        </td>

                        {{-- Status Submit --}}
                        <td class="px-4 py-3">
                            @if ($item->is_submitted)
                            <span class="px-3 py-1 text-xs font-semibold bg-blue-100 text-blue-700 rounded-full">
                                Sudah Submit
                            </span>
                            @else
                            <span class="px-3 py-1 text-xs font-semibold bg-red-100 text-red-700 rounded-full">
                                Belum Submit
                            </span>
                            @endif
                        </td>

                        {{-- Tanggal --}}
                        <td class="px-4 py-3 text-gray-600">
                            {{ $item->created_at->format('d M Y H:i') }}
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-4 py-6 text-center text-gray-500 italic">
                            Belum ada riwayat pengerjaan quiz.
                        </td>
                    </tr>
                    @endforelse
                </tbody>

            </table>
        </div>
    </div>

</div>
@endsection