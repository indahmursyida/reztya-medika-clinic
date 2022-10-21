@extends('layout/main')

@section('title', 'Edit Schedule')

@section('container')
<form method="POST" action="/update-schedule/{{ $schedule->schedule_id }}" enctype="multipart/form-data">
    @method('put')
    @csrf
    <h1 class="text-center mb-3">Edit Jadwal</h1>
    <div class="mb-3">
        <p class="mb-2">Waktu Mulai</p>
        <input class="input-data ps-3 pb-1 form-control" id="start_time" name="start_time" value="{{ old('start_time', $schedule->start_time) }}" type="datetime-local">
    </div>
    <div class="mb-3">
        <p class="mb-2">Waktu Berakhir</p>
        <input class="input-data ps-3 pb-1 form-control" id="end_time" name="end_time" value="{{ old('end_time', $schedule->end_time) }}" type="datetime-local">
    </div>
    <div class="d-flex justify-content-center mt-5">
        <button type="submit" class="btn btn-outline-success">Simpan</button>
    </div>
</form>
@endsection