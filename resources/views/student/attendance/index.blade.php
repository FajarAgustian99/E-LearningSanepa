@extends('layouts.student')

@section('title', 'Absensi - ' . $kelas->name)

@section('content')

<div class="bg-white rounded-xl shadow border overflow-hidden">

    {{-- HEADER --}}
    <div class="p-6 bg-gradient-to-r from-[#0A1D56] to-[#132d8a] text-white">
        <h2 class="text-2xl font-semibold">
            {{ $kelas->name }}
        </h2>
        <p class="text-sm opacity-90 mt-1">
            {{ $course->title }} • {{ now()->translatedFormat('l, d F Y') }}
        </p>
    </div>

    <div class="p-6 space-y-6">

        {{-- LOCKED --}}
        @if ($locked)
        <div class="flex items-center gap-3 p-5 bg-gray-100 border border-gray-300 rounded-lg">
            <div class="text-3xl">🔒</div>
            <div>
                <p class="font-semibold text-gray-700">Absensi belum dibuka</p>
                <p class="text-sm text-gray-600">Tunggu sampai guru membuka absensi.</p>
            </div>
        </div>

        {{-- SUDAH ABSEN --}}
        @elseif ($attendanceToday)
        <div class="flex items-center gap-3 p-5 bg-green-50 border border-green-200 rounded-lg">
            <div class="text-3xl">✅</div>
            <div>
                <p class="font-semibold text-green-700">Absensi berhasil</p>
                <p class="text-sm text-green-600">
                    Status hari ini: <span class="font-bold">{{ $attendanceToday->status }}</span>
                </p>
            </div>
        </div>

        {{-- BELUM ABSEN --}}
        @else

        <div class="flex items-center gap-3 p-4 bg-blue-50 border border-blue-200 rounded-lg">
            <div class="text-2xl">📅</div>
            <div>
                <p class="font-semibold text-blue-700">Belum absen</p>
                <p class="text-sm text-blue-600">Silakan pilih status kehadiran.</p>
            </div>
        </div>

        <form action="{{ route('student.absensi.store', $kelas->id) }}" method="POST">
            @csrf

            <input type="hidden" name="course_id" value="{{ $course->id }}">

            <div class="grid grid-cols-2 md:grid-cols-4 gap-5 mt-4">

                {{-- HADIR --}}
                <button type="submit" name="status" value="Hadir"
                    class="p-5 rounded-xl bg-green-500 text-white shadow hover:scale-105 transition-all">
                    <div class="text-3xl mb-1">✔</div>
                    <div class="font-semibold">Hadir</div>
                </button>

                {{-- IZIN --}}
                <button type="submit" name="status" value="Izin"
                    class="p-5 rounded-xl bg-yellow-500 text-white shadow hover:scale-105 transition-all">
                    <div class="text-3xl mb-1">📝</div>
                    <div class="font-semibold">Izin</div>
                </button>

                {{-- SAKIT --}}
                <button type="submit" name="status" value="Sakit"
                    class="p-5 rounded-xl bg-orange-500 text-white shadow hover:scale-105 transition-all">
                    <div class="text-3xl mb-1">🤒</div>
                    <div class="font-semibold">Sakit</div>
                </button>

                {{-- ALPHA --}}
                <button type="submit" name="status" value="Alpha"
                    class="p-5 rounded-xl bg-red-600 text-white shadow hover:scale-105 transition-all">
                    <div class="text-3xl mb-1">✖</div>
                    <div class="font-semibold">Alpha</div>
                </button>

            </div>
        </form>

        @endif

        {{-- FOOTER --}}
        <div class="pt-4 border-t text-sm text-center text-gray-500">
            Sistem Absensi • {{ config('app.name') }}
        </div>

    </div>
</div>

@endsection