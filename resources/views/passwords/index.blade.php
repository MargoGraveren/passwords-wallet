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

                        @if(sizeof($passwords) == 0)
                            <div class="row justify-content-center">
                                <span>You have no passwords here.</span>
                            </div>
                        @else
                            @foreach($passwords as $password)
                                @if($password->user_id == Auth::user()->id)
                                    <p><b>Login: </b>{{ $password->login }} |
                                        <b>Password: </b><label
                                            id="encryptedPasswordLabel{{$password->id}}">{{ $password->password }}</label>
                                    </p>
                                    <p><b>Web Address: </b>{{ $password->web_address }}</p>
                                    <p><b>Description:</b></p>
                                    <p>{{ $password->description }}</p>
                                    <a href="/share/{{$password->id}}">Share password</a>
                                    <hr>
                                @endif
                            @endforeach
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button onclick="window.location='{{ route("decrypted") }}'"
                                            class="btn btn-primary">
                                        Decrypt Passwords
                                    </button>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
