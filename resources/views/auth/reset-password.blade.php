@extends('layouts.auth')
@section('content')
<div class="container">
    <div class="row h-100">
        <div class="col-12 col-md-8 col-lg-6 mx-auto my-auto">
            <div class="card auth-card">
                <div class="loadingwrap" style="display:none;">
                    <div class="loading">
                    </div>
                </div>
                <div class="card-body">
                    <span class="logo d-block mb-3"></span>
                    @if (session('success'))
                    <div class="alert alert-success text-center msg" id="success">
                        <strong>{{ session('success') }}</strong>
                    </div>
                    @endif
                    @if (session('error'))
                    <div class="alert alert-danger text-center msg" id="error">
                        <strong>{{ session('error') }}</strong>
                    </div>
                    @endif
                    <form action="{{route('change.password')}}" method="POST">
                        <h6 class="mb-4 text-left">Reset password</h6>
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">
                        <div class="form-group row">
                            <!-- <label class="col-lg-4 col-xl-3 col-form-label">New Password</label> -->
                            <div class="col-lg-12 col-xl-12">
                                <input type="password" class="form-control" placeholder="Password" name="new_password" value="">
                            </div>
                            @error('new_password')
                            <span class=" col-md-6 text-danger text-left pt-1"> {{$message}} </span>
                            @enderror
                        </div>
                        <div class="form-group row">
                            <!-- <label class="col-lg-4 col-xl-3 col-form-label">Confirm Password</label> -->
                            <div class="col-lg-12 col-xl-12">
                                <input type="password" class="form-control" placeholder="Password Confirmation " name="password_confirmation" value="">
                            </div>
                            @error('password_confirmation')
                            <span class=" col-md-12 text-danger text-left pt-1"> {{$message}} </span>
                            @enderror
                        </div>
                        <div class="form-row mt-4">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary btn-lg btn-shadow uppercase_button float-right" onclick=" toggleLoader( 'block');">
                                    Update Password
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection