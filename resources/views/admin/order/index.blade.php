@php
use App\Enums\OrderStatus;
use App\Enums\OrderType;
@endphp

@extends('layouts.main')

@section('sidebar')
    @include('partials.adminSidebar')
@endsection

@section('container')
<div class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="container my-5 mx-3">
        <h1 class="mb-4">Orders</h1>
        @php($found = false)
        @foreach ($orders as $order)
            @if (in_array($order->status, [OrderStatus::PENDING, OrderStatus::ON_GOING]))
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
                @if (in_array($order->status, [OrderStatus::PENDING, OrderStatus::ON_GOING]))
                    <div class="border border-5 border-warning mt-3 p-3 pt-4 col-md-7 col-lg-10 position-relative">
                        <h5 class="d-inline-block mb-2">Customer Name: {{ $order->user->name }}</h5>
                        <hr class="border border-warning border-2 opacity-100">
                        @foreach ($order->menus as $menu)
                            <span class="position-absolute top-0 start-50 translate-middle badge @if($order->status == OrderStatus::PENDING) bg-primary @else bg-success @endif px-5 py-2 fs-6">{{ ucwords($order->status) }}</span>
                        
                            <div class="d-flex justify-content-between mt-2 mb-2">
                                <div>
                                    <h5 class="d-inline-block">{{ $menu->name }}</h5>
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
                        <div class="d-flex justify-content-between mt-2">
                            <div>
                                <h5 class="mt-1">Type</h5>
                            </div>
                            <div class="alert alert-primary w-25 text-center">
                                <p>{{OrderType::getDescription($order->type)}}</h5>
                            </div>
                        </div>
                        @if ($order->status === OrderStatus::PENDING)
                            <div class="d-flex justify-content-end mt-3">
                                <form action="/admin/order-decline/{{ $order->id }}" method="post" class="d-inline me-2">
                                    @csrf
                                    @method('patch')
                                    <button type="submit" class="btn btn-danger px-2">Decline Order</button>
                                </form>
                                <form action="/admin/order-accept/{{ $order->id }}" method="post" class="d-inline">
                                    @csrf
                                    @method('patch')
                                    <button type="submit" class="btn btn-success px-2">Accept Order</button>
                                </form>
                            </div>
                        @else
                            <div class="d-flex justify-content-end mt-3">
                                <form action="/admin/order-done/{{ $order->id }}" method="post" class="d-inline">
                                    @csrf
                                    @method('patch')
                                    <button type="submit" class="btn btn-primary px-2">Mark as Completed</button>
                                </form>
                            </div>
                        @endif
                    </div>
                @endif
            @endforeach
        @endif
    </div>
</div>
@endsection