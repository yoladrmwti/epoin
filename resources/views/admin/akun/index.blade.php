<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data User</title>
    <!-- Link ke CSS Bootstrap (jika diperlukan) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container my-4">
        <h1>Data User</h1>

        <!-- Menu Utama dan Logout -->
        <div class="mb-3">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Menu Utama</a>
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="btn btn-danger">Logout</a>
        </div>

        <!-- Logout Form -->
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>

        <br>

        <!-- Form Pencarian -->
        <form action="" method="get" class="mb-3">
            <div class="input-group">
                <input type="text" name="cari" id="cari" class="form-control" placeholder="Cari User" value="{{ request()->get('cari') }}">
                <button type="submit" class="btn btn-primary">Cari</button>
            </div>
        </form>

        <!-- Tambah User -->
        <a href="{{ route('akun.create') }}" class="btn btn-success mb-3">Tambah User</a>

        <!-- Pesan Sukses -->
        @if(Session::has('success'))
            <div class="alert alert-success" role="alert">
                {{ Session::get('success') }}
            </div>
        @endif

        <!-- Tabel Data User -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->usertype }}</td>
                    <td>
                        <a href="{{ route('akun.edit' , $user->id) }}" class="btn btn-sm btn-primary">EDIT</a>

                        <!-- Form Hapus User -->
                        <form onsubmit="return confirm('{{ $user->usertype == 'siswa' ? 'Jika Akun Siswa Dihapus Maka Data Siswa Akan Ikut Terhapus, Apakah Anda Yakin?' : 'Apakah Anda Yakin?' }}');" action="{{ route('akun.destroy', $user->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" aria-label="Hapus User">HAPUS</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center">
                        <p>Data tidak ditemukan</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="d-flex justify-content-center">
            {{ $users->links() }}
        </div>
    </div>

    <!-- Link ke JS Bootstrap (jika diperlukan) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
