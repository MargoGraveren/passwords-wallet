@extends('layouts.master')

@section('header')
    @include('elements.welcome-header')
@endsection

@section('content')
    <h2>Simple Passwords Wallet</h2>
    <hr>
    <p>The Simple Passwords Wallet allows to keep your passwords in the safety and easy way. First and foremore, you can
        choose the type of hash you want to encrypt your passwords in the moment of registration. </p>
    <p>All informations you
        need to enter are the website address with password you want to save, login and short description of the page
        which allows to find needed password on the list in the fastest way.</p>
    <p>When you want to change the main passwords, you need to know thay all encrypted passwords also get a new hash.</p>
@endsection
