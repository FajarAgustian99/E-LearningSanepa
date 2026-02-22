@extends('layouts.student')

@section('title', 'Absensi Kelas')

@section('page-title')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-[#0A1D56]">
        Absensi Kelas
    </h1>
    <p class="text-gray-500 mt-1">

        {{ $kelas->name }} • {{ $course->title ?? '-' }} • {{ now()->translatedFormat('l, d F Y') }}
    </p>


</div>
@endsection

@section('content')

<div class="bg-white rounded-xl shadow border overflow-hidden">

    {{-- HEADER KELAS --}}
    <div class="p-6 border-b bg-gradient-to-r from-[#0A1D56] to-[#132d8a] text-white">
        <h2 class="text-2xl font-semibold">
            {{ $kelas->name }}
        </h2>
        <p class="text-sm opacity-90 mt-1">
            {{ $kelas->description ?? 'Tidak ada deskripsi kelas.' }}
        </p>
    </div>

    <div class="p-6 space-y-6">

        {{-- STATUS --}}
        @if($sudahAbsen)
        <div class="flex items-center gap-3 p-4 bg-green-50 border border-green-200 rounded-lg">
            <div class="text-2xl">✅</div>
            <div>
                <p class="font-semibold text-green-700">Absensi berhasil</p>
                <p class="text-sm text-green-600">Kamu sudah melakukan absensi hari ini.</p>
            </div>
        </div>
        @else
        <div class="flex items-center gap-3 p-4 bg-blue-50 border border-blue-200 rounded-lg">
            <div class="text-2xl">📅</div>
            <div>
                <p class="font-semibold text-blue-700">Belum absen</p>
                <p class="text-sm text-blue-600">Silakan pilih status kehadiran.</p>
            </div>
        </div>
        @endif

        {{-- FORM --}}
        <form action="{{ route('student.attendance.store') }}" method="POST">
            @csrf

            <input type="hidden" name="kelas_id" value="{{ $kelas->id }}">
            <input type="hidden" name="course_id" value="{{ $course->id }}">

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                {{-- HADIR --}}
                <button type="submit" name="status" value="hadir"
                    class="group relative p-6 rounded-xl border bg-green-500 text-white shadow hover:scale-105 transition-all
                    @if($sudahAbsen) opacity-40 cursor-not-allowed @endif"
                    @if($sudahAbsen) disabled @endif>

                    <div class="text-4xl mb-2">✔</div>
                    <div class="text-lg font-semibold">Hadir</div>
                </button>

                {{-- IZIN --}}
                <button type="submit" name="status" value="izin"
                    class="group relative p-6 rounded-xl border bg-yellow-500 text-white shadow hover:scale-105 transition-all
                    @if($sudahAbsen) opacity-40 cursor-not-allowed @endif"
                    @if($sudahAbsen) disabled @endif>

                    <div class="text-4xl mb-2">📝</div>
                    <div class="text-lg font-semibold">Izin</div>
                </button>

                {{-- ALFA --}}
                <button type="submit" name="status" value="alpha"
                    class="group relative p-6 rounded-xl border bg-red-600 text-white shadow hover:scale-105 transition-all
                    @if($sudahAbsen) opacity-40 cursor-not-allowed @endif"
                    @if($sudahAbsen) disabled @endif>

                    <div class="text-4xl mb-2">✖</div>
                    <div class="text-lg font-semibold">Alfa</div>
                </button>

            </div>
        </form>

        {{-- FOOTER INFO --}}
        <div class="pt-4 border-t text-sm text-gray-500 text-center">
            Sistem Absensi • {{ config('app.name') }}
        </div>

    </div>
</div>

@endsection