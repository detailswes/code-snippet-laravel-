@extends('layouts.auth')
@section('title') Forget Password @stop
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
                    <form action="{{route('forget.password.request')}}" method="POST">
                        <h6 class="mb-4 ">Forgot password?</h6>
                        @if (session()->has('success'))
                        <x-flash-message type="success" :message="session('success')" />
                        @endif
                        @csrf
                        <div class="form-group row">

                            <div class="col-lg-12 col-xl-12">

                                <input type="email" class="form-control" placeholder="Email" name="email" value="">
                            </div>
                            @error('email')
                            <span class=" col-md-6 text-danger"> {{$message}} </span>
                            @enderror
                        </div>
                        <div class="form-group row has-float-label mb-4 ">
                            <a class="btn btn-link text-left" href="{{ route('admin.login')}}">Login</a>
                            <button type="submit" class="btn btn-primary float-right mr-3" onclick=" toggleLoader( 'block');">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection