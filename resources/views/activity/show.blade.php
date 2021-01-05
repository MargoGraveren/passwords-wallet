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
                                <tr>
                                    <td class="login-history-title" colspan="3">
                                        <hr>
                                        <p class="row justify-content-center">PASSWORD #{{$details->modified_record_id}}</p>
                                        <hr>
                                    </td>
                                </tr>
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
                                <tr>
                                    <td class="login-history-title" colspan="3">
                                        <hr>
                                        <p class="row justify-content-center">PREVIOUS DATA</p>
                                    <hr>
                                    </td>
                                </tr>
                                <tr class="login-history-title">
                                    <td class="login-history-element" colspan="3">
                                        <p>Password</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="login-history-element" colspan="3">
                                        @if($details->previous_value_of_record != null)
                                            <p>{{explode("|", $details->previous_value_of_record)[1]}}</p>
                                        @else
                                            <p>null</p>
                                        @endif
                                    </td>
                                </tr>
                                <tr class="login-history-title">
                                    <td class="login-history-element"><p>Web Address</p></td>
                                    <td class="login-history-element"><p>Login</p></td>
                                    <td class="login-history-element"><p>Description</p></td>
                                </tr>
                                <tr>
                                    <td class="login-history-element">
                                        @if($details->previous_value_of_record != null)
                                            <p> {{explode("|", $details->previous_value_of_record)[2]}}</p>
                                        @else
                                            <p>null</p>
                                        @endif
                                    </td>
                                    <td class="login-history-element">
                                        @if($details->previous_value_of_record != null)
                                            <p>{{explode("|", $details->previous_value_of_record)[3]}}</p>
                                        @else
                                            <p>null</p>
                                        @endif
                                    </td>
                                    <td class="login-history-element">
                                        @if($details->previous_value_of_record != null)
                                            <p>{{explode("|", $details->previous_value_of_record)[4]}}</p>
                                        @else
                                            <p>null</p>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="login-history-title" colspan="3">
                                        <hr>
                                        <p class="row justify-content-center">PRESENT DATA</p>
                                        <hr>
                                    </td>
                                </tr>
                                <tr class="login-history-title">
                                    <td class="login-history-element" colspan="3">
                                        <p>Password</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="login-history-element" colspan="3">
                                        @if($details->present_value_of_record != null)
                                            <p>{{explode("|", $details->present_value_of_record)[1]}}</p>
                                        @else
                                            <p>null</p>
                                        @endif
                                    </td>
                                </tr>
                                <tr class="login-history-title">
                                    <td class="login-history-element"><p>Web Address</p></td>
                                    <td class="login-history-element"><p>Login</p></td>
                                    <td class="login-history-element"><p>Description</p></td>
                                </tr>
                                <tr>
                                    <td class="login-history-element">
                                        @if($details->present_value_of_record != null)
                                            <p> {{explode("|", $details->present_value_of_record)[2]}}</p>
                                        @else
                                            <p>null</p>
                                        @endif
                                    </td>
                                    <td class="login-history-element">
                                        @if($details->present_value_of_record != null)
                                            <p>{{explode("|", $details->present_value_of_record)[3]}}</p>
                                        @else
                                            <p>null</p>
                                        @endif
                                    </td>
                                    <td class="login-history-element">
                                        @if($details->present_value_of_record != null)
                                            <p>{{explode("|", $details->present_value_of_record)[4]}}</p>
                                        @else
                                            <p>null</p>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                            <a href="/details/update/{{$details->id}}">Recovery</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
