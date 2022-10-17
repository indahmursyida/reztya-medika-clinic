@extends('layout/main')
@section('title', 'Sign up')

@section('container')
    <div class="container" style="width: 450px;" style="background-color: white">
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                Sign up failed!
                <button type="button" class="btn btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div style="margin-top: -4%; margin-bottom: -2%;">
            <div class="d-flex justify-content-center">
                <p class="h5 fw-bold unselectable" style="font-family: Alander, sans-serif;">Register Account</p>
            </div>
        </div>
        <div class="unselectable d-flex justify-content-center mt-2">
            <div class="card bg-white outline-reztya" style="width: 30rem;">
                <div class="card-body">
                    <form action="/signup" method="POST">
                        @csrf
                        <div class="form-floating mb-2" autofocus>
                            <input placeholder="Username" id="floatingUsername" class="shadow-none form-control @error('username') is-invalid @enderror" type="text" name="username" required value="{{old('username')}}" autofocus>
                            <label for="floatingUsername" style="font-family: 'Futura Md BT', sans-serif">Username</label>
                            @error('username')
                            <div class="invalid-feedback">
                                Please insert username.
                            </div>
                            @enderror
                        </div>
                        <div class="form-floating mb-2">
                            <input placeholder="Name" id="floatingName" class="shadow-none form-control @error('name') is-invalid @enderror" type="text" name="name" required value="{{old('name')}}">
                            <label for="floatingName" style="font-family: 'Futura Md BT', sans-serif">Name</label>
                            @error('name')
                            <div class="invalid-feedback">
                                Please insert name.
                            </div>
                            @enderror
                        </div>
                        <div class="form-floating mb-2">
                            <input placeholder="Birthdate" id="floatingBirthdate" class="shadow-none form-control @error('birthdate') is-invalid @enderror" type="date" name="birthdate" required value="{{old('birthdate')}}">
                            <label for="floatingBirthdate" style="font-family: 'Futura Md BT', sans-serif;">Birthdate</label>
                            @error('birthdate')
                            <div class="invalid-feedback">
                                Please insert birthdate.
                            </div>
                            @enderror
                        </div>
                        <div class="form-floating mb-2">
                            <input placeholder="Phone" id="floatingPhone" class="shadow-none form-control @error('phone') is-invalid @enderror" type="number" name="phone" required value="{{old('phone')}}">
                            <label for="floatingPhone" style="font-family: 'Futura Md BT', sans-serif">Phone Number</label>
                            @error('phone')
                            <div class="invalid-feedback">
                                Please insert phone.
                            </div>
                            @enderror
                        </div>
                        <div class="form-floating mb-2">
                            <input placeholder="Address" id="floatingAddress" class="shadow-none form-control @error('address') is-invalid @enderror" type="text" name="address" required value="{{old('address')}}">
                            <label for="floatingAddress" style="font-family: 'Futura Md BT', sans-serif">Address</label>
                            @error('address')
                            <div class="invalid-feedback">
                                Please insert address.
                            </div>
                            @enderror
                        </div>
                        <div class="form-floating mb-2">
                            <input placeholder="Email" id="floatingEmail" class="shadow-none form-control @error('email') is-invalid @enderror" type="text" name="email" required value="{{old('email')}}">
                            <label for="floatingEmail" style="font-family: 'Futura Md BT', sans-serif">Email</label>
                            @error('email')
                            <div class="invalid-feedback">
                                Please insert email.
                            </div>
                            @enderror
                        </div>
                        <div class="form-floating mb-2">
                            <input placeholder="Password" id="floatingPassword" class="shadow-none form-control @error('password') is-invalid @enderror" type="password" name="password" required value="{{old('password')}}">
                            <label for="floatingPassword" style="font-family: 'Futura Md BT', sans-serif">Password</label>
                            @error('password')
                            <div class="invalid-feedback">
                                Please insert password.
                            </div>
                            @enderror
                        </div>
                        <div class="form-floating mb-2">
                            <input placeholder="Confirm Password" id="floatingConfirmPassword" class="shadow-none form-control @error('confirm_password') is-invalid @enderror" type="password" name="confirm_password" required value="{{old('confirm_password')}}">
                            <label for="floatingConfirmPassword" style="font-family: 'Futura Md BT', sans-serif">Confirm Password</label>
                            @error('confirm_password')
                            <div class="invalid-feedback">
                                Please insert confirm password.
                            </div>
                            @enderror
                        </div>
                        <div class="d-grid gap-2">
                            <button class="btn button-outline-reztya" type="submit" style="font-family: 'Futura Md BT', sans-serif">Sign Up</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
