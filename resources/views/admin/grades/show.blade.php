@extends('layouts.navigation')

@section('content')
<div class="container">
    <h3 class="mb-3">Daftar Nilai Kelas {{ $class_id }} - Mapel {{ $course_id }}</h3>

    <div class="mb-3">
        <a href="{{ route('admin.grades.export.excel', [$class_id, $course_id]) }}" class="btn btn-success">Download Excel</a>
        <a href="{{ route('admin.grades.export.pdf', [$class_id, $course_id]) }}" class="btn btn-danger">Download PDF</a>
    </div>

    <table class="table table-bordered">
        <thead class="bg-gray-200">
            <tr>
                <th>Nama Siswa</th>
                <th>Guru Pengampu</th>
                <th>Mata Pelajaran</th>
                <th>Nilai</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($grades as $grade)
            <tr>
                <td>{{ $grade->student->name }}</td>
                <td>{{ $grade->teacher->name }}</td>
                <td>{{ $grade->course->name }}</td>
                <td>{{ $grade->score }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center">Belum ada nilai</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection