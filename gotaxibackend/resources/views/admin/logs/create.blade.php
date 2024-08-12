@extends('admin.layout.base')
@extends('admin.layout.base2')
@section('title', 'Add User ')

@section('content')
    <style>
        .input-group-addon {
            width: 35px !important;
            border-radius: 5px;
        }
    </style>
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="box box-block bg-white border-radius-10">

                <a href="{{ route('admin.user.index') }}" class="btn btn-default pull-right"><i
                            class="fa fa-angle-left"></i> {{ translateKeyword('back') }}</a>

                <h5 style="margin-bottom: 2em;">{{ translateKeyword('Add_User') }}</h5>
                @include('common.notify')
                <form class="form-horizontal" action="{{route('admin.user.store')}}" method="POST"
                      enctype="multipart/form-data" role="form">
                    {{csrf_field()}}
                    <div class="form-group row">
                        <label for="first_name" class="col-xs-12 col-form-label">{{ translateKeyword('first_name') }}</label>
                        <div class="col-xs-10">
                            <input class="form-control" type="text" value="{{ old('first_name') }}" name="first_name"
                                   required id="first_name" placeholder="{{ translateKeyword('first_name') }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="last_name" class="col-xs-12 col-form-label">{{ translateKeyword('last_name')}}</label>
                        <div class="col-xs-10">
                            <input class="form-control" type="text" value="{{ old('last_name') }}" name="last_name"
                                   required id="last_name" placeholder="{{ translateKeyword('last_name')}}">
                        </div>
                    </div>
                    
                    @if (Setting::get('email_field', 0) == 1)
                        <div class="form-group row">
                            <label for="email" class="col-xs-12 col-form-label">{{ translateKeyword('email') }}</label>
                            <div class="col-xs-10">
                                <input class="form-control" type="email" required name="email" value="{{ old('email') }}"
                                    id="email" placeholder="{{ translateKeyword('email') }}">
                            </div>
                        </div>
                    @endif
                    @if(Setting::get('gender') == 1)
                    <div class="form-group row">
                        <label for="gender" class="col-xs-12 col-form-label">{{ translateKeyword('gender') }}</label>
                        <div class="col-xs-10">
                            <label class="radio-inline">
                                <input type="radio" name="gender" value="male" checked>&nbsp; {{ translateKeyword('male')}}
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="gender" value="female">&nbsp; {{ translateKeyword('female')}}
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="gender" value="other">&nbsp; {{ translateKeyword('other')}}
                            </label>
                        </div>
                    </div>
                    @endif
                    @if(Setting::get('gender_pref_enabled') == 1)
                        <div class="form-group row">
                            <label for="gender_pref" class="col-xs-12 col-form-label">{{ translateKeyword('gender-preference') }}</label>
                            <div class="col-xs-10">
                                <label class="radio-inline">
                                    <input type="radio" name="gender_pref" value="male" checked> {{ translateKeyword('male')}}
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="gender_pref" value="female"
                                           > {{ translateKeyword('female')}}
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="gender_pref" value="both"> {{ translateKeyword('both')}}
                                </label>
                            </div>
                        </div>
                    @endif

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
                    @if (Setting::get('address_user', 0) == 1)
                        <div class="form-group row">
                            <label for="address" class="col-xs-12 col-form-label">Address</label>
                            <div class="col-xs-10">
                                <input class="form-control" type="text" value="{{ old('address') }}" name="address"
                                    required id="address" placeholder="Address">
                            </div>
                        </div>
                    @endif
                    @if (Setting::get('dob_user', 0) == 1)
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
                    @if (Setting::get('customer_pic_mandatory', 0) == 1)
                        <div class="form-group row">
                            <label for="picture" class="col-xs-12 col-form-label">Picture</label>
                            <div class="col-xs-10">
                                <input type="file" accept="image/*" name="picture" class="dropify form-control-file"
                                    id="picture" aria-describedby="fileHelp">
                            </div>
                        </div>
                    @endif
                    <div class="form-group row">
                        <label for="mobile" class="col-xs-12 col-form-label">Mobile</label>
                        <div class="col-xs-10">
                            <input class="form-control" type="text" value="{{ old('mobile') }}" name="mobile" required
                                   id="mobile" minlength="10" maxlength="15" placeholder="Mobile">
                        </div>
                    </div>
                    @if(Setting::get('wallet', 0) == 1)
                    <div class="form-group row">
                        <label for="wallet" class="col-xs-12 col-form-label">Wallet Amount</label>
                        <div class="col-xs-4">
                            <input class="form-control" type="number" name="wallet" id="wallet"
                                   value="{{ old('wallet') }}" placeholder="wallet">
                        </div>

                        <input type="hidden" name="wallet_suggestion" id="wallet_suggestion"/>
                        <div class="col-xs-2">
                            <input type="button"
                                   value="{{ trans('currency.'.Setting::get('currency')) . Setting::get('wallet_suggestion1') }}"
                                   onclick="setWalletSuggestion({{ Setting::get('wallet_suggestion1') }})"
                                   class="form-control"/>
                        </div>
                        <div class="col-xs-2">
                            <input type="button"
                                   value="{{ trans('currency.'.Setting::get('currency')) . Setting::get('wallet_suggestion2') }}"
                                   onclick="setWalletSuggestion({{ Setting::get('wallet_suggestion2') }})"
                                   class="form-control"/>
                        </div>
                        <div class="col-xs-2">
                            <input type="button"
                                   value="{{ trans('currency.'.Setting::get('currency')) . Setting::get('wallet_suggestion3') }}"
                                   onclick="setWalletSuggestion({{ Setting::get('wallet_suggestion3') }})"
                                   class="form-control"/>
                        </div>


                    </div>
                    @endif
                    @if (Setting::get('reward_point_customer', 0) == 1)
                        <div class="form-group row">
                            <label for="wallet" class="col-xs-12 col-form-label">Reward Points</label>
                            <div class="col-xs-10">
                                <input class="form-control" type="text" name="reward_points" id="reward_points"
                                    value="{{ old('reward_points') }}" placeholder="Reward Points">
                            </div>
                        </div>
                    @endif

                    <div class="form-group row">
                        <label for="zipcode" class="col-xs-12 col-form-label"></label>
                        <div class="col-xs-10">
                            <button type="submit" class="btn btn-primary">Add User</button>
                            <a href="{{route('admin.user.index')}}" class="btn btn-default">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        function setWalletSuggestion(amount) {
            $('#wallet_suggestion').val(amount);
        }

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
