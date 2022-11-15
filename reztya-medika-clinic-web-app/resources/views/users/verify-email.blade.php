@extends('layout/main')
@section('title', 'Verify Email')

@section('container')
    <div class="container sign-box mb-5">
        <div class="box-up pt-4">
            <div class="d-flex justify-content-center">
                <p class="h5 fw-bold unselectable font-alander-reztya">Verify Email</p>
            </div>
        </div>
        <div class="unselectable d-flex justify-content-center mt-3">
            <div class="card card-sign bg-white outline-reztya">
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <h2 class="text-reztya font-futura-reztya text-center">Tolong verfikasi email sebelum mengakses halaman lain atau sign in</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="unselectable d-flex justify-content-center mt-3">
            <div class="card card-sign bg-white outline-reztya">
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button class="btn button-outline-reztya font-futura-reztya" type="submit">Daftar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
