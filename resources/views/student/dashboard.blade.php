@extends('layouts.student')

@section('title', 'Beranda')
@section('page-title')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-[#0A1D56]"> </h1>
    <p class="text-gray-600">Selamat datang! Berikut ringkasan aktivitas kamu.</p>
</div>
@endsection

@section('content')


<!-- GRID SUMMARY CARDS -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
    {{-- Total Kelas --}}
    <div class="bg-blue-500 text-white p-5 rounded-xl shadow hover:shadow-lg border border-blue-400 transition flex items-center justify-between">
        <div>
            <p class="text-gray-100 text-sm">Kelas Kamu</p>
            <p class="text-2xl font-bold">{{ $kelasList->count() }}</p>
        </div>
        <div class="text-3xl">🏫</div>
    </div>

    {{-- Total Mapel Aktif --}}
    <div class="bg-green-500 text-white p-5 rounded-xl shadow hover:shadow-lg border border-green-400 transition flex items-center justify-between">
        <div>
            <p class="text-gray-100 text-sm">Mata Pelajaran Aktif</p>
            <p class="text-2xl font-bold">{{ $mapelAktif->count() }}</p>
        </div>
        <div class="text-3xl">📚</div>
    </div>

    {{-- Total Absensi --}}
    <div class="bg-yellow-400 text-white p-5 rounded-xl shadow hover:shadow-lg border border-yellow-300 transition flex items-center justify-between">
        <div>
            <p class="text-gray-100 text-sm">Riwayat Absensi</p>
            <p class="text-2xl font-bold">{{ $absensi->count() }}</p>
        </div>
        <div class="text-3xl">📝</div>
    </div>

    {{-- Riwayat Nilai --}}
    @php
    $totalSubmissions = $quizHistory->count() ?? 0;

    $totalScores = 0;
    foreach($quizHistory as $submission) {
    $mcScore = $submission->multiple_choice_score ?? 0;
    $essayScore = !empty($submission->essay_scores) ? array_sum($submission->essay_scores) : 0;
    $totalScores += $mcScore + $essayScore;
    }
    @endphp

    <div class="bg-purple-500 text-white p-5 rounded-xl shadow hover:shadow-lg border border-purple-400 transition flex items-center justify-between">
        <div>
            <p class="text-gray-100 text-sm">Riwayat Nilai</p>
            <p class="text-2xl font-bold">{{ $totalSubmissions }}</p>
            @if($totalSubmissions > 0)
            <p class="text-sm mt-1">Rata-rata Nilai: {{ round($totalScores / $totalSubmissions, 2) }}</p>
            @endif
        </div>
        <div class="text-3xl">📊</div>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">

    {{-- STATISTIK KEHADIRAN --}}
    <div class="bg-white rounded-xl shadow border p-6">
        <h3 class="font-semibold text-gray-700 mb-4">📊 Statistik Kehadiran</h3>

        <div class="grid grid-cols-2 gap-4 text-sm">

            <div class="p-3 bg-green-50 rounded">
                Hadir
                <div class="text-xl font-bold text-green-600">
                    {{ $attendanceStats->hadir ?? 0 }}
                </div>
            </div>

            <div class="p-3 bg-yellow-50 rounded">
                Izin
                <div class="text-xl font-bold text-yellow-600">
                    {{ $attendanceStats->izin ?? 0 }}
                </div>
            </div>

            <div class="p-3 bg-orange-50 rounded">
                Sakit
                <div class="text-xl font-bold text-orange-600">
                    {{ $attendanceStats->sakit ?? 0 }}
                </div>
            </div>

            <div class="p-3 bg-red-50 rounded">
                Alpha
                <div class="text-xl font-bold text-red-600">
                    {{ $attendanceStats->alpha ?? 0 }}
                </div>
            </div>

        </div>
    </div>

    {{-- PROGRESS BELAJAR --}}
    <div class="bg-white rounded-xl shadow border p-6">
        <h3 class="font-semibold text-gray-700 mb-4">📈 Progress Belajar</h3>

        <div class="mb-2 text-sm text-gray-600">
            Penyelesaian Materi
        </div>

        <div class="w-full bg-gray-200 rounded-full h-4 overflow-hidden">
            <div class="bg-indigo-600 h-4 rounded-full transition-all"
                style="width: {{ $progress }}%"></div>
        </div>

        <div class="mt-2 text-sm font-semibold text-indigo-600">
            {{ $progress }}%
        </div>
    </div>

</div>




<!-- GRID MAIN CONTENT -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    {{-- Pengumuman --}}
    <div class="bg-white p-6 rounded-xl shadow border border-[#E5E9F2] hover:shadow-md transition">
        <h3 class="text-lg font-semibold text-[#0A1D56] mb-4 flex items-center gap-2">📣 Pengumuman Terbaru</h3>
        @if($announcements->count())
        <ul class="space-y-3">
            @foreach($announcements as $a)
            <li class="pb-2 border-b border-gray-200">
                <a href="{{ route('student.announcements.show', $a->id) }}"
                    class="text-[#3E6D9C] font-medium hover:underline cursor-pointer">
                    {{ Str::limit($a->title, 60) }}
                </a>
                <p class="text-xs text-gray-500 mt-1">{{ $a->created_at->format('d M Y') }}</p>
            </li>
            @endforeach
        </ul>
        @else
        <p class="text-gray-500 text-sm">Belum ada pengumuman.</p>
        @endif
    </div>

    {{-- Riwayat Absensi --}}
    <div class="bg-white p-6 rounded-xl shadow border border-[#E5E9F2] hover:shadow-md transition">
        <h3 class="text-lg font-semibold text-[#0A1D56] mb-4 flex items-center gap-2">📝 Riwayat Absensi</h3>
        @if($absensi->count())
        <ul class="space-y-3">
            @foreach($absensi as $ab)
            <li class="pb-2 border-b border-gray-200 flex justify-between items-center">
                <div>
                    <span class="font-medium text-gray-700">{{ $ab->classes->nama ?? '-' }}</span>
                    <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($ab->date)->format('d M Y') }}</p>
                </div>
                <span class="text-sm font-semibold 
                    @if($ab->status == 'hadir') text-green-600 
                    @elseif($ab->status == 'izin') text-yellow-500
                    @else text-red-600 @endif">
                    {{ ucfirst($ab->status) }}
                </span>
            </li>
            @endforeach
        </ul>
        @else
        <p class="text-gray-500 text-sm">Belum ada riwayat absensi.</p>
        @endif
    </div>
</div>

<!-- GRID MAPEL -->
<div class="grid grid-cols-1 md:grid-cols-2 mt-6 gap-6">
    {{-- Mata Pelajaran Aktif --}}
    <div class="bg-white p-6 rounded-xl shadow border border-[#E5E9F2] hover:shadow-md transition">
        <h3 class="text-lg font-semibold text-[#0A1D56] mb-4 flex items-center gap-2">📚 Mata Pelajaran Aktif</h3>
        @if($mapelAktif->count())
        <ul class="space-y-3">
            @foreach($mapelAktif as $mp)
            <li class="flex justify-between pb-2 border-b border-gray-200">
                <span class="font-medium text-gray-700">{{ $mp->title }}</span>
                <a href="{{ route('student.courses.show', $mp->id) }}"
                    class="text-[#0A1D56] text-sm font-semibold hover:underline cursor-pointer">
                    Lihat Mata Pelajaran
                </a>
            </li>
            @endforeach
        </ul>
        @else
        <p class="text-gray-500 text-sm">Belum ada mata pelajaran aktif.</p>
        @endif
    </div>

    {{-- Riwayat Asesmen --}}
    <div class="bg-white p-6 rounded-xl shadow border border-[#E5E9F2] hover:shadow-md transition">
        <h3 class="text-lg font-semibold text-[#0A1D56] mb-4 flex items-center gap-2">📊 Riwayat Asesmen</h3>

        @if($quizHistory->count())
        <ul class="space-y-3">
            @foreach($quizHistory as $submission)
            <li class="flex justify-between pb-2 border-b border-gray-200">
                {{-- Judul Quiz --}}
                <span class="font-medium text-gray-700">
                    {{ $submission->quiz->title ?? 'Quiz Dihapus' }}
                </span>

                {{-- Total Nilai (MC + Essay jika ada) --}}
                <span class="text-sm font-semibold text-[#0A1D56]">
                    @php
                    $totalScore = 0;
                    if ($submission && $submission->is_submitted) {
                    // Gunakan 'score' karena di Controller ini adalah hasil akhir (MC)
                    // Jika nanti ada penilaian essay, Anda bisa menjumlahkannya di sini
                    $mcScore = $submission->score ?? 0;

                    // Sementara essay_scores belum ada di DB, kita set 0 atau ambil dari kolom lain jika ada
                    $essayScore = is_array($submission->essay_scores) ? array_sum($submission->essay_scores) : 0;

                    $totalScore = $mcScore + $essayScore;
                    }
                    @endphp

                    {{ ($submission && $submission->is_submitted) ? $totalScore : 'Belum Dinilai' }}
                </span>
            </li>
            @endforeach
        </ul>
        @else
        <p class="text-gray-500 text-sm">Belum ada riwayat asesmen.</p>
        @endif

        <a href="{{ route('student.quiz.history') }}" class="text-sm font-semibold text-[#0A1D56] hover:underline mt-3 block">
            Lihat Semua Riwayat Nilai
        </a>
    </div>
</div>
<div class="grid grid-cols-1 md:grid-cols-2 mt-6 gap-6">
    {{-- Progress Belajar Per Mapel --}}
    <div class="bg-white p-6 rounded-xl shadow border border-[#E5E9F2] hover:shadow-md transition">
        <h3 class="font-semibold mb-4">Progress Belajar Per Mapel</h3>

        @foreach($progressMapel as $mapel)
        <div class="mb-4">
            <div class="flex justify-between text-sm mb-1">
                <span>{{ $mapel['title'] }}</span>
                <span>{{ $mapel['percent'] }}%</span>
            </div>

            <div class="w-full bg-gray-200 rounded h-3">
                <div class="bg-green-600 h-3 rounded"
                    style="width: {{ $mapel['percent'] }}%"></div>
            </div>
        </div>
        @endforeach
    </div>
    <!-- PILIHAN MATA PELAJARAN (CARD MODEL)
<div class="mt-10">
    <h3 class="text-xl font-bold text-[#0A1D56] mb-4">🎯 Pilih Mata Pelajaran</h3>
    @if($availableMapel->count())
    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach($availableMapel as $mapel)
        <a href="{{ route('student.courses.show', $mapel->id) }}"
            class="bg-white p-5 rounded-xl shadow hover:shadow-lg border border-[#E5E9F2] transition flex flex-col justify-between hover:-translate-y-1">
            <div class="flex items-center justify-between mb-3">
                <span class="text-[#3E6D9C] font-semibold">{{ $mapel->title }}</span>
                <span class="text-2xl">📚</span>
            </div>
            <p class="text-gray-500 text-sm line-clamp-3">{{ Str::limit($mapel->description ?? '-', 100) }}</p>
            <div class="mt-4 text-right">
                <span class="text-indigo-600 font-semibold hover:underline">Buka</span>
            </div>
        </a>
        @endforeach
    </div>
    @else
    <p class="text-gray-500 text-sm">Belum ada mata pelajaran tersedia untuk dipilih.</p>
    @endif
</div> -->

    @endsection