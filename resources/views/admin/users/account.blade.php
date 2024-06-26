@extends('layouts.admin')
@section('title')Account  @stop
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1>My Account</h1>
            <div class="separator mb-5"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card mb-4">
                <div class="row">
                <div class="col-md-3">
                    <div class="card-header tabs-header">
                        <ul class="nav nav-tabs vertical-tabs flex-column card-header-tabs " role="tablist">
                            <li class="nav-item">
                            <a class="nav-link active" id="first-tab" data-toggle="tab" href="#first" role="tab"
                                aria-controls="first" aria-selected="true">Basic</a>
                            </li>
                            <li class="nav-item">
                            <a class="nav-link" id="second-tab" data-toggle="tab" href="#second" role="tab"
                                aria-controls="second" aria-selected="false">Reset Password</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="first" role="tabpanel"
                            aria-labelledby="first-tab">
                            <form class="profileform">
                                <div class="row align-items-center">
                                    <div class="col-md-3 profile-picture">
                                        <img  src="{ URL::asset('img/profile-pic-l.jpg') }}"/>
                                    </div>
                                    <div class="col-md-9 profile-info">
                                        <div class="form-group row align-items-center">
                                        <label class="col-lg-3 col-xl-2 col-form-label">First Name</label>
                                        <div class="col-lg-9 col-xl-10 d-flex">
                                            <a href="#" class="" data-type="text">John</a>
                                        </div>
                                        </div>
                                        <div class="form-group row align-items-center">
                                        <label class="col-lg-3 col-xl-2 col-form-label">Last Name</label>
                                        <div class="col-lg-9 col-xl-10 d-flex">
                                            <a href="#" class="" data-type="text">Mark</a>
                                        </div>
                                        </div>
                                        <div class="form-group row align-items-center">
                                        <label class="col-lg-3 col-xl-2 col-form-label">Email</label>
                                        <div class="col-lg-9 col-xl-10 d-flex">
                                            <a href="#" class="" data-type="text">john@gmail.com</a>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            </div>
                            <div class="tab-pane fade" id="second" role="tabpanel" aria-labelledby="second-tab">
                            <div class="col-md-8">
                                <form>
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-xl-3 col-form-label">Old Password</label>
                                        <div class="col-lg-8 col-xl-9 d-flex">
                                        <input type="password" class="form-control" value="">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-xl-3 col-form-label">New Password</label>
                                        <div class="col-lg-8 col-xl-9 d-flex">
                                        <input type="password" class="form-control" value="">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-xl-3 col-form-label">Confirm Password</label>
                                        <div class="col-lg-8 col-xl-9 d-flex">
                                        <input type="password" class="form-control" value="">
                                        </div>
                                    </div>
                                    <div class="form-row mt-4">
                                        <div class="col-md-12">
                                        <button type="button" class="btn btn-primary default btn-lg mb-1 mr-2">Submit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
