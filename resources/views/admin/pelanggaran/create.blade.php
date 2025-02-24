<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tambah Pelanggaran</title>
</head>
<body>
    <h1>Tambah Pelanggaran</h1>
    <br><br>

    <!-- Tombol kembali -->
    <a href="{{ route('pelanggaran.index') }}">Kembali</a><br><br>

    <!-- Menampilkan error validasi jika ada -->
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Form untuk menambah pelanggaran -->
    <form action="{{ route('pelanggaran.store') }}" method="POST">
        @csrf

        <!-- Input Jenis Pelanggaran -->
        <label for="jenis">Jenis Pelanggaran</label><br>
        <textarea id="jenis" name="jenis" rows="7" cols="50">{{ old('jenis') }}</textarea>
        <br><br>

        <!-- Input Konsekuensi -->
        <label for="konsekuensi">Konsekuensi</label><br>
        <textarea id="konsekuensi" name="konsekuensi" rows="7" cols="50">{{ old('konsekuensi') }}</textarea>
        <br><br>

        <!-- Input Poin -->
        <label for="poin">Poin</label><br>
        <input type="number" id="poin" name="poin" value="{{ old('poin') }}"><br><br>

        <!-- Submit Button -->
        <input type="submit" value="Tambah Pelanggaran">
    </form>

</body>
</html>
