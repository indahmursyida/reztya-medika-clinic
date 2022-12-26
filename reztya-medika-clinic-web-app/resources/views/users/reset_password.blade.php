@extends('layout/main')
@section('title', 'Setel Ulang Sandi')

@section('container')
    <div class="container sign-box mb-5">
        @if(session()->has('resetError'))
            <div class="alert alert-danger alert-dismissible fade show font-futura-reztya" role="alert">
                {{session('resetError')}}
                <button type="button" class="btn btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="box-up pt-4">
            <div class="d-flex justify-content-center">
                <p class="h5 fw-bold unselectable font-alander-reztya">Setel Ulang Sandi</p>
            </div>
        </div>
        <div class="unselectable d-flex justify-content-center mt-2">
            <div class="card card-sign bg-white outline-reztya">
                <div class="card-body">
                    <form action="/reset-password" method="POST">
                        @csrf
                        <div class="form-floating mb-2">
                            <input autofocus placeholder="Email" id="floatingEmail" class="shadow-none form-control @error('email') is-invalid @enderror" type="text" name="email" value="{{old('email')}}">
                            <label for="floatingEmail" class="font-futura-reztya">Email</label>
                            @error('email')
                            <div class="invalid-feedback">
                                Email wajib diisi / email sudah terdaftarkan
                            </div>
                            @enderror
                        </div>
                        <div class="form-floating mb-2">
                            <input placeholder="Password" id="floatingPassword" class="shadow-none form-control @error('password') is-invalid @enderror" type="password" name="password" value="{{old('password')}}">
                            <label for="floatingPassword" class="font-futura-reztya">Kata Sandi</label>
                            @error('password')
                            <div class="invalid-feedback">
                                Kata sandi wajib diisi
                            </div>
                            @enderror
                        </div>
                        <div class="form-floating mb-2">
                            <input placeholder="ConfirmPassword" id="floatingConfirmPassword" class="shadow-none form-control @error('confirm_password') is-invalid @enderror" type="password" name="confirm_password" value="{{old('confirm_password')}}">
                            <label for="floatingConfirmPassword" class="font-futura-reztya">Konfirmasi Kata Sandi</label>
                            @error('confirm_password')
                            <div class="invalid-feedback">
                                Konfirmasi kata sandi wajib diisi
                            </div>
                            @enderror
                        </div>
                        <div class="d-grid gap-2">
                            <button class="btn button-outline-reztya font-futura-reztya" type="submit">Setel Ulang</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection