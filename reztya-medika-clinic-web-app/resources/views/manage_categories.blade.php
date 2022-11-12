@extends('layout/main')

@section('title', 'Daftar Kategori')

@section('container')
<div class="border outline-reztya rounded-4 p-5 font-futura-reztya">
    <div class="py-3 text-center">
        <h2 class="pb-5 font-alander-reztya unselectable">Daftar Kategori</h2>
    </div>
    <a href="/add-category" class="btn button-outline-reztya my-3"><i class="fa-solid fa-plus"></i> Tambah Kategori</a>
    <table class="table table-bordered table-striped outline-reztya">
        <thead>
            <tr class="text-center">
                <th>No.</th>
                <th>Nama Kategori</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @if($categories->isEmpty())
            <tr>
                <td colspan="3" class="text-center">Kategori tidak tersedia</td>
            </tr>
            @else
            @php
            $i = 1
            @endphp
            @foreach($categories as $category)
            <tr class="text-center">
                <td>{{ $i }}</td>
                <td>{{ $category->category_name }}</td>
                <td>
                    <a class="btn btn-outline-primary btn-sm" href="/edit-category/{{ $category->category_id }}"><i class="fa-regular fa-pen-to-square"></i></a>
                    <form method="post" action="/delete-category/{{ $category->category_id }}" class="d-inline">
                        @method('post') @csrf
                        <button class="btn btn-outline-danger btn-sm" onclick="return confirm('Apakah anda yakin ingin mengapus produk ini?')">
                            <i class="fa-solid fa-trash"></i>
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