@extends('layouts.student')

@section('content')
<div class="container mx-auto py-8 px-4 sm:px-6 lg:px-8">

    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-8">
        <h2 class="text-3xl font-extrabold text-gray-800 flex items-center gap-2">
            <i class="fas fa-comments text-indigo-600"></i>
            Forum Diskusi Siswa
        </h2>
    </div>

    {{-- Alert sukses --}}
    @if(session('success'))
    <div class="bg-green-50 border border-green-300 text-green-700 px-4 py-3 rounded mb-6">
        {{ session('success') }}
    </div>
    @endif

    {{-- List Diskusi --}}
    <div class="space-y-5">
        @forelse($discussions as $discussion)
        <a href="{{ route('student.forum.show', $discussion) }}"
            class="block bg-white p-6 rounded-2xl shadow-sm border border-gray-200 hover:shadow-md 
           hover:border-indigo-200 transition-all">

            <div class="flex justify-between items-start">
                <h3 class="text-xl font-bold text-gray-800">
                    {{ $discussion->title }}
                </h3>

                <span class="text-xs bg-gray-100 text-gray-600 px-3 py-1 rounded-full">
                    {{ $discussion->created_at?->diffForHumans() ?? '-' }}
                </span>
            </div>

            <p class="text-gray-600 mt-3 text-sm leading-relaxed">
                {{ \Illuminate\Support\Str::limit($discussion->content ?? '', 150) }}
            </p>

            <div class="flex flex-wrap items-center gap-4 mt-4 text-xs text-gray-600">

                <span class="inline-flex items-center gap-1 bg-gray-100 px-2.5 py-1 rounded-full">
                    <i class="fas fa-user text-gray-500"></i>
                    {{ $discussion->user?->name ?? 'Unknown' }}
                </span>

                <span class="inline-flex items-center gap-1 bg-gray-100 px-2.5 py-1 rounded-full">
                    <i class="fas fa-school text-gray-500"></i>
                    {{ $discussion->classes?->name ?? 'Tidak ada kelas' }}
                </span>

                <span class="inline-flex items-center gap-1 bg-gray-100 px-2.5 py-1 rounded-full">
                    <i class="fas fa-reply text-gray-500"></i>
                    {{ $discussion->comments?->count() ?? 0 }} Balasan
                </span>
            </div>

        </a>
        @empty

        {{-- Empty State --}}
        <div class="p-12 text-center bg-white rounded-2xl shadow-sm border border-gray-200">
            <h3 class="text-lg font-semibold text-gray-700 mb-2">Belum ada diskusi</h3>
            <!-- <p class="text-gray-500 mb-4">Mulai diskusi pertama kamu sekarang.</p> -->

            <!-- <a href="{{ route('student.forum.create') }}"
                class="inline-block bg-indigo-500 hover:bg-indigo-600 text-white py-2 px-5 rounded-lg shadow-sm">
                Mulai Diskusi
            </a> -->
        </div>

        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="mt-8 flex justify-center">
        {{ $discussions->links() }}
    </div>

</div>
@endsection