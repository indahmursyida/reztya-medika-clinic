<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="http://fonts.cdnfonts.com/css/alander" rel="stylesheet">
    <link href="http://fonts.cdnfonts.com/css/futura-md-bt" rel="stylesheet">
    <link rel="stylesheet" href="{{ url('css/index.css') }}">
    <title>@yield('title')</title>
</head>
<body class="bg-light">
<nav class="navbar navbar-light p-1 pt-0">
    <div class="container-fluid pt-1">
        <a class="navbar ps-4" href="/home" style="max-width: 15%;">
            <img src="{{url('storage/reztya_logo.png')}}" data-toggle="tooltip" title="Home" style="max-width: 80%;">
        </a>
        @auth
            @if(auth()->user()->user_role_id == 1)
                <div class="col-2 mb-2">
                    <a class="text-reztya font-futura-reztya fs-6 text-decoration-none" href="/services">
                        Layanan Perawatan
                    </a>
                </div>
                <div class="col-2 mb-2">
                    <a class="text-reztya font-futura-reztya fs-6 text-decoration-none" href="/products">
                        Produk
                    </a>
                </div>
                <div class="col-2 mb-2">
                    <a class="text-reztya font-futura-reztya fs-6 text-decoration-none" href="/manage-services">
                        Kelola Layanan Perawatan
                    </a>
                </div>
                <div class="col-2 mb-2">
                    <a class="text-reztya font-futura-reztya fs-6 text-decoration-none" href="/manage-products">
                        Kelola Produk
                    </a>
                </div>
            @else
                <div class="col-2 mb-2">
                    <a class="text-reztya font-futura-reztya fs-6 text-decoration-none" href="/services">
                        Layanan Perawatan
                    </a>
                </div>
                <div class="col-6 mb-2">
                    <a class="text-reztya font-futura-reztya fs-6 text-decoration-none" href="/products">
                        Produk
                    </a>
                </div>
            @endif
        @else
            <div class="col-2 mb-2">
                <a class="text-reztya font-futura-reztya fs-6 text-decoration-none" href="/services">
                    Layanan Perawatan
                </a>
            </div>
            <div class="col-6 mb-2">
                <a class="text-reztya font-futura-reztya fs-6 text-decoration-none" href="/products">
                    Produk
                </a>
            </div>
        @endauth
        @auth
            <div class="col-2">
                <div class="row align-items-start">
                    <div class="font-futura-reztya text-reztya dropdown">
                        <p class="fs-6 dropdown-toggle" type="button" id="dropdownToggle" data-bs-toggle="dropdown" aria-expanded="false">
                            Welcome, {{auth()->user()->username}}
                        </p>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu">
                            <li><a class="button-outline-reztya dropdown-item" href="/profile/{{auth()->user()->name}}">Lihat Profil</a></li>
                            <li><a class="button-outline-reztya dropdown-item" href="#">Lihat Order</a></li>
                            <li><a class="button-outline-reztya dropdown-item" href="#">Lihat Order Aktif</a></li>
                            @if(auth()->user()->user_role_id == 1)
                                <li><a class="button-outline-reztya dropdown-item" href="#">Ban / Unban Akun</a></li>
                            @endif
                            <li>
                                <form method="POST" action="/signout">
                                    @csrf
                                    <button type="submit" class="button-outline-reztya dropdown-item font-futura-reztya">Keluar</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        @else
            <div class="pe-5 mb-2">
                <a class="link-success pe-4" href="/signin" style="text-decoration: none; font-family: 'Futura Md BT', sans-serif; font-size: 110%;">
                    Masuk
                </a>
                <a class="link-success" href="/signup" style="text-decoration: none; font-family: 'Futura Md BT', sans-serif; font-size: 110%;">
                    Daftar
                </a>
            </div>
        @endauth
    </div>
</nav>
<div class="container mt-4">@yield('container')</div>
<footer class="unselectable footer fixed-bottom pb-1 bg-white">
    <div class="container text-center pt-1">
        <a style="text-decoration: none; font-size: 12px; color: #00A54F" href="/home" data-toggle="tooltip" title="Home">
            © 2022 Reztya Medika Clinic. All rights reserved.
        </a>
    </div>
</footer>
<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
</body>
</html>
