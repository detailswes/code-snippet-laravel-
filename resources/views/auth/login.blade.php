@extends('layouts.auth')
@section('title') Login @stop
@section('content')
    <div class="container">
        <div class="row h-100">
            <div class="loadingwrap" style="display: none;">
                <div class="loading">
                </div>
            </div>
            <div class="col-12 col-md-8 col-lg-6 mx-auto my-auto">
                <div class="card auth-card">
                    <div class="form-side">
                        <span class="logo d-block mb-3"></span>
                        </a>
                        <h6 class="mb-4" id="login-text">Login</h6>
                        @if (session()->has('success'))
                            <x-flash-message type="success" :message="session('success')" />
                        @endif
                        @if (session()->has('error'))
                            <x-flash-message type="danger" :message="session('error')" />
                        @endif
                        <form method="POST" id="login-submit">
                            @csrf
                            <label class="form-group has-float-label mb-4">
                                <input type="email" class="form-control" name="email" id="email"
                                    value="{{ old('email') }}">
                                <span>E-mail</span>
                            </label>
                            <label class="form-group has-float-label mb-4">
                                <input type="password" class="form-control" name="password" id="password">
                                <span>Password</span>
                            </label>
                            <div class="checkbox pull-right">

                                <a href=" {{ route('forget.password') }}" class="btn btn-link float-right">Forget
                                    password?</a>
                            </div>
                            {{-- <div class=" form-group has-float-label mb-4"> --}}
                            {{-- <a href="{{ route('forget.password') }}">Forget password?</a> --}}
                            {{-- <button type="submit" class="btn btn-primary float-right">LOGIN</button>
                            </div> --}}
                            <div class=" form-group mb-4">
                                <button type="submit" class=" form-group btn btn-primary w-100 mb-0" sty>LOGIN</button>
                            </div>

                            <div class="form-group text-center mt-2 mb-0">
                                <a href=" {{ route('user.register') }}" class="btn btn-link ">Don't have an account? Sign
                                    Up</a>

                            </div>
                    </div>
                </div>
            @endsection
            @push('extra_scripts')
                <script src="{{ url('js/auth/login.js') }}"></script>
            @endpush
