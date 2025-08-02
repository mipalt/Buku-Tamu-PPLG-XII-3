<!DOCTYPE html>
<html>
<head>
    <title>Tambah Guest Alumni</title>
</head>
<body>
    <h1>Tambah Guest Alumni</h1>
    
    <form action="{{ route('guest') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label>Nama:</label><br>
        <input type="text" name="name" required><br><br>

        <label>Tahun Lulus:</label><br>
        <input type="number" name="graduation_year" required><br><br>

        <label>Jurusan:</label><br>
<select name="major" required>
    <option value="">-- Pilih Jurusan --</option>
    <option value="PPLG">PPLG</option>
</select><br><br>

        <label>Phone:</label><br>
        <input type="text" name="phone" required><br><br>

        <label>Email:</label><br>
        <input type="email" name="email"><br><br>

        <label>Tujuan:</label><br>
        <textarea name="purpose" required></textarea><br><br>

        <label>Tanda Tangan:</label><br>
        <input type="file" name="signature"><br><br>

        <button type="submit">Simpan</button>
    </form>
</body>
</html>
