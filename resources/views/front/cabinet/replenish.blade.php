@extends('front.layouts.default')

@section('content')
@include('front.cabinet.menu')
Пополнение:
<form action="{{ route('post.replenish') }}" method="post">
	{{ csrf_field() }}
	<input type="text" name="transaction" placeholder="№ Транзакции" value="{{ old('transaction') }}">
	<select name="wallet">
	@foreach($wallets as $wallet)
		<option value="{{ $wallet->name.'::n::'.$wallet->number }}">{{ $wallet->name.' [ '.$wallet->number.' ]' }}</option>
	@endforeach
	</select>
	<button type="submit">Пополнить</button>
</form>

@if(isset($success))
	{{ $success }}
@endif

@if ($errors->has('transaction'))
	{{ $errors->first('transaction') }}
@endif

Последнии операции
<table border="1">
@foreach($replenish as $rep)
	<tr>
		<td>{{ $rep['name'] }}</td>
		<td>{{ $rep['sum'] }}</td>
		<td>{{ $rep['transaction'] }}</td>
		<td>{{ $rep['date'] }}</td>
		<td>{{ $rep['status'] }}</td>
		<td>{{ $rep['accepted'] }}</td>
	</tr>
@endforeach
</table>

@endsection