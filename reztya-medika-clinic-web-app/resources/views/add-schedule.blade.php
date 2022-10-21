@extends('layout/main')

@section('title', 'Add Schedule')

@section('container')
<form action="/add-schedule" method="POST" class="">
    {{ csrf_field() }}
    <h1 class="text-center mb-3">Tambah Jadwal</h1>
    <div class="mb-3">
        <p class="mb-2">Tanggal</p>
        <input class="input-data ps-3 pb-1 form-control" type="date" name="start-time">
    </div>
    <div class="mb-3">
        <p class="mb-2">Waktu Mulai</p>
        <input class="input-data ps-3 pb-1 form-control" type="time" name="start-time">
    </div>
    <div class="mb-3">
        <p class="mb-2">Waktu Berakhir</p>
        <input class="input-data ps-3 pb-1 form-control" type="time" name="end-time">
    </div>
    <div class="d-flex justify-content-center mt-5">
        <input type="submit" class="btn btn-outline-success" value="Simpan">
    </div>
</form>
@endsection