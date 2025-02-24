<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
</head>
<body>

    <!-- Navigasi -->
    <nav>
        <a href="{{ route('siswa.index') }}" class="nav-link">Data Siswa</a>
        <a href="{{ route('akun.index') }}" class="nav-link">Data Akun</a>
        <a href="{{ route('pelanggaran.index') }}" class="nav-link">Data Pelanggaran</a>
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

    @if (Session::has('success'))
        <p>{{ Session::get('success') }}</p>
    @else
        <p>You are logged in!</p>
    @endif

</body>
</html>
