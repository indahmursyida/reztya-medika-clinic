@extends('layout/main')

@section('title', 'Daftar Produk')

@section('container')
<div class="border outline-reztya rounded-4 p-5 font-futura-reztya">
    <div class="py-3 text-center">
        <h2 class="pb-5 font-alander-reztya">Daftar Produk</h1>
    </div>
    <a href="/add-product" class="btn button-outline-reztya my-3">Tambah Produk</a>
    <table class="table table-bordered outline-reztya">
        <thead>
            <tr class="text-center">
                <th>No.</th>
                <th>Gambar Produk</th>
                <th>Nama Produk</th>
                <th>Stok Produk</th>
                <th>Harga Produk</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @if($products->isEmpty())
            <tr>
                <td colspan="6" class="text-center">Produk tidak tersedia</td>
            </tr>
            @else
            @php
            $i = 1
            @endphp
            @foreach($products as $product)
            <tr class="text-center">
                <td>{{ $i }}</td>
                <td><img src="{{ asset('storage/' . $product->image_path) }}" width="150" height="150"></td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->stock }} buah</td>
                <td>Rp.{{  number_format($product->price, 0, '', '.') }}</td>
                <td>
                    <a class="btn btn-outline-secondary btn-sm" href="/product-detail/{{ $product->product_id }}">Lihat Detail</a>
                    <a class="btn btn-outline-primary btn-sm" href="/edit-product/{{ $product->product_id }}">Edit</a>
                    <form method="post" action="/delete-product/{{ $product->product_id }}" class="d-inline">
                        @method('post') @csrf
                        <button class="btn btn-outline-danger btn-sm" onclick="return confirm('Are you sure?')">
                            Hapus
                        </button>
                    </form>
                </td>
            </tr>

            @php
            $i++
            @endphp
            @endforeach
            @endif
        </tbody>
    </table>
</div>

@endsection