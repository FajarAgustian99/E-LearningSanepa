<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px
        }

        table {
            width: 100%;
            border-collapse: collapse
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
            text-align: center
        }
    </style>
</head>

<body>

    <h3>Rekap Absensi Siswa</h3>

    <p>
        Kelas: {{ $kelas->name ?? '-' }}<br>
        Periode: {{ \Carbon\Carbon::parse($month)->translatedFormat('F Y') }}<br>
        Dicetak: {{ now()->format('d F Y') }}
    </p>

    <table>
        <thead>
            <tr>
                <th>Nama</th>
                <th>Hadir</th>
                <th>Izin</th>
                <th>Sakit</th>
                <th>Alpha</th>
                <th>Total</th>
            </tr>
        </thead>

        <tbody>
            @foreach($students as $s)
            <tr>
                <td style="text-align:left">{{ $s->name }}</td>
                <td>{{ $rekap[$s->id]['Hadir'] ?? 0 }}</td>
                <td>{{ $rekap[$s->id]['Izin'] ?? 0 }}</td>
                <td>{{ $rekap[$s->id]['Sakit'] ?? 0 }}</td>
                <td>{{ $rekap[$s->id]['Alpha'] ?? 0 }}</td>
                <td>{{ $rekap[$s->id]['Total'] ?? 0 }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>