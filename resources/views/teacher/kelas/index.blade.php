@extends('layouts.teacher')

@section('title', 'Kelas Saya')

@section('content')
<div class="container mx-auto px-6 py-6">

    {{-- --------------------------------------------------------------------------
        KELAS YANG SUDAH DIGABUNG OLEH GURU
    --------------------------------------------------------------------------- --}}

    @if ($joinedClasses->count())
    <h2 class="text-xl font-semibold mb-3">Kelas Anda</h2>

    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
        @foreach ($joinedClasses as $class)
        <div class="bg-white rounded-xl shadow p-5 border border-gray-200">

            {{-- Nama Kelas --}}
            <h3 class="text-lg font-semibold mb-1">
                Kelas {{ $class->name }}
            </h3>

            <!-- {{-- Nama Mata Pelajaran --}}
            <p class="text-gray-600 mb-2">
                Mata Pelajaran: {{ $class->course->title ?? '-' }}
            </p> -->

            {{-- Tombol Aksi --}}
            <div class="flex gap-2">

                {{-- Tombol Masuk Kelas --}}
                <a href="{{ route('teacher.kelas.show', $class->id) }}"
                    class="bg-green-600 hover:bg-green-700 text-white px-3 py-2 rounded-lg">
                    Masuk
                </a>

                {{-- Tombol Keluar dari Kelas --}}
                <form action="{{ route('teacher.kelas.unjoin', $class->id) }}"
                    method="POST"
                    onsubmit="return confirm('Yakin ingin keluar dari kelas ini?');">

                    @csrf
                    @method('DELETE')

                    <button type="submit"
                        class="bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded-lg">
                        Batal Gabung
                    </button>
                </form>

            </div>

        </div>
        @endforeach
    </div>
    @else
    {{-- Jika belum ada kelas yang digabung --}}
    <p class="text-gray-600 mb-6">Belum ada kelas yang Anda gabung.</p>
    @endif

    {{-- --------------------------------------------------------------------------
        KELAS YANG BELUM DIGABUNG (AVAILABLE)
    --------------------------------------------------------------------------- --}}

    @if ($availableClasses->count())
    <h2 class="text-xl font-semibold mb-3">Kelas yang Bisa Anda Gabung</h2>

    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
        @foreach ($availableClasses as $class)
        <div class="bg-white rounded-xl shadow p-5 border border-gray-200">

            {{-- Nama Kelas --}}
            <h3 class="text-lg font-semibold mb-1">
                Kelas {{ $class->name }}
            </h3>

            {{-- Jika ingin tampilkan mapel, tinggal buka komentar --}}
            <!-- {{--
                    <p class="text-gray-600 mb-2">
                      Mata Pelajaran: {{ $class->course->title ?? '-' }}
            </p>
            --}} -->

            {{-- Tombol Gabung --}}
            <form action="{{ route('teacher.kelas.enroll') }}" method="POST">
                @csrf
                <input type="hidden" name="class_id" value="{{ $class->id }}">

                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded-lg">
                    Gabung Kelas
                </button>
            </form>
        </div>
        @endforeach
    </div>
    @endif

</div>
@endsection