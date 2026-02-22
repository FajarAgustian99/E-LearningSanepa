<table>
    <thead>
        <tr>
            <th>Nama</th>
            <th>Email</th>
            <th>Kelas</th>
        </tr>
    </thead>
    <tbody>
        @foreach($students as $student)
        <tr>
            <td>{{ $student->name }}</td>
            <td>{{ $student->email }}</td>
            <td>{{ $student->class->name ?? 'N/A' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>