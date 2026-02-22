@forelse($mapelAktif as $course)

<div class="bg-white rounded-xl shadow">

    <div class="h-40 relative overflow-hidden">

        @if($course->image)
        <img src="{{ asset('storage/'.$course->image) }}"
            class="w-full h-full object-cover">
        @endif

        <div class="absolute inset-0 bg-black/40 flex items-center justify-center">
            <h2 class="text-white text-xl font-bold">
                {{ $course->title }}
            </h2>
        </div>

    </div>

</div>

@empty

<p class="text-center text-gray-500">
    Belum ada mata pelajaran untuk kelas ini.
</p>

@endforelse