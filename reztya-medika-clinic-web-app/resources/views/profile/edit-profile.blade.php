@extends('layout/main')
@section('title', 'Profile')

@section('container')
    <div class="unselectable container bg-white sign-box">
        @if(session()->has('updateError'))
            <div class="alert alert-danger alert-dismissible fade show font-futura-reztya" role="alert">
                {{session('updateError')}}
                <button type="button" class="btn btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="pt-3 mb-4">
            <div class="d-flex justify-content-center">
                <p class="h5 fw-bold unselectable font-alander-reztya">Ubah Profil</p>
            </div>
        </div>
        <div class="d-flex justify-content-center mt-2 bg-white font-futura-reztya">
            <div class="profile-box">
                <form action="/edit-profile/{{auth()->user()->username}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="d-flex justify-content-center mb-3">
                        <div class="col-auto">
                            <img width="200px" src="{{asset('storage/' . auth()->user()->profile_picture)}}" class="bg-secondary img-thumbnail rounded-circle" id="preview" aria-expanded="false" alt="Profile Picture">
                        </div>
                    </div>
                    <div class="card outline-reztya">
                        <ul class="list-group">
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-3">
                                        <label for="name" class="col-form-label">Foto</label>
                                    </div>
                                    <div class="col-md-8 mt-1">
                                        <input type="file" name="photo" class="shadow-none form-control form-control-sm @error('photo') is-invalid @enderror" aria-describedby="photo" onchange="loadFile(event)">
                                        @error('photo')
                                        <div class="invalid-feedback">
                                            Format foto wajib JPEG, JPG, SVG, GIF, atau PNG
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-3">
                                        <label for="username" class="col-form-label">Username</label>
                                    </div>
                                    <div class="col-md-8 mt-2">
                                        <input type="text" name="username" class="shadow-none form-control form-control-sm @error('username') is-invalid @enderror" aria-describedby="username" placeholder="{{auth()->user()->username}}" value="{{old('username')}}">
                                        @error('username')
                                        <div class="invalid-feedback">
                                            Username wajib diisi
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-3">
                                        <label for="name" class="col-form-label">Nama Lengkap</label>
                                    </div>
                                    <div class="col-md-8 mt-2">
                                        <input type="text" name="name" class="shadow-none form-control form-control-sm @error('name') is-invalid @enderror" aria-describedby="name" placeholder="{{auth()->user()->name}}" value="{{old('name')}}">
                                        @error('name')
                                        <div class="invalid-feedback">
                                            Nama lengkap wajib diisi
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-3">
                                        <label for="birthdate" class="col-form-label">Tanggal Lahir</label>
                                    </div>
                                    <div class="col-md-5 mt-2">
                                        <input type="date" name="birthdate" class="shadow-none form-control form-control-sm @error('birthdate') is-invalid @enderror" aria-describedby="birthdate" placeholder="{{auth()->user()->birthdate}}" value="{{old('birthdate')}}">
                                        @error('birthdate')
                                        <div class="invalid-feedback">
                                            Tanggal lahir wajib diisi
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-3">
                                        <label for="phone" class="col-form-label">Nomor Telepon</label>
                                    </div>
                                    <div class="col-md-8 mt-3">
                                        <input type="number" name="phone" class="shadow-none form-control form-control-sm @error('phone') is-invalid @enderror" aria-describedby="phone" placeholder="{{auth()->user()->phone}}" value="{{old('phone')}}">
                                        @error('phone')
                                        <div class="invalid-feedback">
                                            Nomor telepon wajib diisi
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-3">
                                        <label for="address" class="col-form-label">Alamat</label>
                                    </div>
                                    <div class="col-md-8 mt-1">
                                        <textarea name="address" class="shadow-none form-control form-control-sm @error('address') is-invalid @enderror" aria-describedby="address">{{auth()->user()->address}}</textarea>
                                        @error('address')
                                        <div class="invalid-feedback">
                                            Alamat wajib diisi
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-3">
                                        <label for="email" class="col-form-label">Email</label>
                                    </div>
                                    <div class="col-md-8 mt-1">
                                        <input type="text" name="email" class="shadow-none form-control form-control-sm @error('email') is-invalid @enderror" aria-describedby="email" placeholder="{{auth()->user()->email}}" value="{{old('email')}}">
                                        @error('email')
                                        <div class="invalid-feedback">
                                            Email wajib diisi
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-3">
                                        <label for="password" class="col-form-label">Kata Sandi</label>
                                    </div>
                                    <div class="col-md-8 mt-1">
                                        <input type="password" name="password" class="shadow-none form-control form-control-sm @error('password') is-invalid @enderror" aria-describedby="password">
                                        @error('password')
                                        <div class="invalid-feedback">
                                            Kata sandi wajib diisi / harus sesuai
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="d-flex justify-content-center mt-3 mb-5">
                        <button class="btn button-outline-reztya" type="submit">Simpan</button>
                    </div>
                </form>
                <form action="/change-password/{{auth()->user()->username}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if(session()->has('passwordChangeError'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{session('passwordChangeError')}}
                            <button type="button" class="btn btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <div class="d-flex justify-content-center">
                        <div class="pt-3 mb-4">
                            <div class="d-flex justify-content-center">
                                <p class="h5 fw-bold unselectable font-alander-reztya">Ubah Kata Sandi</p>
                            </div>
                        </div>
                    </div>
                    <div class="card outline-reztya">
                        <ul class="list-group">
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-3">
                                        <label for="oldpass" class="col-form-label">Kata Sandi Lama</label>
                                    </div>
                                    <div class="col-md-8 mt-3">
                                        <input type="password" name="oldpass" class="shadow-none form-control form-control-sm @error('oldpass') is-invalid @enderror" aria-describedby="oldpass">
                                        @error('oldpass')
                                        <div class="invalid-feedback">
                                            Kata sandi lama wajib diisi / harus sesuai
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-3">
                                        <label for="newpass" class="col-form-label">Kata Sandi Baru</label>
                                    </div>
                                    <div class="col-md-8 mt-3">
                                        <input type="password" name="newpass" class="shadow-none form-control form-control-sm @error('newpass') is-invalid @enderror" aria-describedby="newpass">
                                        @error('newpass')
                                        <div class="invalid-feedback">
                                            Kata sandi baru wajib diisi
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-3">
                                        <label for="confnewpass" class="col-form-label">Konfirmasi Kata Sandi Baru</label>
                                    </div>
                                    <div class="col-md-8 mt-4">
                                        <input type="password" name="confnewpass" class="shadow-none form-control form-control-sm @error('confnewpass') is-invalid @enderror" aria-describedby="confnewpass">
                                        @error('confnewpass')
                                        <div class="invalid-feedback">
                                            Konfirmasi kata sandi baru wajib diisi
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="d-flex justify-content-center mt-3 mb-5">
                        <button class="btn button-outline-reztya" type="submit">Ubah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        var loadFile = function(event) {
            var output = document.getElementById('preview');
            output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = function() {
                URL.revokeObjectURL(output.src)
            }
        };
    </script>
@endsection