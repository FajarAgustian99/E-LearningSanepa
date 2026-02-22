@extends('layouts.teacher')

@section('title','Absensi Guru')

@section('content')
<div class="max-w-xl mx-auto mt-10 bg-white shadow-xl rounded-xl p-6">

    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-bold">🧑‍🏫 Absensi Guru</h2>

        <a href="{{ route('teacher.attendance.index') }}"
            class="text-sm text-indigo-600 hover:underline">← Kembali</a>
    </div>

    @if($alreadySubmitted)
    <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">✅ Sudah absen</div>
    @endif

    @if($locked)
    <div class="mb-4 p-3 bg-yellow-100 text-yellow-800 rounded">⚠️ Absensi siswa terkunci</div>
    @endif

    <form method="POST" action="{{ route('teacher.attendance.store') }}">
        @csrf

        <input type="hidden" name="class_id" value="{{ $class->id }}">
        <input type="hidden" name="date" value="{{ $date }}">

        <label class="block mb-2 font-semibold">Status Kehadiran</label>

        <select name="status[{{ auth()->id() }}]"
            class="w-full border rounded-lg px-3 py-2 mb-6"
            {{ $alreadySubmitted?'disabled':'' }}>

            <option value="">-- pilih --</option>
            @foreach(['Hadir','Izin','Sakit','Alpha'] as $s)
            <option value="{{ $s }}" {{ optional($attendance)->status==$s?'selected':'' }}>{{ $s }}</option>
            @endforeach
        </select>

        <div class="flex justify-end">
            <button {{ $alreadySubmitted?'disabled':'' }}
                class="px-6 py-2 bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-lg shadow">
                💾 Simpan
            </button>
        </div>

    </form>

</div>
@endsection