@extends('layouts.auth')
@section('title') Register @stop
@push('styles')
    {{-- <link rel="stylesheet" href="{{ url('css/live-search.css') }}"> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css" />
@endpush
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
                        <h6 class="mb-4 form-heading" id="login-text">Register</h6>
                        @if (session()->has('success'))
                            <x-flash-message type="success" :message="session('success')" />
                        @endif
                        @if (session()->has('error'))
                            <x-flash-message type="danger" :message="session('error')" />
                        @endif
                        <form method="POST" id="register-submit">
                            @csrf
                            <label class="form-group has-float-label mb-4">
                                <input type="text" class="form-control" name="first_name" id="first_name" value=""
                                    placeholder="First Name">
                                <span>First Name</span>
                            </label>
                            <label class="form-group has-float-label mb-4">
                                <input type="text" class="form-control" name="last_name" id="last_name" value=""
                                    placeholder="Last Name">
                                <span>Last Name</span>
                            </label>
                            <label class="form-group has-float-label mb-4">
                                <input type="email" class="form-control" name="email" id="email" value="">
                                <span>E-mail</span>
                            </label>
                            <label class="form-group has-float-label mb-4">
                                <input id="phone" type="tel"
                                    class="form-control @error('phone') is-invalid @enderror" name="phone" value=""
                                    autocomplete="phone" autofocus>
                                <span>Phone</span>
                            </label>
                            <label class="form-group has-float-label mb-4">
                                <input type="password" class="form-control" name="password" id="password">
                                <span>Password</span>
                            </label>
                            <label class="form-group has-float-label mb-4">
                                <input type="password" class="form-control" name="password_confirmation"
                                    id="password_confirmation" placeholder="">
                                <span>Password Confirmation</span>
                            </label>
                            {{-- <label class="form-group has-float-label mb-4 search ">
                                <select class="form-control select2-single selectpicker search_sel" data-width="100%"
                                    name="location_id" id="location_id" value="" data-live-search="true">
                                    <option value="">Select Location</option>
                                    @foreach ($locations as $location)
                                        <option value="{{ $location->id }}">
                                            {{ $location->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </label>
                            <label class="form-group has-float-label mb-4 search">
                                <select class="form-control select2-single selectpicker search_sel" data-width="100%"
                                    name="timezone" id="timezone" value="" data-live-search="true">
                                    <option value="">Select Time Zone</option>
                                    @foreach ($timezone as $timezone)
                                        <option value="{{ $timezone->name }}">
                                            {{ $timezone->name }}
                                        </option>
                                    @endforeach

                                </select>
                            </label> --}}

                            <div class=" form-group text-center mb-4">
                                <button type="submit" class="btn btn-primary w-100">Sign up</button>
                            </div>
                            <div class="form-group text-center mt-2 mb-0">
                                <a href=" {{ route('admin.login') }}" class="btn btn-link ">Already have an account? Sign
                                    In</a>

                            </div>
                    </div>
                </div>
            @endsection
            @push('extra_scripts')
                <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
                {{-- <script src="{{ url('js/live-search.js') }}"></script> --}}
                <script src="{{ url('js/auth/register.js') }}"></script>
            @endpush
