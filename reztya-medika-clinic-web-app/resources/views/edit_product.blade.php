@extends('layout/main')

@section('title', 'Edit Produk')

@section('container')

<div class="container-product border outline-reztya rounded-4 font-futura-reztya py-5">
    <div class="py-3 text-center">
        <h2 class="py-3 font-alander-reztya">Edit Produk</h2>
    </div>
    <input type="hidden" name="old_image" value="{{ $product->image_path }}">
    @if($product->image_path)
    <div class="d-flex justify-content-center my-4">
        <img src="{{ asset('storage/' . $product->image_path) }}" width="300" height="300" class="img-preview img-fluid border border-3 rounded">
    </div>
    @else
    <div class="d-flex justify-content-center my-4">
        <img class="img-preview img-fluid border border-3 rounded" width="300" height="300">
    </div>
    @endif

    <form method="post" action="/update-product/{{ $product->product_id }}" enctype="multipart/form-data" class="row g-4 my-5">
        @method('put')@csrf
        <div class="col-md-4">
            <label class="form-label" for="image">Foto Produk</label>
        </div>
        <div class="col-md-8">
            <input class="form-control @error('image_path') is-invalid @enderror" type="file" id="image_path" name="image_path" onchange="previewImage()">
            @error('image_path')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>

        <div class="col-md-4">
            <label class="form-label" for="name">Nama Produk</label>
        </div>
        <div class="col-md-8">
            <input class="form-control @error('name') is-invalid @enderror" type="text" id="name" name="name" value="{{ old('name', $product->name) }}">
            @error('name')
            <div class="invalid-feedback">
                Nama Produk harus diisi
            </div>
            @enderror
        </div>

        <div class="col-md-4">
            <label class="form-label" for="category_id">Kategori Produk</label>
        </div>
        <div class="col-md-8">
            <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id">
                @foreach($categories as $category) @if(old('category_id', $product->category_id) == $category->category_id)
                <option value="{{ $category->category_id }}" selected>{{ $category->category_name }}</option>
                @else
                <option value="{{ $category->category_id }}">{{ $category->category_name }}</option>
                @endif @endforeach
            </select>
            @error('category_id')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>

        <div class="col-md-4">
            <label class="form-label" for="description">Deskripsi Produk</label>
        </div>
        <div class="col-md-8">
            <textarea class="form-control @error('description') is-invalid @enderror" placeholder="Description" id="description" name="description" style="height: 100px" value="{{ old('description', $product->description) }}">{{ old('description', $product->description) }}</textarea>
            @error('description')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>

        <div class="col-md-4">
            <label class="form-label" for="expired_date">Tanggal Kadaluarsa Produk</label>
        </div>
        <div class="col-md-8">
            <input type="date" class="form-control @error('expired_date') is-invalid @enderror" id="expired_date" name="expired_date" value="{{ old('expired_date', $product->expired_date) }}">
            @error('expired_date')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>

        <div class="col-md-4">
            <label class="form-label" for="price">Harga Produk</label>
        </div>
        <div class="col-md-8">
            <input type="text" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price', $product->price) }}">
            @error('price')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>

        <div class="col-md-4">
            <label class="form-label" for="stock">Stok Produk</label>
        </div>
        <div class="col-md-8">
            <input type="number" class="form-control @error('stock') is-invalid @enderror" id="stock" name="stock" value="{{ old('stock', $product->stock) }}">
            @error('stock')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
        <div class="col-12 d-flex justify-content-center pb-5">
            <button class="btn button-color" type="submit">Update Produk</button>
        </div>
    </form>
</div>

<script>
    function previewImage() {
        const image = document.querySelector('#image_path');
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