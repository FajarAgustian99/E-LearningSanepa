@foreach($comments as $comment)
<div class="relative pl-{{ $comment->parent_id ? '10' : '0' }}">

    {{-- Garis vertical untuk nested comment --}}
    @if($comment->parent_id)
    <div class="absolute left-2 top-0 bottom-0 w-0.5 bg-indigo-100"></div>
    @endif

    <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 mb-4">
        <div class="flex items-start gap-3">

            {{-- AVATAR --}}
            <div class="w-10 h-10 rounded-full bg-indigo-600 text-white flex items-center justify-center text-sm font-bold shadow">
                {{ strtoupper(substr($comment->user->name, 0, 1)) }}
            </div>

            <div class="flex-1">
                {{-- HEADER --}}
                <div class="flex justify-between items-center mb-1">
                    <span class="font-semibold text-gray-800">
                        {{ $comment->user->name }}
                    </span>

                    <span class="text-xs text-gray-500">
                        {{ $comment->created_at->diffForHumans() }}
                    </span>
                </div>

                {{-- CONTENT --}}
                <p class="text-gray-700 leading-relaxed mb-2">
                    {{ $comment->content }}
                </p>

                {{-- FORM BALAS --}}
                <details class="mt-2">
                    <summary class="cursor-pointer text-indigo-600 text-sm hover:underline">
                        Balas
                    </summary>

                    <form action="{{ route('student.forum.reply.store', $comment->discussion_id) }}"
                        method="POST"
                        class="mt-2 bg-gray-50 p-3 rounded-lg border flex flex-col gap-2">
                        @csrf

                        <input type="hidden" name="parent_id" value="{{ $comment->id }}">

                        <textarea name="content" rows="2"
                            class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-300"
                            placeholder="Tulis balasan..." required></textarea>

                        <button type="submit"
                            class="self-end bg-indigo-600 hover:bg-indigo-700 text-white text-xs px-3 py-1.5 rounded-lg">
                            Kirim Balasan
                        </button>
                    </form>
                </details>

                {{-- RECURSIVE CHILD COMMENTS --}}
                @if($comment->children && $comment->children->count())
                <div class="mt-3">
                    @include('student.forum.partials.comments', ['comments' => $comment->children])
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endforeach