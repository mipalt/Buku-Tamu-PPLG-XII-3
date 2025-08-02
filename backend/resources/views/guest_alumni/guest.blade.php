<!DOCTYPE html>
<html>

<head>
    <title>Tambah Guest Alumni</title>
      <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f3f4f6;
            margin: 0;
            padding: 40px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        form {
            background-color: #ffffff;
            max-width: 500px;
            margin: 0 auto;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
            color: #333;
        }

        input[type="text"],
        input[type="number"],
        input[type="email"],
        textarea,
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            margin-bottom: 15px;
            box-sizing: border-box;
        }

        textarea {
            resize: vertical;
        }

        button {
            background-color: #2563eb;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 6px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
        }

        button:hover {
            background-color: #1d4ed8;
        }

        .alert-success,
        .alert-error {
            max-width: 500px;
            margin: 0 auto 20px;
            padding: 15px;
            border-radius: 6px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        ul {
            padding-left: 20px;
        }
    </style>
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

        <label>Phone:</label>
        <input type="text" name="phone" id="phoneInput" value="{{ old('phone', '+62') }}" required>

        <label>Email:</label><br>
        <input type="email" name="email" value="{{ old('email') }}" ><br><br>

        <label>Tujuan:</label><br>
        <textarea name="purpose" value="{{ old('purpose') }}"  required></textarea><br><br>

        <label>Tanda Tangan:</label><br>
<input type="file" name="signature_path" id="signature" accept="image/*" onchange="previewSignature(event)">
<br><br>
<img id="signaturePreview" src="#" alt="Preview Tanda Tangan" style="display:none; width:150px; margin-top:10px;">


        <button type="submit">Simpan</button>
    </form>
</body>

</html>

<script>
    const phoneInput = document.getElementById('phoneInput');

    phoneInput.addEventListener('focus', function () {
        if (!phoneInput.value.startsWith('+62')) {
            phoneInput.value = '+62';
        }

        // Pindahkan kursor ke akhir input
        setTimeout(() => {
            phoneInput.setSelectionRange(phoneInput.value.length, phoneInput.value.length);
        }, 0);
    });

    phoneInput.addEventListener('keydown', function (e) {
        // Cegah menghapus "+62"
        if ((phoneInput.selectionStart <= 3) && (e.key === "Backspace" || e.key === "Delete")) {
            e.preventDefault();
        }
    });

    phoneInput.addEventListener('paste', function (e) {
        e.preventDefault(); // Cegah paste yang bisa menghapus +62
    });
    function previewSignature(event) {
    var reader = new FileReader();
    reader.onload = function(){
        var output = document.getElementById('signaturePreview');
        output.src = reader.result;
        output.style.display = 'block';
    };
    reader.readAsDataURL(event.target.files[0]);
}
</script>

