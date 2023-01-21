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

                                            @if (session('status'))
                                                <div class="alert alert-success" role="alert">
                                                    <x-ri-mail-check-fill width="22px" />&nbsp; {{session('status')}}
                                                </div>
                                            @endif

                                            <form method="POST" action="{{ route('password.email') }}">
                                                @csrf
                                                <div class="mb-4">
                                                    <div class="form-floating">
                                                        <input type="email" id="email"
                                                            @class([
                                                                "form-control",
                                                                "is-invalid" => $errors->has('email'),
                                                            ])
                                                            name="email" required
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
                                                <button type="submit" class="btn btn-outline-danger btn-lg w-100">
                                                    <x-ri-restart-fill width="26px" />
                                                    <span>Reset Password</span>
                                                </button>
                                            </form>
                                            <div class="d-block text-center">
                                                <p class="lead my-4">OR</p>
                                                <a href="{{ route('login') }}" class="btn btn-light btn-lg w-100 bordered-start  bordered-end bordered-dark text-dark">
                                                    <x-ri-login-circle-line width="22px" />
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

