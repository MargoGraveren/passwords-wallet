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
                                    @if(Auth::user()->id == $password->owner_id)
                                        <div class="row justify-content-center">
                                            <a href="/share/{{$password->id}}">Share password</a> |
                                            @if(\Illuminate\Support\Facades\Cache::get('isInReadMode') == false)
                                                <a href="/passwords/{{ $password->id }}">Delete Password</a> |
                                                <a href="/passwords/{{ $password->id }}/edit">Edit Password</a>
                                            @else
                                                <div class="popup" onclick="deletePopupFunction({{$password->id}})">Delete Password
                                                    <span class="popuptext" id="deletePopup{{$password->id}}">You have to switch to
                                                        the modify mode to delete a password.</span>
                                                </div> |
                                                <div class="popup" onclick="editPopupFunction({{$password->id}})">Edit Password
                                                    <span class="popuptext" id="editPopup{{$password->id}}">You have to switch to the
                                                        modify mode to edit a password.</span>
                                                </div>
                                            @endif

                                        </div>
                                    @endif

                                    @if(Auth::user()->id != $password->owner_id)
                                        <div class="row justify-content-center">
                                            <div class="popup" onclick="shareNotByAnOwnerPopupFunction({{$password->id}})">Share Password
                                                <span class="popuptext" id="shareNotByAnOwnerPopup{{$password->id}}">You have to be an owner
                                                    to share a password.</span>
                                            </div> |
                                            <div class="popup" onclick="deleteNotByAnOwnerPopupFunction({{$password->id}})">Delete Password
                                                <span class="popuptext" id="deleteNotByAnOwnerPopup{{$password->id}}">You have to be an owner
                                                    to delete a password.</span>
                                            </div> |
                                            <div class="popup" onclick="editNotByAnOwnerPopupFunction({{$password->id}})">Edit Password
                                                <span class="popuptext" id="editNotByAnOwnerPopup{{$password->id}}">You have to be an owner
                                                    to edit a password.</span>
                                            </div>
                                        </div>
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
