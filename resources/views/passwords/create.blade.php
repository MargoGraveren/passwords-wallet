@extends('layouts.master')

@section('header')
    @include('elements.header')
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    @if(Auth::user()->isPasswordKeptHash)
                        <div class="card-header">{{ __('Add Password with SHA512') }}</div>
                    @else
                        <div class="card-header">{{ __('Add Password with HMAC') }}</div>
                    @endif
                    <div class="card-body">
                        <hr>
                        <form method="POST" action="{{route('passwords.store')}}">
                            @csrf
                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password"
                                           class="form-control @error('password') is-invalid @enderror" name="password"
                                           value="{{ old('password') }}" required autocomplete="name" autofocus>

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="web_address" class="col-md-4 col-form-label text-md-right">{{ __('Web Address') }}</label>

                                <div class="col-md-6">
                                    <input id="web_address" type="text"
                                           class="form-control @error('web_address') is-invalid @enderror" name="web_address"
                                           value="{{ old('web_address') }}" required autocomplete="web_address" autofocus>

                                    @error('web_address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="login" class="col-md-4 col-form-label text-md-right">{{ __('Login') }}</label>

                                <div class="col-md-6">
                                    <input id="login" type="text"
                                           class="form-control @error('login') is-invalid @enderror" name="login"
                                           value="{{ old('login') }}" required autocomplete="login" autofocus>

                                    @error('login')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('Description') }}</label>

                                <div class="col-md-6">
                                    <textarea id="description" type="text" rows="7"
                                           class="form-control @error('description') is-invalid @enderror" name="description"
                                              required autocomplete="description" autofocus></textarea>

                                    @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Add Password') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                        <hr>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
