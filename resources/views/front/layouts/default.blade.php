<!DOCTYPE HTML>
<html lang="{{ app()->getLocale() }}">
	<head>
		<meta charset="UTF-8">
		<title>@yield('meta_title')</title>
	</head>
	<body>
		<a href="{{ route('index') }}">Главная</a>
		@if (Auth::guest())
			<form action="{{ route('auth') }}" method="POST">
				{{ csrf_field() }}
				<input type="text" name="login" value="{{ old('login') }}" placeholder="Логин">
				<input type="password" name="password" value="{{ old('password') }}" placeholder="Пароль">
				<input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
				<button type="submit">Войти</button>
			</form>
			
			<a href="{{ route('password.request') }}">Забыли пароль?</a>
			<a href="{{ route('register') }}">Регистрация</a>

			@if ($errors->has('login'))
				{{ $errors->first('login') }}
			@endif

			@if ($errors->has('password'))
				{{ $errors->first('password') }}
			@endif
		@else
			Вы вошли как {{ Auth::user()->login }}
			<form action="{{ route('logout') }}" method="POST">
				{{ csrf_field() }}
				<button type="submit">Выйти</button>
			</form>
		@endif

		@yield('content')
	</body>
</html>