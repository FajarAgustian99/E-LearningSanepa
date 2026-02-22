@extends('layouts.teacher')

@section('title', $discussion->title)

@section('content')
<div class="max-w-4xl mx-auto">

    {{-- Diskusi --}}
    <div class="bg-white p-6 rounded-xl shadow mb-6">
        <h1 class="text-3xl font-bold text-[#0A1D56] mb-2">{{ $discussion->title }}</h1>
        <p class="text-gray-700 whitespace-pre-line">{{ $discussion->content }}</p>
        <div class="mt-4 text-sm text-gray-500">
            Diposting {{ $discussion->created_at->diffForHumans() }} di kelas <strong>{{ $discussion->classes->name ?? '-' }}</strong>
        </div>
    </div>

    {{-- Form komentar --}}
    <div class="bg-white p-6 rounded-xl shadow mb-6">
        <h3 class="text-xl font-semibold mb-4">💬 Tambahkan Komentar</h3>

        <form method="POST" action="{{ route('teacher.comments.store', $discussion->id) }}">
            @csrf
            <textarea name="content" rows="4" class="w-full border border-gray-300 rounded-lg p-3" placeholder="Tulis komentar..." required></textarea>
            <button type="submit" class="mt-3 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg">Kirim Komentar</button>
        </form>
    </div>

    {{-- Semua komentar --}}
    <h3 class="text-xl font-semibold mb-4">📚 Semua Komentar</h3>
    <div class="space-y-4">
        @foreach($discussion->comments as $comment)
        @include('teacher.discussions.partials.comment', ['comment' => $comment])
        @endforeach
    </div>
</div>

{{-- SweetAlert --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.querySelectorAll('.delete-button').forEach(button => {
        button.addEventListener('click', function() {
            const form = this.closest('form');
            Swal.fire({
                title: 'Yakin hapus komentar ini?',
                text: "Komentar yang dihapus tidak bisa dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e3342f',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus'
            }).then((result) => {
                if (result.isConfirmed) form.submit();
            });
        });
    });
</script>
@endsection