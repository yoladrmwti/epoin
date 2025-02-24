<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Data Siswa</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0px;
        }

        table, th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        .alert-danger {
            color: red;
            background: #ffdddd;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <h1>Edit Data Siswa</h1>

    <a href="{{ route('siswa.index') }}">Kembali</a>
    <br><br>

    {{-- Notifikasi Error --}}
    @if ($errors->any())
        <div class="alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form Edit Siswa --}}
    <form action="{{ route('siswa.update', $siswa->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <h2>Data Siswa</h2>

        {{-- Foto Siswa --}}
        <label>Foto Siswa</label><br>
        <img src="{{ asset('storage/siswas/' . $siswa->image) }}" width="120px" height="120px" alt="Foto Siswa">
        <br>
        <input type="file" name="image" accept="image/*">
        <br><br>

        {{-- NIS --}}
        <label>NIS Siswa</label><br>
        <input type="text" name="nis" value="{{ old('nis', $siswa->nis) }}" required>
        <br><br>

        {{-- Tingkatan --}}
        <label>Tingkatan</label><br>
        <select name="tingkatan" required>
            <option value="X" {{ $siswa->tingkatan == 'X' ? 'selected' : '' }}>X</option>
            <option value="XI" {{ $siswa->tingkatan == 'XI' ? 'selected' : '' }}>XI</option>
            <option value="XII" {{ $siswa->tingkatan == 'XII' ? 'selected' : '' }}>XII</option>
        </select>
        <br><br>

        {{-- Jurusan --}}
        <label>Jurusan</label><br>
        <select name="jurusan" required>
            <option value="TBSM" {{ $siswa->jurusan == 'TBSM' ? 'selected' : '' }}>TBSM</option>
            <option value="TJKT" {{ $siswa->jurusan == 'TJKT' ? 'selected' : '' }}>TJKT</option>
            <option value="PPLG" {{ $siswa->jurusan == 'PPLG' ? 'selected' : '' }}>PPLG</option>
            <option value="DKV" {{ $siswa->jurusan == 'DKV' ? 'selected' : '' }}>DKV</option>
            <option value="TOI" {{ $siswa->jurusan == 'TOI' ? 'selected' : '' }}>TOI</option>
        </select>
        <br><br>

        {{-- Kelas --}}
        <label>Kelas</label><br>
        <select name="kelas" required>
            <option value="1" {{ $siswa->kelas == '1' ? 'selected' : '' }}>1</option>
            <option value="2" {{ $siswa->kelas == '2' ? 'selected' : '' }}>2</option>
            <option value="3" {{ $siswa->kelas == '3' ? 'selected' : '' }}>3</option>
            <option value="4" {{ $siswa->kelas == '4' ? 'selected' : '' }}>4</option>
        </select>
        <br><br>

        {{-- No HP --}}
        <label>No HP</label><br>
        <input type="text" name="hp" value="{{ old('hp', $siswa->hp) }}" required>
        <br><br>

        {{-- Status --}}
        <label>Status</label><br>
        <select name="status" required>
            <option value="1" {{ $siswa->status == 1 ? 'selected' : '' }}>Aktif</option>
            <option value="0" {{ $siswa->status == 0 ? 'selected' : '' }}>Tidak Aktif</option>
        </select>
        <br><br>

        {{-- Tombol Submit --}}
        <button type="submit">SIMPAN DATA</button>
        <button type="reset">RESET FORM</button>
    </form>
</body>

</html>
