@extends('layouts.master')

@section('header')
    @include('elements.header')
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div
                        class="card-header">{{ __('Registered Changes for Password #'.$details->modified_record_id) }}</div>
                    <div class="card-body">
                        <div class="col-md-12">
                            <table class="login-history row justify-content-center">
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
                                <tr>
                                    <td class="login-history-element">
                                        <p>{{ $details->created_at }}</p>
                                    </td>
                                    <td class="login-history-element">
                                        <p>{{ $details->modified_record_id }}</p>
                                    </td>
                                    <td class="login-history-element">
                                        <p>{{ $details->actionTypes->action_type }}</p>
                                    </td>
                                </tr>
{{--                            </table>--}}
{{--                            <table>--}}
                                <tr class="login-history-title">
                                    <td class="login-history-element" colspan="3">
                                        <p>Password</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="login-history-element" colspan="3">
                                        <p>{{explode("|", $details->previous_value_of_record)[0]}}</p>
                                    </td>
                                </tr>
                                <tr class="login-history-title">
                                    <td class="login-history-element" ><p>Login</p></td>
                                    <td class="login-history-element" ><p>Web Address</p></td>
                                    <td class="login-history-element" ><p>Description</p></td>
                                </tr>
                                <tr>
                                    <td class="login-history-element">
                                        {{explode("|", $details->previous_value_of_record)[1]}}
                                    </td>
                                    <td class="login-history-element">
                                        {{explode("|", $details->previous_value_of_record)[2]}}
                                    </td>
                                    <td class="login-history-element">
                                        {{explode("|", $details->previous_value_of_record)[3]}}
                                    </td>
                                </tr>
                            </table>
                            <a href="#">Recovery</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
