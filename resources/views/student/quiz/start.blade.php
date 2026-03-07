@extends('layouts.student')

@section('title', 'Mulai Asesmen')
@section('page-title', 'Mulai Asesmen')

@section('content')
<div class="container mx-auto px-4 py-8">

    {{-- Tombol Kembali --}}
    <a href="{{ route('student.quiz.show', $quiz->id) }}"
        class="inline-flex items-center mb-6 text-gray-500 hover:text-[#0A1D56] transition-colors font-medium">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Kembali ke Detail Asesmen
    </a>

    {{-- STICKY HEADER: Info Kuis, Timer, & Progress --}}
    <div class="sticky top-4 z-40 bg-white p-5 rounded-xl shadow-lg border border-gray-100 mb-8">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-4">
            <div>
                <h2 class="text-xl md:text-2xl font-bold text-[#0A1D56]">{{ $quiz->title }}</h2>
                <div class="flex items-center gap-4 mt-1">
                    <span class="text-sm text-gray-500 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        {{ $quiz->questions->count() }} Soal
                    </span>
                    <span class="text-sm text-gray-500 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Durasi: {{ $quiz->duration }} Menit
                    </span>
                </div>
            </div>

            {{-- Timer --}}
            <div class="flex items-center gap-3 bg-red-50 px-6 py-3 rounded-xl border border-red-100 shadow-sm">
                <div class="text-right">
                    <p class="text-[10px] uppercase tracking-wider text-red-500 font-bold">Sisa Waktu</p>
                    <p id="countdown" class="text-2xl font-mono font-bold text-red-700 leading-none">00:00:00</p>
                </div>
                <div class="p-2 bg-red-100 rounded-lg text-red-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

        {{-- Progress Bar --}}
        <div class="space-y-2">
            <div class="flex justify-between items-center text-sm">
                <span class="text-gray-600 font-medium">Progres Pengerjaan</span>
                <span id="progressText" class="text-blue-700 font-bold">0%</span>
            </div>
            <div class="w-full bg-gray-100 rounded-full h-3 overflow-hidden border border-gray-200">
                <div id="progressBar" class="bg-gradient-to-r from-blue-500 to-indigo-600 h-full rounded-full transition-all duration-500 ease-out" style="width: 0%"></div>
            </div>
        </div>
    </div>

    {{-- FORM ASESMEN --}}
    <form id="quizForm" action="{{ route('student.quiz.submit', $quiz->id) }}" method="POST" class="space-y-6">
        @csrf

        @foreach ($quiz->questions as $index => $question)
        <div class="question-block p-6 md:p-8 bg-white border border-gray-200 rounded-2xl shadow-sm hover:border-blue-300 transition-all">
            <div class="flex gap-4">
                {{-- Nomor Soal --}}
                <div class="flex-shrink-0">
                    <span class="flex items-center justify-center w-10 h-10 rounded-xl bg-blue-50 text-blue-700 font-extrabold text-lg border border-blue-100">
                        {{ $index + 1 }}
                    </span>
                </div>

                <div class="flex-1">
                    {{-- Teks Soal --}}
                    <div class="text-lg text-gray-800 mb-5 leading-relaxed font-medium">
                        {!! nl2br(e($question->question_text)) !!}
                    </div>

                    {{-- Gambar Soal --}}
                    @if($question->image)
                    <div class="mb-6">
                        <img src="{{ asset('storage/'.$question->image) }}"
                            onclick="openImage(this.src)"
                            alt="Gambar Soal"
                            class="max-w-full md:max-w-md h-auto rounded-xl border-4 border-gray-50 shadow-sm cursor-zoom-in hover:opacity-90 transition-opacity">
                    </div>
                    @endif

                    {{-- Pilihan Ganda --}}
                    @if ($question->question_type === 'multiple_choice')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach (['option_a','option_b','option_c','option_d'] as $option)
                        @if ($question->$option)
                        <label class="relative flex items-center p-4 border border-gray-100 rounded-xl cursor-pointer hover:bg-blue-50 hover:border-blue-200 transition-all group">
                            <input type="radio"
                                name="answers[{{ $question->id }}]"
                                value="{{ $option }}"
                                class="answer-input w-5 h-5 text-blue-600 border-gray-300 focus:ring-blue-500 transition-transform group-active:scale-90">
                            <span class="ml-4 text-gray-700 font-medium group-hover:text-blue-900">
                                {{ $question->$option }}
                            </span>
                        </label>
                        @endif
                        @endforeach
                    </div>
                    @endif

                    {{-- Essay --}}
                    @if ($question->question_type === 'essay')
                    <div class="space-y-2">
                        <label class="inline-block text-sm font-semibold text-gray-600 mb-1 italic">
                            Tuliskan jawaban lengkap Anda:
                        </label>
                        <textarea name="answers[{{ $question->id }}]"
                            rows="5"
                            class="answer-input w-full border-2 border-gray-100 rounded-xl p-4 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all placeholder-gray-300"
                            placeholder="Ketik jawaban di sini..."></textarea>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endforeach

        {{-- Footer Submit --}}
        <div class="sticky bottom-6 bg-white/80 backdrop-blur-md p-4 rounded-2xl shadow-2xl border border-gray-100 flex justify-between items-center">
            <p class="hidden md:block text-sm text-gray-500">Pastikan semua soal telah terjawab sebelum mengumpulkan.</p>
            <button type="submit" id="submitBtn"
                class="w-full md:w-auto bg-[#0A1D56] text-white px-12 py-4 rounded-xl font-bold hover:bg-blue-900 transition-all transform hover:scale-[1.02] active:scale-95 shadow-xl flex items-center justify-center gap-2">
                <span>Kumpulkan Semua Jawaban</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </button>
        </div>
    </form>
</div>

{{-- Modal Zoom Gambar --}}
<div id="imageModal" class="fixed inset-0 bg-black/90 hidden items-center justify-center z-[100] p-4">
    <button onclick="closeImage()" class="absolute top-5 right-5 text-white bg-white/10 p-2 rounded-full hover:bg-white/20 transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
    </button>
    <img id="modalImage" class="max-w-full max-h-full rounded-lg shadow-2xl">
</div>

{{-- ===================== SCRIPTS ===================== --}}
<script>
    // Fungsi Zoom Gambar
    function openImage(src) {
        const modal = document.getElementById('imageModal');
        document.getElementById('modalImage').src = src;
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    function closeImage() {
        const modal = document.getElementById('imageModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = 'auto';
    }

    document.addEventListener('DOMContentLoaded', function() {

        // --- KONFIGURASI TIMER ---

        let durationMinutes = parseInt("{{ $quiz->duration }}");
        let timeRemaining = durationMinutes * 60;

        const display = document.querySelector('#countdown');
        const form = document.getElementById('quizForm');

        // Cek di console (F12) apakah angka muncul atau NaN
        console.log("Durasi kuis:", durationMinutes, "menit");

        const timer = setInterval(function() {
            let hours = Math.floor(timeRemaining / 3600);
            let minutes = Math.floor((timeRemaining % 3600) / 60);
            let seconds = timeRemaining % 60;

            display.textContent =
                (hours < 10 ? "0" + hours : hours) + ":" +
                (minutes < 10 ? "0" + minutes : minutes) + ":" +
                (seconds < 10 ? "0" + seconds : seconds);

            if (--timeRemaining < 0) {
                clearInterval(timer);
                window.onbeforeunload = null;
                alert("Waktu habis! Jawaban Anda akan dikirim otomatis.");
                form.submit();
            }

            if (timeRemaining < 300) {
                display.classList.add('animate-pulse', 'text-red-500');
            }
        }, 1000);

        // --- KONFIGURASI PROGRESS BAR ---

        const totalQuestions = parseInt("{{ $quiz->questions->count() }}");
        const inputs = document.querySelectorAll('.answer-input');
        const progressBar = document.getElementById('progressBar');
        const progressText = document.getElementById('progressText');

        function updateProgress() {
            const answeredNames = new Set();

            inputs.forEach(input => {
                if (input.type === 'radio' && input.checked) {
                    answeredNames.add(input.name);
                } else if (input.type === 'textarea' && input.value.trim() !== "") {
                    answeredNames.add(input.name);
                }
            });

            const answeredCount = answeredNames.size;
            const percentage = Math.round((answeredCount / totalQuestions) * 100);

            if (progressBar) progressBar.style.width = percentage + '%';
            if (progressText) progressText.textContent = percentage + '% (' + answeredCount + '/' + totalQuestions + ')';
        }

        // Jalankan saat ada input
        inputs.forEach(input => {
            input.addEventListener('change', updateProgress);
            if (input.type === 'textarea') {
                input.addEventListener('input', updateProgress);
            }
        });

        // Jalankan sekali saat load (jika ada jawaban lama/old input)
        updateProgress();

        // Warning saat refresh
        window.onbeforeunload = function() {
            return "Progres kuis Anda mungkin hilang!";
        };

        form.addEventListener('submit', function() {
            window.onbeforeunload = null;
        });
    });
</script>
@endsection