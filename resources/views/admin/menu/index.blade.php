@php
use App\Enums\MenuType;    
@endphp

@extends('layouts.main')

@section('sidebar')
    @include('partials.adminSidebar')        
@endsection

@section('container')
    <div class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div class="container my-5 mx-3">
            <h1 class="mb-3">Menu Management</h1>

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
                    <div class="form-check mb-2">
                        <input class="form-check-input me-1 mt-1" type="checkbox" value="true" id="enable" name="enable" checked>
                        <label class="form-check-label mb-1" for="enable">
                          Available
                        </label>
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
                        <td>{{ MenuType::getDescription($menu->type) }}</td>
                        <td class="col-md-2">Rp. {{number_format($menu->price)}}</td>
                        <td class="col-md-2">
                            @if ($menu->enable)
                                Tersedia
                            @else
                                Tidak Tersedia
                            @endif
                        </td>
                        <td class="col-md-2">
                            <a href="/admin/menus/{{ $menu->id }}/edit" class="badge bg-warning" ><span data-feather="edit" class="p-1"></span></a>
                            <form action="/admin/menus/{{ $menu->id }}/enable" method="post" class="d-inline">
                                @method('patch')
                                @csrf
                                @if (!$menu->enable)
                                    <button class= "badge bg-success border-0" onclick="return confirm('Do you want to make this menu available?')"><span data-feather="check-circle" class="p-1"></span></button>
                                @else
                                    <button class= "badge bg-danger border-0" onclick="return confirm('Do you want to make this menu unavailable?')"><span data-feather="x-circle" class="p-1"></span></button>
                                @endif
                            </form>
                            <form action="/admin/menus/{{ $menu->id }}" method="post" class="d-inline">
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