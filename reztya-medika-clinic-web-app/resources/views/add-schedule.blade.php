@extends('layout/main')

@section('title', 'Add Schedule')

@section('container')
<h1 class="text-center" style="color: #00A54F">Add Schedule</h1>
<div>
    <p class="" >Date</p>
    <input class="input-data ps-3 pb-1" type="date" placeholder="Date">
</div>
<div>
    <p class="">Start Time</p>
    <input class="input-data ps-3 pb-1" type="date" placeholder="Date">
</div>
<div>
    <p class="">End Time</p>
    <input class="input-data ps-3 pb-1" type="date" placeholder="Date">
</div>
<div>
    <input type="button" class="btn btn-outline-success" value="Add">
</div>
@endsection