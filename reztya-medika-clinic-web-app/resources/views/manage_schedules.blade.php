@extends('layout/main')

@section('title', 'Manage Schedule')

@section('container')
@php
    use Carbon\Carbon;
@endphp
<div class="border outline-reztya rounded-4 p-5 font-futura-reztya">
    <h2 class="my-3 text-center font-alander-reztya">Jadwal Perawatan</h2>
    <div class="mt-2 mb-4">
        <a href="{{ url('/add-schedule') }}" class="btn btn-add rounded-2 border"  title="Tambah Jadwal">
            <img src="storage/add.png" class="align-middle" height="15px" width="15px">
        </a>
    </div>
    <table class="table table-striped">
        <thead>
            <tr class="text-center" style="background-color: #7dc241">
                <th scope="col">No.</th>
                <th scope="col">Waktu Mulai</th>
                <th scope="col">Waktu Berakhir</th>
                <th scope="col">Status</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>        
        <tbody>
            @if($schedules->isEmpty())
            <tr>
                <td colspan="5" class="text-center">Jadwal tidak tersedia</td>
            </tr>
            @else
            @for ( $i = 0; $i < count($schedules); $i++)
            <tr class="align-middle text-center">
                <td>{{ $i+1 }}</td>
                {{-- <td>{{ \Carbon\Carbon::parse($schedules[$i]->start_time)->format('j F Y') }} </td> 
                <td>{{ \Carbon\Carbon::parse($schedules[$i]->start_time)->format('H:i:s')  }} WIB</td>
                <td>{{ \Carbon\Carbon::parse($schedules[$i]->end_time)->format('H:i:s') }} WIB</td> --}}
                <td>{{ Carbon::parse($schedules[$i]->start_time)->toDayDateTimeString() }} </td>
                <td>{{ Carbon::parse($schedules[$i]->end_time)->toDayDateTimeString() }} </td>
                <td>{{ $schedules[$i]->status }} </td>
                <td>
                    <a href="/edit-schedule/{{$schedules[$i]->schedule_id}}" type="button" class="btn button-color rounded-2 btn-sm me-2 btn-edit" title="Edit Jadwal">
                        <img src="storage/edit.png" class="align-middle" height="15px" width="15px">
                    </a>
                    <a href="/delete-schedule/{{$schedules[$i]->schedule_id}}" type="button" class="btn btn-danger rounded-2 btn-sm btn-delete" onclick="return confirm('Apakah Anda yakin ingin menghapus jadwal ini?')" title="Hapus Jadwal">
                        <img src="storage/delete.png" class="align-middle" height="15px" width="15px">
                    </a>
                </td>
              </tr>
            @endfor
            @endif
        </tbody>
    </table>
</div>
{{-- <div style="display:flex !important; justify-content:center !important; ">
    {{$schedules->links()}}
</div> --}}
@endsection