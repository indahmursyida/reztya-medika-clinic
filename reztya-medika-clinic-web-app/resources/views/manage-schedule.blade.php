@extends('layout/main')

@section('title', 'Manage Schedule')

@section('container')
<?php
use Carbon\Carbon;
?>
<div class="font-futura-reztya">
    <h1 class="text-center">Jadwal Perawatan</h1>
    <div class="mt-5 mb-4">
        <a href="{{ url('/add-schedule') }}" class="btn button-color">Tambah Jadwal</a>
    </div>
    
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col" class="text-center">Tanggal</th>
                <th scope="col" class="text-center">Waktu Mulai</th>
                <th scope="col" class="text-center">Waktu Berakhir</th>
                {{-- <th class="d-flex justify-content-center text-center" style="width: fit-content;">
                    <p style="opacity: 0%;">-------------------------</p>
                </th> --}}
                <th scope="col"></th>
            </tr>
        </thead>        
        <tbody>
            @for ( $i = 0; $i < count($schedules); $i++)
            <tr>
                <th scope="row" class="align-middle">{{ $i+1 }}</th>
                <td class="align-middle text-center">{{ Carbon::parse($schedules[$i]->start_time)->format('j F Y') }} </td>
                <td class="align-middle text-center">{{ Carbon::parse($schedules[$i]->start_time)->format('H:i:s')  }} WIB</td>
                <td class="align-middle text-center">{{ Carbon::parse($schedules[$i]->end_time)->format('H:i:s') }} WIB</td>
                <td class="d-flex justify-content-center">
                    <a href="{{ url('edit-schedule')}}" type="button" class="btn button-outline-reztya me-2">Edit</a>
                    <a href="" type="button" class="btn btn-outline-danger" onclick="return confirm('Are you sure want to delete?')">Hapus</a>
                </td>
              </tr>
            @endfor
        </tbody>
    </table>
</div>
<div style="display:flex !important; justify-content:center !important; ">
    {{$schedules->links()}}
</div>
@endsection