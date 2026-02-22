@extends('layouts.app')

@section('content')
<div class="container">

    <!-- ==========================
         HEADER HALAMAN
    =========================== -->
    <h2 class="mb-3">Daftar Tugas</h2>

    <!-- Tombol Tambah Tugas -->
    <a href="{{ route('teacher.assignments.create') }}" class="btn btn-primary mb-3">
        + Tambah Tugas
    </a>

    <!-- ==========================
         TABEL DAFTAR TUGAS
    =========================== -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Judul</th>
                <th>Kelas</th>
                <th>Mata Pelajaran</th>
                <th>Waktu Pengerjaan</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            @forelse($assignments as $assignment)
            <tr>
                <!-- Judul Tugas -->
                <td>{{ $assignment->title }}</td>

                <!-- Nama Kelas -->
                <td>{{ $assignment->class->name ?? '-' }}</td>

                <!-- Mata Pelajaran -->
                <td>{{ $assignment->course->title ?? '-' }}</td>

                <!-- Waktu Pengerjaan -->
                <td>{{ $assignment->due_date }}</td>

                <!-- Aksi -->
                <td class="d-flex gap-1">

                    <!-- Tombol Edit -->
                    <a href="{{ route('teacher.assignments.edit', $assignment) }}"
                        class="btn btn-warning btn-sm">
                        Edit
                    </a>

                    <!-- Form Hapus -->
                    <form action="{{ route('teacher.assignments.destroy', $assignment) }}"
                        method="POST"
                        onsubmit="return confirm('Yakin ingin menghapus tugas ini?')">
                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-danger btn-sm">
                            Hapus
                        </button>
                    </form>

                </td>
            </tr>

            @empty
            <!-- Jika data kosong -->
            <tr>
                <td colspan="5" class="text-center text-muted py-3">
                    Tidak ada tugas yang tersedia.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

</div>
@endsection