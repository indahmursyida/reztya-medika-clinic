@extends('layout/main')

@section('title', 'Detail Produk')

@section('container')
<div class="container-product border outline-reztya rounded-4 font-futura-reztya py-5">
	<div class="py-3 text-center">
		<h2 class="pb-3 font-alander-reztya unselectable">Detail Produk</h2>
	</div>
	<form method="post" action="/buy-product" enctype="multipart/form-data" novalidate>
		@method('post') @csrf
		<input type="hidden" value="{{ $product->product_id }}" name="product_id" id="product_id">
		<div class="row py-5">
			<div class="col-sm-6 pe-5">
				<img src="{{ asset('storage/' . $product->image_path) }}" class="img-fluid img-thumbnail">
			</div>

			<div class="col-sm-6">
				<div class="btn btn-outline-secondary rounded-pill">{{$product->category->category_name}}</div>
				<h3 class="text-reztya my-3">{{ $product->name }}</h3>
				@if(!is_null($product->size))
				<p>Ukuran: {{ $product->size }}</p>
				@endif
				<h5>Rp. {{ number_format($product->price, 0, '', '.') }}</h5>
				<div class="my-5">
					<p>{{ $product->description }}</p>
				</DIv>
				<p>Expired Date: {{ date('d F Y', strtotime($product->expired_date)) }}</p>
				<label for="quantity" class="my-2">Jumlah</label>
				<input type="number" class="form-control form-quantity" id="quantity" name="quantity" min="1" max="{{ old('quantity') }}" value="{{ old('quantity', 1) }}">
			</div>
		</div>
		<div class="d-flex justify-content-center pb-5">
			<button class="btn btn-success" type="submit"><i class="fa-solid fa-cart-shopping"></i> Tambahkan ke keranjang</button>
		</div>
	</form>
</div>
@endsection