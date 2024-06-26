@extends('layouts.admin')
@section('title') {{ 'Dashboard' }} @stop
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 pt-4">
                <h1>Dashboard</h1>
                <div class="separator mb-4"></div>
            </div>
        </div>

        <div class="row dashboard-columns">
            <div class="col-xl-3 col-md-6 mb-3 mb-md-4">
                <div class="card" style="background-color: #a8c8d8; color:white;">
                    <div class="card-block">
                        <div class="row align-items-end">
                            <div class="col-lg-12">
                                <h3 class="m-b-0">Users<a title="Users" href="#" class="float-right"><i
                                            class="dash-icon iconsminds-conference" style="color: white;"></i></a></h3>
                                <h4>{{ $data['users'] }}</h4>
                                <h6 class="action-fn m-b-0"><a title="Users" class="stretched-link"
                                        href="{{ route('users.index') }}" style="color:white;">View
                                        all</a></h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection
