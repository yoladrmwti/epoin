<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Akun</title>
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

        .alert-success {
            color: green;
            background: #ddffdd;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <h1>Edit Akun</h1>
    <a href="{{ route('akun.index') }}">Kembali</a>
    <br><br>

    {{-- Notifikasi Error --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Notifikasi Sukses --}}
    @if (Session::has('success'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('success') }}
        </div>
    @endif

    {{-- Form Edit Akun --}}
    <form action="{{ route('akun.update', $akun->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <h2>Data Akun</h2>

        {{-- Nama Lengkap --}}
        <label>Nama Lengkap</label><br>
        <input type="text" id="name" name="name" value="{{ old('name', $akun->name) }}" required>
        <br><br>

        {{-- Hak Akses --}}
        <label>Hak Akses</label><br>
        <select name="usertype" required>
            <option value="admin" {{ $akun->usertype == 'admin' ? 'selected' : '' }}>Admin</option>
            <option value="ptk" {{ $akun->usertype == 'ptk' ? 'selected' : '' }}>PTK</option>
        </select>
        <br><br>

        <button type="submit">SIMPAN DATA</button>
        <br><br>
    </form>

    {{-- Form Update Email --}}
    <form action="{{ route('updateEmail', $akun->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <label>Email Address</label><br>
        <input type="email" id="email" name="email" value="{{ old('email', $akun->email) }}" required>
        <br><br>

        <button type="submit">SIMPAN EMAIL</button>
        <br><br>
    </form>

    {{-- Form Update Password --}}
    <form action="{{ route('updatePassword', $akun->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <label>Password</label><br>
        <input type="password" id="password" name="password" required>
        <br><br>

        <label for="password_confirmation">Confirm Password</label><br>
        <input type="password" id="password_confirmation" name="password_confirmation" required>
        <br><br>

        <button type="submit">SIMPAN PASSWORD</button>
        <br><br>
    </form>

</body>
</html>
