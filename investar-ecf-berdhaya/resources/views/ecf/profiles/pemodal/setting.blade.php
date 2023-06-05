@extends( env('DEFAULT_LAYOUT', 'layouts.codebase').'_profile' )


@section('content')
    <!-- Hero -->
    <div class="card block block-rounded">
        <div class="card-body block-content block-content-full bg-pattern" style="background-image: url('assets/media/various/bg-pattern-inverse.png');">
            <div class="py-20 text-center">
                <h2 class="font-w700 text-black mb-10">
                    Settings
                </h2>
                <h3 class="h5 text-muted mb-0">
                    Change your settings.
                </h3>
            </div>
        </div>
    </div>
    <!-- END Hero -->

    <!-- Settings -->
    <h2 class="h4 font-w300 mt-50">Settings</h2>
    <div class="card block">
        <div class="card-header block-header block-header-default">
            <h3 class="block-title">
                <i class="las la-pencil fa-fw mr-5 text-muted"></i> {{__('Profile')}}
            </h3>
        </div>
        <div class="card-body block-content">
            <div class="row items-push">
                <div class="col-lg-3">
                    <p class="text-muted">
                        Your account’s vital info. Your name should match your public ID.
                    </p>
                </div>
                <div class="col-lg-7 offset-lg-1">
                    <div class="form-group">
                        <label for="hosting-settings-profile-name">Name</label>
                        <input type="text" class="form-control form-control-lg" id="hosting-settings-profile-name" name="hosting-settings-profile-name" placeholder="Enter your name.." value="John Smith">
                    </div>
                    <div class="form-group">
                        <label for="hosting-settings-profile-email">Email Address</label>
                        <input type="email" class="form-control form-control-lg" id="hosting-settings-profile-email" name="hosting-settings-profile-email" placeholder="Enter your email.." value="hosting@example.com">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-alt-primary">Update</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card block">
        <div class="card-header block-header block-header-default">
            <h3 class="block-title">
                <i class="las la-lock fa-fw mr-5 text-muted"></i> {{__('Security')}}
            </h3>
        </div>
        <div class="card-body block-content">
            <div class="row items-push">
                <div class="col-lg-3">
                    <p class="text-muted">
                        Keep your account as secure and as private as you like.
                    </p>
                </div>
                <div class="col-lg-7 offset-lg-1">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <div class="custom-control custom-checkbox mb-5">
                                    <input type="checkbox" class="custom-control-input" id="hosting-settings-security-status" name="hosting-settings-security-status">
                                    <label class="custom-control-label" for="hosting-settings-security-status">Online Status</label>
                                </div>
                                <div class="text-muted">Show your status to all</div>
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-checkbox mb-5">
                                    <input type="checkbox" class="custom-control-input" id="hosting-settings-security-verify" name="hosting-settings-security-verify" checked>
                                    <label class="custom-control-label" for="hosting-settings-security-verify">Verify on Login</label>
                                </div>
                                <div class="text-muted">Most secure option</div>
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-checkbox mb-5">
                                    <input type="checkbox" class="custom-control-input" id="hosting-settings-security-updates" name="hosting-settings-security-updates" checked>
                                    <label class="custom-control-label" for="hosting-settings-security-updates">Auto Updates</label>
                                </div>
                                <div class="text-muted">Keep app updated</div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <div class="custom-control custom-checkbox mb-5">
                                    <input type="checkbox" class="custom-control-input" id="hosting-settings-security-notifications" name="hosting-settings-security-notifications">
                                    <label class="custom-control-label" for="hosting-settings-security-notifications">Notifications</label>
                                </div>
                                <div class="text-muted">For every upgrade</div>
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-checkbox mb-5">
                                    <input type="checkbox" class="custom-control-input" id="hosting-settings-security-api" name="hosting-settings-security-api" checked>
                                    <label class="custom-control-label" for="hosting-settings-security-api">API Access</label>
                                </div>
                                <div class="text-muted">Enable access from third party apps</div>
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-checkbox mb-5">
                                    <input type="checkbox" class="custom-control-input" id="hosting-settings-security-2fa" name="hosting-settings-security-2fa" checked>
                                    <label class="custom-control-label" for="hosting-settings-security-2fa">Two Factor Auth</label>
                                </div>
                                <div class="text-muted">Using an authenticator</div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-alt-primary">Update</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END Settings -->

@endsection
