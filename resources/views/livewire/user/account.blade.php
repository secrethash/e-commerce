<div>
    <!-- Breadcrumb Area Start -->
    <div class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcrumb-content">
                        <ul class="nav">
                            <li><a href="{{route('home')}}">Home</a></li>
                            <li>Account</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Area End-->

    <!-- login area start -->
    <div class="row mb-60px mx-3">
        <div class="col-lg-6 my-2">
            <div class="card shadow rounded-lg bordered-start bordered-danger">
                <div class="card-body">
                    <div class="mb-2">
                        <div class="mb-5">
                            <h5 class="lead text-center card-subtitle">Manage Account Information</h5>
                            <h3 class="text-center card-title">Personal Information</h3>
                        </div>
                        <div class="row card-text">
                            <div class="col-lg-6 col-md-6">
                                <div class="mb-4">
                                    <label for="first_name">First Name</label>
                                    <input type="text"
                                        class="form-control @error('user.first_name'){{'is-invalid'}}@enderror"
                                        name="first_name"
                                        id="first_name"
                                        required
                                        wire:model='user.first_name'
                                        autocomplete="name"
                                    />
                                    @error('user.first_name')
                                        <span class="invalid-feedback show" role="alert">
                                            <strong><x-ri-information-fill width="16px" /> {{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="mb-4">
                                    <label for="last_name">Last Name</label>
                                    <input type="text"
                                        class="form-control @error('user.last_name'){{'is-invalid'}}@enderror"
                                        name="last_name"
                                        id="last_name"
                                        wire:model='user.last_name'
                                        autocomplete="family-name" />
                                    @error('user.last_name')
                                        <span class="invalid-feedback show" role="alert">
                                            <strong><x-ri-information-fill width="16px" /> {{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="mb-4">
                                    <label for="email">Email Address</label>
                                    <input type="email"
                                        class="form-control @error('user.email'){{'is-invalid'}}@enderror"
                                        name="email"
                                        id="email"
                                        required
                                        autocomplete="email"
                                        wire:model='user.email' />
                                    @error('user.email')
                                        <span class="invalid-feedback show" role="alert">
                                            <strong><x-ri-information-fill width="16px" /> {{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="mb-4">
                                    <label for="phone_number">Phone Number</label>
                                    <input type="tel"
                                        name="phone_number"
                                        class="form-control @error('user.phone_number'){{'is-invalid'}}@enderror"
                                        id="phone_number"
                                        required
                                        wire:model='user.phone_number'
                                        autocomplete="mobile" />
                                    @error('user.phone_number')
                                        <span class="invalid-feedback show" role="alert">
                                            <strong><x-ri-information-fill width="16px" /> {{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="mt-2">
                            <button type="button" class="btn btn-lg w-100 btn-danger rounded-0" wire:click.prevent='savePersonal' wire:loading.attr='disabled'>
                                <x-heroicon-s-check-circle width="18" wire:loading.remove wire:target='savePersonal' />
                                <div class="spinner-border spinner-border-sm" role="status" wire:loading wire:target='savePersonal'>
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                Update <strong>Information</strong>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 my-2">
            <div class="card shadow rounded-lg bordered-end bordered-danger">
                <div class="card-body">
                    <div class="mb-2">
                        <div class="mb-5 card-title">
                            <h5 class="lead text-center card-subtitle">Change your Password</h5>
                            <h3 class="text-center card-title">Update Password</h3>
                        </div>
                        <div class="row card-text">
                            <div class="col-lg-12 col-md-12">
                                <div class="mb-4">
                                    <label for="current_password">Current Password</label>
                                    <input type="password"
                                        class="form-control @error('current_password'){{'is-invalid'}}@enderror"
                                        name="current_password"
                                        id="current_password"
                                        required autocomplete="current-password"
                                        wire:model='current_password' />
                                    @error('current_password')
                                        <span class="invalid-feedback show" role="alert">
                                            <strong><x-ri-information-fill width="16px" /> {{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="mb-4">
                                    <label for="password">New Password</label>
                                    <input type="password"
                                        class="form-control @error('password'){{'is-invalid'}}@enderror"
                                        name="password"
                                        id="password"
                                        required autocomplete="new-password"
                                        wire:model='password' />
                                    @error('password')
                                        <span class="invalid-feedback show" role="alert">
                                            <strong><x-ri-information-fill width="16px" /> {{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="mb-4">
                                    <label for="password_confirmation">Confirm New Password</label>
                                    <input type="password"
                                        class="form-control"
                                        name="password_confirmation"
                                        id="password_confirmation"
                                        required
                                        wire:model='password_confirmation' />
                                </div>
                            </div>
                        </div>
                        <div class="mt-2">
                            <button type="button" class="btn btn-lg w-100 btn-danger rounded-0" wire:click.prevent='savePassword' wire:loading.attr='disabled'>
                                <x-heroicon-s-check-circle width="18" wire:loading.remove wire:target='savePassword' />
                                <div class="spinner-border spinner-border-sm" role="status" wire:loading wire:target='savePassword'>
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                Update <strong>Password</strong>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- login area end -->
</div>
