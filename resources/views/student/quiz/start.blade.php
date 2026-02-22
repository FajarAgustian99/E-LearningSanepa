@extends('layouts.student')

@section('title', 'Mulai Kuis')
@section('page-title', 'Mulai Kuis')

@section('content')
<div class="container mx-auto px-4 py-10">

    {{-- Tombol kembali --}}
    <a href="{{ route('student.quiz.show', $quiz->id) }}"
        class="inline-block mb-4 text-gray-600 hover:text-gray-800">
        &larr; Kembali ke Detail Quiz
    </a>

    <div class="bg-white p-6 rounded-xl shadow-md space-y-6">

        {{-- Header --}}
        <div class="flex items-center justify-between">
            <div class="max-w-[70%]">
                <h2 class="text-2xl font-bold text-[#0A1D56] truncate">{{ $quiz->title }}</h2>
                <p class="text-gray-600 text-sm">Durasi: {{ $quiz->duration }} menit</p>
            </div>

            {{-- Countdown Timer --}}
            <!-- <div class="bg-red-50 p-3 rounded-lg border border-red-200 w-48">
                <p class="text-red-500 text-xs font-semibold uppercase">Sisa Waktu</p>
                <p id="timer" class="text-xl font-mono font-bold text-red-600">00:00</p>

                <div class="w-full h-2 bg-red-100 rounded mt-2 overflow-hidden">
                    <div
                        id="timeBar"
                        class="h-2 bg-red-500 transition-all"
                        style="width:100%">
                    </div>
                </div>
            </div> -->
        </div>

        {{-- Progress Bar --}}
        <!-- <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
            <div class="flex justify-between text-sm font-medium mb-2">
                <span class="text-gray-600">Progres Pengerjaan</span>
                <span id="progressText" class="text-blue-600">0%</span>
            </div>
            <div class="w-full bg-gray-200 h-3 rounded-full overflow-hidden">
                <div id="progressBar"
                    class="h-3 bg-blue-600 rounded-full transition-all duration-500 shadow-sm"
                    style="width:0%">
                </div>
            </div>
        </div> -->

        <hr class="border-gray-100">

        {{-- FORM KUIS --}}
        <form id="quizForm" action="{{ route('student.quiz.submit', $quiz->id) }}" method="POST">
            @csrf

            @foreach ($quiz->questions as $index => $question)
            <div class="question-block mb-8 p-6 border border-gray-200 rounded-xl bg-white hover:border-blue-200 transition-colors">
                <div class="flex gap-3">
                    <span class="flex-shrink-0 flex items-center justify-center w-8 h-8 rounded-full bg-blue-100 text-blue-700 font-bold text-sm">
                        {{ $index + 1 }}
                    </span>
                    <div class="flex-1">
                        <p class="text-lg text-gray-800 mb-4 leading-relaxed">
                            {{ $question->question_text }}
                        </p>

                        {{-- Pilihan Ganda --}}
                        @if ($question->question_type === 'multiple_choice')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            @foreach (['option_a','option_b','option_c','option_d'] as $option)
                            @if ($question->$option)
                            <label class="flex items-center p-3 border border-gray-100 rounded-lg cursor-pointer hover:bg-blue-50 transition-all group">
                                <input type="radio"
                                    name="answers[{{ $question->id }}]"
                                    value="{{ $option }}"
                                    class="answer-input w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                <span class="ml-3 text-gray-700 group-hover:text-blue-800">
                                    {{ $question->$option }}
                                </span>
                            </label>
                            @endif
                            @endforeach
                        </div>
                        @endif

                        {{-- Essay --}}
                        @if ($question->question_type === 'essay')
                        <textarea name="answers[{{ $question->id }}]"
                            rows="4"
                            class="answer-input w-full border border-gray-200 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all"
                            placeholder="Tuliskan jawaban lengkap Anda di sini..."></textarea>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach

            <div class="sticky bottom-6 bg-white p-4 rounded-xl shadow-lg border border-gray-200 flex justify-end">
                <button type="submit" id="submitBtn"
                    class="w-full md:w-auto bg-[#0A1D56] text-white px-10 py-3 rounded-lg font-bold hover:bg-blue-900 transition-all transform active:scale-95 shadow-md">
                    Kumpulkan Semua Jawaban
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ===================== SCRIPT ===================== --}}
<!-- <script>
    document.addEventListener('DOMContentLoaded', () => {

        /* =========================
           KONFIGURASI
        ========================== */
        const quizId = {
            {
                $quiz - > id
            }
        };
        const endTime = {
            {
                $submission - > end_time - > timestamp
            }
        };
        const storageKey = `quiz_answers_${quizId}`;

        const form = document.getElementById('quizForm');
        const submitBtn = document.getElementById('submitBtn');
        const timerEl = document.getElementById('timer');
        const questions = document.querySelectorAll('.question-block');
        const inputs = document.querySelectorAll('.answer-input');

        let isSubmitted = false;

        /* =========================
           AUTOSAVE KE LOCALSTORAGE
        ========================== */
        function saveAnswers() {
            const data = {};

            inputs.forEach(input => {
                if (input.type === 'radio' && input.checked) {
                    data[input.name] = input.value;
                }

                if (input.tagName === 'TEXTAREA') {
                    data[input.name] = input.value;
                }
            });

            localStorage.setItem(storageKey, JSON.stringify(data));
        }

        function loadAnswers() {
            const saved = localStorage.getItem(storageKey);
            if (!saved) return;

            const data = JSON.parse(saved);

            inputs.forEach(input => {
                if (data[input.name] !== undefined) {
                    if (input.type === 'radio') {
                        input.checked = input.value === data[input.name];
                    } else {
                        input.value = data[input.name];
                    }
                }
            });
        }

        inputs.forEach(input => {
            input.addEventListener('change', saveAnswers);
            input.addEventListener('input', saveAnswers);
        });

        loadAnswers();

        /* =========================
           VALIDASI SOAL BELUM DIJAWAB
        ========================== */
        function countUnanswered() {
            let unanswered = 0;

            questions.forEach(block => {
                let answered = false;
                const fields = block.querySelectorAll('.answer-input');

                fields.forEach(input => {
                    if (input.type === 'radio' && input.checked) answered = true;
                    if (input.tagName === 'TEXTAREA' && input.value.trim() !== '') answered = true;
                });

                if (!answered) unanswered++;
            });

            return unanswered;
        }

        /* =========================
           SUBMIT MANUAL
        ========================== */
        form.addEventListener('submit', function(e) {
            if (isSubmitted) return;

            const unanswered = countUnanswered();

            if (unanswered > 0) {
                const confirmSubmit = confirm(
                    `Masih ada ${unanswered} soal yang belum dijawab.\n\nYakin ingin mengumpulkan?`
                );

                if (!confirmSubmit) {
                    e.preventDefault();
                    return;
                }
            }

            isSubmitted = true;
            localStorage.removeItem(storageKey);

            submitBtn.disabled = true;
            submitBtn.innerText = 'Mengirim...';
        });

        /* =========================
           TIMER & AUTO SUBMIT
        ========================== */
        function formatTime(sec) {
            const m = Math.floor(sec / 60);
            const s = sec % 60;
            return `${String(m).padStart(2,'0')}:${String(s).padStart(2,'0')}`;
        }

        function startTimer() {
            const interval = setInterval(() => {
                const now = Math.floor(Date.now() / 1000);
                const remaining = endTime - now;

                if (remaining <= 0) {
                    clearInterval(interval);

                    if (!isSubmitted) {
                        alert('⏰ Waktu habis! Jawaban akan dikumpulkan.');
                        isSubmitted = true;
                        localStorage.removeItem(storageKey);
                        form.submit();
                    }

                    return;
                }

                if (timerEl) {
                    timerEl.textContent = formatTime(remaining);
                }
            }, 1000);
        }

        startTimer();

        /* =========================
           CEGAH KELUAR TANPA SUBMIT
           (TIDAK MENYIMPAN KE DB)
        ========================== */
        window.addEventListener('beforeunload', function(e) {
            if (!isSubmitted) {
                e.preventDefault();
                e.returnValue = '';
            }
        });

    });
</script> -->

@endsection