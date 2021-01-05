@extends('layouts.master')

@section('header')
    @include('elements.header')
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Registered Activity') }}</div>
                    <div class="card-body">
                        <div class="col-md-12">
                            <hr>
                            <p class="row justify-content-center">Data for {{Cache::get('registeredActivity')}} records</p>
                            <hr>
                            <div class="row justify-content-center">
                                <a class="activity-filter" href="/activity/all">All</a>
                                <a class="activity-filter" href="/activity/create">Create</a>
                                <a class="activity-filter" href="/activity/read">Read</a>
                                <a class="activity-filter" href="/activity/update">Update</a>
                                <a class="activity-filter" href="/activity/delete">Delete</a>
                                <a class="activity-filter" href="/activity/modifymode">Modify Mode</a>
                                <a class="activity-filter" href="/activity/readmode">Read Mode</a>
                            </div>
                            <hr>
                        </div>
                        <div class="col-md-12">
                            @include('activity.list')
                            <hr>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
