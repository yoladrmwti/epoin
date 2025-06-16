<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pelanggar</title>
</head>
<body>
    <h1>Data Pelanggar</h1>

    <a href="{{ route('admin.dashboard') }}">Menu Utama</a>
    <br>
    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <br><br>
    <form action="" method="get">
    <label for="cari">Cari :</label>
    <input type="text" name="cari" id="cari" placeholder="Masukkan nama">
    <input type="submit" value="Cari">
</form>


    <br>
    <a href="{{ route('pelanggar.create') }}">Tambah Pelanggar</a>

    @if(Session::has('success'))
        <div class="alert alert-success">
            {{ Session::get('success') }}
        </div>
    @endif

    <table class="tabel" border="1" cellspacing="0" cellpadding="8">
    <tr>
        <th>Foto</th>
        <th>NIS</th>
        <th>Nama</th>
        <th>Kelas</th>
        <th>No HP</th>
        <th>Point</th>
        <th>Status</th>
        <th>Aksi</th>
    </tr>

    @forelse ($pelanggars as $pelanggar)
    <tr>
        <td><img src="{{ asset('storage/siswas/' . $pelanggar->image) }}" width="120px" height="120px" alt=""></td>
        <td>{{ $pelanggar->nis }}</td>
        <td>{{ $pelanggar->name }}</td>
        <td>{{ $pelanggar->tingkatan }} {{ $pelanggar->jurusan }} {{ $pelanggar->kelas }}</td>
        <td>{{ $pelanggar->hp }}</td>
        <td>{{ $pelanggar->poin_pelanggar }}</td>
        <td>
            @if($pelanggar->status == 0)
                Tidak Perlu Ditindak
            @elseif($pelanggar->status == 1)
                <form onsubmit="return confirm('Apakah Anda Yakin {{ $pelanggar->name }} Sudah Ditindak?');" action="{{ route('pelanggar.statusTindak', $pelanggar->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <button type="submit">Perlu Ditindak</button>
                </form>
            @elseif($pelanggar->status == 2)
                Sudah Ditindak
            @endif
        </td>
        <td>
            <form onsubmit="return confirm('Apakah Anda Yakin ?');" action="{{ route('pelanggar.destroy', $pelanggar->id) }}" method="POST">
                <a href="{{ route('detailPelanggar.show', $pelanggar->id) }}" class="btn-sm btn-dark">DETAIL</a>
                @csrf
                @method('DELETE')
                <button type="submit">HAPUS</button>
            </form>
        </td>
    </tr>
    @empty
    <tr>
        <td colspan="8">Data tidak ditemukan <br><a href="{{ route('pelanggar.index') }}">Kembali</a></td>
    </tr>
    @endforelse
</table>


    {{ $pelanggars->links() }}
</body>
</html>
