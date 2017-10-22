@extends('front.layouts.default')
@section('content')
Тарифы:
<table border="1">
@foreach($rates as $rate)
	<tr>
		<td>{{ $rate->name }}</td>
		<td>{{ $rate->min }}</td>
		<td>{{ $rate->max }}</td>
		<td>{{ $rate->percent }}</td>
		<td>{{ $rate->time }}</td>
		<td>{{ $rate->parts }}</td>
	</tr>
@endforeach
</table>
@endsection