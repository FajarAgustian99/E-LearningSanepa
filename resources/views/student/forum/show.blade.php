@extends('layouts.student')

@section('content')
<div class="max-w-4xl mx-auto py-10 px-4">

    {{-- HEADER DISKUSI --}}
    <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-200 mb-8">
        <h2 class="text-3xl font-extrabold text-gray-800 mb-2">{{ $discussion->title ?? '-' }}</h2>

        <p class="text-gray-700 leading-relaxed mb-4">
            {{ $discussion->content ?? '-' }}
        </p>

        <div class="text-sm text-gray-500 flex items-center gap-4">
            <span><i class="fas fa-user mr-1 text-indigo-600"></i> {{ $discussion->user?->name ?? 'Unknown' }}</span>
            <span><i class="fas fa-layer-group mr-1 text-yellow-600"></i> {{ $discussion->classes?->name ?? 'Tidak ada kelas' }}</span>
            <span><i class="fas fa-clock mr-1 text-gray-500"></i> {{ $discussion->created_at?->diffForHumans() ?? '-' }}</span>
        </div>

        {{-- Tombol Kembali --}}
        <div class="mt-6">
            <a href="{{ route('student.forum.index') }}"
                class="inline-flex items-center gap-2 text-indigo-600 hover:text-indigo-700 font-semibold">
                <i class="fas fa-arrow-left"></i> Kembali ke Forum
            </a>
        </div>
    </div>

    {{-- PESAN SUKSES --}}
    @if(session('success'))
    <div class="bg-green-50 border border-green-300 text-green-700 px-5 py-3 rounded-xl mb-6">
        {{ session('success') }}
    </div>
    @endif

    {{-- FORM BALAS KOMENTAR --}}
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 mb-10">
        <h3 class="font-bold text-xl text-gray-800 mb-3 flex items-center gap-2">
            <i class="fas fa-reply text-indigo-600"></i> Tulis Balasan
        </h3>

        <form action="{{ route('student.forum.reply.store', $discussion) }}" method="POST" class="space-y-3">
            @csrf
            <textarea name="content" rows="3"
                class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-indigo-400 focus:outline-none text-gray-700"
                placeholder="Tulis balasan Anda di sini..." required>{{ old('content') }}</textarea>

            <button type="submit"
                class="bg-indigo-600 hover:bg-indigo-700 text-white py-2.5 px-5 rounded-lg font-semibold shadow transition inline-flex items-center gap-2">
                <i class="fas fa-paper-plane"></i> Kirim Balasan
            </button>
        </form>
    </div>

    {{-- KOMENTAR --}}
    <div>
        <h3 class="text-2xl font-bold text-gray-800 mb-4">Komentar</h3>

        @if($discussion->comments?->count())
        {{-- Comment Partial --}}
        @include('student.forum.partials.comments', ['comments' => $discussion->comments])
        @else
        <div class="text-center bg-white p-6 rounded-xl shadow-sm border border-gray-200 text-gray-600">
            Belum ada komentar. Jadilah yang pertama memberikan balasan!
        </div>
        @endif
    </div>

</div>
@endsection