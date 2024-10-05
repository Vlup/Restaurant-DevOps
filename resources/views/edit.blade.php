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
        <h1 class="mb-3">Edit Menu</h1>
        
        <form action="/menus/{{ $menu->slug }}" method="post" enctype="multipart/form-data" class="me-4">
            @method('put')
            @csrf
            <div class="mb-2">
                <label for="add_name" class="form-label">Nama</label>
                <input type="text" class="form-control p-1" id="add_name" name="name" value="{{ old('name', $menu->name) }}" required>
            </div>
            <input type="hidden" id="add_slug" name="slug" value="{{ old('name', $menu->name) }}" required> 
            <div class="mb-2">
                <label for="description" class="form-label">Deskripsi</label>
                <input type="text" class="form-control p-1" id="description" name="description" value="{{ old('description', $menu->description) }}"  required>
            </div>
            <div class="mb-2">
                <label for="price" class="form-label">Harga</label>
                <input type="number" class="form-control p-1" id="price" name="price" value="{{ old('price', $menu->price) }}"  required min="3">
            </div>
            <input type="hidden" name="stock" value="{{ $menu->stock }}">
            <div class="mb-2">
                <label for="image" class="form-label">Image</label>
                @if ($menu->image)
                    <input type="hidden" value="{{ $menu->image }}" name="oldImage">
                    <img src="{{ asset('storage/' . $menu->image) }}" class="img-preview img-fluid mb-2 col-sm-5">
                @else
                    <img class="img-preview img-fluid mb-2 col-sm-5">
                @endif
                <input class="form-control p-1" type="file" id="image" name="image" onchange="previewImage()">
            </div>
            <button type="submit" class="btn btn-primary p-1 px-3 mt-3">Edit</button>
        </form>
    </div>
</div>

<script>
    const name = document.querySelector('#add_name');
    const slug = document.querySelector('#add_slug');
    
    name.addEventListener('change', () => {
        fetch('/menus/checkSlug?name=' + name.value)
        .then(response => response.json())
        .then(data => slug.value = data.slug)
    })

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
</script>


@endsection