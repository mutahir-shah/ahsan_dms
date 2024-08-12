@extends('user.layout.auth')

@section('content')
    <?php $login_user = asset('asset/img/login-user-bg.jpg'); ?>
    <div class="full-page-bg" style="background-image: url({{ Setting::get('f_mainBanner', '') }});">
        <div class="log-overlay"></div>
        <div class="full-page-bg-inner">
            <div class="row no-margin">
                <div class="col-md-6 log-left">
                    <span class="login-logo"><a href="{{ route('website.login') }}"><img
                                src="{{ Setting::get('site_icon') }}"></a></span>
                    <h2>Create your account and get moving in minutes</h2>
                    <p>Welcome to {{ Setting::get('site_title', '') }}, the easiest way to get around at the tap
                        of a button.</p>
                </div>
                <div class="col-md-6 log-right">
                    <div class="login-box-outer">
                        <div class="login-box row no-margin">
                            <div class="col-md-12">
                                <a class="log-blk-btn" href="{{ url('login') }}">ALREADY HAVE AN ACCOUNT?</a>
                                <h3>Reset Password</h3>
                            </div>
                            @if (session('status'))
                                <div class="alert alert-success">
                                    {{ session('status') }}
                                </div>
                            @endif
                            <form role="form" method="POST" action="{{ url('/password-reset/phone') }}">
                                {{ csrf_field() }}

                                <div class="col-md-12">
                                    <input type="text" class="form-control" name="otp" value="12345678"
                                        placeholder="Verification code">

                                    @if ($errors->has('otp'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('otp') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="col-md-12">
                                    <input type="password" class="form-control" name="password" value="12345678"
                                        placeholder="Password">

                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-md-12">
                                    <input type="password" placeholder="Re-type Password" value="12345678"
                                        class="form-control" name="password_confirmation">

                                    @if ($errors->has('password_confirmation'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="col-md-12">
                                    <button class="log-teal-btn" type="submit">RESET PASSWORD</button>
                                </div>
                            </form>

                            <div class="col-md-12">
                                <p class="helper">Or <a href="{{ route('website.login') }}">Sign in</a> with your user
                                    account.</p>
                            </div>

                        </div>


                        <div class="log-copy">
                            <p class="no-margin">
                                &copy; {{ Setting::get('site_copyright', date('Y') . ' Meemcolart') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
