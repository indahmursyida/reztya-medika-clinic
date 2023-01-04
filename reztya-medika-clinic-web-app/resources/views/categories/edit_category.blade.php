@extends('layout/main')

@section('title', 'Edit Kategori')

@section('container')
<div class="container-product border outline-reztya rounded-4 font-futura-reztya py-5">
    <div class="pt-4">
        <div class="py-3 d-flex justify-content-center">
            <p class="h5 fw-bold unselectable font-alander-reztya">Edit Kategori</p>
        </div>
    </div>
    <form method="post" action="/update-category/{{ $category->category_id }}" class="row g-4 needs-validation">
        @method('put') @csrf
        <div class="col-md-4">
            <label class="form-label" for="category_name">Nama Kategori</label>
        </div>
        <div class="col-md-8">
            <input class="form-control @error('category_name') is-invalid @enderror" type="text" id="category_name" name="category_name" value="{{ old('category_name', $category->category_name) }}">
            @error('category_name')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
        <div class="col-12 d-flex justify-content-center pb-5">
            <button class="btn button-color" type="submit">Simpan</button>
        </div>
    </form>
</div>
@endsection