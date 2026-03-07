<div class="border p-3 rounded-lg">

    <div class="flex items-start gap-3">

        {{-- Foto User --}}
        <div class="w-8 h-8">
            @php
            $name = $comment->user->name ?? 'Anonim';
            $initials = collect(explode(' ', $name))
            ->map(fn($word) => strtoupper(substr($word,0,1)))
            ->take(2)
            ->implode('');
            @endphp

            @if($comment->user && $comment->user->photo)
            <img src="{{ asset('storage/'.$comment->user->photo) }}"
                class="w-8 h-8 rounded-full object-cover">
            @else
            <div class="w-8 h-8 rounded-full bg-blue-600 text-white flex items-center justify-center text-xs font-bold">
                {{ $initials }}
            </div>
            @endif
        </div>
        <div class="flex-1">
            <p>
                <strong>{{ $comment->user->name ?? 'Anonim' }}</strong>
                <span class="text-gray-700">: {{ $comment->content }}</span>
            </p>
            <div class="mt-2 flex gap-3 items-center text-sm">
                {{-- Tombol Hapus --}}
                @if(Auth::id() === $comment->user_id || Auth::user()->role->name === 'Guru')
                <form method="POST" action="{{ route('teacher.comments.destroy', $comment->id) }}">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="delete-button text-red-500">🗑️ Hapus</button>
                </form>
                @endif

                {{-- Tombol Balas --}}
                <button type="button"
                    onclick="document.getElementById('reply-form-{{ $comment->id }}').classList.toggle('hidden')"
                    class="text-blue-500">
                    💬 Balas
                </button>
            </div>
        </div>
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