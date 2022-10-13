@extends('layout/main')

@section('title', 'Manage Schedule')

@section('container')
<div class="font-futura-reztya">
    <h1 class="text-center">Jadwal Perawatan</h1>
    <div class="button_new_schedule">
        <a class="btn btn-outline-success">Tambah Jadwal</a>
    </div>
    <div class="schedule pt-5">
        <div class="d-flex jus align-items-center">
            <p class="d-flex align-items-center pe-3">Tanggal</p>
        </div>
        <div class="d-flex justify-content-between">
            <p class="justify-content-star">Waktu Mulai - Waktu Berakhir</p>
            <div class="d-flex">
                <a href="" type="button" class="btn button-outline-reztya">Ubah</a>
                <a href="" type="button" class="btn btn-outline-danger">Hapus</a>
            </div>
        </div>
    </div>
</div>

@endsection