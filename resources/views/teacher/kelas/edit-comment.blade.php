@extends('layouts.teacher')

@section('content')
<div class="max-w-3xl mx-auto py-10">
    <h1 class="text-2xl font-bold mb-6 text-gray-800">✏️ Edit Komentar</h1>

    <form action="{{ route('teacher.kelas.comment.update', $comment->id) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')
        <textarea name="content" rows="4"
            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500 focus:outline-none"
            required>{{ $comment->content }}</textarea>

        <button type="submit"
            class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-2.5 rounded-lg shadow-md transition-all">
            💾 Simpan Perubahan
        </button>
        <a href="{{ url()->previous() }}" class="text-gray-500 hover:underline">Batalkan</a>
    </form>
</div>
@endsection