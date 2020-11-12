<!DOCTYPE html>
<html>
<head>
    <title>Simple Passwords Wallet</title>
    <meta name=viewport content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href={{ URL::asset('css/style.css') }}>
    <link rel="stylesheet"
          href="{{ URL::asset('https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css') }}"
          integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet"
          href={{ URL::asset('https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css') }}>
    <script src="{{ URL::asset('https://kit.fontawesome.com/695d2140c6.js') }}" crossorigin="anonymous"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>
<body>
<header onload="styleTogglerMenu()">
    @yield('header')
</header>
<hr>
<div class="container">
    @yield('content')
</div>
<footer>
    <div class="footer-author">
        <div class="author">
            <hr>
            <span>PGarbarz</span>
        </div>
    </div>
</footer>
</body>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
        integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI"
        crossorigin="anonymous"></script>
<script src="{{ URL::asset('js/app.js') }}"></script>
</html>
