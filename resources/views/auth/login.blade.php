@extends('auth.layouts')

@section('content')

<style>
    body {
        background-color: #d3e3ef;
        font-family: Georgia, serif;
    }

    .login-container {
        background-color: #b2cde0;
        padding: 40px;
        border-radius: 10px;
        width: 360px;
        margin: 80px auto;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        text-align: center;
    }

    .logo {
        width: 80px;
        margin-bottom: 20px;
    }

    h1 {
        color: #333;
        margin-bottom: 30px;
    }

    input[type="text"],
    input[type="password"],
    input[type="email"] {
        width: 100%;
        padding: 10px;
        margin: 10px 0;
        background-color: #7ba6c7;
        border: none;
        color: white;
        font-style: italic;
        font-size: 16px;
        border-radius: 4px;
    }

    input[type="submit"] {
        background-color: #6a98b6;
        color: white;
        padding: 10px;
        width: 100%;
        border: none;
        font-size: 16px;
        cursor: pointer;
        margin-top: 10px;
    }

    input[type="submit"]:hover {
        background-color: #557b9c;
    }

    .credit {
        margin-top: 20px;
        font-size: 12px;
        color: #888;
        font-style: italic;
    }
</style>

<div class="login-container">
    <!-- Tambahkan logo sekolah -->
    <img src="{{ asset('storage/siswas/logo.png') }}" class="logo" alt="Logo Sekolah">
    
    <h1>LOGIN E-POINT SISWA</h1>

    <form action="{{ route('authenticate') }}" method="post">
        @csrf
        <input type="text" id="email" name="email" placeholder="Username" value="{{ old('email') }}" required><br>
        <input type="password" id="password" name="password" placeholder="Password" required><br>
        <input type="submit" value="LOGIN">
    </form>

    <p class="credit">@laaa</p>
</div>

@endsection
