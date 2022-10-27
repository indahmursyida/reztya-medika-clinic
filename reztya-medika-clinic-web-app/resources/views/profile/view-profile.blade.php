@extends('layout/main')
@section('title', 'Profile')

@section('container')
    <div class="unselectable container bg-white sign-box">
        @if(session()->has('updateError'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{session('updateError')}}
                <button type="button" class="btn btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="pt-3 mb-4">
            <div class="d-flex justify-content-center">
                <p class="h5 fw-bold unselectable font-alander-reztya">Profil</p>
            </div>
        </div>
        <div class="d-flex justify-content-center mt-2 bg-white font-futura-reztya">
            <div class="profile-box">
                <div class="card outline-reztya">
                    <ul class="list-group">
                        <li class="list-group-item list-group-item-view">
                            <div class="row row-profile">
                                <div class="ms-4 col-3 view-profile-img">
                                    <img width="120px" src="storage/profile-images/profile_picture_default.jpg" class="bg-secondary img-thumbnail rounded-circle" id="preview" aria-expanded="false" alt="Profile Picture">
                                </div>
                                <div class="col-9 mt-4 ms-3">
                                    <div class="row">
                                        <div class="col-auto mb-1">
                                            <a href="/edit-profile" style="text-decoration: none">
                                                <h5 class="fw-bold text-reztya">{{auth()->user()->full_name}}</h5>
                                            </a>
                                        </div>
                                        <div class="row">
                                            <div class="col-4">
                                                <div>
                                                    <h6>{{auth()->user()->birth_date}}</h6>
                                                </div>
                                                <div>
                                                    <h6 class="text-wrap">{{auth()->user()->address}}</h6>
                                                </div>
                                            </div>
                                            <div class="col-8">
                                                <div>
                                                    <h6>{{auth()->user()->phone_number}}</h6>
                                                </div>
                                                <div>
                                                    <h6>{{auth()->user()->email}}</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="row mt-5 ms-1-5 mb-4">
                    <div class="col-6 active-order-box">
                        <div class="card outline-reztya">
                            <button href="/active-order" class="card-header text-white btn button-outline-reztya button-active-order">
                                <h5 class="mt-1 d-flex justify-content-start">Active Order</h5>
                            </button>
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <h6 class="fw-bold">Order Date</h6>
                                </li>
                                <li class="list-group-item">
                                    <ul class="row list-unstyled">
                                        <li class="h6 col-6 fw-bold list-unstyled">Services</li>
                                        <li class="col-6 fw-bold list-unstyled">Rp 300,000</li>
                                    </ul>
                                    <ul class="list-group mb-2">
                                        <li class="list-group-item list-group-flush">
                                            Service Name
                                        </li>
                                        <li class="list-group-item">
                                            Quantity
                                        </li>
                                        <li class="list-group-item">
                                            Schedule
                                        </li>
                                    </ul>
                                    <ul class="list-group mb-3">
                                        <ul class="row list-unstyled">
                                            <li class="h6 col-6 fw-bold list-unstyled">Products</li>
                                            <li class="col-6 fw-bold list-unstyled">Rp 300,000</li>
                                        </ul>
                                        <li class="list-group-item">
                                            Product Name
                                        </li>
                                        <li class="list-group-item">
                                            Quantity
                                        </li>
                                    </ul>
                                    <ul class="list-group">
                                        <ul class="row list-unstyled">
                                            <li class="h6 col-6 fw-bold list-unstyled">Total Cost</li>
                                            <li class="col-6 fw-bold list-unstyled">Rp 600,000</li>
                                        </ul>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-6 me-2-5">
                        <div class="card outline-reztya">
                            <button href="/order-history" class="card-header text-white btn button-outline-reztya button-history-order">
                                <h5 class="mt-1 d-flex justify-content-start">Order History</h5>
                            </button>
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <h6 class="fw-bold">Order Date</h6>
                                </li>
                                <li class="list-group-item">
                                    <ul class="row list-unstyled">
                                        <li class="h6 col-6 fw-bold list-unstyled">Services</li>
                                        <li class="col-6 fw-bold list-unstyled">Rp 300,000</li>
                                    </ul>
                                    <ul class="list-group mb-2">
                                        <li class="list-group-item list-group-flush">
                                            Service Name
                                        </li>
                                        <li class="list-group-item">
                                            Quantity
                                        </li>
                                        <li class="list-group-item">
                                            Schedule
                                        </li>
                                    </ul>
                                    <ul class="list-group mb-3">
                                        <ul class="row list-unstyled">
                                            <li class="h6 col-6 fw-bold list-unstyled">Products</li>
                                            <li class="col-6 fw-bold list-unstyled">Rp 300,000</li>
                                        </ul>
                                        <li class="list-group-item">
                                            Product Name
                                        </li>
                                        <li class="list-group-item">
                                            Quantity
                                        </li>
                                    </ul>
                                    <ul class="list-group">
                                        <ul class="row list-unstyled">
                                            <li class="h6 col-6 fw-bold list-unstyled">Total Cost</li>
                                            <li class="col-6 fw-bold list-unstyled">Rp 600,000</li>
                                        </ul>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
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
