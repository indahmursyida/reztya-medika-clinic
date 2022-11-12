@extends('layout/main')

@section('title', 'Daftar Layanan Perawatan')

@section('container')
@if(session()->has('success'))
<div class="alert alert-success alert-dismissible fade show font-futura-reztya" role="alert">
    {{session('success')}}
    <button type="button" class="btn btn-close shadow-none" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
<div class="border outline-reztya rounded-4 p-5 font-futura-reztya">
    <div class="py-3 text-center">
        <h2 class="pb-5 font-alander-reztya unselectable">Daftar Layanan Perawatan</h1>
    </div>
    <a href="/add-service" class="btn button-outline-reztya my-3"><i class="fa-solid fa-plus"></i> Tambah Perawatan</a>
    <table class="table table-bordered outline-reztya">
        <thead>
            <tr class="text-center">
                <th>No.</th>
                <th>Gambar Perawatan</th>
                <th>Nama Perawatan</th>
                <th>Durasi Perawatan</th>
                <th>Harga Perawatan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @if($services->isEmpty())
            <tr>
                <td colspan="6" class="text-center">Perawatan tidak tersedia</td>
            </tr>
            @else
            @php
            $i = 1
            @endphp
            @foreach($services as $service)
            <tr class="text-center">
                <td>{{ $i }}</td>
                <td><img src="{{ asset('storage/' . $service->image_path) }}" width="150" height="150" class="img-preview img-fluid img-thumbnail"></td>
                <td>{{ $service->name }}</td>
                <td>{{ $service->duration }} menit</td>
                <td>Rp.{{ number_format($service->price, 0, '', '.') }}</td>
                <td>
                    <a class="btn btn-outline-secondary btn-sm" href="/service-detail/{{ $service->service_id }}"><i class="fa-solid fa-circle-info"></i> Detail</a>
                    <a class="btn btn-outline-primary btn-sm" href="/edit-service/{{ $service->service_id }}"><i class="fa-regular fa-pen-to-square"></i></a>
                    <form method="post" action="/delete-service/{{ $service->service_id }}" class="d-inline">
                        @method('post') @csrf
                        <button class="btn btn-outline-danger btn-sm" onclick="return confirm('Are you sure?')">
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