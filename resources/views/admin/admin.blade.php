@extends('layouts.main')

@section('sidebar')
    @include('partials.adminSidebar')        
@endsection

@section('container')
    <div class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div class="container my-5 mx-3">
            <h1 class="mb-3">Admin Management</h1>

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

            <button type="button" class="btn btn-primary p-1 mb-3" onclick="createDiv()">Add New Account</button>
            <fieldset class="border p-3 mb-3 col-lg-5 d-none" id="createDiv">
                <form action="/admin/register" method="POST">
                    @csrf
                    <div class="form-floating">
                        <input type="text" name="name" class="form-control p-2 @error('name') is-invalid @enderror" id="name" placeholder="name@example.com" value="{{ old('name') }}" autofocus required>
                        <label class="p-1" for="name">Name</label>
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-floating">
                        <input type="email" name="email" class="form-control p-2 @error('email') is-invalid @enderror" id="email" placeholder="name@example.com" value="{{ old('email') }}" autofocus required>
                        <label class="p-1" for="email">Email address</label>
                        @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-floating">
                        <input type="password" name="password" class="form-control p-2" id="password" placeholder="Password" required>
                        <label class="p-1" for="password">Password</label>
                    </div>
                    <div class="form-floating">
                        <input type="password" name="password_confirmation" class="form-control p-2" id="password_confirmation" placeholder="Confirm Password" required>
                        <label class="p-1" for="password_confirmation">Confirm Password</label>
                    </div>
                    <div class="d-flex justify-content-end mt-2">
                        <button class="btn btn-danger py-1 px-2 mx-1" onclick="hideDiv()">Close</button>
                        <button class="btn btn-primary py-1 px-2 mx-1" type="submit">Register</button>
                    </div>
                </form>
                    
            </fieldset>
            <div class="table-responsive col-lg-10 text-center">
                <table class="table table-striped table-sm">
                    <thead>
                    <tr>
                        <th scope="col">No.</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Email</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($admins as $admin)
                        <tr>
                            <td>{{ $loop->iteration }}.</td>
                            <td>{{ $admin->name }}</td>
                            <td>{{ $admin->email }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            </div>
            <div class="d-flex justify-content-center mb-5">
                {{ $admins->links() }}
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