@extends('layouts.master')

@section('header')
    @include('elements.header')
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Blocked IPs') }}</div>
                    <div class="card-body">
                        <div class="col-md-12">
                            <table class="login-history row justify-content-center">
                                @if(sizeof($blockedIps) == 0)
                                    <tr>
                                        <div class="row justify-content-center">
                                            <span>You have no blocked IPs.</span>
                                        </div>
                                    </tr>
                                @else
                                    <tr class="login-history-title">
                                        <td class="login-history-element">
                                            <p>IP Address</p>
                                        </td>
                                        <td class="login-history-element">
                                            <p>Date and Hour of Block</p>
                                        </td>
                                        <td>

                                        </td>
                                    </tr>

                                    @foreach($blockedIps as $blockedIp)
                                        @if($blockedIp->user_id == Auth::user()->id)
                                            <tr>
                                                <td class="login-history-element">
                                                    {{ $blockedIp->IP_address }}
                                                </td>
                                                <td class="login-history-element">
                                                    {{ $blockedIp->created_at }}
                                                </td>
                                                <td>
                                                    <a href="/blocked/{{ $blockedIp->id }}">Delete Block</a>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                @endif
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
