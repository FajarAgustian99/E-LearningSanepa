@extends('layouts.teacher')

@section('title', 'Daftar Diskusi')

@section('content')
<div class="max-w-6xl mx-auto px-3 md:px-0">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6 gap-3">

        <div>
            <h1 class="text-2xl md:text-3xl font-bold text-[#0A1D56]">
                Forum Diskusi
            </h1>
            <p class="text-gray-600 text-sm md:text-base">
                Semua diskusi yang dibuat oleh guru.
            </p>
        </div>

        <a href="{{ route('teacher.discussions.create') }}"
            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow text-sm md:text-base text-center">
            ➕ Diskusi Baru
        </a>

    </div>


    {{-- Notifikasi --}}
    @if(session('success'))
    <div class="p-3 mb-4 bg-green-100 border border-green-300 text-green-800 rounded-lg text-sm">
        {{ session('success') }}
    </div>
    @endif

    @if(isset($newCommentsCount) && $newCommentsCount > 0)
    <div class="p-3 mb-4 bg-yellow-100 border border-yellow-300 text-yellow-800 rounded-lg flex items-center gap-2 text-sm">
        <span>🔔</span>
        <span>Ada <strong>{{ $newCommentsCount }}</strong> diskusi yang diperbarui.</span>
    </div>
    @endif


    {{-- DESKTOP TABLE --}}
    <div class="bg-white shadow rounded-xl overflow-hidden hidden md:block">

        <table class="w-full table-auto">

            <thead class="bg-gray-100 border-b">
                <tr>
                    <th class="px-4 py-3 text-left">Judul</th>
                    <th class="px-4 py-3 text-center">Kelas</th>
                    <th class="px-4 py-3 text-center">Komentar</th>
                    <th class="px-4 py-3 text-center">Diperbarui</th>
                    <th class="px-4 py-3 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($discussions as $discussion)

                <tr class="border-b hover:bg-gray-50">

                    <td class="px-4 py-3">
                        <div class="flex items-center gap-2">

                            @if($discussion->classes)
                            <a href="{{ route('teacher.discussions.showThread', [$discussion->classes->id, $discussion->id]) }}"
                                class="text-blue-700 font-semibold hover:underline">
                                {{ $discussion->title }}
                            </a>
                            @endif

                            @if(isset($lastVisit) && $discussion->updated_at > $lastVisit)
                            <span class="text-xs px-2 py-1 bg-blue-100 text-blue-700 rounded-full">
                                Baru 🔥
                            </span>
                            @endif

                        </div>
                    </td>

                    <td class="text-center">
                        {{ $discussion->classes->description ?? '-' }}
                    </td>

                    <td class="text-center">
                        {{ $discussion->comments_count }}
                    </td>

                    <td class="text-center text-gray-600">
                        {{ $discussion->updated_at->diffForHumans() }}
                    </td>

                    <td class="text-center">
                        <div class="flex justify-center gap-2 flex-wrap">

                            @if($discussion->classes)
                            <a href="{{ route('teacher.discussions.showThread', [$discussion->classes->id, $discussion->id]) }}"
                                class="px-3 py-1 bg-blue-500 text-white rounded-lg hover:bg-blue-600 text-sm">
                                👁 Lihat
                            </a>
                            @endif

                            @if(Auth::id() === $discussion->teacher_id)
                            <a href="{{ route('teacher.discussions.edit', $discussion->id) }}"
                                class="px-3 py-1 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 text-sm">
                                ✏️ Edit
                            </a>
                            @endif

                            @if(Auth::id() === $discussion->teacher_id)
                            <form action="{{ route('teacher.discussions.destroy', $discussion->id) }}"
                                method="POST"
                                onsubmit="return confirm('Yakin ingin menghapus diskusi ini?')">
                                @csrf
                                @method('DELETE')

                                <button
                                    class="px-3 py-1 bg-red-500 text-white rounded-lg hover:bg-red-600 text-sm">
                                    🗑 Hapus
                                </button>

                            </form>
                            @endif

                        </div>
                    </td>

                </tr>

                @empty

                <tr>
                    <td colspan="5" class="px-4 py-6 text-center text-gray-500">
                        Belum ada diskusi.
                    </td>
                </tr>

                @endforelse
            </tbody>

        </table>
    </div>



    {{-- MOBILE CARD --}}
    <div class="md:hidden space-y-3">

        @forelse($discussions as $discussion)

        <div class="bg-white border rounded-xl p-4 shadow-sm">

            {{-- Judul --}}
            <div class="flex justify-between gap-3">

                <div>

                    <a href="{{ $discussion->classes ? route('teacher.discussions.showThread', [$discussion->classes->id, $discussion->id]) : '#' }}"
                        class="font-semibold text-blue-700 leading-snug">

                        {{ $discussion->title }}

                    </a>

                    @if(isset($lastVisit) && $discussion->updated_at > $lastVisit)
                    <div class="mt-1">
                        <span class="text-xs px-2 py-1 bg-blue-100 text-blue-700 rounded-full">
                            Baru 🔥
                        </span>
                    </div>
                    @endif

                </div>

                <div class="text-xs text-gray-500 text-right">
                    {{ $discussion->updated_at->diffForHumans() }}
                </div>

            </div>


            {{-- Info --}}
            <div class="flex justify-between items-center mt-3 text-sm text-gray-600">

                <span>
                    📚 {{ $discussion->classes->description ?? '-' }}
                </span>

                <span>
                    💬 {{ $discussion->comments_count }}
                </span>

            </div>


            {{-- Tombol --}}
            <div class="flex gap-2 mt-4 flex-wrap">

                @if($discussion->classes)
                <a href="{{ route('teacher.discussions.showThread', [$discussion->classes->id, $discussion->id]) }}"
                    class="flex-1 text-center px-3 py-2 bg-blue-500 text-white rounded-lg text-sm">
                    👁 Lihat
                </a>
                @endif

                @if(Auth::id() === $discussion->teacher_id)
                <a href="{{ route('teacher.discussions.edit', $discussion->id) }}"
                    class="flex-1 text-center px-3 py-2 bg-yellow-500 text-white rounded-lg text-sm">
                    ✏️ Edit
                </a>
                @endif

                @if(Auth::id() === $discussion->teacher_id)
                <form action="{{ route('teacher.discussions.destroy', $discussion->id) }}"
                    method="POST"
                    class="flex-1"
                    onsubmit="return confirm('Yakin ingin menghapus diskusi ini?')">

                    @csrf
                    @method('DELETE')

                    <button
                        class="w-full px-3 py-2 bg-red-500 text-white rounded-lg text-sm">
                        🗑 Hapus
                    </button>

                </form>
                @endif

            </div>

        </div>

        @empty

        <p class="text-gray-500 text-center">
            Belum ada diskusi.
        </p>

        @endforelse

    </div>


    {{-- Pagination --}}
    <div class="mt-6">
        {{ $discussions->links() }}
    </div>

</div>
@endsection