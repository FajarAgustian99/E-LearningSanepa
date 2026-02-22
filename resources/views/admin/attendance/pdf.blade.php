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

        .summary td {
            text-align: center;
            font-weight: bold;
        }
    </style>
</head>

<body>

    {{-- ================= JUDUL ================= --}}
    <h3>Rekap Absensi Guru</h3>

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

            @php
            $total = ['Hadir'=>0,'Izin'=>0,'Sakit'=>0,'Alpha'=>0];
            @endphp

            @foreach($attendances as $i => $a)

            @php
            if(isset($total[$a->status])) $total[$a->status]++;
            @endphp

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

    <br>

    {{-- ================= REKAP ================= --}}
    <table class="summary">
        <tr>
            <td>Hadir<br>{{ $total['Hadir'] }}</td>
            <td>Izin<br>{{ $total['Izin'] }}</td>
            <td>Sakit<br>{{ $total['Sakit'] }}</td>
            <td>Alpha<br>{{ $total['Alpha'] }}</td>
            <td>Total<br>{{ array_sum($total) }}</td>
        </tr>
    </table>

    <br><br>

    <table width="100%" style="border:none">
        <tr>
            <td style="border:none"></td>
            <td style="border:none" width="200" align="center">
                <p>Wali Kelas</p>
                <br><br>
                <p>( __________________ )</p>
            </td>
        </tr>
    </table>

</body>

</html>