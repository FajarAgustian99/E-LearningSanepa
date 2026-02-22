@extends('layouts.teacher')

@section('title', 'Hasil Quiz: ' . $quiz->title)

@section('content')
<div class="container mx-auto px-4 py-8">

    <h1 class="text-3xl font-bold text-[#0A1D56] mb-2">
        Hasil Quiz: {{ $quiz->title }}
    </h1>

    <p class="text-gray-600 mb-6">
        Daftar siswa dan nilai hasil pengerjaan quiz.
    </p>
    <div class="flex gap-2 mb-4">
        <a href="{{ route('teacher.quiz.export.excel', $quiz->id) }}"
            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm">
            📥 Export Excel
        </a>

        <a href="{{ route('teacher.quiz.export.pdf', $quiz->id) }}"
            class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm">
            📄 Export PDF
        </a>
    </div>
    @php
    $hasEssay = $quiz->questions->where('question_type', 'essay')->count() > 0;
    @endphp

    <div class="bg-white shadow-md rounded-xl overflow-hidden">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="px-4 py-3">No</th>
                    <th class="px-4 py-3">Nama Siswa</th>
                    <th class="px-4 py-3">Total Nilai</th>
                    <th class="px-4 py-3">Status</th>
                </tr>
            </thead>

            <tbody class="divide-y">
                @forelse ($submissions as $index => $submission)
                <tr>
                    <td class="px-4 py-3">
                        {{ $index + 1 }}
                    </td>

                    <td class="px-4 py-3 font-medium">
                        {{ $submission->user->name }}
                    </td>

                    <td class="px-4 py-3 font-semibold text-blue-700">
                        {{ $submission->score }}
                    </td>

                    <td class="px-4 py-3">
                        @if ($hasEssay)
                        <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-xs font-semibold">
                            Menunggu Penilaian Essay
                        </span>
                        @else
                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs font-semibold">
                            Selesai
                        </span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-4 py-6 text-center text-gray-500">
                        Belum ada siswa yang mengerjakan quiz ini.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection