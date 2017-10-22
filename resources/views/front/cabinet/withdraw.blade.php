@extends('front.layouts.default')

@section('content')
@include('front.cabinet.menu')
Выплаты:

<form action="{{ route('post.withdraw') }}" method="post">
	{{ csrf_field() }}
	<input type="text" name="sum" placeholder="0.00" value="{{ old('sum') }}">
	<select name="wallet">
	@foreach($wallets as $k => $v)
		<option value="{{ $k.'::n::'.$v }}">{{ $k.' [ '.$v.' ]' }}</option>
	@endforeach
	</select>
	<button type="submit">Вывести</button>
</form>

@if(isset($success))
	{{ $success }}
@endif

@if ($errors->has('sum'))
	{{ $errors->first('sum') }}
@endif

Последнии операции
<table border="1">
	<tr>
		<td>Дата</td>
		<td>Дата принятия</td>
		<td>Сумма</td>
		<td>Кошелек</td>
		<td>Номер</td>
		<td>Сообщение</td>
		<td>Статус</td>
	</tr>
@foreach($withdraws as $wit)
	<tr>
		<td>{{ $wit['date'] }}</td>
		<td>{{ $wit['accepted'] }}</td>
		<td>{{ $wit['sum'] }}</td>
		<td>{{ $wit['wallet'] }}</td>
		<td>{{ $wit['number'] }}</td>
		<td>{{ $wit['message'] }}</td>
		<td>{{ $wit['status'] }}</td>
	</tr>
@endforeach
</table>

@endsection