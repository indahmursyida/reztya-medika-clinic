@extends('layout/main')

@section('title', 'Edit Schedule')

@section('container')
<form action="" method="POST">
    <h1 class="text-center mb-3">Edit Jadwal</h1>
    <div class="mb-3">
        <input type="hidden" value="{{$schedule->schedule_id}}" name="id">
        <p class="mb-2">Tanggal</p>
        <input class="input-data ps-3 pb-1 form-control" value="{{ date('Y-m-d', strtotime($schedule->start_time)) }}" type="date">
    </div>
    <div class="mb-3">
        <p class="mb-2">Waktu Mulai</p>
        <input class="input-data ps-3 pb-1 form-control" value="{{ date('H:i', strtotime($schedule->start_time)) }}" type="time">
    </div>
    <div class="mb-3">
        <p class="mb-2">Waktu Berakhir</p>
        <input class="input-data ps-3 pb-1 form-control" value="{{ date('H:i', strtotime($schedule->end_time)) }}" type="time">
    </div>
    <div class="d-flex justify-content-center mt-5">
        <input type="submit" class="btn btn-outline-success" value="Simpan">
    </div>
</form>
@endsection