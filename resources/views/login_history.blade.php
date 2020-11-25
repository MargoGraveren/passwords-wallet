@extends('layouts.master')

@section('header')
    @include('elements.header')
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Login History') }}</div>
                    <div class="card-body">
                        <div class="col-md-12">
                            <table class="login-history row justify-content-center">
                                <tr class="login-history-title">
                                    <td class="login-history-element">
                                        <p>IP Address</p>
                                    </td>
                                    <td class="login-history-element">
                                        <p>Login Result</p>
                                    </td>
                                    <td class="login-history-element">
                                        <p>Date and Hour of Login</p>
                                    </td>
                                </tr>
                                @foreach($userLogins as $userLogin)
                                    @if($userLogin->user_id == Auth::user()->id)
                                        <tr>
                                            <td class="login-history-element">
                                                {{ $userLogin->IP_address }}
                                            </td>
                                            <td class="login-history-element">
                                                {{ $userLogin->login_result }}
                                            </td>
                                            <td class="login-history-element">
                                                {{ $userLogin->created_at }}
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
