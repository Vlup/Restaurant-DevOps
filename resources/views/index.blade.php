@extends('layouts.main')

@section('sidebar')
    @if(auth()->user()->is_admin)
        @include('partials.adminSidebar')    
    @else
        @include('partials.sidebar')        
    @endif      
@endsection

@section('container')
    <div class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div class="container my-5 mx-3">
            <h1 class="mb-3">Menu Management</h1>
            
            @if (!auth()->user()->is_admin)
                @if (session()->has('success'))
                    <div class="alert alert-success col-md-10 mb-2 p-3" role="alert">{{ session('success') }}</div> 
                @endif
                <div class="row">
                @foreach ($menus as $menu)
                    @if ($menu->enable)
                        <div class="col-sm-3 mb-5 me-4 card border-3 border-warning" style="width: 18rem;">
                        {{-- @if ($menu->image) --}}
                            {{-- <img src="{{ asset('storage/'. $menu->image) }}" class="card-img-top border-bottom border-warning" alt="{{ $menu->name }}">  
                        @else --}}
                            <img src="/image/imgNotFound.png" class="card-img-top border-bottom border-warning" alt="{{ $menu->name }}">    
                        {{-- @endif --}}
                        <div class="card-body">
                          <h5 class="card-title text-center py-3">{{ $menu->name }}</h5>
                          <p class="card-text p-2">{{ $menu->description }}</p>
                        </div>
                        <ul class="list-group list-group-flush ">
                          <li class="list-group-item py-2 border-warning px-3">Harga: Rp. {{number_format($menu->price)}}</li>
                          <li class="list-group-item py-2 px-3">Status: <p class="d-inline-flex align-items-baseline">Tersedia<span class="d-block badge bg-success p-1 ms-2 position-absolute start-50" data-feather="check-circle"></span></p></li>
                        </ul>
                        <div class="card-body text-center py-2">
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-warning p-1" data-bs-toggle="modal" data-bs-target="#addToBasket-{{ $menu->id }}">
                                Tambah ke keranjang
                            </button>
                            <!-- Modal -->
                            <div class="modal fade modal-dialog-centered position-absolute start-0 top-100 w-100 h-25" id="addToBasket-{{ $menu->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addToBasketLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content py-1 px-2">
                                        <form action="/baskets" method="post">
                                            @csrf
                                            <input type="hidden" name="menu_id" value="{{ $menu->id }}" >
                                            <div class="modal-body py-2">
                                                <label for="qty">Jumlah:</label>
                                                <input type="number" id="qty-{{ $menu->id }}" name="qty" min="1" step="1" class="d-inline form-control w-25 p-1" value="1" onchange="addPrice(this, {{ $menu->price }})">
                                                <label class="d-block mt-2" for="price" id="priceLabel-qty-{{ $menu->id }}">Harga: Rp. {{ $menu->price }}</label>
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
                          <li class="list-group-item py-2 border-warning px-3">Harga: Rp. @convert($menu->price)</li>
                          <li class="list-group-item py-2 px-3">Status: <p class="d-inline-flex align-items-baseline">Tidak Tersedia<span class="d-block badge bg-danger p-1 position-absolute end-0 me-15" data-feather="x-circle"></span></p></li>
                        </ul>
                        <div class="card-body text-center py-2">
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-warning p-1" data-bs-toggle="modal" data-bs-target="#addToBasket-{{ $menu->id }}" disabled>
                                Tambah ke keranjang
                            </button>
                            <!-- Modal -->
                            <div class="modal fade modal-dialog-centered position-absolute start-0 top-100 w-100 h-25" id="addToBasket-{{ $menu->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addToBasketLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content py-1 px-2">
                                        <form action="" method="post">
                                            @csrf
                                            <div class="modal-body py-2">
                                                <label for="qty">Jumlah:</label>
                                                <input type="number" id="qty-{{ $menu->id }}" name="qty" min="1" step="1" class="d-inline form-control w-25 p-1" value="1" onchange="addPrice(this, {{ $menu->price }})">
                                                <label class="d-block mt-2" for="price" id="priceLabel-qty-{{ $menu->id }}">Harga: Rp. {{ $menu->price }}</label>
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
            @else
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

                <button type="button" class="btn btn-primary p-1 mb-3" onclick="createDiv()">Add New Menu</button>
                <fieldset class="border p-3 mb-3 col-lg-5 d-none" id="createDiv">
                    <form action="/admin/menus" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-2">
                            <label for="add_name" class="form-label">Nama</label>
                            <input type="text" class="form-control p-1" id="add_name" name="name" required>
                        </div>
                        <div class="mb-2">
                            <label for="tag" class="form-label">Tags</label>
                            <input type="text" class="form-control p-1" id="tag" name="tag" required>
                        </div>
                        <div class="mb-2">
                            <label for="description" class="form-label">Deskripsi</label>
                            <input type="text" class="form-control p-1" id="description" name="description" required>
                        </div>
                        <div class="mb-2">
                            <label for="type" class="form-label">Tipe</label>
                            <select class="form-select p-1" aria-label="Default select example" name="type" id='type' required>
                                <option value="" selected>Select type</option>
                                @foreach ($types as $type)
                                    <option value="{{ $type['id'] }}">{{ $type['value'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-2">
                            <label for="price" class="form-label">Harga</label>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text p-2">IDR</div>
                                </div>
                                <input type="number" class="form-control p-1" id="price" name="price" required min="3">
                            </div>
                        </div>
                        <div class="mb-2">
                            <label for="image" class="form-label">Image</label>
                            <img class="img-preview img-fluid mb-2 col-sm-5">
                            <input class="form-control p-1" type="file" id="image" name="image" onchange="previewImage()">
                        </div>
                        <div class="d-flex justify-content-end">
                            <button class="btn btn-danger py-1 px-2 mx-1" onclick="hideDiv()">Close</button>
                            <button type="submit" class="btn btn-primary py-1 px-2 mx-1">Add</button>
                        </div>
                    </form>
                </fieldset>
                <div class="table-responsive col-lg-10 text-center">
                    <table class="table table-striped table-sm">
                        <thead>
                        <tr>
                            <th scope="col">No.</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Tipe</th>
                            <th scope="col">Harga</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($menus as $menu)
                            <tr>
                            <td>{{ $loop->iteration }}.</td>
                            <td>{{ $menu->name }}</td>
                            <td>{{ $menu->type }}</td>
                            <td class="col-md-2">Rp. {{number_format($menu->price)}}</td>
                            <td class="col-md-2">
                                @if ($menu->enable)
                                    Tersedia
                                @else
                                    Tidak Tersedia
                                @endif
                            </td>
                            <td class="col-md-2">
                                <a href="/menus/{{ $menu->id }}/edit" class="badge bg-warning" ><span data-feather="edit" class="p-1"></span></a>
                                <form action="/menus/{{ $menu->id }}/is-available" method="post" class="d-inline">
                                    @method('patch')
                                    @csrf
                                    @if (!$menu->stock)
                                        <button class= "badge bg-success border-0" onclick="return confirm('Do you want to make this menu available?')"><span data-feather="check-circle" class="p-1"></span></button>
                                    @else
                                        <button class= "badge bg-danger border-0" onclick="return confirm('Do you want to make this menu unavailable?')"><span data-feather="x-circle" class="p-1"></span></button>
                                    @endif
                                </form>
                                <form action="/menus/{{ $menu->id }}" method="post" class="d-inline">
                                    @method('delete')
                                    @csrf
                                    <button class="badge bg-danger border-0" onclick="return confirm('Do you want to delete this menu?')"><span data-feather="trash-2" class="p-1"></span></button>
                                </form>
                            </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                </div>
                <div class="d-flex justify-content-center mb-5">
                    {{ $menus->links() }}
                </div>
            @endif
            
        </div>
    </div>

    <script>
        const name = document.querySelector('#add_name');

        function addPrice(e, p) {
            const priceLabel = document.querySelector(`#priceLabel-${e.id}`);
            const price = document.querySelector(`#price-${e.id}`);

            priceLabel.innerHTML = 'Harga: Rp. ' + p * e.value;
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