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

                            <ul class="nav nav-tabs" id="myTabs" style="padding-left: 15px !important">
                                @foreach (['email_field' => 'Email', 'login_phone_hidden' => 'Phone'] as $setting => $title)
                                    <li class="{{ $loop->first ? 'active' : '' }}"><a data-toggle="tab"
                                            href="#{{ $setting }}">{{ $title }}</a></li>
                                @endforeach
                            </ul>

                            <div class="tab-content col-md-12" style="margin-top: 1.5rem">
                                <div id="email_field" class="tab-pane fade in active">
                                    <form role="form" method="POST" action="{{ url('/password/email') }}">
                                        {{ csrf_field() }}

                                        <input type="email" class="form-control" name="email"
                                            placeholder="Email Address" value="{{ old('email') }}">

                                        @if ($errors->has('email'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif

                                        <button class="log-teal-btn" type="submit">SEND PASSWORD RESET LINK</button>
                                    </form>

                                </div>
                                <div id="login_phone_hidden" class="tab-pane fade">
                                    <form role="form" method="POST" action="{{ url('/password/phone') }}">
                                        {{ csrf_field() }}

                                        <div class="form-group mb-1">
                                            <input class="form-control mb-2" type="text" id="phone" minlength="10"
                                                maxlength="15" name="phone" value="{{ old('phone') }}" required
                                                placeholder="+92">
                                        </div>

                                        @if ($errors->has('phone'))
                                            <span class="alert-danger p-1">
                                                <strong>{{ $errors->first('phone') }}</strong>
                                            </span>
                                        @endif

                                        <button class="log-teal-btn" type="submit">SEND PASSWORD RESET LINK</button>
                                    </form>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <p class="helper">Or <a href="{{ route('website.login') }}">Sign in</a> with your
                                    user
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
