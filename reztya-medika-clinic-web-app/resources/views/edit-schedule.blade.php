@extends('layout/main')

@section('title', 'Edit Schedule')

@section('container')
<h1 class="text-center" style="color: #00A54F">Ubah Jadwal</h1>
<div>
    <p class="">T</p>
    <input class="input-data ps-3 pb-1" type="date">
</div>
<div>
    <p class="">Start Time</p>
    <input class="input-data ps-3 pb-1 form-control" type="time">
</div>
<div>
    <p class="">End Time</p>
    <input class="input-data ps-3 pb-1 form-control" type="time">
</div>
<div>
    <input type="button" class="btn btn-outline-success" value="Add">
</div>
@endsection