@extends('layout/main')
@section('title', 'Sign in')

@section('container')
    <div class="container" style="width: 450px;" style="background-color: white">
        @if(session()->has('loginError'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{session('loginError')}}
                <button type="button" class="btn btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div style="">
            <div class="d-flex justify-content-center">
                <p class="h5 fw-bold unselectable" style="font-family: Alander, sans-serif;">Log in to your Account</p>
            </div>
        </div>
        <div class="d-flex justify-content-center mt-2">
            <div class="card bg-white outline-reztya" style="width: 30rem;">
                <div class="card-body">
                    <form action="/signup" method="post">
                        @csrf
                        <div class="form-floating mb-2">
                            <input placeholder="Email" id="floatingEmail" class="shadow-none form-control @error('email') is-invalid @enderror" type="text" name="email" required value="{{\Illuminate\Support\Facades\Cookie::get('email')}}">
                            <label for="floatingEmail" style="font-family: 'Futura Md BT', sans-serif">Email</label>
                            @error('email')
                            <div class="invalid-feedback">
                                Please insert email.
                            </div>
                            @enderror
                        </div>
                        <div class="form-floating mb-2">
                            <input placeholder="Password" id="floatingPassword" class="shadow-none form-control @error('password') is-invalid @enderror" type="password" name="password" required value="{{\Illuminate\Support\Facades\Cookie::get('password')}}">
                            <label for="floatingPassword" style="font-family: 'Futura Md BT', sans-serif">Password</label>
                            @error('password')
                            <div class="invalid-feedback">
                                Please insert password.
                            </div>
                            @enderror
                        </div>
                        <div class="mt-3 mb-3 form-check">
                            <input class="form-check-input shadow-none outline-reztya" type="checkbox" id="remember_me" name="remember_me">
                            <label class="form-check-label" for="rememberMe">Remember me</label>
                        </div>
                        <div class="mt-3 mb-3 me-3 form-check text-center ">
                            <a class="h6 text-reztya" href="/forgot-password" style="text-decoration: none; font-family: 'Futura Md BT', sans-serif;">Forgot Password</a>
                        </div>
                        <div class="d-grid gap-2">
                            <button class="btn button-outline-reztya" type="submit" style="font-family: 'Futura Md BT', sans-serif">Sign In</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
