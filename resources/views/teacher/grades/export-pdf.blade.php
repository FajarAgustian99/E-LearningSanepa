<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: DejaVu Sans;
            font-size: 11px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 5px;
            text-align: center;
        }

        th {
            background: #f2f2f2;
        }

        .header {
            text-align: center;
            margin-bottom: 10px;
        }

        .info {
            margin-bottom: 8px;
        }
    </style>
</head>

<body>

    <div class="header">
        <h3>LAPORAN NILAI SISWA</h3>
    </div>

    <div class="info">
        <strong>Kelas :</strong> {{ $class->name }} <br>
        <strong>Mata Pelajaran :</strong> {{ $course->title }}
    </div>

    <table>
        <thead>
            <tr>
                <th>Nama</th>
                <th>Absensi</th>
                <th>LM 1</th>
                <th>LM 2</th>
                <th>LM 3</th>
                <th>LM 4</th>
                <th>Sumatif</th>
                <th>UHB</th>
                <th>PSAT</th>
                <th>NA</th>
                <th>KKTP</th>
            </tr>
        </thead>
        <tbody>
            @foreach($grades as $g)
            <tr>
                <td>{{ $g->student->name ?? '-' }}</td>
                <td>{{ $g->rekap_absensi }}</td>
                <td>{{ $g->lingkup_materi_1 }}</td>
                <td>{{ $g->lingkup_materi_2 }}</td>
                <td>{{ $g->lingkup_materi_3 }}</td>
                <td>{{ $g->lingkup_materi_4 }}</td>
                <td>{{ $g->sumatif_akhir_semester }}</td>
                <td>{{ $g->uhb }}</td>
                <td>{{ $g->psat }}</td>
                <td>{{ $g->na }}</td>
                <td>{{ $g->kktp }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>