<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Data Siswa</title>
</head>
<body>
    <h1>Pilih Data Pelanggar</h1>
    <a href="{{ route('pelanggar.index') }}">Kembali</a><br><br>
    <br><br>
    <form id="logout-form" action="{{ route('logout') }}" method="POST">
        @csrf
    </form>
    <br><br>
    <form action="" method="get">
    <label for="cari">Cari :</label>
    <input type="text" name="cari" id="cari" placeholder="Masukkan nama">
    <input type="submit" value="Cari">
</form>
    <br><br> 

    <table class="tabel" border="1">
        <tr>
            <th>Foto</th>
            <th>Nis</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Kelas</th>
            <th>No Hp</th>
            <th>Aksi</th>
        </tr>

        @forelse ($siswas as $siswa)
        <tr>
            <td><img src="{{ asset('storage/siswas/'. $siswa->image) }}" width="120px" hight="120px" alt=""></td>
            <td>{{  $siswa->nis }}</td>
            <td>{{  $siswa->name }}</td>
            <td>{{  $siswa->email }}</td>
            <td>{{ $siswa->tingkatan }} {{ $siswa->jurusan }} {{ $siswa->kelas }}</td>
            <td>{{  $siswa->hp }}</td>
            <td>
               <form action="{{ route('pelanggar.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id_siswa" value="{{ $siswa->id }}">
                    <button type="submit">Tambah Pelanggaran</button>
               </form>
            </td>
        </tr>
        @empty
        <tr>
            <td>
                <p>data tidak ditemukan silahkan cek pada data pelanggar</p>
            </td>
            <td>
                <a href="{{ route('pelanggar.index') }}">Data Pelanggar</a>   |   <a href="{{ route('pelanggar.create') }}">Kembali</a>
            </td>
        </tr>
        @endforelse
        </table>
        {{ $siswas->links() }}
</body>
</html>