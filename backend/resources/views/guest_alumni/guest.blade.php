<!DOCTYPE html>
<html>

<head>
    <title>Tambah Guest Alumni</title>
</head>

<body>
    <h1>Tambah Guest Alumni</h1>
    @if(session('success'))
    <div style="background: #d4edda; color: #155724; padding: 10px; border: 1px solid #c3e6cb; border-radius: 5px; margin-bottom: 15px;">
        {{ session('success') }}
    </div>
@endif

@if ($errors->any())
    <div style="background: #f8d7da; color: #721c24; padding: 10px; border: 1px solid #f5c6cb; border-radius: 5px; margin-bottom: 15px;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

    <form action="{{ route('guest.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label>Nama:</label><br>
        <input type="text" name="name"  value="{{ old('name') }}" required><br><br>

        <label>Tahun Lulus:</label><br>
        <input type="number" name="graduation_year" value="{{ old('graduation_year') }}" required><br><br>

        <label>Jurusan:</label><br>
        <select name="major" required>
            <option value="">-- Pilih Jurusan --</option>
            <option value="PPLG">PPLG</option>
            <option value="PPLG">TJKT</option>
        </select><br><br>

        <label>Phone:</label><br>
        <input type="number" name="phone" value="{{ old('phone') }}"  required><br><br>

        <label>Email:</label><br>
        <input type="email" name="email" value="{{ old('email') }}" ><br><br>

        <label>Tujuan:</label><br>
        <textarea name="purpose" value="{{ old('purpose') }}"  required></textarea><br><br>

        <label>Tanda Tangan:</label><br>
        <input type="file" name="signature_path"><br><br>

        <button type="submit">Simpan</button>
    </form>
</body>

</html>
