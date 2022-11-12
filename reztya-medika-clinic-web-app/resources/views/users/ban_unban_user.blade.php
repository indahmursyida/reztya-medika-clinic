@extends('layout/main')
@section('title', 'Akun-akun Pengguna')

@section('container')
    <div class="unselectable container bg-white sign-box">
        @if(session()->has('successUpdate'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{session('successUpdate')}}
                <button type="button" class="btn btn-close shadow-none" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="pt-3">
            <div class="d-flex justify-content-center">
                <p class="h5 fw-bold unselectable font-alander-reztya">Ban / Unban Member</p>
            </div>
        </div>
        @foreach($members as $member)
            <div class="mt-3">
                <div class="card outline-reztya">
                    <div class="col-auto mt-2 ms-3">
                        <div class="row">
                            <div class="col-auto">
                                <h5 class="fw-bold text-color-reztya">{{$member->name}}</h5>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div>
                                        <h6>{{$member->birthdate}}</h6>
                                    </div>
                                    <div>
                                        <h6 class="text-wrap">{{$member->address}}</h6>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div>
                                        <h6>{{$member->phone}}</h6>
                                    </div>
                                    <div>
                                        <h6>{{$member->email}}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center">
                        @if($member->is_banned == false)
                            <form action="/ban-user/{{$member->username}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <button class="btn button-outline-ban-reztya mb-1 mt-1" onclick="return confirm('Apakah anda yakin ingin melakukan ban terhadap {{$member->username}}?')">
                                    Ban
                                </button>
                            </form>
                        @else
                            <form action="/unban-user/{{$member->username}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <button class="btn button-outline-reztya mb-1 mt-1" onclick="return confirm('Apakah anda yakin ingin melakukan unban terhadap {{$member->username}}?')">
                                    Unban
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
