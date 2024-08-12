@extends('admin.layout.base3')

@section('content')
    <style>
        .input-group-addon {
            width: 35px !important;
            border-radius: 5px;
        }
    </style>
    <div class="login-box">

        <!-- /.login-logo -->
        <div class="card">
            <div class="login-logo">
                <a href="{{ route('admin.login') }}"><img src="{{ Setting::get('site_logo', asset('logo-black.png'))}}"
                                                          style="max-height: 70px; max-width: 70px; margin-top:20px;"
                                                          alt="logo"/></a>
            </div>
            <div class="login-logo">
                <a href="{{ route('admin.login') }}"><b>{{ Setting::get('site_title', '') }}</b></a>
            </div>
            <p class="text-center">Dispatcher Panel</p>
            <div class="card-body login-card-body">

                <form role="form" method="POST" action="{{ url('/dispatcher/login') }}">

                    {{ csrf_field() }}
                    <div class="input-group mb-3">
                        @if(Setting::get('show_preset_credentials') == 1)
                            <input type="email" class="form-control" name="email" required="true" id="email"
                                   placeholder="Email" value="dispatcher@meemcolart.com">
                        @else
                            <input type="email" class="form-control" name="email" required="true" id="email"
                                   placeholder="Email">
                        @endif
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                        @if ($errors->has('email'))
                            <span class="help-block" style="margin-left: 55px;color: red;">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
                        @endif
                    </div>
                    <div class="input-group mb-3">
                        @if(Setting::get('show_preset_credentials') == 1)
                            <input type="password" name="password" required="true" class="form-control" id="password"
                                   placeholder="Password" value="Quartz@1234">
                        @else
                            <input type="password" name="password" required="true" class="form-control" id="password"
                                   placeholder="Password">
                        @endif
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                        @if ($errors->has('password'))
                            <span class="help-block" style="margin-left: 55px;color: red;">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
                        @endif
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" name="remember" id="remember">
                                <label for="remember">
                                    Remember Me
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>


            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {

            $("#show_hide_password a").on('click', function (event) {
                event.preventDefault();
                if ($('#show_hide_password input').attr("type") == "text") {
                    $('#show_hide_password input').attr('type', 'password');
                    $('#show_hide_password i').addClass("fa-eye-slash");
                    $('#show_hide_password i').removeClass("fa-eye");
                } else if ($('#show_hide_password input').attr("type") == "password") {
                    $('#show_hide_password input').attr('type', 'text');
                    $('#show_hide_password i').removeClass("fa-eye-slash");
                    $('#show_hide_password i').addClass("fa-eye");
                }
            });

        });
    </script>

@endsection

