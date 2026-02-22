@extends('layouts.student')

@section('title','Gabung Kelas')
@section('page-title','Gabung Kelas')

@section('content')
<div class="bg-white p-6 rounded shadow border max-w-md mx-auto">
    <h2 class="text-xl font-bold mb-4 text-[#0A1D56]">Masukkan Kode Kelas</h2>

    @if($errors->any())
    <div class="bg-red-100 text-red-800 p-3 rounded mb-4">
        {{ $errors->first() }}
    </div>
    @endif

    @if(session('success'))
    <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
        {{ session('success') }}
    </div>
    @endif

    <form action="{{ route('student.join.submit') }}" method="POST">
        @csrf
        <input type="text" name="class_code" class="w-full p-3 border rounded mb-3"
            placeholder="Contoh: KLS9AB3F" required>

        <button class="bg-blue-600 text-white w-full py-3 rounded hover:bg-blue-700">
            Gabung Kelas
        </button>
    </form>
</div>
@endsection