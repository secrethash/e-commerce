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
                            <li>Registration</li>
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
                                                <x-ri-user-add-line class="text-danger" width="38px" />
                                            </span>
                                            <h2><span class="fw-light">Account</span> Registration</h2>
                                            <p class="lead">Register your account to Unlock benifits</p>
                                        </div>
                                        <div class="card-body px-md-5 pb-5">
                                            <form method="POST" action="{{ route('register') }}">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-12 col-md-6 mb-4">
                                                        <div class="form-floating">
                                                            <input type="text" id="first_name"
                                                                @class([
                                                                    "form-control",
                                                                    "is-invalid" => $errors->has('first_name'),
                                                                ])
                                                                name="first_name"
                                                                placeholder="John"
                                                                autocomplete="first_name" autofocus />
                                                            <label for="first_name">First Name</label>
                                                        </div>
                                                        @error('first_name')
                                                            <span class="invalid-feedback show" role="alert">
                                                                <strong><x-ri-information-fill width="16px" /> {{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-12 col-md-6 mb-4">
                                                        <div class="form-floating">
                                                            <input type="text" id="last_name"
                                                                @class([
                                                                    "form-control",
                                                                    "is-invalid" => $errors->has('last_name'),
                                                                ])
                                                                name="last_name"
                                                                placeholder="Doe"
                                                                autocomplete="family-name" autofocus />
                                                            <label for="last_name">Last Name</label>
                                                        </div>
                                                        @error('last_name')
                                                            <span class="invalid-feedback show" role="alert">
                                                                <strong><x-ri-information-fill width="16px" /> {{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-12 mb-4">
                                                        <div class="form-floating">
                                                            <input type="email" id="email"
                                                                @class([
                                                                    "form-control",
                                                                    "is-invalid" => $errors->has('email'),
                                                                ])
                                                                name="email"
                                                                placeholder="john.doe@exmple.com"
                                                                autocomplete="email" autofocus />
                                                            <label for="email">Email Address</label>
                                                        </div>
                                                        @error('email')
                                                            <span class="invalid-feedback show" role="alert">
                                                                <strong><x-ri-information-fill width="16px" /> {{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-12 col-md-6 mb-4">
                                                        <div class="form-floating">
                                                            <input type="password"
                                                                @class([
                                                                    "form-control",
                                                                    "is-invalid" => $errors->has('password'),
                                                                ])
                                                                name="password"
                                                                id="password"
                                                                placeholder="Password"
                                                                autocomplete="current-password" />
                                                            <label for="password">Password</label>
                                                        </div>
                                                        @error('password')
                                                            <span class="invalid-feedback show" role="alert">
                                                                <strong><x-ri-information-fill width="16px" /> {{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-12 col-md-6 mb-4">
                                                        <div class="form-floating">
                                                            <input type="password"
                                                                class="form-control"
                                                                name="password_confirmation"
                                                                id="password_confirmation"
                                                                placeholder="Confirm Password"
                                                                required />
                                                            <label for="password_confirmation">Confirm Password</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 d-flex align-items-center justify-content-between mb-5">
                                                        <div class="form-check">
                                                            <input type="checkbox" id="tos" name="tos" class="form-check-input" required />
                                                            <label for="tos" class="form-check-label">I, hereby declare that I have thoroughly read and I accept the <a href="#">Terms of Service</a> & <a href="#">Privacy Policy</a>.</label>
                                                        </div>
                                                        {{-- <div>
                                                            @if (Route::has('password.request'))
                                                                <a href="#" class="text-danger">Forgot Password?</a>
                                                            @endif
                                                        </div> --}}
                                                    </div>
                                                </div>
                                                <button type="submit" class="btn btn-outline-danger btn-lg w-100">
                                                    <x-ri-user-add-fill width="22px" />
                                                    <span>Signup</span>
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

