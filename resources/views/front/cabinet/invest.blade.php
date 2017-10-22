@extends('front.layouts.default')

@section('content')
@include('front.cabinet.menu')
Инвестирование:

<form action="{{ route('post.invest') }}" method="post">
	{{ csrf_field() }}
	<input type="text" name="sum" placeholder="0.00" value="{{ old('sum') }}">
	<select name="rate">
	@foreach($rates as $rate)
		<option value="{{ $rate->ident }}"{{ old('rate') != $rate->ident ? '' : 'selected' }}>{{ $rate->name }}</option>
	@endforeach
	</select>
	<button type="submit">Инвестировать</button>
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
		<td>Старт</td>
		<td>Финиш</td>
		<td>Название тарифа (% за время)</td>
		<td>Инвестировал</td>
		<td>Получу</td>
		<td>Часть(время) из частей (деньги)</td>
		<td>Статус</td>
	</tr>
@foreach($invest as $inv)
	<tr>
		<td>{{ $inv['start'] }}</td>
		<td>{{ $inv['finish'] }}</td>
		<td>{{ $inv['name'] . ' (' . $inv["percent"] . ' за ' . $inv['time'] . ')' }}</td>
		<td>{{ $inv['invested'] }}</td>
		<td>{{ $inv['replenished'] }}</td>
		<td>{{ $inv['part'] . ' (' . $inv["latest"] . ') из ' . $inv["parts"] . ' (' .$inv["sum"] . ')' }}</td>
		<td>{{ $inv['status'] }}</td>
	</tr>
@endforeach
</table>

@endsection