@extends('front.layouts.default')

@section('content')
@include('front.cabinet.menu')
Кошельки
<form action="{{ route('post.settings') }}" method="post">
	{{ csrf_field() }}
	<input type="text" name="login" placeholder="Логин" value="{{ empty(old('login')) ? $set['login'] : old('login') }}">
	<input type="text" name="refback" placeholder="Рефбек" value="{{ empty(old('refback')) ? $set['refback'] : old('refback') }}">
	<input type="text" name="qiwi" placeholder="Qiwi" value="{{ empty(old('qiwi')) ? $wallet['qiwi'] : old('qiwi') }}">
	<input type="text" name="payeer" placeholder="Payeer" value="{{ empty(old('payeer')) ? $wallet['payeer'] : old('payeer') }}">
	<button type="submit" name="role" value="set">Сохранить</button>
</form>

@if ($errors->has('login'))
	{{ $errors->first('login') }}
@endif

@if ($errors->has('refback'))
	{{ $errors->first('refback') }}
@endif

@if ($errors->has('qiwi'))
	{{ $errors->first('qiwi') }}
@endif

@if ($errors->has('payeer'))
	{{ $errors->first('payeer') }}
@endif

<form action="{{ route('post.settings') }}" method="post">
	{{ csrf_field() }}
	<input type="email" name="email" placeholder="Email" value="{{ empty(old('email')) ? $set['email'] : old('email') }}">
	<button type="submit" name="role" value="email">Сохранить</button>
</form>

@if ($errors->has('email'))
	{{ $errors->first('email') }}
@endif

<form action="{{ route('post.settings') }}" method="post">
	{{ csrf_field() }}
	<input type="password" name="password" placeholder="Старый пароль" value="{{ old('password') }}">
	<input type="password" name="newpassword" placeholder="Новый пароль" value="{{ old('newpassword') }}">
	<input type="password" name="newpassword_confirmation" placeholder="Повторить пароль" value="{{ old('newpassword_confirmation') }}">
	<button type="submit" name="role" value="pass">Сохранить</button>
</form>

@if ($errors->has('password'))
	{{ $errors->first('password') }}
@endif

@if ($errors->has('newpassword'))
	{{ $errors->first('newpassword') }}
@endif

@if ($errors->has('newpassword_confirmation'))
	{{ $errors->first('newpassword_confirmation') }}
@endif

@if (isset($success))
	{{ $success }}
@endif

@endsection