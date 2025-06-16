<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }

        nav {
            margin-bottom: 20px;
        }

        .nav-link {
            margin-right: 15px;
            text-decoration: none;
            color: #007bff;
        }

        .nav-link:hover {
            text-decoration: underline;
        }

        h1 {
            margin-bottom: 20px;
        }

        p {
            font-size: 16px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
        }

        img {
            border-radius: 8px;
        }
    </style>
</head>
<body>

    <!-- Navigasi -->
    <nav>
        <a href="{{ route('siswa.index') }}" class="nav-link">Data Siswa</a>
        <a href="{{ route('akun.index') }}" class="nav-link">Data Akun</a>
        <a href="{{ route('pelanggaran.index') }}" class="nav-link">Data Pelanggaran</a>
        <a href="{{ route('pelanggar.index') }}" class="nav-link">Data Pelanggar</a>
        <a href="{{ route('logout') }}"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            Logout
        </a>
    </nav>

    <!-- Form Logout -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <!-- Konten Dashboard -->
    <h1>Dashboard Admin</h1>

    @if ($message = Session::get('success'))
        <p>{{ $message }}</p>
    @else
        <p>You are logged in!</p>
    @endif

    <h3>Jumlah siswa: {{ $jmlSiswas }}</h3>
    <h3>Jumlah pelanggar: {{ $jmlPelanggars }}</h3>

    <h2>Top 10 Siswa dengan Poin Pelanggaran Tertinggi</h2>
    <table>
        <tr>
            <th>Foto</th>
            <th>NIS</th>
            <th>Nama</th>
            <th>Kelas</th>
            <th>No HP</th>
            <th>Poin</th>
            <th>Aksi</th>
        </tr>
        @forelse ($pelanggars as $pelanggar)
        <tr>
            <td>
                <img src="{{ asset('storage/siswas/' . $pelanggar->image) }}" width="100" height="100" alt="foto">
            </td>
            <td>{{ $pelanggar->nis }}</td>
            <td>{{ $pelanggar->name }}</td>
            <td>{{ $pelanggar->tingkatan }} {{ $pelanggar->jurusan }} {{ $pelanggar->kelas }}</td>
            <td>{{ $pelanggar->hp }}</td>
            <td>{{ $pelanggar->poin_pelanggar }}</td>
            <td>
                <a href="{{ route('pelanggar.show', $pelanggar->id) }}">Detail</a>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="7">Data tidak ditemukan.</td>
        </tr>
        @endforelse
    </table>

    <h2>Top 10 Pelanggaran yang Sering Terjadi</h2>
    <table>
        <tr>
            <th>Jenis Pelanggaran</th>
            <th>Konsekuensi</th>
            <th>Poin</th>
            <th>Total Terjadi</th>
        </tr>
        @forelse ($hitung as $hit)
        <tr>
            <td>{{ $hit->jenis }}</td>
            <td>{{ $hit->konsekuensi }}</td>
            <td>{{ $hit->poin }}</td>
            <td>{{ $hit->totals }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="4">Data tidak ditemukan.</td>
        </tr>
        @endforelse
    </table>

</body>
</html>
