@extends('front.layouts.default')

@section('content')
@include('front.cabinet.menu')
Получил со всех рефералов: {{ $digits->pay_by_refs }}<br>
Потратился на рефбек: {{ $digits->spent_on_refback }}<br>
Заработал с рефбека: {{ $digits->pay_by_refback }}<br>
Всего рефералов: {{ count($ref) }}<br>
Реферальный процентный уровень:<br>

<table border="1">
@foreach($ref as $r)
	<tr>
		<td>
			Логин: <a href="{{ route('referral', $r['ident']) }}">{{ $r['login'] }}</a>
		</td>
		<td>
			Пригласил: {{ $r['referer'] }}
		</td>
		<td>
			Дата регистрации: {{ $r['date'] }}
		</td>
		<td>
			Уровень: {{ $r['level'] }}
		</td>
		<td>
			Процент: {{ $r['percent'] }}
		</td>
		<td>
			Рефбэк: {{ $r['refback'] }}
		</td>
	</tr>
@endforeach
</table>

@endsection