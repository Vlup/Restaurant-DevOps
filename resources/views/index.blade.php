@extends('layouts.main')

@section('sidebar')
    @include('partials.sidebar')        
@endsection

@section('container')
    <div class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div class="container my-5 mx-3">
            <h1 class="mb-3">List Menu</h1>
            @if (session()->has('success'))
                <div class="alert alert-success col-md-10 mb-2 p-3" role="alert">{{ session('success') }}</div> 
            @endif
            <div class="row">
            @foreach ($menus as $menu)
                @if ($menu->enable)
                    <div class="col-sm-3 mb-5 me-4 card border-3 border-warning" style="width: 18rem;">
                    @if ($menu->image_url)
                        <img src="{{ $menu->image_url }}" class="card-img-top border-bottom border-warning" alt="{{ $menu->name }}">  
                    @else
                        <img src="/image/imgNotFound.png" class="card-img-top border-bottom border-warning" alt="{{ $menu->name }}">    
                    @endif
                    <div class="card-body">
                        <h5 class="card-title text-center py-2">{{ $menu->name }}</h5>
                        <p class="card-text px-3 mb-2">{{ $menu->description }}</p>
                    </div>
                    <ul class="list-group list-group-flush ">
                        <li class="list-group-item py-2 border-warning px-3">Price: Rp. {{number_format($menu->price)}}</li>
                        <li class="list-group-item py-2 px-3">Status: <p class="d-inline-flex align-items-baseline">Available<span class="d-block badge bg-success p-1 ms-2 position-absolute end-0 me-2" data-feather="check-circle"></span></p></li>
                    </ul>
                    <div class="card-body text-center py-2">
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-warning p-1" data-bs-toggle="modal" data-bs-target="#addToBasket-{{ $menu->id }}">
                            Add To Cart
                        </button>
                        <!-- Modal -->
                        <div class="modal fade modal-dialog-centered position-absolute start-0 top-100 w-100 h-25" id="addToBasket-{{ $menu->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addToBasketLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content py-1 px-2">
                                    <form action="/baskets" method="post">
                                        @csrf
                                        <input type="hidden" name="menu_id" value="{{ $menu->id }}" >
                                        <div class="modal-body py-2">
                                            <label for="qty">Total:</label>
                                            <input type="number" id="qty-{{ $menu->id }}" name="qty" min="1" step="1" class="d-inline form-control w-25 p-1" value="1" onchange="addPrice(this, {{ $menu->price }})">
                                            <label class="d-block mt-2" for="price" id="priceLabel-qty-{{ $menu->id }}">Price: Rp. {{ number_format($menu->price) }}</label>
                                            <input type="hidden" id="price-qty-{{ $menu->id }}" name="price">
                                        </div>
                                        <div class="modal-footer py-1">
                                            <button type="button" class="btn btn-secondary p-1" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary ms-2 p-1">Add</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                @else
                    <div class="col-sm-3 mb-5 me-4 card border-3 border-warning opacity-75" style="width: 18rem;">
                    @if ($menu->image)
                        <img src="{{ asset('storage/'. $menu->image) }}" class="card-img-top border-bottom border-warning" alt="{{ $menu->name }}">  
                    @else
                        <img src="/image/imgNotFound.png" class="card-img-top border-bottom border-warning" alt="{{ $menu->name }}">    
                    @endif
                    <div class="card-body h-215">
                        <h5 class="card-title text-center py-3">{{ $menu->name }}</h5>
                        <p class="card-text p-2">{{ $menu->description }}</p>
                    </div>
                    <ul class="list-group list-group-flush ">
                        <li class="list-group-item py-2 border-warning px-3">Price: Rp. {{ number_format($menu->price) }}</li>
                        <li class="list-group-item py-2 px-3">Status: <p class="d-inline-flex align-items-baseline">Unavailable<span class="d-block badge bg-danger p-1 position-absolute end-0 me-2" data-feather="x-circle"></span></p></li>
                    </ul>
                    <div class="card-body text-center py-2">
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-warning p-1" data-bs-toggle="modal" data-bs-target="#addToBasket-{{ $menu->id }}" disabled>
                            Add To Cart
                        </button>
                        <!-- Modal -->
                        <div class="modal fade modal-dialog-centered position-absolute start-0 top-100 w-100 h-25" id="addToBasket-{{ $menu->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addToBasketLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content py-1 px-2">
                                    <form action="" method="post">
                                        @csrf
                                        <div class="modal-body py-2">
                                            <label for="qty">Total:</label>
                                            <input type="number" id="qty-{{ $menu->id }}" name="qty" min="1" step="1" class="d-inline form-control w-25 p-1" value="1" onchange="addPrice(this, {{ $menu->price }})">
                                            <label class="d-block mt-2" for="price" id="priceLabel-qty-{{ $menu->id }}">Price: Rp. {{ $menu->price }}</label>
                                            <input type="hidden" id="price-qty-{{ $menu->id }}" name="price">
                                        </div>
                                        <div class="modal-footer py-1">
                                            <button type="button" class="btn btn-secondary p-1" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary ms-2 p-1" disabled>Add</button>
                                            </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                @endif
            @endforeach
            </div>
            <div class="d-flex justify-content-center">
                {{ $menus->links() }}
            </div>
        </div>
    </div>

    <script>
        const name = document.querySelector('#add_name');

        function numberFormat(number) {
            const roundedNumber = Math.round(number).toString();
            const formattedNumber = roundedNumber.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            return formattedNumber;
        }

        function addPrice(e, p) {
            const priceLabel = document.querySelector(`#priceLabel-${e.id}`);
            const price = document.querySelector(`#price-${e.id}`);

            priceLabel.innerHTML = 'Harga: Rp. ' + numberFormat(p * e.value);
            price.value = p * e.value;
        }

        function previewImage() {
            const image = document.querySelector('#image');
            const imgPreview = document.querySelector('.img-preview');

            imgPreview.style.display = 'block';
            const oFReader = new FileReader();
            oFReader.readAsDataURL(image.files[0]);

            oFReader.onload = function(oFREvent) {
                imgPreview.src = oFREvent.target.result;
            }
        }

        function createDiv() {
            const div = document.querySelector('#createDiv').classList;
            div.add('display-block');
        }
        
        function hideDiv() {
            const div = document.querySelector('#createDiv').classList;
            div.remove('display-block');
        }

        document.getElementById('type').addEventListener('change', function() {
            const selectElement = this;
            if (selectElement.value) {
                // Remove the "Select type" option if a valid selection is made
                selectElement.options[0].style.display = 'none';
            } else {
                // Optionally, you can show it again if the selection is reset
                selectElement.options[0].style.display = 'block';
            }
        });

    </script>

@endsection