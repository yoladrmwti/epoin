<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Siswa</title>
</head>
<body>
    <h1>Data Siswa</h1>

    {{-- Navigasi --}}
    <a href="{{ route('admin.dashboard') }}">Menu Utama</a>
    <br>
    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
    
    <form action="{{ route('logout') }}" id="logout-form" method="POST" style="display: none;">
        @csrf
    </form>

    <br>

    {{-- Form Pencarian --}}
    <form action="{{ route('siswa.index') }}" method="GET">
        <label>Cari:</label>
        <input type="text" name="cari" placeholder="Masukkan kata kunci..." value="{{ request('cari') }}">
        <input type="submit" value="Cari">
    </form>

    <br>
    <a href="{{ route('siswa.create') }}">Tambah Siswa</a>

    {{-- Notifikasi Sukses --}}
    @if(Session::has('success'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('success') }}
        </div>
    @endif

    {{-- Tabel Data Siswa --}}
    <table border="1" cellspacing="0" cellpadding="10">
        <thead>
            <tr>
                <th>Foto</th>
                <th>NIS</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Kelas</th>
                <th>No Hp</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($siswas as $siswa)
                <tr>
                    <td>
                        <img src="{{ asset('storage/siswas/' . $siswa->image) }}" width="120px" height="120px" alt="Foto Siswa">
                    </td>
                    <td>{{ $siswa->nis }}</td>
                    <td>{{ $siswa->name }}</td>
                    <td>{{ $siswa->email }}</td>
                    <td>{{ $siswa->tingkatan }} {{ $siswa->jurusan }} {{ $siswa->kelas }}</td>
                    <td>{{ $siswa->hp }}</td>
                    <td>{{ $siswa->status == 1 ? 'Aktif' : 'Tidak Aktif' }}</td>
                    <td>
                        <a href="{{ route('siswa.show', $siswa->id) }}" class="btn btn-sm btn-dark">Lihat</a>
                        <a href="{{ route('siswa.edit', $siswa->id) }}" class="btn btn-sm btn-primary">Edit</a>
                        <form action="{{ route('siswa.destroy', $siswa->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Anda Yakin ingin menghapus?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align: center;">Data Tidak Ditemukan</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <br>
    
    {{-- Pagination --}}
    {{ $siswas->links() }}
    
</body>
</html>
