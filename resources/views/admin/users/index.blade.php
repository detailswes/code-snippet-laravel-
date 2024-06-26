@extends('layouts.admin')
@section('title') Users @stop
@push('styles')
    @php
        $loggedInUser = auth()->user();
    @endphp
    <link rel="stylesheet" href="{{ url('css/plugins/datatable/datatables.min.css') }}" />
    <link rel="stylesheet" href="{{ url('css/plugins/datatable/buttons.min.css') }}" />
    <link rel="stylesheet" href="{{ url('css/plugins/datatable/datatables.bootstrap4.min.css') }}" />
    <link rel="stylesheet" href="{{ url('css/vendor/jquery-ui.min.css') }}" />
    <link rel="stylesheet" href="{{ url('css/plugins/datatable/datatables.responsive.bootstrap4.min.css') }}" />
@endpush
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 pt-4" id="create">

                <h1>Users</h1>
                @if ($loggedInUser->can('user_create'))
                    <span class="fl_right balance create">
                        <a id="create_user" class="btn btn-primary" href="#" data-toggle="modal"
                            data-backdrop="static" data-target="#user-modal">
                            Create New User
                        </a>
                    </span>
                @endif
                <span class="float-right balance mr-2"><a id="user_filter" class="btn btn-primary"
                        href="#">Filters</a></span>
                <div id="flash-message"></div>
                <div class="separator mb-5"></div>
            </div>
        </div>
        @include('admin.search-filters.users')
        <div class="col-12  mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered data-table" id="myTable">
                            <thead class="bg-primary">
                                <tr>
                                    <th scope="col">S.no</th>
                                    <th scope="col">First Name</th>
                                    <th scope="col">Last Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Role</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Created at</th>
                                    <th scope="col" class="noExport">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@stop
@push('extra_scripts')
    <script src="{{ url('js/plugins/datatable/datatables.min.js') }}"></script>
    <script src="{{ url('js/plugins/datatable/buttons.min.js') }}"></script>
    <script src="{{ url('js/vendor/jszip.min.js') }}"></script>
    <script src="{{ url('js/plugins/datatable/buttons.html5.min.js') }}"></script>
    <script src="{{ url('js/admin/modules/users.js') }}"></script>
@endpush
