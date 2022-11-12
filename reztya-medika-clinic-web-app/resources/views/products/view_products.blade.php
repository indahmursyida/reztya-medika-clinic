@extends('layout/main')
@section('title', 'Produk')

@section('container')
    <div class="container mb-5 mt-5">
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{$errors}}
                <button type="button" class="btn btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="box-up pt-4">
            <div class="d-flex justify-content-center">
                <p class="h5 fw-bold unselectable font-alander-reztya">Produk</p>
            </div>
        </div>
        <div class="mt-5 d-flex justify-content-center">
            <div class="w-50">
                <form action="/view-products/search-product" method="GET" enctype="multipart/form-data">
                    <div class="input-group">
                    <span class="input-group-text bg-white">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#00A54F" class="bi bi-search" viewBox="0 0 16 16">
                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"></path>
                        </svg>
                    </span>
                        <input type="search" class="form-control shadow-none w-75 font-futura-reztya" placeholder="Search" aria-label="Search" name="keyword">
                    </div>
                </form>
            </div>
        </div>
        <div class="dropdown">
            <button class="btn button-outline-reztya dropdown-toggle mt-4 mb-2" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                Filter
            </button>
            <ul class="dropdown-menu">
                <li><a href="/view-products/filter/name/a-to-z" class="button-outline-reztya dropdown-item">A to Z</a></li>
                <li><a href="/view-products/filter/name/z-to-a" class="button-outline-reztya dropdown-item">Z to A</a></li>
                <li><a href="/view-products/filter/price/high-to-low" class="button-outline-reztya dropdown-item">Price: High to Low</a></li>
                <li><a href="/view-products/filter/price/low-to-high" class="button-outline-reztya dropdown-item">Price: Low to High</a></li>
                @foreach($categories as $category)
                    <form action="/view-products/filter/category/{{$category->category_name}}" method="GET" enctype="multipart/form-data">
                        <input hidden type="hidden" name="category_id" value="{{$category->category_id}}">
                        <li><button type="submit" class="button-outline-reztya dropdown-item">{{$category->category_name}}</button></li>
                    </form>
                @endforeach
            </ul>
        </div>
        <div class="unselectable d-flex justify-content-center mt-2">
            <div class="row">
                @foreach($products as $product)
                    <div class="col-3 mb-4 font-futura-reztya">
                        <a href="/product-detail/{{$product->product_id}}" class="text-decoration-none">
                            <div class="card bg-white outline-reztya">
                                <div class="card-header">
                                    <img class="card-img-top" src="{{asset('storage/Service Reztya.jpg')}}">
                                </div>
                                <div class="card-body">
                                    <div class="card-title text-reztya">
                                        <b>{{$product->name}}</b>
                                    </div>
                                    <div class="card-description text-black">
                                        Rp {{$product->price}}
                                    </div>
                                    <a href="###" class="btn button-outline-reztya float-end w-25">
                                        Beli
                                    </a>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection