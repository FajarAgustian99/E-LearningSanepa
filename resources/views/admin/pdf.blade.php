<!DOCTYPE html>
<html>

<head>
    <title>Data Nilai</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid black;
            padding: 6px;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <h3>Data Nilai Kelas {{ $grades->first()->class->name ?? '' }}</h3>
    <table>
        <thead>
            <tr>
                <th>Nama Siswa</th>
                <th>Guru</th>
                <th>Mata Pelajaran</th>
                <th>Nilai</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($grades as $grade)
            <tr>
                <td>{{ $grade->student->name }}</td>
                <td>{{ $grade->teacher->name }}</td>
                <td>{{ $grade->course->name }}</td>
                <td>{{ $grade->score }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>