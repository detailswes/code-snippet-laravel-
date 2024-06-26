@extends('layouts.admin')
@section('title') {{ __('Forbidden') }} @stop
@push('styles')
    <style>
    .card.authorized_card {
        max-width: 400px;
        margin: 60px auto;
        font-size: 22px;
        text-align: center;
        font-weight: bold;
        border-top: 3px solid #d63434;
        border-radius: 0px;
    }
    .row.dashboard-columns.authorized_col {
        min-height: 80vh;
        -webkit-box-align: center;
            -ms-flex-align: center;
                align-items: center;
    }
    </style>
@endpush
@section('content')
<div class="container-fluid">
    <div class="row dashboard-columns authorized_col">
        <div class="col-xl-12 col-md-12 mb-3 mb-md-4">
            <div class="card authorized_card" style="background-color: #ffffff; color:#d63434;">
                <div class="card-block">
                    <div class="row align-items-end">
                        <div class="col-lg-12">
                            {{ $exception->getMessage() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
