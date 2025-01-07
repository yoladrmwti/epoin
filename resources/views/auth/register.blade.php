@extends('auth.layouts')

@section('content')
<h1>register</h1>
<a href="{{ route('login') }}">login</a>
    <br><br>
    <form action="{{ route('store') }}" method="POST">

    @csrf
    <label>Nama Lengkap</label><br>
    <input type="text"id="name" name="name" value="{{ old('name') }}"><br>
    
    @if ($errors->has('name'))
    <span class="text-danger">{{$errors->first('name') }}</span>
    @endif

    <br>
    <label>Email Adress</label><br>
    <input type="email" id="email" name="email" value="{{ old('email') }}"><br>

    @if ($errors->has('email'))
<span class="text-denger">{{ $errors->first('email') }}</span>
@endif

<br>
<label>password</label><br>
<input type="password" id="password"name="password"><br>

@if ($errors->has('password'))
<span class="text-denger">{{ $errors->first('password') }}</span>
@endif

<br>
<label for="password_confirmation" class="col-md-4 col-form-label text-md-end text-start">confirm password</label>
</div class="col-md-6">
<input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
</div>
<input type="submit" value="Register">
</form>
@endsection