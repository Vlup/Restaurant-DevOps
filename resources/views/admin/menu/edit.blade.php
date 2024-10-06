@extends('layouts.main')

@section('sidebar')
    @include('partials.adminSidebar')    
@endsection

@section('container')
<div class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="container my-5 mx-3">
        <h1 class="mb-3">Edit Menu</h1>
        
        <form action="/menus/{{ $menu->id }}" method="post" enctype="multipart/form-data" class="me-4">
            @method('put')
            @csrf
            <div class="mb-2">
                <label for="add_name" class="form-label">Nama</label>
                <input type="text" class="form-control p-1" id="add_name" name="name" value="{{ old('name', $menu->name) }}" required>
            </div>
            <div class="mb-2">
                <label for="tag" class="form-label">Tags</label>
                <input type="text" class="form-control p-1" id="tag" name="tag" value="{{ old('tag', $menu->tag) }}" required>
            </div>
            <div class="mb-2">
                <label for="description" class="form-label">Deskripsi</label>
                <input type="text" class="form-control p-1" id="description" name="description" value="{{ old('description', $menu->description) }}"  required>
            </div>
            <div class="mb-2">
                <label for="type" class="form-label">Tipe</label>
                <select class="form-select p-1" aria-label="Default select example" name="type" id='type' required>
                    @foreach ($types as $type)
                        @if ($menu->type === $type)
                            <option value="{{ $type['id'] }}" selected>{{ $type['value'] }}</option>
                        @else
                            <option value="{{ $type['id'] }}">{{ $type['value'] }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="mb-2">
                <label for="price" class="form-label">Harga</label>
                <input type="number" class="form-control p-1" id="price" name="price" value="{{ old('price', $menu->price) }}"  required min="3">
            </div>
            <div class="form-check mb-2">
                <input class="form-check-input me-1 mt-1" type="checkbox" value="true" id="enable" name="enable" @if($menu->enable)checked @endif>
                <label class="form-check-label mb-1" for="enable">
                  Available
                </label>
            </div>
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