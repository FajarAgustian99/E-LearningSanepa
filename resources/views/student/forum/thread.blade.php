@extends('layouts.student')

@section('content')
<div class="max-w-4xl mx-auto py-10 px-4">

    {{-- THREAD HEADER --}}
    <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-200 mb-8">
        <h2 class="text-3xl font-extrabold text-gray-800 mb-3">
            {{ $thread->title }}
        </h2>

        <p class="text-gray-700 leading-relaxed mb-4">
            {{ $thread->content }}
        </p>

        <div class="text-sm text-gray-500 flex items-center gap-4">
            <span><i class="fas fa-user text-indigo-600 mr-1"></i> {{ $thread->user->name }}</span>
            <span><i class="fas fa-layer-group text-yellow-600 mr-1"></i> {{ $classes->description }}</span>
            <span><i class="fas fa-clock text-gray-500 mr-1"></i> {{ $thread->created_at->diffForHumans() }}</span>
        </div>

        {{-- Tombol Kembali --}}
        <div class="mt-6">
            <a href="{{ route('student.forum.index') }}"
                class="inline-flex items-center gap-2 text-indigo-600 hover:text-indigo-700 font-semibold">
                <i class="fas fa-arrow-left"></i> Kembali ke Forum
            </a>
        </div>
    </div>

    {{-- BAGIAN KOMENTAR --}}
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
        <h3 class="text-2xl font-bold text-gray-800 mb-4 flex items-center gap-2">
            <i class="fas fa-comments text-indigo-600"></i> Komentar
        </h3>

        {{-- Include Partial Comments --}}
        @if($thread->comments->count())
        @include('forum.partials.comments', ['comments' => $thread->comments])
        @else
        <div class="text-gray-600 italic">
            Belum ada komentar. Jadilah yang pertama untuk mengomentari thread ini!
        </div>
        @endif
    </div>

</div>
@endsection