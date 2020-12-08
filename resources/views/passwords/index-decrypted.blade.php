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
                                @if($password->user_id == Auth::user()->id)
                                    <p><b>Login: </b>{{ $password->login }} |
                                        <b>Password: </b>
                                        <label>{{\App\Http\Controllers\PasswordController::decryptPassword($password->password, App\User::find($password->owner_id)->key)}}</label>
                                    </p>
                                    <p><b>Web Address: </b>{{ $password->web_address }}</p>
                                    <p><b>Description:</b></p>
                                    <p>{{ $password->description }}</p>
                                    {{--                                    <p>{{$password->owner_id}}</p>--}}
                                    @if(Auth::user()->id == $password->owner_id)
                                        <a href="/share/{{$password->id}}">Share password</a>
                                        <a href="#">Delete Password</a>
                                        <a href="#">Modify Password</a>
                                    @endif

                                    <hr>
                                @endif
                            @endforeach
                            <form method="GET" action="{{route('home')}}">
                                <div class="form-group row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            Encrypt Passwords
                                        </button>
                                    </div>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
