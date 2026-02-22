<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Hasil Quiz</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
        }

        th {
            background: #eee;
        }
    </style>
</head>

<body>

    <h2>Hasil Quiz: {{ $quiz->title }}</h2>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Siswa</th>
                <th>Nilai</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($quiz->submissions as $index => $submission)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $submission->user->name }}</td>
                <td>{{ $submission->score ?? 0 }}</td>
                <td>{{ $submission->is_submitted ? 'Selesai' : 'Belum' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>