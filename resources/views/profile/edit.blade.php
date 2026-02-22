@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <h1 class="text-2xl font-bold mb-6">Edit Profil</h1>

    <form action="{{ route('profile.update') }}" method="POST">
        @csrf
        @method('PATCH')

        <div class="mb-4">
            <label for="name">Nama</label>
            <input type="text" name="name" value="{{ $user->name }}" required>
        </div>

        <div class="mb-4">
            <label for="email">Email</label>
            <input type="email" name="email" value="{{ $user->email }}" required>
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Simpan</button>
    </form>
</div>
@endsection