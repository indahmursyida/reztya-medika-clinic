@extends('layout/main')

@section('title', 'Edit Schedule')

@section('container')
<div class="d-flex justify-content-center">
    <div class="border outline-reztya rounded-4 p-5 font-futura-reztya d-flex flex-column add-schedule align-self-center">
        <h2 class="my-3 mx-4 text-center font-alander-reztya">Edit Jadwal</h2>
        <form action="/update-schedule/{{ $schedule->schedule_id }}" method="POST" enctype="multipart/form-data">
            @method('put')
            @csrf
            <div class="container">
                <div class="col mb-2">
                    <p class="mb-2">Waktu Mulai</p>
                    <input class="ps-3 form-control @error('start_time') is-invalid @enderror" id="start_time" name="start_time" value="{{ old('start_time', $schedule->start_time) }}" type="datetime-local">
                    @error('start_time')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="col mb-2">
                    <p class="mb-2">Waktu Berakhir</p>
                    <input class="ps-3 form-control @error('end_time') is-invalid @enderror" id="end_time" name="end_time" value="{{ old('end_time', $schedule->end_time) }}" type="datetime-local">
                    @error('end_time')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="d-flex justify-content-center mt-4">
                <button type="submit" class="btn btn-outline-success">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection