<div class="border p-3 rounded-lg">
    <p>👤 <strong>{{ $comment->user->name ?? 'Anonim' }}:</strong> {{ $comment->content }}</p>
    <div class="mt-2 flex gap-2 items-center">
        {{-- Tombol Hapus --}}
        @if(Auth::id() === $comment->user_id || Auth::user()->role === 'Guru')
        <form method="POST" action="{{ route('teacher.comments.destroy', $comment->id) }}">
            @csrf
            @method('DELETE')
            <button type="button" class="delete-button text-red-500">🗑️ Hapus</button>
        </form>
        @endif

        {{-- Tombol Balas --}}
        <button type="button" onclick="document.getElementById('reply-form-{{ $comment->id }}').classList.toggle('hidden')"
            class="text-blue-500 text-sm">💬 Balas</button>
    </div>

    {{-- Form Balas --}}
    <form method="POST" action="{{ route('teacher.comments.store', $comment->discussion_id) }}"
        id="reply-form-{{ $comment->id }}" class="hidden mt-2">
        @csrf
        <input type="hidden" name="parent_id" value="{{ $comment->id }}">
        <textarea name="content" rows="2"
            class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-300"
            placeholder="Tulis balasan..."></textarea>
        <button type="submit"
            class="mt-1 bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded-lg text-sm">
            💾 Kirim
        </button>
    </form>

    {{-- Balasan komentar --}}
    @if($comment->replies)
    <div class="ml-6 mt-2 space-y-2">
        @foreach($comment->replies as $reply)
        @include('teacher.discussions.partials.comment', ['comment' => $reply])
        @endforeach
    </div>
    @endif
</div>
<script>
    document.querySelectorAll('.delete-button').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
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
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>