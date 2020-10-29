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
                        <hr>
                        @if($passwords == null)
                            <span>You have no passwords here.</span>
                        @else
                            @foreach($passwords as $password)
                                @if($password->user_id == Auth::user()->id)
                                    <p><b>Login: </b>{{ $password->login }} |
                                        <b>Password: </b>
                                        <label>{{\App\Http\Controllers\PasswordController::decryptPassword($password->password, Auth::user()->key)}}</label>
                                    </p>
                                    <p><b>Web Address: </b>{{ $password->web_address }}</p>
                                    <p><b>Description:</b></p>
                                    <p>{{ $password->description }}</p>
                                    <hr>
                                @endif
                            @endforeach
                            <form method="GET" action="{{route('home')}}">
                                <button>Encrypt Passwords</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
