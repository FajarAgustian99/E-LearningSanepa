@extends('layouts.admin')

@section('title', isset($announcement) ? 'Edit Pengumuman' : 'Tambah Pengumuman')

@section('content')

{{-- Tombol Kembali --}}
<a href="{{ route('admin.announcements.index') }}"
    class="inline-flex items-center gap-2 bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded mb-4">
    <span class="material-icons">arrow_back</span>
    Kembali
</a>

<h1 class="text-2xl font-bold mb-6">
    {{ isset($announcement) ? 'Edit' : 'Tambah' }} Pengumuman
</h1>

{{-- Pesan Error --}}
@if($errors->any())
<div class="bg-red-100 text-red-700 p-3 rounded mb-4">
    <ul>
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

{{-- FORM --}}
<form
    action="{{ isset($announcement)
        ? route('admin.announcements.update', $announcement->id)
        : route('admin.announcements.store')
    }}"
    method="POST"
    class="space-y-4">

    @csrf
    @if(isset($announcement))
    @method('PUT')
    @endif

    {{-- Judul --}}
    <div>
        <label class="block mb-1 font-medium">Judul</label>
        <input type="text" name="title"
            class="w-full border px-4 py-2 rounded"
            value="{{ $announcement->title ?? old('title') }}"
            required>
    </div>

    {{-- Deskripsi --}}
    <div>
        <label class="block mb-1 font-medium">Deskripsi</label>
        <textarea name="description"
            class="w-full border px-4 py-2 rounded"
            required>{{ $announcement->description ?? old('description') }}</textarea>
    </div>

    {{-- Tanggal --}}
    <div>
        <label class="block mb-1 font-medium">Tanggal</label>
        <input type="date" name="date"
            class="w-full border px-4 py-2 rounded"
            value="{{ isset($announcement) ? $announcement->date->format('Y-m-d') : old('date') }}"
            required>
    </div>

    {{-- Tombol Submit --}}
    <button type="submit"
        class="bg-green-600 text-white px-6 py-2 rounded">
        {{ isset($announcement) ? 'Update' : 'Simpan' }}
    </button>

</form>

@endsection