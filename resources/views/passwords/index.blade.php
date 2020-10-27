@extends('layouts.master')

@section('header')
    @include('elements.header')
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Your Passwords') }}</div>
                    <div class="card-body">
                        @if($passwords == null)
                            <span>You have no passwords here.</span>
                        @else
                            @foreach($passwords as $password)
                                <p><b>Login: </b>{{ $password->login }} | <b>Password: </b>{{ $password->password }}</p>
                                <p><b>Web Address: </b>{{ $password->web_address }}</p>
                                <p><b>Description:</b></p>
                                <p>{{ $password->description }}</p>
                                {{\App\Http\Controllers\PasswordController::decryptPassword($password->password, Auth::user()->key)}}
                                <br/>
                                <hr>
                            @endforeach
                            @endif


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
