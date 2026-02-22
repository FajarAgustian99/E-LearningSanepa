@extends('layouts.admin')

@section('content')
<div class="max-w-6xl mx-auto mt-10 px-4">

    <!-- HEADER -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-6">
        <div>
            <h2 class="text-2xl font-bold">📋 Rekap Absensi Guru</h2>
            <p class="text-sm text-gray-500">
                Tanggal: {{ \Carbon\Carbon::parse($date)->format('d M Y') }}
            </p>
        </div>

        <div class="flex gap-2">
            {{-- Export Excel --}}
            <a
                href="{{ route('admin.attendance.export', [
            'course_id' => $course_id,
            'class_id'  => $class_id,
            'type'      => $type,
            'date'      => $date,
            'format'    => 'excel',
        ]) }}"
                class="px-4 py-2 bg-emerald-600 text-white rounded hover:bg-emerald-700">
                📥 Export Excel
            </a>

            {{-- Export PDF --}}
            <a
                href="{{ route('admin.attendance.export', [
            'course_id' => $course_id,
            'class_id'  => $class_id,
            'type'      => $type,
            'date'      => $date,
            'format'    => 'pdf',
        ]) }}"
                class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                📄 Export PDF
            </a>
            <button type="button"
                onclick="hadirSemua()"
                class="px-4 py-2 bg-emerald-600 text-white rounded hover:bg-emerald-700 transition">
                ✅ Hadir Semua
            </button>
            <a href="{{ route('admin.attendance.index') }}"
                class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                ← Kembali
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="mb-4 p-3 bg-green-100 text-green-800 rounded shadow">
        {{ session('success') }}
    </div>
    @endif

    <form method="POST" action="{{ route('admin.attendance.update') }}">
        @csrf
        @method('PUT')

        <input type="hidden" name="course_id" value="{{ $course_id }}">
        <input type="hidden" name="date" value="{{ $date }}">
        <input type="hidden" name="type" value="teacher">

        <!-- ================= TABLE ================= -->

        <div class="bg-white rounded-xl shadow overflow-hidden">

            <table class="min-w-full text-sm">

                <thead class="bg-indigo-600 text-white sticky top-0">
                    <tr>
                        <th class="py-3 px-4 w-12">No</th>
                        <th class="py-3 px-4 text-left">Nama Guru</th>
                        <th class="py-3 px-4 w-52">Status</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($users as $i=>$g)

                    @php
                    $a = $attendances[$g->id] ?? null;
                    @endphp

                    <tr class="{{ $i%2?'bg-gray-50':'' }} hover:bg-indigo-50 transition">

                        <td class="text-center py-3">
                            {{ $i+1 }}
                        </td>

                        <td class="px-4 font-medium">
                            {{ $g->name }}
                            <input type="hidden" name="user_id[]" value="{{ $g->id }}">
                        </td>

                        <td class="px-4">

                            <select name="status[]" class="status-select border rounded-lg px-3 py-2 w-full">

                                @foreach(['Hadir','Izin','Sakit','Alpha'] as $s)
                                <option value="{{ $s }}"
                                    {{ optional($a)->status==$s?'selected':'' }}>
                                    {{ $s }}
                                </option>
                                @endforeach

                            </select>
                        </td>
                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

        <!-- BUTTON SAVE -->

        <div class="text-right mt-6">
            <button
                class="px-8 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 shadow transition font-semibold">
                💾 Simpan Perubahan
            </button>
        </div>

        <!-- ================= REKAP ================= -->

        @php
        $total=['Hadir'=>0,'Izin'=>0,'Sakit'=>0,'Alpha'=>0];

        foreach($users as $u){
        $a=$attendances[$u->id]??null;
        if($a && isset($total[$a->status])) $total[$a->status]++;
        }
        @endphp

        <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mt-10">

            <div class="bg-emerald-100 p-4 rounded text-center">
                <p class="text-sm">Hadir</p>
                <p class="text-2xl font-bold">{{ $total['Hadir'] }}</p>
            </div>

            <div class="bg-yellow-100 p-4 rounded text-center">
                <p class="text-sm">Izin</p>
                <p class="text-2xl font-bold">{{ $total['Izin'] }}</p>
            </div>

            <div class="bg-blue-100 p-4 rounded text-center">
                <p class="text-sm">Sakit</p>
                <p class="text-2xl font-bold">{{ $total['Sakit'] }}</p>
            </div>

            <div class="bg-red-100 p-4 rounded text-center">
                <p class="text-sm">Alpha</p>
                <p class="text-2xl font-bold">{{ $total['Alpha'] }}</p>
            </div>

            <div class="bg-gray-800 text-white p-4 rounded text-center">
                <p class="text-sm">Total</p>
                <p class="text-2xl font-bold">{{ array_sum($total) }}</p>
            </div>

        </div>

    </form>
</div>

<!-- JS HADIR SEMUA -->
<script>
    function hadirSemua() {
        document.querySelectorAll('.status-select').forEach(el => {
            el.value = 'Hadir'
        })
    }
</script>

@endsection