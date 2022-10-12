@extends('layout/main')

@section('title', 'Manage Schedule')

@section('container')
<h1 class="text-center" style="color: #00A54F">Manage Schedule</h1>
<div class="button_new_schedule">
    <a class="btn btn-outline-success">+ Add New Schedule</a>
</div>
<div class="schedule pt-5">
    <div class="d-flex jus align-items-center">
        <p class="d-flex align-items-center pe-3">Date</p>
        <p class="green-background">Category</p>
    </div>
    <div class="d-flex justify-content-between">
        <p class="justify-content-start">Start Time - End Time</p>
        <div class="d-flex">
            <p class="green-background justify-content-end me-3">Edit</p>
        <p class="green-background">Delete</p>
        </div>
    </div>
</div>
@endsection