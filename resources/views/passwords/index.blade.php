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
                        @if(sizeof($passwords) == 0)
                            <div class="row justify-content-center">
                                <span>You have no passwords here.</span>
                            </div>
                        @else
                            @foreach($passwords as $password)
                                @if($password->user_id == Auth::user()->id)
                                    <h6 class="row justify-content-center"><b>Password #{{ $password->id }}</b></h6>
                                    <p><b>Login: </b>{{ $password->login }} |
                                        <b>Password: </b>
                                        <label
                                            id="encryptedPasswordLabel{{$password->id}}">{{ $password->password }}
                                        </label>
                                    </p>
                                    <p><b>Web Address: </b>{{ $password->web_address }}</p>
                                    <p><b>Description:</b></p>
                                    <p>{{ $password->description }}</p>

                                    @if(Auth::user()->id == $password->owner_id)
                                        <div class="row justify-content-center">
                                            <a href="/share/{{$password->id}}">Share password</a> |
                                            @if(\Illuminate\Support\Facades\Cache::get('isInReadMode') == false)
                                                <a href="/passwords/{{ $password->id }}/delete">Delete Password</a> |
                                                <a href="/passwords/{{ $password->id }}/edit">Edit Password</a>
                                            @else
                                                <div class="popup" onclick="deletePopupFunction({{$password->id}})">
                                                    Delete Password
                                                    <span class="popuptext" id="deletePopup{{$password->id}}">
                                                        You have to switch to
                                                        the modify mode to delete a password.</span>
                                                </div> |
                                                <div class="popup" onclick="editPopupFunction({{$password->id}})">
                                                    Edit Password
                                                    <span class="popuptext" id="editPopup{{$password->id}}">
                                                        You have to switch to the
                                                        modify mode to edit a password.</span>
                                                </div>
                                            @endif
                                        </div>
                                    @endif

                                    @if(Auth::user()->id != $password->owner_id)
                                        <div class="row justify-content-center">
                                            <div class="popup"
                                                 onclick="shareNotByAnOwnerPopupFunction({{$password->id}})">
                                                Share Password
                                                <span class="popuptext" id="shareNotByAnOwnerPopup{{$password->id}}">
                                                    You have to be an owner to share a password.</span>
                                            </div> |
                                            <div class="popup"
                                                 onclick="deleteNotByAnOwnerPopupFunction({{$password->id}})">
                                                Delete Password
                                                <span class="popuptext" id="deleteNotByAnOwnerPopup{{$password->id}}">
                                                    You have to be an owner to delete a password.</span>
                                            </div> |
                                            <div class="popup"
                                                 onclick="editNotByAnOwnerPopupFunction({{$password->id}})">
                                                Edit Password
                                                <span class="popuptext" id="editNotByAnOwnerPopup{{$password->id}}">
                                                    You have to be an owner to edit a password.</span>
                                            </div>
                                        </div>
                                    @endif
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
                        <hr>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
