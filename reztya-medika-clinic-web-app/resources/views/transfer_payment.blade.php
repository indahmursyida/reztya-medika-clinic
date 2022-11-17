@extends('layout/main')

@section('name', 'Bayar via Transfer')

@section('container')
@php
use Carbon\Carbon;
@endphp

<div class="border outline-reztya rounded-4 p-5 font-futura-reztya">
    <h2 class="my-3 text-center font-alander-reztya unselectable">Konfirmasi Pembayaran</h2>
    
    <div class="d-flex justify-content-center my-4">
        <img class="img-preview img-fluid img-responsive img-thumbnail" width="300" height="300">
    </div>

    <div class="row d-flex justify-content-center">
        <div class="col-md-2">
            <p>Tanggal Transfer: </p>
        </div>
        <div class="col-md-3">
            <p>{{ date('l, d M Y', strtotime($payment_receipt->payment_date)) }}</p>
        </div>
    </div>

    <div class="row d-flex justify-content-center">
        <div class="col-md-2">
            <p>Total Transfer: </p>
        </div>
        <div class="col-md-3">
            <p>Rp{{ number_format($payment_receipt->payment_amount, 2)}}</p>
        </div>
    </div>

    <div class="row d-flex justify-content-center">
        <div class="col-md-2">
            <p>Nomor Akun Bank: </p>
        </div>
        <div class="col-md-3">
            <p>{{$payment_receipt->account_number}}</p>
        </div>
    </div>

    <div class="row d-flex justify-content-center">
        <div class="col-md-2">
            <p>Nama Akun Bank: </p>
        </div>
        <div class="col-md-3">
            <p>{{$payment_receipt->account_name}}</p>
        </div>
    </div>
    
    <div class="unselectable d-flex justify-content-center mt-2">
        <div class="card card-sign bg-white outline-reztya">
            <div class="card-body">
                <form action="/update-payment-receipt/{{ $payment_receipt->payment_receipt_id }}" method="POST" enctype="multipart/form-data">
                    @method('post')
                    @csrf
                    <div class="text-center">
                        Verifikasi Admin
                    </div>
                    <div class="form-floating mb-2">
                        <input placeholder="Username Admin" id="floating_confirmed_by" class="shadow-none form-control @error('confirmed_by') is-invalid @enderror" type="text" name="confirmed_by" value="{{old('username')}}">
                        <label for="floating_confirmed_by" class="font-futura-reztya">Username Admin</label>
                        @error('confirmed_by')
                        <div class="invalid-feedback">
                            Username Admin wajib diisi
                        </div>
                        @enderror
                    </div>
                    <div class="form-floating mb-2">
                        <input placeholder="Password Admin" id="floating_admin_password" class="shadow-none form-control @error('admin_password') is-invalid @enderror" type="password" name="admin_password" value="{{old('password')}}">
                        <label for="floating_admin_password" class="font-futura-reztya">Kata Sandi</label>
                        @error('admin_password')
                        <div class="invalid-feedback">
                            Kata Sandi wajib diisi
                        </div>
                        @enderror
                    </div>
                    <div class="d-grid gap-2">
                        <button class="btn button-outline-reztya font-futura-reztya" type="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
</div>

@endsection