@extends('layouts.master')

@section('header')
    @include('elements.header')
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Registered Passwords Changes') }}</div>
                    <div class="card-body">
                        <div class="col-md-12">
                            <table class="login-history row justify-content-center">
                                @if(sizeof($dataChanges) == 0)
                                    <tr>
                                        <div class="row justify-content-center">
                                            <span>You have no changes registered.</span>
                                        </div>
                                    </tr>
                                @else
                                    <tr class="login-history-title">
                                        <td class="login-history-element">
                                            <p>Date and Hour of Activity</p>
                                        </td>
                                        <td class="login-history-element">
                                            <p>Password ID</p>
                                        </td>
                                        <td class="login-history-element">
                                            <p>Function</p>
                                        </td>
                                        <td></td>
                                    </tr>
                                    @foreach($dataChanges as $dataChange)
                                        @if($dataChange->user_id == Auth::user()->id)
                                            <tr>
                                                <td class="login-history-element">
                                                    {{ $dataChange->created_at }}
                                                </td>
                                                <td class="login-history-element">
                                                    {{ $dataChange->modified_record_id }}
                                                </td>
                                                <td class="login-history-element">
                                                    {{ $dataChange->actionTypes->action_type }}
                                                </td>
                                                <td class="login-history-element">
                                                    <a href="/details/{{ $dataChange->id }}">Details</a>
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
