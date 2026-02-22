<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">

    <style>
        body {
            font-family: DejaVu Sans;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
        }

        th {
            background: #eee;
        }

        h3 {
            text-align: center;
            margin-bottom: 4px;
        }

        .sub {
            text-align: center;
            margin-bottom: 15px;
            font-size: 11px;
        }
    </style>
</head>

<body>

    {{-- ================= JUDUL ================= --}}
    <h3>Rekap Absensi Siswa</h3>

    <div class="sub">
        {{ $className }} — {{ $tanggal }}
    </div>

    <table>
        <thead>
            <tr>
                <th width="40">No</th>
                <th>Nama</th>
                <th width="120">Status</th>
            </tr>
        </thead>

        <tbody>

            @foreach($attendances as $i => $a)
            <tr>
                <td align="center">{{ $i+1 }}</td>
                <td>{{ optional($a->student)->name ?? '-' }}</td>
                <td align="center">{{ $a->status }}</td>
            </tr>
            @endforeach

            @if($attendances->count() == 0)
            <tr>
                <td colspan="3" align="center">Data kosong</td>
            </tr>
            @endif

        </tbody>
    </table>

</body>

</html>