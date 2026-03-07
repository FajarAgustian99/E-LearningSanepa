@extends('layouts.student')

@section('title','Riwayat Nilai Assesmen')

@section('content')
<div class="container mx-auto px-4 py-10">

    <div class="bg-white shadow-lg rounded-xl overflow-hidden">

        {{-- HEADER --}}
        <div class="bg-[#0A1D56] px-6 py-4">
            <h3 class="text-xl font-bold text-white">
                📘 Riwayat Nilai Assesmen
            </h3>
        </div>

        <div class="p-6 overflow-x-auto">
            <table class="min-w-full border divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold text-gray-700">No</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Assesmen</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Skor</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Status</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Dikerjakan Pada</th>
                    </tr>
                </thead>

                <tbody class="divide-y">
                    @forelse ($quizHistory as $submission)
                    <tr class="hover:bg-gray-50 transition">

                        {{-- Nomor --}}
                        <td class="px-4 py-3">{{ $loop->iteration }}</td>

                        {{-- Judul Quiz --}}
                        <td class="px-4 py-3 font-medium text-gray-800">
                            {{ $submission->quiz->title ?? 'Quiz Dihapus' }}
                        </td>

                        {{-- Total Nilai --}}
                        <td class="px-4 py-3">
                            @php

                            $totalScore = $submission->score ?? 0;
                            @endphp

                            {{-- Cek apakah kuis sudah disubmit --}}
                            @if ($submission->is_submitted)
                            <span class="px-3 py-1 text-xs font-semibold bg-green-100 text-green-700 rounded-full">
                                {{ $totalScore }}
                            </span>
                            @else
                            <span class="px-3 py-1 text-xs font-semibold bg-gray-200 text-gray-600 rounded-full">
                                Belum Dinilai
                            </span>
                            @endif
                        </td>

                        {{-- Status Submit --}}
                        <td class="px-4 py-3">
                            @if ($submission->is_submitted)
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
                            {{ $submission->created_at->format('d M Y H:i') }}
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-4 py-6 text-center text-gray-500 italic">
                            Belum ada riwayat pengerjaan asesmen.
                        </td>
                    </tr>
                    @endforelse
                </tbody>

            </table>
        </div>
    </div>

</div>
@endsection