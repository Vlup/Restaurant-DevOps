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
                    <div class="border border-5 border-warning mt-3 p-3 py-4 col-md-7 col-lg-10 position-relative" style="height: 200px;">
                        <h5 class="d-inline-block mb-2">Customer Name: {{ $order->user->name }}</h5>
                        <hr class="border border-warning border-2 opacity-100">
                        @foreach ($order->menus as $menu)
                            @if ($order->status == 'pending')
                                <button type="button" class="position-absolute top-0 start-50 translate-middle badge border-0 bg-primary px-5 py-2 fs-6" data-bs-toggle="modal" data-bs-target="#order-{{ $order->id }}">
                                    {{ ucwords($order->status) }}
                                </button>
                                
                                <!-- Modal -->
                                <div class="modal fade modal position-absolute top-0 start-50 fade modal-dialog modal-dialog-centered"  id="order-{{ $order->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" >
                                    <div class="modal-dialog">
                                        <div class="modal-content p-3">
                                        <div class="modal-header p-2">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Change Order Status</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body p-2 text-center">
                                            <form action="/order-accept/{{ $order->id }}" method="post" class="d-inline">
                                                @csrf
                                                @method('patch')
                                                <button type="submit" class="btn btn-success">Terima Pesanan</button>
                                            </form>
                                            <form action="/order-cancel/{{ $order->id }}" method="post" class="d-inline">
                                                @csrf
                                                @method('patch')
                                                <button type="submit" class="btn btn-danger">Batalkan Pesanan</button>
                                            </form>
                                        </div>
                                        <div class="modal-footer p-2">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <button type="button" class="position-absolute top-0 start-50 translate-middle badge border-0 bg-primary px-5 py-2 fs-6" data-bs-toggle="modal" data-bs-target="#order-{{ $order->id }}">
                                    {{ ucwords($order->status) }}
                                </button>
                                
                                <!-- Modal -->
                                <div class="modal fade modal position-absolute top-0 start-50 fade modal-dialog modal-dialog-centered"  id="order-{{ $order->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" >
                                    <div class="modal-dialog">
                                        <div class="modal-content p-3">
                                        <div class="modal-header p-2">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Change Order Status</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body p-2 text-center">
                                            <form action="/order-done/{{ $order->id }}" method="post" class="d-inline">
                                                @csrf
                                                @method('patch')
                                                <button type="submit" class="btn btn-success">Pesanan Selesai</button>
                                            </form>
                                        </div>
                                        <div class="modal-footer p-2">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        </div>
                                        </div>
                                    </div>
                                </div>   
                            @endif
                            

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
                    </div>
                @endif
            @endforeach
        @endif
    </div>
</div>
@endsection