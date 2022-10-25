@extends('layout/main')
@section('title', 'Daftar')

@section('container')
    <div class="container sign-box mb-5">
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                Pendaftaran tidak berhasil!
                <button type="button" class="btn btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="box-up pt-4">
            <div class="d-flex justify-content-center">
                <p class="h5 fw-bold unselectable font-alander-reztya">Daftar Akun</p>
            </div>
        </div>
        <div class="unselectable d-flex justify-content-center mt-2">
            <div class="card card-sign bg-white outline-reztya">
                <div class="card-body">
                    <form action="/signup" method="POST">
                        @csrf
                        <div class="form-floating mb-2" autofocus>
                            <input placeholder="Username" id="floatingUsername" class="shadow-none form-control @error('username') is-invalid @enderror" type="text" name="username" value="{{old('username')}}" autofocus>
                            <label for="floatingUsername" class="font-futura-reztya">Username</label>
                            @error('username')
                            <div class="invalid-feedback">
                                Username wajib diisi
                            </div>
                            @enderror
                        </div>
                        <div class="form-floating mb-2">
                            <input placeholder="Name" id="floatingName" class="shadow-none form-control @error('name') is-invalid @enderror" type="text" name="name" value="{{old('name')}}">
                            <label for="floatingName" class="font-futura-reztya">Nama Lengkap</label>
                            @error('name')
                            <div class="invalid-feedback">
                                Nama lengkap wajib diisi
                            </div>
                            @enderror
                        </div>
                        <div class="form-floating mb-2">
                            <input placeholder="Birthdate" id="floatingBirthdate" class="shadow-none form-control @error('birthdate') is-invalid @enderror" type="date" name="birthdate" value="{{old('birthdate')}}">
                            <label for="floatingBirthdate" class="font-futura-reztya">Tanggal Lahir</label>
                            @error('birthdate')
                            <div class="invalid-feedback">
                                Tanggal lahir wajib diisi
                            </div>
                            @enderror
                        </div>
                        <div class="form-floating mb-2">
                            <input placeholder="Phone" id="floatingPhone" class="shadow-none form-control @error('phone') is-invalid @enderror" type="number" name="phone" value="{{old('phone')}}">
                            <label for="floatingPhone" class="font-futura-reztya">Nomor Telepon</label>
                            @error('phone')
                            <div class="invalid-feedback">
                                Nomor telepon wajib diisi
                            </div>
                            @enderror
                        </div>
                        <div class="form-floating mb-2">
                            <input placeholder="Address" id="floatingAddress" class="shadow-none form-control @error('address') is-invalid @enderror" type="text" name="address" value="{{old('address')}}">
                            <label for="floatingAddress" class="font-futura-reztya">Alamat</label>
                            @error('address')
                            <div class="invalid-feedback">
                                Alamat wajib diisi
                            </div>
                            @enderror
                        </div>
                        <div class="form-floating mb-2">
                            <input placeholder="Email" id="floatingEmail" class="shadow-none form-control @error('email') is-invalid @enderror" type="text" name="email" value="{{old('email')}}">
                            <label for="floatingEmail" class="font-futura-reztya">Email</label>
                            @error('email')
                            <div class="invalid-feedback">
                                Email wajib diisi
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
                            <input placeholder="Confirm Password" id="floatingConfirmPassword" class="shadow-none form-control @error('confirm_password') is-invalid @enderror" type="password" name="confirm_password" value="{{old('confirm_password')}}">
                            <label for="floatingConfirmPassword" class="font-futura-reztya">Konfirmasi Kata Sandi</label>
                            @error('confirm_password')
                            <div class="invalid-feedback">
                                Konfirmasi kata sandi wajib diisi / Konfirmasi kata sandi tidak sesuai dengan kata sandi.
                            </div>
                            @enderror
                        </div>
                        <div class="d-grid gap-2">
                            <button class="btn button-outline-reztya font-futura-reztya" type="submit">Daftar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
