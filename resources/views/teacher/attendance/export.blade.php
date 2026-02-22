<table>
    <thead>

        <tr>
            <th colspan="6" style="text-align:center;font-weight:bold;">
                Rekap Absensi Siswa
            </th>
        </tr>

        <tr>
            <th colspan="6" style="text-align:center;">
                Kelas: {{ $kelas->name ?? '-' }}
            </th>
        </tr>

        <tr>
            <th colspan="6" style="text-align:center;">
                Periode: {{ \Carbon\Carbon::parse($month . '-01')->translatedFormat('F Y') }}
            </th>
        </tr>

        <tr>
            <th colspan="6" style="text-align:center;">
                Dicetak: {{ now()->translatedFormat('d F Y') }}
            </th>
        </tr>

        <tr>
            <th colspan="6"></th>
        </tr>

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
        @foreach($students as $student)
        <tr>
            <td>{{ $student->name }}</td>
            <td>{{ $rekap[$student->id]['Hadir'] }}</td>
            <td>{{ $rekap[$student->id]['Izin'] }}</td>
            <td>{{ $rekap[$student->id]['Sakit'] }}</td>
            <td>{{ $rekap[$student->id]['Alpha'] }}</td>
            <td><strong>{{ $rekap[$student->id]['Total'] }}</strong></td>
        </tr>
        @endforeach
    </tbody>
</table>