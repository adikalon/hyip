@extends('front.layouts.default')

@section('content')
@include('front.cabinet.menu')

Баланс: {{ $digits->balance }}<br>
Пополнено с кошелька: {{ $digits->replenished }}<br>
Инвестировано: {{ $digits->invested }}<br>
Доход с инвестиций: {{ $digits->pay_by_inv }}<br>
Всего начислено: {{ $digits->payment }}<br>
Выведено на кошелек: {{ $digits->widthdraw }}<br>
Активно: {{ $digits->actively }}<br>
В ожидании на вывод: {{ $digits->pending }}<br>

<br>
@if(Session::has('verification'))
	{{ Session::get('verification') }}
@endif

@endsection