@extends('layouts.teacher')

@section('title', 'Kelas Terhapus')

@section('content')
<div class="container mx-auto px-4 py-8">

    <h1 class="text-3xl font-bold text-gray-800 mb-6">♻️ Kelas Terhapus</h1>

    @if(session('success'))
    <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded-lg mb-4">
        ✅ {{ session('success') }}
    </div>
    @endif

    @if($deletedClasses->isEmpty())
    <p class="text-gray-600">Tidak ada kelas yang dihapus.</p>
    @else
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($deletedClasses as $class)
        <div class="bg-white border border-gray-200 rounded-xl shadow-md p-4 flex flex-col justify-between">
            <div>
                <h2 class="text-xl font-semibold text-gray-700">{{ $class->name }}</h2>
                <p class="text-gray-500 mt-2">{{ $class->description ?? '-' }}</p>
            </div>
            <form action="{{ route('teacher.kelas.restoreClass', $class->id) }}" method="POST" class="mt-4">
                @csrf
                @method('PUT')
                <button type="submit"
                    class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg">
                    🔄 Pulihkan Kelas
                </button>
            </form>
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection