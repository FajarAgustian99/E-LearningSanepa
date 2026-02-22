@extends('layouts.teacher')

@section('title', 'Gabung Kelas')

@section('content')
<div class="container mx-auto px-4 py-8">

    <h1 class="text-3xl font-bold text-[#0A1D56] mb-6">Gabung ke Kelas</h1>

    <div class="bg-white p-6 rounded-lg shadow-md">
        <form action="{{ route('teacher.kelas.enroll') }}" method="POST">
            @csrf

            <label class="block text-gray-700 font-semibold mb-2">Pilih Kelas</label>

            <select name="class_id" class="w-full border rounded-lg p-3 mb-4">
                <option disabled selected>-- Pilih Kelas --</option>
                @foreach ($classes as $class)
                <option value="{{ $class->id }}">
                    {{ $class->name }} — {{ $class->description }}
                </option>
                @endforeach
            </select>

            @error('class_id')
            <p class="text-red-600 text-sm mb-3">{{ $message }}</p>
            @enderror

            <button
                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                Gabung
            </button>
        </form>
    </div>

</div>
@endsection