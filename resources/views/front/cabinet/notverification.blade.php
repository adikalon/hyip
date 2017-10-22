@extends('front.layouts.default')
@section('content')
<br>
Требуется верификация. Ваш email: {{ $email }}
<br>
<br>
Письмо с инструкцией будет отправлено на ва email
<form action="{{ route('forreverification') }}" method="post">
	{{ csrf_field() }}
	<input type="email" name="email" placeholder="Новый email" value="{{ $email }}">
	<button type="submit" name="reverification">Отправить</button>
</form>
<br>

@if ($errors->has('email'))
	{{ $errors->first('email') }}
@endif

@if (isset($success))
	{{ $success }}
@endif

@endsection