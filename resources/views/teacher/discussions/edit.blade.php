@extends('layouts.teacher')
@section('title', 'Edit Diskusi')

@section('content')
<div class="max-w-3xl mx-auto px-4 md:px-0">

    <h2 class="text-2xl font-bold text-[#0A1D56] mb-4 text-center">
        Edit Diskusi
    </h2>

    <div class="bg-white shadow rounded-lg p-6">

        <form action="{{ route('teacher.discussions.update', $discussion->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block font-semibold mb-1">Kelas</label>

                <select name="class_id" class="w-full border rounded-lg px-3 py-2">
                    @foreach($classes as $class)
                    <option value="{{ $class->id }}"
                        {{ $discussion->class_id == $class->id ? 'selected' : '' }}>
                        {{ $class->description }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="font-semibold block mb-1">Judul Diskusi</label>

                <input
                    type="text"
                    name="title"
                    value="{{ old('title',$discussion->title) }}"
                    class="w-full border rounded-lg px-3 py-2">
            </div>

            <div class="mb-4">
                <label class="font-semibold block mb-1">Isi Diskusi</label>

                <textarea
                    name="content"
                    rows="5"
                    class="w-full border rounded-lg px-3 py-2">{{ old('content',$discussion->content) }}</textarea>
            </div>

            <div class="flex gap-3">

                <button class="bg-blue-600 text-white px-5 py-2 rounded-lg">
                    💾 Simpan
                </button>

                <a href="{{ route('teacher.discussions.index') }}"
                    class="bg-gray-300 px-5 py-2 rounded-lg">
                    Batal
                </a>

            </div>

        </form>
    </div>
</div>
@endsection