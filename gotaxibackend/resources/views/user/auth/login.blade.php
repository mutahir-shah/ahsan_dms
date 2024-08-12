@extends('layout.base')

@section('content')
    <div class="tj-wrapper">


        <!--Header Banner Content Start-->

        <section class="tj-banner-form"
                 style="background: url('{{Setting::get('f_mainBanner', '')}}') no-repeat; background-size: cover;">

            <div class="container">

                <div class="row" style=" margin-top: -100px;">

                    <!--Header Banner Caption Content Start-->

                    <div class="col-md-12 col-sm-12">

                        <div class="banner-caption">

                            <div class="banner-inner bounceInLeft animated delay-0s text-center">

                                <h2>User Web Panel</h2>

                                <h3 style="color: white;">Login & Register</h3><br/>

                                <div class="banner-btns" style="margin-bottom: -100px;">

                                    <a href="{{Setting::get('f_u_url', '')}}" style=" width: 155px; margin-right: 5px; "
                                       class="btn-style-1"><i class="fab fa-android"></i> User App</a>

                                    <a href="{{Setting::get('f_f_url', '')}}" style=" width: 155px; margin-left: 5px; "
                                       class="btn-style-2"><i class="fab fa-android"></i> Partner App</a>

                                </div>

                            </div>

                        </div>

                    </div>


                </div>

            </div>

        </section>


        <!--Login Section Start-->

        <section class="tj-login">

            <div class="container">

                <div class="row" style="margin: auto;  padding: 10px;">

                    <div class="col-md-12 col-sm-12">

                        <!--Tabs Nav Start-->

                        <div class="tj-tabs" style="margin-left: 15px;">

                            <ul class="nav nav-tabs" role="tablist">

                                <li class="active"><a href="#login" data-toggle="tab">Login</a></li>

                                <li><a href="#register" data-toggle="tab">Register</a></li>

                            </ul>

                        </div>

                        <!--Tabs Nav End-->

                        <!--Tabs Content Start-->

                        <div class="tab-content">

                            <!--Login Tabs Content Start-->

                            <div class="tab-pane active" id="login">

                                <div class="col-md-6 col-sm-6">

                                    <div class="reg-cta">

                                        <ul class="cta-list" style="margin-top: 20px;">

                                            <li>

                                                <span class="icon-mail-envelope icomoon"></span>

                                                <div class="cta-card">

                                                    <strong>24/7 Customer Support</strong>

                                                    <p>Get support for 24 hours and 7 days.</p>

                                                </div>

                                            </li>

                                            <li>

                                                <span class="icon-lock icomoon"></span>

                                                <div class="cta-info">

                                                    <strong>100% Secure Payment</strong>

                                                    <p>3D Secure online payment system to protect your data.</p>

                                                </div>

                                            </li>

                                        </ul>

                                    </div>

                                </div>

                                <div class="col-md-6 col-sm-6">

                                    <form style="margin-top: 20px;" class="login-frm" role="form" method="POST"
                                          action="{{ url('/login') }}">

                                        {{ csrf_field() }}

                                        <div class="field-holder">

                                            <span class="far fa-envelope"></span>

                                            <input id="email" type="email" name="email" value="{{ old('email') }}"
                                                   placeholder="Enter your Email Address" required>

                                            @if ($errors->has('email'))

                                                <span class="help-block">

															<strong>{{ $errors->first('email') }}</strong>

														</span>

                                            @endif

                                        </div>

                                        <div class="field-holder">

                                            <span class="fas fa-lock"></span>

                                            <input id="password" type="password" name="password" placeholder="Password"
                                                   required>

                                            @if ($errors->has('password'))

                                                <span class="help-block">

															<strong>{{ $errors->first('password') }}</strong>

														</span>

                                            @endif

                                        </div>
                                        <!-- <a href="#reset" data-toggle="tab">Forget Password?</a> -->

                                        <button type="submit" class="reg-btn">Login <i class="fa fa-arrow-circle-right"
                                                                                       aria-hidden="true"></i></button>

                                        <!-- <button type="hidden" class="facebook-btn">Login with Facebook <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></button> -->

                                        <!-- <button type="hidden" class="google-btn">Login with Google <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></button> -->


                                    </form>

                                </div>

                            </div>

                            <!--Login Tabs Content End-->

                            <!--Register Tabs Content Start-->

                            <div class="tab-pane" id="register">

                                <div class="col-md-6 col-sm-6">

                                    <div class="reg-cta">

                                        <ul class="cta-list" style="margin-top: 20px;">

                                            <li>

                                                <span class="icon-mail-envelope icomoon"></span>

                                                <div class="cta-card">

                                                    <strong>24/7 Customer Support</strong>

                                                    <p>Get support for 24 hours and 7 days.</p>

                                                </div>

                                            </li>

                                            <li>

                                                <span class="icon-lock icomoon"></span>

                                                <div class="cta-info">

                                                    <strong>100% Secure Payment</strong>

                                                    <p>3D Secure online payment system to protect your data.</p>

                                                </div>

                                            </li>

                                        </ul>

                                    </div>

                                </div>

                                <div class="col-md-6 col-sm-6">

                                    <form style="margin-top: 20px;" class="reg-frm" method="POST"
                                          action="{{ url('/register') }}">

                                        {{ csrf_field() }}

                                        <div class="field-holder">

                                            <div class="row field-holder">

                                                <div class="col-sm-12 col-md-12">

                                                    <div class="col-sm-4 col-md-4">

                                                        <input value="+27" type="text" placeholder="+27"
                                                               id="country_code" name="country_code"/>

                                                    </div>

                                                    <div class="col-sm-8 col-md-8">

                                                        <input type="text" autofocus id="phone_number"
                                                               placeholder="Enter Phone Number" name="phone_number"
                                                               value="{{ old('phone_number') }}"/>

                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                        <div class="field-holder">

                                            <div class="row">

                                                <div class="col-sm-12 col-md-12">

                                                    <div class="col-md-6 col-sm-6">

                                                        <span class="fas fa-user" style="margin-left: 10px;"></span>

                                                        <input type="text" placeholder="First Name" name="first_name">


                                                        @if ($errors->has('first_name'))

                                                            <span class="help-block">

																		<strong>{{ $errors->first('first_name') }}</strong>

																	</span>

                                                        @endif

                                                    </div>

                                                    <div class="col-md-6 col-sm-6">

                                                        <span class="fas fa-user" style="margin-left: 10px;"></span>

                                                        <input type="text" placeholder="Last Name" name="last_name">


                                                        @if ($errors->has('last_name'))

                                                            <span class="help-block">

																		<strong>{{ $errors->first('last_name') }}</strong>

																	</span>

                                                        @endif

                                                    </div>

                                                    <div class="col-md-12 col-sm-12">

                                                        <span class="fas fa-envelope" style="margin-left: 10px;"></span>

                                                        <input type="email" name="email" placeholder="Email Address">


                                                        @if ($errors->has('email'))

                                                            <span class="help-block">

																		<strong>{{ $errors->first('email') }}</strong>

																	</span>

                                                        @endif

                                                    </div>

                                                    <div class="col-md-12 col-sm-12">

                                                        <span class="fas fa-lock" style="margin-left: 10px;"></span>

                                                        <input type="password" name="password" placeholder="Password">


                                                        @if ($errors->has('password'))

                                                            <span class="help-block">

																	<strong>{{ $errors->first('password') }}</strong>

																	</span>

                                                        @endif

                                                    </div>

                                                    <div class="col-md-12 col-sm-12">

                                                        <span class="fas fa-lock" style="margin-left: 10px;"></span>

                                                        <input type="password" placeholder="Re-type Password"
                                                               name="password_confirmation">


                                                        @if ($errors->has('password_confirmation'))

                                                            <span class="help-block">

																		<strong>{{ $errors->first('password_confirmation') }}</strong>

																	</span>

                                                        @endif

                                                    </div>

                                                    <label for="terms" style="margin-left: 20px;">

                                                        <input type="checkbox" name="terms" id="terms">

                                                        I accept terms & conditions

                                                    </label>

                                                </div>

                                            </div>

                                        </div>

                                        <button type="submit" class="reg-btn">Signup <i class="fa fa-arrow-circle-right"
                                                                                        aria-hidden="true"></i></button>

                                        <!-- <button type="hidden" class="facebook-btn">Login with Facebook <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></button> -->

                                        <!-- <button type="hidden" class="google-btn">Login with Google <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></button> -->

                                    </form>

                                </div>

                            </div>

                            <div class="tab-pane" id="reset">

                                <!-- <div class="col-md-6 col-sm-6">

                                    <div class="reg-cta">

                                        <ul class="cta-list" style="margin-top: 20px;">

                                            <li>

                                                <span class="icon-mail-envelope icomoon"></span>

                                                <div class="cta-card">

                                                    <strong>24/7 Customer Support</strong>

                                                    <p>Get support for 24 hours and 7 days.</p>

                                                </div>

                                            </li>

                                            <li>

                                                <span class="icon-lock icomoon"></span>

                                                <div class="cta-info">

                                                    <strong>100% Secure Payment</strong>

                                                    <p>3D Secure online payment system to protect your data.</p>

                                                </div>

                                            </li>

                                        </ul>

                                    </div>

                                </div> -->

                                <div class="col-md-6 col-sm-6">
                                    <strong>Reset Password</strong>
                                    <form style="margin-top: 20px;" class="login-frm" role="form" method="POST"
                                          action="{{ url('/password/reset') }}">

                                        {{ csrf_field() }}

                                        <div class="field-holder">

                                            <span class="fas fa-envelope"></span>

                                            <input type="email" name="email" placeholder="Email Address">

                                            @if ($errors->has('email'))
                                                <span class="help-block">
													<strong>{{ $errors->first('email') }}</strong>
												</span>
                                            @endif
                                        </div>


                                        <button type="submit" class="reg-btn">Get Reset Link<i
                                                    class="fa fa-arrow-circle-right" aria-hidden="true"
                                                    style="margin-left: 10px;"></i></button>


                                    </form>


                                </div>

                            </div>

                            <!--Register Tabs Content End-->

                        </div>

                        <!--Tabs Content End-->

                    </div>

                </div>

            </div>

        </section>

        <!--Login Section End-->


    </div>
@endsection