@extends('layouts.teacher')

@section('title', 'Daftar Diskusi')

@section('content')
<div class="max-w-6xl mx-auto px-4 md:px-0">

    {{-- Header --}}
    <div class="flex flex-col md:flex-row items-start md:items-center justify-between mb-6 gap-4">
        <div>
            <h1 class="text-3xl font-bold text-[#0A1D56]">Forum Diskusi</h1>
            <p class="text-gray-600">Semua diskusi yang dibuat oleh guru.</p>
        </div>

        <a href="{{ route('teacher.discussions.create') }}"
            class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg shadow transition">
            ➕ Diskusi Baru
        </a>
    </div>

    {{-- Notifikasi --}}
    @if(session('success'))
    <div class="p-3 mb-4 bg-green-100 border border-green-300 text-green-800 rounded-lg">
        {{ session('success') }}
    </div>
    @endif

    @if(isset($newCommentsCount) && $newCommentsCount > 0)
    <div class="p-3 mb-4 bg-yellow-100 border border-yellow-300 text-yellow-800 rounded-lg flex items-center gap-2">
        <span class="text-lg">🔔</span>
        <span>Ada <strong>{{ $newCommentsCount }}</strong> diskusi yang diperbarui.</span>
    </div>
    @endif

    {{-- Table / Card List --}}
    <div class="bg-white shadow rounded-xl overflow-hidden">
        <table class="w-full table-auto hidden md:table">
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
                            @else
                            <span class="text-gray-500">{{ $discussion->title }}</span>
                            @endif

                            @if(isset($lastVisit) && $discussion->updated_at > $lastVisit)
                            <span class="text-xs px-2 py-1 bg-blue-100 text-blue-700 rounded-full">Baru 🔥</span>
                            @endif
                        </div>
                    </td>

                    <td class="px-4 py-3 text-center">{{ $discussion->classes->description ?? '-' }}</td>
                    <td class="px-4 py-3 text-center">{{ $discussion->comments_count }}</td>
                    <td class="px-4 py-3 text-center text-gray-600">{{ $discussion->updated_at->diffForHumans() }}</td>
                    <td class="px-4 py-3 text-center">
                        <div class="flex justify-center gap-2 flex-wrap">
                            @if($discussion->classes)
                            <a href="{{ route('teacher.discussions.showThread', [$discussion->classes->id, $discussion->id]) }}"
                                class="px-3 py-1 bg-blue-500 text-white rounded-lg hover:bg-blue-600 text-sm">👁 Lihat</a>
                            @endif

                            @if(Auth::id() === $discussion->teacher_id)
                            <form action="{{ route('teacher.discussions.destroy', $discussion->id) }}" method="POST"
                                onsubmit="return confirm('Yakin ingin menghapus diskusi ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="px-3 py-1 bg-red-500 text-white rounded-lg hover:bg-red-600 text-sm">🗑 Hapus</button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-4 py-6 text-center text-gray-500">Belum ada diskusi.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Mobile Card List --}}
        <div class="md:hidden space-y-4 p-4">
            @forelse($discussions as $discussion)
            <div class="bg-gray-50 p-4 rounded-lg shadow hover:shadow-md transition">
                <div class="flex justify-between items-start">
                    <div>
                        <a href="{{ $discussion->classes ? route('teacher.discussions.showThread', [$discussion->classes->id, $discussion->id]) : '#' }}"
                            class="font-semibold text-blue-700 hover:underline">
                            {{ $discussion->title }}
                        </a>
                        @if(isset($lastVisit) && $discussion->updated_at > $lastVisit)
                        <span class="text-xs px-2 py-1 bg-blue-100 text-blue-700 rounded-full ml-1">Baru 🔥</span>
                        @endif
                        <p class="text-gray-500 text-sm mt-1">{{ $discussion->classes->description ?? '-' }}</p>
                    </div>
                    <div class="text-right text-gray-500 text-sm">
                        {{ $discussion->updated_at->diffForHumans() }}
                    </div>
                </div>
                <div class="flex justify-between items-center mt-3">
                    <span class="text-gray-600 text-sm">{{ $discussion->comments_count }} Komentar</span>
                    <div class="flex gap-2 flex-wrap">
                        @if($discussion->classes)
                        <a href="{{ route('teacher.discussions.showThread', [$discussion->classes->id, $discussion->id]) }}"
                            class="px-3 py-1 bg-blue-500 text-white rounded-lg hover:bg-blue-600 text-sm">👁 Lihat</a>
                        @endif
                        @if(Auth::id() === $discussion->teacher_id)
                        <form action="{{ route('teacher.discussions.destroy', $discussion->id) }}" method="POST"
                            onsubmit="return confirm('Yakin ingin menghapus diskusi ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="px-3 py-1 bg-red-500 text-white rounded-lg hover:bg-red-600 text-sm">🗑 Hapus</button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <p class="text-gray-500 text-center">Belum ada diskusi.</p>
            @endforelse
        </div>
    </div>

    {{-- Pagination --}}
    <div class="mt-4">{{ $discussions->links() }}</div>
</div>
@endsection