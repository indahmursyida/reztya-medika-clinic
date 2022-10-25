@extends('layout/main')
@section('title', 'Masuk')

@section('container')
    <div class="unselectable container" style="width: 450px;" style="background-color: white">
        @if(session()->has('loginError'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{session('loginError')}}
                <button type="button" class="btn btn-close shadow-none" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="pt-3">
            <div class="d-flex justify-content-center">
                <p class="h5 fw-bold unselectable font-alander-reztya">Masuk ke Akunmu</p>
            </div>
        </div>
        <div class="d-flex justify-content-center mt-2">
            <div class="card bg-white outline-reztya" style="width: 30rem;">
                <div class="card-body">
                    <form action="/signin" method="POST">
                        @csrf
                        <div class="form-floating mb-2">
                            <input placeholder="Email" id="floatingEmail" class="shadow-none form-control @error('email') is-invalid @enderror" type="text" name="email" value="{{\Illuminate\Support\Facades\Cookie::get('email')}}">
                            <label for="floatingEmail" class="font-futura-reztya">Email</label>
                            @error('email')
                            <div class="invalid-feedback">
                                Email wajib diisi
                            </div>
                            @enderror
                        </div>
                        <div class="form-floating mb-2">
                            <input placeholder="Password" id="floatingPassword" class="shadow-none form-control @error('password') is-invalid @enderror" type="password" name="password" value="{{\Illuminate\Support\Facades\Cookie::get('password')}}">
                            <label for="floatingPassword" class="font-futura-reztya">Kata Sandi</label>
                            @error('password')
                            <div class="invalid-feedback">
                                Kata sandi wajib diisi
                            </div>
                            @enderror
                        </div>
                        <div class="mt-3 mb-3 form-check">
                            <input class="form-check-input shadow-none outline-reztya" type="checkbox" id="remember_me" name="remember_me">
                            <label class="form-check-label" for="rememberMe">Ingat saya</label>
                        </div>
                        <div class="mt-3 mb-3 me-3 form-check text-center ">
                            <a class="h6 font-futura-reztya text-reztya" href="/forgot-password" style="text-decoration: none;">Lupa Kata Sandi</a>
                        </div>
                        <div class="d-grid gap-2">
                            <button class="btn button-outline-reztya font-futura-reztya" type="submit">Masuk</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
