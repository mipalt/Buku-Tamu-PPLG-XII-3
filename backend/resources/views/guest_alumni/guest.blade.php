<!DOCTYPE html>
<html>
<head>
    <title>Guest Alumni</title>
</head>
<body>
    <h1>Daftar Guest Alumni</h1>
    <a href="/guest-alumni/create">Tambah Alumni</a>

    <table border="1" cellpadding="5">
        <tr>
            <th>Nama</th>
            <th>Tahun Lulus</th>
            <th>Jurusan</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Tujuan</th>
            <th>Tanda Tangan</th>
        </tr>
        @foreach($alumni as $item)
            <tr>
                <td>{{ $item->name }}</td>
                <td>{{ $item->graduation_year }}</td>
                <td>{{ $item->major }}</td>
                <td>{{ $item->phone }}</td>
                <td>{{ $item->email }}</td>
                <td>{{ $item->purpose }}</td>
                <td>
                    @if($item->signature_path)
                        <img src="{{ asset('storage/' . $item->signature_path) }}" width="80">
                    @endif
                </td>
            </tr>
        @endforeach
    </table>
</body>
</html>
