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
        <title>@yield('title')</title>
    </head>
    <body class="bg-light">
        <nav class="navbar navbar-light p-1 pt-0">
            <div class="container-fluid">
                <a class="navbar-brand fs-2 fw-bold ps-5 pt-3" href="/home" data-toggle="tooltip" title="Home" style="font-family: Alander,sans-serif; color: #7DC241; text-decoration: none;">
                    reztya
                </a>
                <div class="position-absolute" style="margin-left: 18%">
                    <a class="link-success" href="/services" style="text-decoration: none; font-family: 'Futura Md BT', sans-serif; font-size: 110%;">
                        Services
                    </a>
                </div>
                <div class="position-absolute" style="margin-left: 31%">
                    <a class="link-success" href="/products" style="text-decoration: none; font-family: 'Futura Md BT', sans-serif; font-size: 110%;">
                        Products
                    </a>
                </div>
                @auth
                    @if(auth()->user()->role == 'admin')

                    @endif
                @endauth
                @auth

                @else
                    <div class="pe-5">
                        <a class="link-success pe-4" href="/signin" style="text-decoration: none; font-family: 'Futura Md BT', sans-serif; font-size: 110%;">
                            Sign in
                        </a>
                        <a class="link-success" href="/signup" style="text-decoration: none; font-family: 'Futura Md BT', sans-serif; font-size: 110%;">
                            Sign up
                        </a>
                    </div>
                @endauth
            </div>
        </nav>
        <div class="container mt-4">@yield('container')</div>
        <footer class="footer fixed-bottom pb-2 bg-light" style="">
            <div class="container text-center pt-2">
                <a style="text-decoration: none; font-size: 12px; color: #00A54F" href="/home" data-toggle="tooltip" title="Home">
                    © 2022 Reztya Medika Clinic. All rights reserved.
                </a>
            </div>
        </footer>
        <!-- JavaScript Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
    </body>
</html>
