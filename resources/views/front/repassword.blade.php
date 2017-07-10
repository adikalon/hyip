@extends('front.layouts.default')
@section('content')

<form action="{{ route('password.email') }}" method="post">
	{{ csrf_field() }}
	<input type="email" name="email" value="{{ old('email') }}" placeholder="E-mail">
	<button type="submit">Отправить</button>
</form>

@if (session('status'))
	{{ session('status') }}
@endif

@if ($errors->has('email'))
	{{ $errors->first('email') }}
@endif

@endsection