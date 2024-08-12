<head>
    @section('title', 'Delivery/Transport Hub')
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Provider Register - @yield('title')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('mainindex/css/style.css') }}">
</head>
<body>
<div class="container-fluid">
    <div class="row mh-100vh">
        <div class="col-10 col-sm-8 col-md-6 col-lg-6 offset-1 offset-sm-2 offset-md-3 offset-lg-0 align-self-center d-lg-flex align-items-lg-center align-self-lg-stretch bg-white p-5 rounded rounded-lg-0 my-5 my-lg-0"
             id="login-block">
            <div class="m-auto w-lg-75 w-xl-50">
                <h2 class="text-dark font-weight-light mb-5"><i class="fa fa-lock"></i> Provider Register</h2>
                <form method="POST" action="{{ url('/provider/register') }}">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label class="text-secondary">First Name</label>
                        <input class="form-control" type="text" name="first_name" required>
                        @if ($errors->has('first_name'))
                            <span class="help-block">
                            <strong>{{ $errors->first('first_name') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label class="text-secondary">Last Name</label>
                        <input class="form-control" type="text" name="last_name" required>
                        @if ($errors->has('last_name'))
                            <span class="help-block">
                            <strong>{{ $errors->first('last_name') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label class="text-secondary">Phone Number</label>
                        <input class="form-control" type="text" name="phone_number" required placeholder="+46">
                        @if ($errors->has('phone_number'))
                            <span class="help-block">
                            <strong>{{ $errors->first('phone_number') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label class="text-secondary">Email</label>
                        <input class="form-control" type="text" name="email" required type="email" inputmode="email">
                        @if ($errors->has('email'))
                            <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label class="text-secondary">Car Type</label>
                        <select name="service_type" class="form-control">
                            @foreach ($service_types as $service_type)
                                <option value="{{ $service_type->id }}">{{ $service_type->name }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('service_type'))
                            <span class="help-block">
                            <strong>{{ $errors->first('service_type') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label class="text-secondary">Car Model</label>
                        <input class="form-control" type="text" name="service_model" required placeholder="Toyota">
                        @if ($errors->has('service_model'))
                            <span class="help-block">
                            <strong>{{ $errors->first('service_model') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label class="text-secondary">Car Number</label>
                        <input class="form-control" type="text" name="service_number" required placeholder="zxc 2021">
                        @if ($errors->has('service_number'))
                            <span class="help-block">
                            <strong>{{ $errors->first('service_number') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label class="text-secondary">Gender</label><br/>
                        <input type="radio" id="gender" name="gender" value="Male">
                        <label for="male">Male</label>&nbsp;&nbsp;&nbsp;
                        <input type="radio" id="gender" name="gender" value="Female">
                        <label for="female">Female</label>
                        <input type="radio" id="gender" name="gender" value="other">
                        <label for="female">Other</label>
                        @if ($errors->has('gender'))
                            <span class="help-block">
                        <strong>{{ $errors->first('gender') }}</strong>
                        </span>
                        @endif
                    </div>
                    @if (Setting::get('address_driver', 0) == 1)
                        <div class="form-group">
                            <label for="address" class="text-secondary">Address</label>
                            <input class="form-control" type="text" value="{{ old('address') }}" name="address"
                                    required id="address" placeholder="Address">
                        </div>
                    @endif
                    @if (Setting::get('dob_driver', 0) == 1)
                        <div class="form-group">
                            <label for="dob" class="text-secondary">Date of birth</label>
                            <input class="form-control" type="date" value="{{ old('dob') }}" name="dob"
                                    required id="dob" placeholder="DOB">
                        </div>
                    @endif
                    @if (Setting::get('zone_restrict_module', 0) == 1 && Setting::get('zone_module', 0) == 1)
                        <div class="form-group">
                            <label for="mobile" class="text-secondary">Zone</label>
                            <select name="zone_id" class="form-control">
                                <option value="0" selected>No Zone</option>
                                @foreach ($zones as $zone)
                                    <option value="{{ $zone->id }}">{{ $zone->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                    <div class="form-group">
                        <label class="text-secondary">Password</label>
                        <input class="form-control" type="password" name="password" required>
                        @if ($errors->has('password'))
                            <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label class="text-secondary">Confirm Password</label>
                        <input class="form-control" type="password" name="password_confirmation" required>
                        @if ($errors->has('password_confirmation'))
                            <span class="help-block">
                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                            </span>
                        @endif
                    </div>
                    <button class="btn btn-dark  mt-2" type="submit">Register Now</button>
                </form>
                {{-- <p class="mt-3 mb-0"><a class="text-dark small" href="{{ url('/login') }}">Already&nbsp; have an account ? Login Now</a></p> --}}
                <p class="mt-3 mb-0 "><a class="text-dark small " href="{{ url('/') }}">Back to <b>Home Page</b></a></p>
            </div>
        </div>
        <div class="col-lg-6 d-flex align-items-end" id="bg-block"
             style="background-image:url({{ Setting::get('website_register') }});background-size:cover;background-position:center center;">
            <p class="ml-auto small text-dark mb-2">
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
</body>
