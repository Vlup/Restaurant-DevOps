@php
use App\Enums\OrderType;
@endphp

@extends('layouts.main')

@section('sidebar')
    @include('partials.sidebar')
@endsection

@section('container')
@php($total = 0)
<div class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="container my-5 mx-3">
        @if (session()->has('success'))
            <div class="alert alert-success col-md-10 mb-2 p-3" role="alert">{{ session('success') }}</div> 
        @endif
            
        @if($errors->any())
            <div class="alert alert-danger col-md-10 mb-2 p-3" role="alert">
                <h6>Action Failed!</h6>
                <ul class="mt-1 mb-0 px-5">
                    @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div> 
        @endif
        <h1 class="mb-3">My Basket</h1>
        
        @if(!$hasMenu)
            <div class="alert alert-danger col-md-3 p-3" role="alert">
                <h5>There is no item yet</h5>
            </div>
        @else
            <form action="/baskets" method="post">
                @csrf
                @method('delete')
                <button type="submit" class="btn btn-danger px-4 py-2 mb-3" onclick="return confirm('Do you want to clear your basket?')">Clear All</button>
            </form>
            @foreach ($baskets->menus as $menu)
                <div class="card mb-3 border-5 border-warning" style="max-width: 700px;">
                    <div class="row g-0">
                        <div class="col-md-4 me-3 border-end border-5 border-warning">
                            @if ($menu->image)
                                <img src="{{ asset('storage/'. $menu->image) }}" class="img-fluid rounded-start " alt="{{ $menu->name }}">  
                            @else
                                <img src="/image/imgNotFound.png" class="img-fluid rounded-start " alt="{{ $menu->name }}">    
                            @endif
                        </div>
                        <div class="col-md-7">
                            <div class="card-body py-2 px-3">
                                <h5 class="card-title mb-3">{{ $menu->name }}</h5>
                                <form action="/basket/{{ $menu->id }}" class="mb-2" method="post">
                                    @csrf
                                    <div class="row g-3 align-items-center">
                                        <div class="col-auto">
                                            <label for="qty" class="col-form-label">Total:</label>
                                        </div>
                                        <div class="col-3 ms-2">
                                            <input type="number" id="qty" name="qty" class="form-control px-2 py-1 border-1" min="1" required value="{{ $menu->basket->qty }}">
                                        </div>
                                        <div class="col-3 ms-2">
                                            <button type="submit" class="btn btn-primary px-1">Update</button>
                                        </div>
                                    </div>
                                </form>
                                <p>Price: Rp. {{ number_format($menu->price * $menu->basket->qty) }}</p>
                                
                                <form action="/basket/{{ $menu->id }}" class="position-absolute top-0 end-0" method="post">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-danger" style="border-top-right-radius: 0; border-bottom-right-radius: 0; border-top-left-radius: 0;" onclick="return confirm('Do you want to clear your basket?')"><span data-feather="trash-2" class="p-1"></span></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>         
            @endforeach
            <hr class="border border-danger border-2 opacity-100">
            <form action="/order" method="POST" class="d-flex flex-column-reverse">
                @csrf

                <div class="border border-2 mt-3 p-3 col-md-7 col-lg-10">
                    <div class="alert alert-primary p-1 mb-2">
                        <h4>Choose Your Order Type</h4>
                        <div class="form-check mb-1">
                            <input class="form-check-input me-2 mt-1" type="radio" name="type" id="dine-in" value="{{OrderType::DINE_IN}}">
                            <label class="form-check-label" for="dine-in">
                                <h5 class="text-black">Dine In</h5>
                            </label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input me-2 mt-1" type="radio" name="type" id="take-away" value="{{OrderType::TAKE_AWAY}}">
                            <label class="form-check-label" for="take-away">
                                <h5 class="text-black">Take Away</h5>
                            </label>
                        </div>
                    </div> 
                    
                    @foreach ($baskets->menus as $menu)
                        <div class="d-flex justify-content-between mb-2">
                            <div>
                                <h5>{{ $menu->name }}</h5>
                            </div>
                            <div>
                                <h5>Rp. {{ number_format($menu->price * $menu->basket->qty) }}</h5>
                                @php($total = $total + ($menu->price * $menu->basket->qty))
                            </div>
                        </div>
                    @endforeach
                    <hr class="border border-warning border-2 opacity-100">
                    <div class="d-flex justify-content-between mt-2">
                        <div>
                            <h5 class="mb-1">Total</h5>
                        </div>
                        <div>
                            <h5>Rp. {{ number_format($total) }}</h5>
                        </div>
                    </div>

                    @foreach ($baskets->menus as $menu)
                        <input type="hidden" name="menus[]" value="{{ $menu->id }}">
                        <input type="hidden" name="qty[]" value="{{ $menu->basket->qty }}">
                    @endforeach
                    <input type="hidden" name="total" value="{{ $total }}">
                    
                    <button type="submit" class="btn btn-primary px-2 py-1 mt-2 fs-5 w-100" onclick="return confirm('Are you sure you want to order? You won\'t be able to cancel after you order')">Order</button>
                </form>
            </div>
        @endif
    </div>
</div>
@endsection