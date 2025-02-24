<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Data pelanggaran</title>
<style type="text/css">
 table 
 {
    width: 100%;
    border-collapse: collapse;
    margin: 20px 0px;
 }

 table,
 th,
 td {
    border: 1px solid;
 }
</style>

</head>
<body>
    <h1>Edit Pelanggaran</h1>
    <a href="{{ route('pelanggaran.index') }}">Kembali</a><br><br>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    @if(Session::has('success'))
    <div class="alert alert-success" role="alert">
        {{ Session::get('success') }}
    </div>
@endif

<form action="{{ route('pelanggaran.update',$pelanggaran->id) }}" method="POST" enctype="multipart/form-data">
    @csrf@method('PUT')
    <h2>Data Pelanggaran</h2>
    <label>Jenis pelanggaran</label><br>
    <textarea id="jenis" name="jenis" cols="50" rows="7" value="{{ old('jenis') }}">{{ $pelanggaran->jenis }}</textarea>
<br><br>

<label>Konsekuensi pelanggaran</label><br>
<textarea name="konsekuensi" id="konsekuensi" cols="50" rows="7" value="{{ old('konsekuensi') }}">{{ $pelanggaran->konsekuensi }}</textarea>
<br><br>

<label>poin pelanggaran</label><br>
<input type="text" id="poin" name="poin" value="{{ $pelanggaran->poin }}">
<br><br>

<button type="submit">SIMPAN DATA</button>
<br><br>
</form>

</body>
</html>