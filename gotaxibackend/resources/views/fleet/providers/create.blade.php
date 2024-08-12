@extends('fleet.layout.basecode')
@extends('admin.layout.base2')

@section('title', 'Add Provider ')

@section('content')
    <style>
        .input-group-addon {
            width: 35px !important;
            border-radius: 5px;
        }
    </style>
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="box box-block bg-white">
                <a href="{{ route('fleet.provider.index') }}" class="btn btn-default pull-right"><i
                            class="fa fa-angle-left"></i> Back</a>

                <h5 style="margin-bottom: 2em;">Add Provider</h5>
                @include('common.notify')
                <form class="form-horizontal" action="{{route('fleet.provider.store')}}" method="POST"
                      enctype="multipart/form-data" role="form">
                    {{csrf_field()}}
                    <div class="form-group row">
                        <label for="first_name" class="col-xs-12 col-form-label">First Name</label>
                        <div class="col-xs-10">
                            <input class="form-control" type="text" value="{{ old('first_name') }}" name="first_name"
                                   required id="first_name" placeholder="First Name">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="last_name" class="col-xs-12 col-form-label">Last Name</label>
                        <div class="col-xs-10">
                            <input class="form-control" type="text" value="{{ old('last_name') }}" name="last_name"
                                   required id="last_name" placeholder="Last Name">
                        </div>
                    </div>

                    @if (Setting::get('partner_company_info') == 1)
                        <div class="form-group row">
                            <label for="company_name" class="col-xs-12 col-form-label">Company Name</label>
                            <div class="col-xs-10">
                                <input class="form-control" type="text" value="{{ old('company_name') }}"
                                       name="company_name"
                                       required id="company_name" placeholder="Company Name">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="company_address" class="col-xs-12 col-form-label">Company Address</label>
                            <div class="col-xs-10">
                                <input class="form-control" type="text" value="{{ old('company_address') }}"
                                       name="company_address"
                                       required id="company_address" placeholder="Company Address">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="company_vat" class="col-xs-12 col-form-label">Company VAT</label>
                            <div class="col-xs-10">
                                <input class="form-control" type="text" value="{{ old('company_vat') }}"
                                       name="company_vat"
                                       required id="company_vat" placeholder="Company VAT">
                            </div>
                        </div>
                    @endif


                    <div class="form-group row">
                        <label for="email" class="col-xs-12 col-form-label">Email</label>
                        <div class="col-xs-10">
                            <input class="form-control" type="email" required name="email" value="{{old('email')}}"
                                   id="email" placeholder="Email">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="password" class="col-xs-12 col-form-label">Password</label>
                        <div class="col-xs-10">
                            <div class="input-group" id="show_hide_password">
                                <input class="form-control" type="password" name="password" id="password"
                                       placeholder="Password">
                                <div class="input-group-addon">
                                    <a href="javascript:"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="password_confirmation" class="col-xs-12 col-form-label">Password
                            Confirmation</label>
                        <div class="col-xs-10">
                            <div class="input-group" id="show_hide_password_confirmation">
                                <input class="form-control" type="password" name="password_confirmation"
                                       id="password_confirmation" placeholder="Password">
                                <div class="input-group-addon">
                                    <a href="javascript:"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if (Setting::get('address_driver', 0) == 1)
                        <div class="form-group row">
                            <label for="address" class="col-xs-12 col-form-label">Address</label>
                            <div class="col-xs-10">
                                <input class="form-control" type="text" value="{{ old('address') }}" name="address"
                                    required id="address" placeholder="Address">
                            </div>
                        </div>
                    @endif
                    @if (Setting::get('dob_driver', 0) == 1)
                        <div class="form-group row">
                            <label for="dob" class="col-xs-12 col-form-label">Date of birth</label>
                            <div class="col-xs-10">
                                <input class="form-control" type="date" value="{{ old('dob') }}" name="dob"
                                    required id="dob" placeholder="DOB">
                            </div>
                        </div>
                    @endif
                    @if (Setting::get('zone_restrict_module', 0) == 1 && Setting::get('zone_module', 0) == 1)
                        <div class="form-group row">
                            <label for="mobile" class="col-xs-12 col-form-label">Zone</label>
                            <div class="col-xs-10">
                                <select name="zone_id" class="form-control">
                                    <option value="0" selected>No Zone</option>
                                    @foreach ($zones as $zone)
                                        <option value="{{ $zone->id }}">{{ $zone->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endif

                    <div class="form-group row">
                        <label for="picture" class="col-xs-12 col-form-label">Picture</label>
                        <div class="col-xs-10">
                            <input type="file" accept="image/*" name="avatar" class="dropify form-control-file"
                                   id="picture" aria-describedby="fileHelp">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="mobile" class="col-xs-12 col-form-label">Mobile</label>
                        <div class="col-xs-10">
                            <input class="form-control" type="text" value="{{ old('mobile') }}" name="mobile" required
                                   id="mobile" minlength="10" maxlength="15" placeholder="+46">
                        </div>
                    </div>


                    <div class="form-group row">
                        <label for="zipcode" class="col-xs-12 col-form-label"></label>
                        <div class="col-xs-10">
                            <button type="submit" class="btn btn-primary">Add Provider</button>
                            <a href="{{route('fleet.provider.index')}}" class="btn btn-default">Cancel</a>
                        </div>
                    </div>
                    <input type="hidden" name="fleet" value="{{ Auth::guard('fleet')->user()->id }}"/>
                </form>
            </div>
        </div>
    </div>

@endsection
@section('scripts-load')
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

            $("#show_hide_password_confirmation a").on('click', function (event) {
                event.preventDefault();
                if ($('#show_hide_password_confirmation input').attr("type") == "text") {
                    $('#show_hide_password_confirmation input').attr('type', 'password');
                    $('#show_hide_password_confirmation i').addClass("fa-eye-slash");
                    $('#show_hide_password_confirmation i').removeClass("fa-eye");
                } else if ($('#show_hide_password_confirmation input').attr("type") == "password") {
                    $('#show_hide_password_confirmation input').attr('type', 'text');
                    $('#show_hide_password_confirmation i').removeClass("fa-eye-slash");
                    $('#show_hide_password_confirmation i').addClass("fa-eye");
                }
            });
        });
    </script>
@endsection