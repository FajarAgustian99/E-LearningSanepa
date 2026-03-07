@extends('layouts.teacher')

@section('content')
<div class="space-y-6">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <h1 class="text-xl sm:text-2xl font-bold flex items-center gap-2">
            📊 Agenda Penilaian
        </h1>

        @if(request('class_id') && request('course_id'))
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('grades.export.excel', request()->query()) }}"
                class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg text-sm shadow w-full sm:w-auto text-center">
                📊 Excel
            </a>

            <a href="{{ route('grades.export.pdf', request()->query()) }}"
                class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm shadow w-full sm:w-auto text-center">
                📄 PDF
            </a>
        </div>
        @endif
    </div>

    <!-- Alert -->
    @if(session('success'))
    <div class="bg-green-100 text-green-700 px-4 py-3 rounded-lg text-sm">
        {{ session('success') }}
    </div>
    @endif

    <!-- Filter -->
    <form method="GET" class="bg-white p-4 rounded-lg shadow flex flex-col sm:flex-row flex-wrap gap-4 sm:items-end">

        <div class="w-full sm:w-auto">
            <label class="text-sm font-medium text-gray-600">Kelas</label>
            <select name="class_id" class="mt-1 border rounded-lg px-3 py-2 w-full sm:w-48">
                <option value="">-- Pilih Kelas --</option>
                @foreach($classes as $c)
                <option value="{{ $c->id }}" {{ request('class_id') == $c->id ? 'selected' : '' }}>
                    {{ $c->name }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="w-full sm:w-auto">
            <label class="text-sm font-medium text-gray-600">Mata Pelajaran</label>
            <select name="course_id" class="mt-1 border rounded-lg px-3 py-2 w-full sm:w-48">
                <option value="">-- Pilih Mapel --</option>
                @foreach($courses as $m)
                <option value="{{ $m->id }}" {{ request('course_id') == $m->id ? 'selected' : '' }}>
                    {{ $m->title }}
                </option>
                @endforeach
            </select>
        </div>

        <button class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg shadow w-full sm:w-auto">
            🔍 Tampilkan
        </button>
    </form>

    <!-- Tabel Nilai -->
    @if($selectedClass && $students->count())
    <form method="POST">
        @csrf
        <input type="hidden" name="class_id" value="{{ request('class_id') }}">
        <input type="hidden" name="course_id" value="{{ request('course_id') }}">

        <div class="bg-white rounded-lg shadow overflow-x-auto">

            <table class="min-w-full text-xs sm:text-sm border">
                <thead class="bg-blue-700 text-white sticky top-0 z-10">
                    <tr>
                        <th class="px-3 py-2 text-left">Nama</th>
                        <th class="px-2">Abs</th>
                        <th class="px-2">LM1</th>
                        <th class="px-2">LM2</th>
                        <th class="px-2">LM3</th>
                        <th class="px-2">LM4</th>
                        <th class="px-2">Sum</th>
                        <th class="px-2">UHB</th>
                        <th class="px-2">PSAT</th>
                        <th class="px-2">NA</th>
                        <th class="px-2">KKTP</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($students as $s)
                    @php $g = $grades[$s->id] ?? null; @endphp
                    <tr class="border-t hover:bg-gray-50">

                        <td class="px-3 py-2 font-medium whitespace-nowrap">
                            {{ $s->name }}
                        </td>

                        @foreach([
                        'rekap_absensi',
                        'lingkup_materi_1',
                        'lingkup_materi_2',
                        'lingkup_materi_3',
                        'lingkup_materi_4',
                        'sumatif_akhir_semester',
                        'uhb',
                        'psat'
                        ] as $f)

                        <td class="px-1 py-1">
                            <input type="number" step="0.01"
                                name="grades[{{ $s->id }}][{{ $f }}]"
                                value="{{ $g->$f ?? '' }}"
                                class="w-16 sm:w-20 border rounded px-1 py-1 text-center focus:ring focus:ring-blue-200">
                        </td>

                        @endforeach

                        <td class="px-1">
                            <input value="{{ $g->na ?? '' }}"
                                readonly
                                class="w-16 sm:w-20 bg-gray-100 border rounded px-1 py-1 text-center">
                        </td>

                        <td class="px-1">
                            <select name="grades[{{ $s->id }}][kktp]"
                                class="border rounded px-1 py-1 text-xs sm:text-sm">
                                <option value="">-</option>
                                <option value="Lulus" {{ ($g->kktp ?? '')=='Lulus'?'selected':'' }}>
                                    Lulus
                                </option>
                                <option value="Belum Lulus" {{ ($g->kktp ?? '')=='Belum Lulus'?'selected':'' }}>
                                    Belum
                                </option>
                            </select>
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="flex justify-end mt-4 gap-4">
            <a href="{{ route('teacher.grades.index') }}"
                class="px-6 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg shadow">
                ⬅️ Kembali
            </a>

            <button class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg shadow w-full sm:w-auto">
                💾 Simpan Nilai
            </button>
        </div>
    </form>
    @endif

</div>
@endsection