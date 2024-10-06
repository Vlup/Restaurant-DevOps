@extends('layouts.main')

@section('sidebar')
    @include('partials.sidebar')
@endsection

@section('container')
<div class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="container my-5 mx-3">
        <h1 class="mb-3">Your Order</h1>
        @php($found = false)
        @foreach ($orders as $order)
            @if ($order->status == 'pending' || $order->status == 'on going')
                @php($found = true)
                @break
            @endif 
        @endforeach
        @if (!$found)
            <div class="alert alert-danger col-md-3 p-3" role="alert">
                <h5>There is no order yet</h5>
            </div>
        @else
            @foreach ($orders as $order)
                @if ($order->status == 'pending' || $order->status == 'on going')      
                    <div class="border border-5 border-warning mt-3 p-3 py-4 col-md-7 col-lg-10 position-relative">
                        @foreach ($order->menus as $menu)
                            <span class="position-absolute top-0 start-50 translate-middle badge @if($order->status == 'pending') bg-primary @else bg-success @endif px-5 py-2 fs-6">{{ ucwords($order->status) }}</span>
                            <div class="d-flex justify-content-between mb-2">
                                <div>
                                    <h5 class="d-inline">{{ $menu->name }}</h5>
                                    <h5 class="d-inline-block px-2">( Qty: {{ $menu->detail->qty }} )</h5>
                                </div>
                                <div>
                                    <h5>Rp. {{ number_format($menu->price * $menu->detail->qty) }}</h5>
                                </div>
                            </div>
                        @endforeach
                        <hr class="border border-warning border-2 opacity-100">
                        <div class="d-flex justify-content-between mt-2">
                            <div>
                                <h5 class="mb-1">Total</h5>
                            </div>
                            <div>
                                <h5>Rp. {{ number_format($order->total) }}</h5>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        @endif
    </div>
</div>
@endsection