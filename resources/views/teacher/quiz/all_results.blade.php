@extends('layouts.teacher')

@section('title', 'Hasil Semua Asesmen - ' . $class->description)

@section('content')
<div class="container mx-auto px-4 py-8">

    <h1 class="text-3xl font-bold text-[#0A1D56] mb-4">
        Hasil Semua Asesmen - {{ $class->description }}
    </h1>

    {{-- Filter Quiz --}}
    <div class="flex items-center gap-3 mb-4">
        <form action="{{ route('teacher.quiz.allResults', $class->id) }}" method="GET" class="flex items-center  gap-2">
            <label for="quiz_id" class="mr-2 font-medium">Filter Asesmen:</label>
            <select name="quiz_id" id="quiz_id" class="border rounded px-2 py-1">
                <option value="">-- Semua Asesmen --</option>
                @foreach($quizzes as $q)
                <option value="{{ $q->id }}" {{ request('quiz_id') == $q->id ? 'selected' : '' }}>
                    {{ $q->title }}
                </option>
                @endforeach
            </select>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded">Terapkan</button>
        </form>
    </div>

    <div class="bg-white shadow-md rounded-xl overflow-hidden">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="px-4 py-3">No</th>
                    <th class="px-4 py-3">Nama Siswa</th>
                    <th class="px-4 py-3">Quiz</th>
                    <th class="px-4 py-3">Total Nilai</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y">
                @php $no = 1; @endphp

                @forelse ($results as $submission)
                <tr>
                    <td class="px-4 py-3">{{ $no++ }}</td>
                    <td class="px-4 py-3 font-medium">{{ $submission->user->name }}</td>
                    <td class="px-4 py-3 font-semibold">{{ $submission->quiz->title }}</td>
                    <td class="px-4 py-3 font-semibold text-blue-700">
                        {{ ($submission->multiple_choice_score ?? 0) + array_sum($submission->essay_scores ?? []) }}
                    </td>
                    <td class="px-4 py-3">
                        @if($submission->quiz->questions->where('question_type','essay')->count() > 0)
                        <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-xs font-semibold">
                            Essay Perlu Penilaian Manual
                        </span>
                        @else
                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs font-semibold">
                            Selesai
                        </span>
                        @endif
                    </td>
                    <td class="px-4 py-3">
                        @if($submission->quiz->questions->where('question_type','essay')->count() > 0)
                        <button onclick="openModal('modal{{ $submission->id }}')"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-1.5 rounded-lg text-xs">
                            Lihat Essay
                        </button>
                        @endif
                        <a href="{{ route('teacher.quiz.results', $submission->quiz->id) }}"
                            class="bg-gray-600 hover:bg-gray-700 text-white px-3 py-1.5 rounded-lg text-xs ml-1">
                            Detail Quiz
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-4 py-6 text-center text-gray-500">
                        Belum ada asesmen atau siswa yang mengerjakan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <br>
    <a href="{{ route('teacher.quiz.results', $submission->quiz->id) }}"
        class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium px-5 py-2.5 rounded-lg shadow-sm">
        ← Kembali
    </a>
</div>

{{-- Modal essay --}}
@foreach ($results as $submission)
@php $answers = $submission->answers ?? []; @endphp
<div id="modal{{ $submission->id }}" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-lg w-11/12 max-w-2xl p-6">
        <form method="POST" action="{{ route('teacher.quiz.gradeEssay', [$submission->quiz->id, $submission->id]) }}">
            @csrf
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-bold">Jawaban Essay - {{ $submission->user->name }}</h2>
                <button type="button" onclick="closeModal('modal{{ $submission->id }}')" class="text-gray-500 hover:text-gray-800 text-xl">✕</button>
            </div>

            <div class="space-y-4 max-h-[400px] overflow-y-auto">
                @foreach($submission->quiz->questions->where('question_type','essay') as $essay)
                <div class="border rounded-lg p-4">
                    <p class="font-semibold text-gray-800">{{ $loop->iteration }}. {!! $essay->question_text !!}</p>
                    <div class="mt-2 bg-gray-50 p-3 rounded text-sm text-gray-700">
                        {{ $answers[$essay->id] ?? 'Tidak menjawab' }}
                    </div>
                    <div class="mt-3">
                        <label class="text-sm font-medium">Nilai</label>
                        <input type="number" name="essay_scores[{{ $essay->id }}]"
                            class="w-24 border rounded px-2 py-1 text-sm"
                            min="0" max="100"
                            value="{{ $submission->essay_scores[$essay->id] ?? 0 }}">
                    </div>
                </div>
                @endforeach
            </div>

            <div class="mt-4 flex justify-end gap-2">
                <button type="button" onclick="closeModal('modal{{ $submission->id }}')" class="bg-gray-300 px-4 py-2 rounded">Tutup</button>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Simpan Nilai</button>
            </div>
        </form>
    </div>
</div>
@endforeach

<script>
    function openModal(id) {
        document.getElementById(id).classList.remove('hidden');
        document.getElementById(id).classList.add('flex');
    }

    function closeModal(id) {
        document.getElementById(id).classList.add('hidden');
    }
</script>
@endsection