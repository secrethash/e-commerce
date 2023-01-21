@extends('layouts.app')

@section('content')
    <!-- Breadcrumb Area Start -->
    <div class="breadcrumb-area text-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="breadcrumb-content">
                        <ul class="nav justify-content-center">
                            <li>
                                <a href="{{ route('home') }}">Home</a>
                            </li>
                            <li>Reset Password</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Area End-->
    <!-- login area start -->
    <div class="login-register-area mb-60px">
        <div class="container">
            <div class="container-inner bg-transparent">
                <div class="row justify-content-center">
                    <div class="col-lg-7 col-md-12 ml-auto mr-auto">
                        <div class="login-register-wrapper">
                            <div class="tab-content">
                                <div id="lg1" class="card border-0 bordered-top bordered-danger shadow">
                                    <div class="card-content px-md-5">
                                        <div class="text-center mt-4 mb-md-5 card-header bg-transparent border-bottom-0">
                                            <span class="d-block">
                                                <x-ri-restart-line class="text-danger" width="38px" />
                                            </span>
                                            <h2><span class="fw-light">Password</span> Reset</h2>
                                            <p class="lead">Get a link to reset your password.</p>
                                        </div>
                                        <div class="card-body px-md-5 pb-5">

                                            <form method="POST" action="{{ route('password.update') }}">
                                                @csrf
                                                <input type="hidden" name="token" value="{{$token}}" />
                                                <input type="hidden" name="email" value="{{$request->input('email')}}" />
                                                <div class="mb-4">
                                                    <div class="form-floating">
                                                        <input type="email" id="email"
                                                            @class([
                                                                "form-control",
                                                                "is-invalid" => $errors->has('email'),
                                                            ])
                                                            value="{{$request->input('email')}}"
                                                            readonly
                                                            autocomplete="email" />
                                                        <label for="email">Email Address</label>
                                                    </div>
                                                    @error('email')
                                                        <span class="invalid-feedback show" role="alert">
                                                            <strong><x-ri-information-fill width="16px" /> {{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="row">
                                                    <div class="mb-4 col-12 col-md-6">
                                                        <div class="form-floating">
                                                            <input type="password"
                                                                @class([
                                                                    "form-control",
                                                                    "is-invalid" => $errors->has('password'),
                                                                ])
                                                                name="password" required
                                                                id="password"
                                                                placeholder="Password"
                                                                autocomplete="new-password" autofocus />
                                                            <label for="password">Password</label>
                                                        </div>
                                                        @error('password')
                                                            <span class="invalid-feedback show" role="alert">
                                                                <strong><x-ri-information-fill width="16px" /> {{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                    <div class="mb-4 col-12 col-md-6">
                                                        <div class="form-floating">
                                                            <input type="password"
                                                                @class([
                                                                    "form-control",
                                                                    "is-invalid" => $errors->has('password'),
                                                                ])
                                                                name="password_confirmation" required
                                                                id="password_confirmation"
                                                                placeholder="Confirm Password"
                                                                autocomplete="new-password" />
                                                            <label for="password">Confirm Password</label>
                                                        </div>
                                                        @error('password')
                                                            <span class="invalid-feedback show" role="alert">
                                                                <strong><x-ri-information-fill width="16px" /> {{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <button type="submit" class="btn btn-outline-danger btn-lg w-100">
                                                    <x-ri-restart-fill width="22px" />
                                                    <span>Reset Password</span>
                                                </button>
                                            </form>
                                            <div class="d-block text-center">
                                                <p class="lead my-4">OR</p>
                                                <a href="{{ route('login') }}" class="btn btn-light btn-lg w-100 bordered-start  bordered-end bordered-dark text-dark">
                                                    <x-ri-login-circle-fill width="22px" />
                                                    <span>Login</span>
                                                </a>
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
    </div>
    <!-- login area end -->
@endsection

