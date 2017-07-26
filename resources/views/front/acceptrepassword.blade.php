@extends('front.layouts.default')
@section('content')

<form action="{{ route('acceptrepassword') }}" method="post">
	{{ csrf_field() }}
	<input type="hidden" name="token" value="{{ $token }}">
	<input type="email" name="email" value="{{ $email or old('email') }}"  placeholder="Email" required autofocus>
	<input type="password" name="password" placeholder="Новый пароль" value="{{ old('password') }}" required>
	<input type="password" name="password_confirmation" placeholder="Еще раз" value="{{ old('password_confirmation') }}" required>
	<button type="submit">Изменить</button>
</form>

@if (session('status'))
	{{ session('status') }}
@endif

@if ($errors->has('email'))
	{{ $errors->first('email') }}
@endif

@if ($errors->has('password'))
	{{ $errors->first('password') }}
@endif

@if ($errors->has('password_confirmation'))
	{{ $errors->first('password_confirmation') }}
@endif

@endsection