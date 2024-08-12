@extends('admin.layout.base')
@extends('admin.layout.base2')
@section('title', 'Add Fleet Owner ')

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
                <a href="{{ route('admin.fleet.index') }}" class="btn btn-default pull-right"><i
                            class="fa fa-angle-left"></i> {{ translateKeyword('back') }}</a>

                <h5 style="margin-bottom: 2em;">{{ translateKeyword('add_fleet_owner') }}</h5>
                @include('common.notify')
                <form class="form-horizontal" action="{{route('admin.fleet.store')}}" method="POST"
                      enctype="multipart/form-data" role="form">
                    {{csrf_field()}}
                    <div class="form-group row">
                        <label for="name" class="col-xs-12 col-form-label">{{ translateKeyword('full_name') }}</label>
                        <div class="col-xs-10">
                            <input class="form-control" type="text" value="{{ old('name') }}" name="name" required
                                   id="name" placeholder="{{ translateKeyword('full_name') }}">
                        </div>
                    </div>

                    {{-- @if (Setting::get('partner_company_info') == 1) --}}
                    {{-- <div class="form-group row">
                        <label for="company_name" class="col-xs-12 col-form-label">Company Name</label>
                        <div class="col-xs-10">
                            <input class="form-control" type="text" value="{{ old('company_name') }}" name="company_name"
                                required id="company_name" placeholder="Company Name">
                        </div>
                    </div> --}}
                    <div class="form-group row">
                        <label for="company" class="col-xs-12 col-form-label">{{ translateKeyword('company_name') }}</label>
                        <div class="col-xs-10">
                            <input class="form-control" type="text" value="{{ old('company') }}" name="company" required
                                   id="company" placeholder="{{ translateKeyword('company_name') }}">
                        </div>
                    </div>
                    {{-- <div class="form-group row">
                        <label for="company_address" class="col-xs-12 col-form-label">Company Address</label>
                        <div class="col-xs-10">
                            <input class="form-control" type="text" value="{{ old('company_address') }}" name="company_address"
                                required id="company_address" placeholder="Company Address">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="company_vat" class="col-xs-12 col-form-label">Company VAT</label>
                        <div class="col-xs-10">
                            <input class="form-control" type="text" value="{{ old('company_vat') }}" name="company_vat"
                                required id="company_vat" placeholder="Company VAT">
                        </div>
                    </div> --}}
                    {{-- @endif --}}

                    @if (Setting::get('fleet_manager_address_nif') == 1)

                        <div class="form-group row">
                            <label for="address" class="col-xs-12 col-form-label">{{ translateKeyword('address') }}</label>
                            <div class="col-xs-10">
                                <input class="form-control" type="text" value="{{ old('address') }}" name="address"
                                       required id="address" placeholder="{{ translateKeyword('address') }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="nif" class="col-xs-12 col-form-label">{{ translateKeyword('NIF') }}</label>
                            <div class="col-xs-10">
                                <input class="form-control" type="text" value="{{ old('nif') }}" name="nif"
                                       required id="nif" placeholder="{{ translateKeyword('NIF') }}">
                            </div>
                        </div>
                    @endif


                    <div class="form-group row">
                        <label for="email" class="col-xs-12 col-form-label">{{ translateKeyword('email') }}</label>
                        <div class="col-xs-10">
                            <input class="form-control" type="email" required name="email" value="{{old('email')}}"
                                   id="email" placeholder="{{ translateKeyword('email')}}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="password" class="col-xs-12 col-form-label">{{ translateKeyword('password') }}</label>
                        <div class="col-xs-10">
                            <div class="input-group" id="show_hide_password">
                                <input class="form-control" type="password" name="password" id="password"
                                       placeholder="{{ translateKeyword('password') }}">
                                <div class="input-group-addon">
                                    <a href="javascript:"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="password_confirmation" class="col-xs-12 col-form-label">{{ translateKeyword('password_confirmation') }}</label>
                        <div class="col-xs-10">
                            <div class="input-group" id="show_hide_password_confirmation">
                                <input class="form-control" type="password" name="password_confirmation"
                                       id="password_confirmation" placeholder="{{ translateKeyword('password')}}">
                                <div class="input-group-addon">
                                    <a href="javascript:"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if (Setting::get('zone_restrict_module', 0) == 1 && Setting::get('zone_module', 0) == 1)
                        <div class="form-group row">
                            <label for="mobile" class="col-xs-12 col-form-label">{{ translateKeyword('zone') }}</label>
                            <div class="col-xs-10">
                                <select name="zone_id" class="form-control">
                                    <option value="0" selected>{{ translateKeyword('no-zone') }}</option>
                                    @foreach ($zones as $zone)
                                        <option value="{{ $zone->id }}">{{ $zone->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endif

                    <div class="form-group row">
                        <label for="logo" class="col-xs-12 col-form-label">{{ translateKeyword('company_logo') }}</label>
                        <div class="col-xs-10">
                            <input type="file" accept="image/*" name="logo" class="dropify form-control-file" id="logo"
                                   aria-describedby="fileHelp">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="mobile" class="col-xs-12 col-form-label">{{ translateKeyword('mobile')}}</label>
                        <div class="col-xs-10">
                            <input class="form-control" type="text" value="{{ old('mobile') }}" name="mobile" required
                                   id="mobile" minlength="10" maxlength="15" placeholder="{{ translateKeyword('mobile')}}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="zipcode" class="col-xs-12 col-form-label"></label>
                        <div class="col-xs-10">
                            <button type="submit" class="btn btn-primary">{{ translateKeyword('add_fleet_owner')}}</button>
                            <a href="{{route('admin.fleet.index')}}" class="btn btn-default">{{ translateKeyword('cancel')}}</a>
                        </div>
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
