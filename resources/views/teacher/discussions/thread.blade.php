@extends('layouts.teacher')

@section('title', "🗨️ $discussion->title")

@section('content')
<div class="max-w-4xl mx-auto">

    {{-- Judul Diskusi --}}
    <div class="bg-white p-6 rounded-xl shadow mb-6">
        <h1 class="text-3xl font-bold text-[#0A1D56] mb-2">🗨️ {{ $discussion->title }}</h1>
        <p class="text-gray-700 whitespace-pre-line">{{ $discussion->content }}</p>
        <div class="mt-4 text-sm text-gray-500">
            Diposting {{ $discussion->created_at->diffForHumans() }} di kelas <strong>{{ $discussion->classes->name ?? '-' }}</strong>
        </div>
    </div>

    {{-- Form Komentar --}}
    <div class="bg-white p-6 rounded-xl shadow mb-6">
        <h3 class="text-xl font-semibold mb-4">💬 Tambahkan Komentar</h3>
        <form action="{{ route('teacher.comments.store', $discussion->id) }}" method="POST">
            @csrf
            <textarea name="content" rows="4"
                class="w-full border border-gray-300 rounded-lg p-3 focus:ring focus:ring-blue-300"
                placeholder="Tulis komentar..."></textarea>
            <button type="submit" class="mt-3 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg">
                💾 Kirim Komentar
            </button>
        </form>
    </div>

    {{-- Daftar komentar --}}
    <h3 class="text-xl font-semibold mb-4">📚 Semua Komentar</h3>
    <div class="space-y-4">
        @foreach($discussion->comments as $comment)
        @include('teacher.discussions.partials.comment', ['comment' => $comment])
        @endforeach
    </div>

</div>
@endsection