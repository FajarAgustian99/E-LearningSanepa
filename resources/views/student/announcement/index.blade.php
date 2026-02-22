@extends('layouts.student')

@section('title','Pengumuman')
@section('page-title','Pengumuman')

@section('content')
<div class="space-y-6">

    @forelse($announcements as $a)
    <article class="bg-white p-6 rounded-xl shadow-md border border-gray-100 hover:shadow-lg transition relative overflow-hidden">

        {{-- Label Kategori --}}
        @if($a->category)
        <span class="absolute top-4 right-4 bg-indigo-100 text-indigo-700 px-2 py-1 rounded text-xs font-semibold">
            {{ $a->category->name }}
        </span>
        @endif

        {{-- Thumbnail Gambar --}}
        @if($a->image)
        <div class="mb-4">
            <img src="{{ asset('storage/' . $a->image) }}" alt="{{ $a->title }}" class="rounded-lg w-full h-48 object-cover">
        </div>
        @endif

        {{-- Judul --}}
        <h3 class="text-xl font-bold text-[#0A1D56]">
            {{ $a->title }}
        </h3>

        {{-- Tanggal --}}
        <p class="mt-1 text-sm text-gray-500 flex items-center gap-2">
            📅 <span>{{ $a->date->format('d M Y') }}</span>
        </p>

        {{-- Deskripsi Singkat --}}
        <div class="mt-3 text-gray-700 leading-relaxed">
            {!! Str::limit(strip_tags($a->description), 220) !!}
        </div>

        {{-- Tombol Baca Selengkapnya --}}
        <div class="mt-4">
            <a href="{{ route('student.announcements.show', $a) }}"
                class="inline-block px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg text-sm font-medium transition">
                Baca Selengkapnya →
            </a>
        </div>

    </article>
    @empty

    {{-- Jika tidak ada pengumuman --}}
    <div class="bg-white p-10 rounded-xl text-center shadow-md">
        <p class="text-gray-500 text-lg">Belum ada pengumuman.</p>
    </div>

    @endforelse

    {{-- Pagination --}}
    <div class="pt-4">
        {{ $announcements->links('pagination::tailwind') }}
    </div>

</div>
@endsection