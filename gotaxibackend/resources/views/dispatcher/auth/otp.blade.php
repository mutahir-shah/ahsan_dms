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
                <a href="#"><b>{{ Setting::get('site_title', '') }}</b></a>
            </div>
            <div class="card-body login-card-body">

                <form role="form" method="POST" action="{{ route('dispatcher.verify-otp') }}">

                    {{ csrf_field() }}
                   
                    <div class="input-group mb-3">
                        <input type="text" name="otp" required="true" class="form-control" id="otp" placeholder="{{ translateKeyword('enter_otp') }}">
                        
                    </div>
                      @if ($errors->has('otp'))
                            <span class="help-block" style="color: red;">
                                <strong>{{ $errors->first('otp') }}</strong>
                            </span>
                        @endif
                    <div class="row">
                        <!-- /.col -->
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">{{ translateKeyword('verify_otp') }}</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

