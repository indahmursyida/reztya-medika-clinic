@extends('layout.main')
@section('title', 'Profile')

@section('container')
    <div class="mt-4" style="margin-left: 20%">
        <div class="card border-light bg-light" style="margin-right: 30%">
            @if(session()->has('updateError'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{session('updateError')}}
                    <button type="button" class="btn btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div>
                <h3 class="fw-bold mb-3">Profile</h3>
                <form action="/profile-update" method="post" enctype="multipart/form-data">
                    @csrf
                    <div>
                        <div class="row card-header bg-light">
                            <div class="col-auto" style="margin-right: 25%">
                                <label for="name" class="col-form-label">Name</label>
                            </div>
                            <div class="col-md-7">
                                <input type="text" name="name" class="form-control form-control-sm @error('name') is-invalid @enderror" aria-describedby="name" placeholder="" value="{{old('name')}}">
                            </div>
                        </div>
                        <div class="row card-header bg-light">
                            <div class="col-auto" style="margin-right: 25%">
                                <label for="photo" class="col-form-label">Photo</label>
                            </div>
                            <div class="col-auto">
                                <img style="overflow: hidden" width="45px" src="" class="bg-secondary img-thumbnail rounded-circle" id="preview" aria-expanded="false" alt="Profile Picture">
                            </div>
                            <div class="col-md-4 mt-2" style="margin-left: 15%">
                                <input type="file" name="photo" class="form-control form-control-sm  @error('photo') is-invalid @enderror" aria-describedby="photo" onchange="loadFile(event)">
                            </div>
                        </div>
                        <div class="row card-header bg-light">
                            <div class="col-auto" style="margin-right: 25.4%">
                                <label for="email" class="col-form-label">Email</label>
                            </div>
                            <div class="col-md-7">
                                <input type="text" name="email" class="form-control form-control-sm @error('email') is-invalid @enderror" aria-describedby="email" placeholder="" value="{{old('email')}}">
                            </div>
                        </div>
                        <div class="row card-header bg-light">
                            <div class="col-auto" style="margin-right: 24%">
                                <label for="name" class="col-form-label">Gender</label>
                            </div>
                            <div class="col-auto mt-2 ps-2">
                                <h4 class="small"></h4>
                            </div>
                        </div>
                        <div class="row card-header bg-light mb-3">
                            <div class="col-auto" style="margin-right: 19.5%">
                                <label for="name" class="col-form-label">Date of Birth</label>
                            </div>
                            <div class="col-auto mt-2 ps-1">
                                <h4 class="small"></h4>
                            </div>
                        </div>
                    </div>
                    <div class="row float-end">
                        <button class="btn btn-primary" type="submit">Update</button>
                    </div>
                </form>
            </div>
            <br>
            <br>
            <div>
                @if(session()->has('passwordChangeError'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{session('passwordChangeError')}}
                        <button type="button" class="btn btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <h3 class="fw-bold mb-3">Account</h3>
                <form action="/password-update" method="post" enctype="multipart/form-data">
                    @csrf
                    <div>
                        <div class="row card-header bg-light">
                            <div class="col-auto" style="margin-right: 18.8%">
                                <label for="oldpass" class="col-form-label">Old Password</label>
                            </div>
                            <div class="col-md-7">
                                <input type="password" name="oldpass" class="form-control form-control-sm @error('oldpass') is-invalid @enderror" aria-describedby="oldpass">
                            </div>
                        </div>
                        <div class="row card-header bg-light">
                            <div class="col-auto" style="margin-right: 18%">
                                <label for="newpass" class="col-form-label">New Password</label>
                            </div>
                            <div class="col-md-7">
                                <input type="password" name="newpass" class="form-control form-control-sm @error('newpass') is-invalid @enderror" aria-describedby="newpass">
                            </div>
                        </div>
                        <div class="row card-header bg-light mb-3">
                            <div class="col-auto" style="margin-right: 9.5%">
                                <label for="confnewpass" class="col-form-label">Confirm New Password</label>
                            </div>
                            <div class="col-md-7">
                                <input type="password" name="confnewpass" class="form-control form-control-sm @error('confnewpass') is-invalid @enderror" aria-describedby="confnewpass">
                            </div>
                        </div>
                    </div>
                    <div class="row float-end">
                        <button class="btn btn-primary" type="submit">Update</button>
                    </div>
                </form>
            </div>
            <h1 class="text-light">.</h1>
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
