<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <!-- CSS only -->
        <link href="resources/css/bootstrap.min.css" rel="stylesheet">
        <!-- Fonts -->
        <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <title>@yield('title')</title>
    </head>
    <body class="bg-light">
        <nav class="navbar navbar-light bg-light p-2 pt-2">
            <div class="navbar-brand">
                <a class="fs-4 fw-bold ps-5 text-dark" href="/home" data-toggle="tooltip" title="Home" style="text-decoration: none;">
                    Reztya Medika Clinic
                </a>
            </div>
            <div class="pe-5">
                <a href="/services" style="text-decoration: none;">
                    <button class="btn btn-primary" type="button">Services</button>
                </a>
                <a href="/products" style="text-decoration: none;">
                    <button class="btn btn-outline-primary" type="button">Products</button>
                </a>
            </div>
            @auth
                @if(auth()->user()->role == 'admin')
                    <div class="navbar-text">
                        <a class="h6 text-muted text-dark" href="/game" data-toggle="tooltip" title="Home" style="text-decoration: none;">Manage Game</a>
                    </div>
                    <div class="navbar-text" >
                        <a class="h6 text-muted text-dark" href="/genre/index" data-toggle="tooltip" title="Home" style="text-decoration: none;">Manage Game Genre</a>
                    </div>
                @endif
            @endauth
            @auth
                <div class="me-5">
                    <div class="row align-items-start">
                        <div class="col">
                            <a href="/cart">
                                <svg xmlns="http://www.w3.org/2000/svg" width="26" fill="currentColor" class="bi bi-cart3 img-fluid mt-2" viewBox="0 0 16 16">
                                    <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .49.598l-1 5a.5.5 0 0 1-.465.401l-9.397.472L4.415 11H13a.5.5 0 0 1 0 1H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l.84 4.479 9.144-.459L13.89 4H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                                </svg>
                            </a>
                        </div>
                        <div class="col">
                            <div class="dropdown">
                                <img width="60px" src="{{asset('storage/'.auth()->user()->profile_picture)}}" class="bg-secondary img-thumbnail dropdown-toggle rounded-circle" type="button" id="profilePicture" data-bs-toggle="dropdown" aria-expanded="false" alt="Profile Picture">
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenu">
                                    <li><a class="dropdown-item disabled text-black">Hi, {{auth()->user()->name}}</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="/profile/{{auth()->user()->name}}">Your Profile</a></li>
                                    <li><a class="dropdown-item" href="/transaction/history">Transaction History</a></li>
                                    <li>
                                        <form method="post" action="/signout">
                                            @csrf
                                            <button type="submit" class="dropdown-item">Sign out</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="pe-5">
                    <a href="/signin" style="text-decoration: none;">
                        <button class="btn btn-primary" type="button">Sign in</button>
                    </a>
                    <a href="/signup" style="text-decoration: none;">
                        <button class="btn btn-outline-primary" type="button">Sign up</button>
                    </a>
                </div>
            @endauth
        </nav>
        <div class="container mt-4">@yield('container')</div>
        <footer class="footer fixed-bottom pb-2" style="background-color: #D9D9D9">
            <div class="container text-center pt-2">
                <a class="text-secondary" style="text-decoration: none; font-size: 12px; color: #7C7C7C" href="/home" data-toggle="tooltip" title="Home">
                    © 2022 Reztya Medika Clinic. All rights reserved.
                </a>
            </div>
        </footer>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
        <script src="resources/js/bootstrap.bundle.min.js"></script>
    </body>
</html>

