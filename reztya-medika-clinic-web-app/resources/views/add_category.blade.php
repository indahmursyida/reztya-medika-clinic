@extends('layout/main')

@section('title', 'Tambah Kategori')

@section('container')
<div class="container-product border outline-reztya rounded-4 font-futura-reztya py-5">
    <div class="py-3 text-center">
        <h2 class="pb-5 font-alander-reztya unselectable">Tambah Kategori</h2>
    </div>
    <form method="post" action="/store-category" class="row g-4 needs-validation">
        @method('post') @csrf
        <div class="col-md-4">
            <label class="form-label" for="category_name">Nama Kategori</label>
        </div>
        <div class="col-md-8">
            <input class="form-control @error('category_name') is-invalid @enderror" type="text" id="category_name" name="category_name" value="{{ old('category_name') }}">
            @error('category_name')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
        <div class="col-12 d-flex justify-content-center pb-5">
            <button class="btn button-color" type="submit"><i class="fa-solid fa-plus"></i> Tambah Kategori</button>
        </div>
    </form>
</div>
@endsection