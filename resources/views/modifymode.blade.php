@extends('layouts.master')

@section('header')
    @include('elements.header')
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Modify Mode') }}</div>
                    <div class="card-body">
                        <h5>Welcome to the Modify Mode!</h5>
                        <hr>
                        <p>In the Read Mode, you have a possibility to overview your passwords,
                        share them to other users of Simple Passwords Wallet or create a new one.</p>
                        <p>To get an option of editing and deleting your passwords, yu have to get into
                            the Modify Mode</p>
                        <p>The Modify Mode allows you to have full funcionality of the Simple Passwords Wallet.</p>
                        <hr>
                        @if(\Illuminate\Support\Facades\Cache::get('isInReadMode')  == true)
                            <p class="row justify-content-center">Your current mode is: Read mode</p>
                            <hr>
                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button class="btn btn-primary" type="button"
                                            onclick="window.location='{{ url("/modifymodeon") }}'">
                                        Switch to the Modify Mode
                                    </button>
                                </div>
                            </div>
                        @else
                            <p class="row justify-content-center">Your current mode is: Modify mode</p>
                            <hr>
                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button class="btn btn-primary" type="button"
                                            onclick="window.location='{{ url("/modifymodeoff") }}'">
                                        Switch to the Read Mode
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
