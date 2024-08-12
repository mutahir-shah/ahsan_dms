@extends('admin.layout.base')
@extends('admin.layout.base2')

@section('title', 'Add Provider ')

@section('content')
    <style>
        .input-group-addon {
            width: 35px !important;
            border-radius: 5px;
        }

        .dropify-wrapper {
            width: 200px;
            /* Set your desired width */
            height: 200px;
            border-radius: 15px;
            /* Set your desired height */
        }

        .dropify-message {
            font-size: 14px;
            /* Adjust text size if needed */
        }

        .dropify-preview {
            height: 100%;
            border-radius: 15px;
            /* Ensure the preview area fits the wrapper height */
        }

        .dropify-render img {
            height: auto;
            /* Ensure images don't overflow */
            max-height: 100%;
            border-radius: 15px;
            /* Fit image within the wrapper height */
        }
    </style>
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="box box-block bg-white border-radius-10">
                <a href="{{ route('admin.provider.index') }}" class="btn btn-default pull-right"><i
                        class="fa fa-angle-left"></i> Back</a>

                <h5 style="margin-bottom: 2em;">{{ translateKeyword('Add Provider') }}</h5>
                @include('common.notify')
                <form class="form-horizontal row" action="{{ route('admin.provider.store') }}" method="POST"
                    enctype="multipart/form-data" role="form">
                    {{ csrf_field() }}

                    @if (Setting::get('driver_pic_mandatory', 0) == 1)
                        <div class="form-group col-12">
                            <label for="picture" class="col-xs-12 col-form-label">{{ translateKeyword('image') }}</label>
                            <div class="col-xs-10">
                                <input type="file" accept="image/*" name="avatar" class="dropify form-control-file"
                                    id="picture" aria-describedby="fileHelp">
                            </div>
                        </div>
                    @endif
                    <div class="form-group col-4">
                        <label for="first_name"
                            class="col-xs-12 col-form-label">{{ translateKeyword('first_name') }}</label>
                        <div class="col-xs-10">
                            <input class="form-control" type="text" value="{{ old('first_name') }}" name="first_name"
                                required id="first_name" placeholder="{{ translateKeyword('first_name') }}">
                        </div>
                    </div>

                    <div class="form-group col-4">
                        <label for="last_name" class="col-xs-12 col-form-label">{{ translateKeyword('last_name') }}</label>
                        <div class="col-xs-10">
                            <input class="form-control" type="text" value="{{ old('last_name') }}" name="last_name"
                                required id="last_name" placeholder="{{ translateKeyword('last_name') }}">
                        </div>
                    </div>
                    <div class="col-4"></div>

                    @if (Setting::get('gender', 0) == 1)
                        <div class="form-group col-4">
                            <label for="gender" class="col-xs-12 col-form-label">{{ translateKeyword('gender') }}</label>
                            <div class="col-xs-10">
                                <label class="radio-inline">
                                    <input type="radio" name="gender" value="male" checked>&nbsp;
                                    {{ translateKeyword('male') }}
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="gender" value="female">&nbsp;
                                    {{ translateKeyword('female') }}
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="gender" value="other">&nbsp;
                                    {{ translateKeyword('other') }}
                                </label>
                            </div>
                        </div>
                    @endif
                    @if (Setting::get('gender_pref_enabled') == 1)
                        <div class="form-group col-4">
                            <label for="gender_pref"
                                class="col-xs-12 col-form-label">{{ translateKeyword('gender-preference') }}</label>
                            <div class="col-xs-10">
                                <label class="radio-inline">
                                    <input type="radio" name="gender_pref" value="male" checked>
                                    {{ translateKeyword('male') }}
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="gender_pref" value="female">
                                    {{ translateKeyword('female') }}
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="gender_pref" value="both"> {{ translateKeyword('both') }}
                                </label>
                            </div>
                        </div>
                    @endif

                    @if (Setting::get('email_field', 0) == 1)
                        <div class="form-group col-4">
                            <label for="email" class="col-xs-12 col-form-label">{{ translateKeyword('email') }}</label>
                            <div class="col-xs-10">
                                <input class="form-control" type="email" required name="email"
                                    value="{{ old('email') }}" id="email"
                                    placeholder="{{ translateKeyword('email') }}">
                            </div>
                        </div>
                    @endif

                    <div class="form-group col-4">
                        <label for="mobile" class="col-xs-12 col-form-label">{{ translateKeyword('mobile') }}</label>
                        <div class="col-xs-10">
                            <input class="form-control" type="text" value="{{ old('mobile') }}" name="mobile"
                                required id="mobile" minlength="10" maxlength="15"
                                placeholder="{{ translateKeyword('mobile') }}">
                        </div>
                    </div>

                    <div class="form-group col-4">
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

                    <div class="form-group col-4">
                        <label for="password_confirmation"
                            class="col-xs-12 col-form-label">{{ translateKeyword('password_confirmation') }}</label>
                        <div class="col-xs-10">
                            <div class="input-group" id="show_hide_password_confirmation">
                                <input class="form-control" type="password" name="password_confirmation"
                                    id="password_confirmation" placeholder="{{ translateKeyword('password') }}">
                                <div class="input-group-addon">
                                    <a href="javascript:"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group col-4">
                        <label for="mobile"
                            class="col-xs-12 col-form-label">{{ translateKeyword('Fleet owner') }}</label>
                        <div class="col-xs-10">
                            <select name="fleet" class="form-control">
                                <option value="0" selected>{{ translateKeyword('No Owner') }}</option>
                                @foreach ($fleets as $fleet)
                                    <option value="{{ $fleet->id }}">{{ $fleet->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    @if (Setting::get('partner_company_info') == 1)
                        <div class="form-group row">
                            <label for="company_name"
                                class="col-xs-12 col-form-label">{{ translateKeyword('company_name') }}</label>
                            <div class="col-xs-10">
                                <input class="form-control" type="text" value="{{ old('company_name') }}"
                                    name="company_name" required id="company_name"
                                    placeholder="{{ translateKeyword('company_name') }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="company_address"
                                class="col-xs-12 col-form-label">{{ translateKeyword('company_address') }}</label>
                            <div class="col-xs-10">
                                <input class="form-control" type="text" value="{{ old('company_address') }}"
                                    name="company_address" required id="company_address"
                                    placeholder="{{ translateKeyword('company_address') }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="company_vat"
                                class="col-xs-12 col-form-label">{{ translateKeyword('company_vat') }}</label>
                            <div class="col-xs-10">
                                <input class="form-control" type="text" value="{{ old('company_vat') }}"
                                    name="company_vat" required id="company_vat"
                                    placeholder="{{ translateKeyword('company_vat') }}">
                            </div>
                        </div>
                    @endif

                    @if (Setting::get('address_driver', 0) == 1)
                        <div class="form-group row">
                            <label for="address"
                                class="col-xs-12 col-form-label">{{ translateKeyword('address') }}</label>
                            <div class="col-xs-10">
                                <input class="form-control" type="text" value="{{ old('address') }}" name="address"
                                    required id="address" placeholder="{{ translateKeyword('address') }}">
                            </div>
                        </div>
                    @endif
                    @if (Setting::get('dob_driver', 0) == 1)
                        <div class="form-group row">
                            <label for="dob"
                                class="col-xs-12 col-form-label">{{ translateKeyword('date-of-birth') }}</label>
                            <div class="col-xs-10">
                                <input class="form-control" type="date" value="{{ old('dob') }}" name="dob"
                                    required id="dob" placeholder="{{ translateKeyword('date-of-birth') }}">
                            </div>
                        </div>
                    @endif
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

                    @if (Setting::get('tax_tps_info_field', 0) == 1)
                        <div class="form-group row">
                            <label for="mobile" class="col-xs-12 col-form-label">tax_tps_info_field</label>
                            <div class="col-xs-10">
                                <input class="form-control" type="text" value="{{ old('tax_tps_info') }}"
                                    name="tax_tps_info" required id="tax_tps_info" placeholder="tax_tps_info_field"
                                    required>
                            </div>
                        </div>
                    @endif

                    @if (Setting::get('tax_tvq_info_field', 0) == 1)
                        <div class="form-group row">
                            <label for="mobile" class="col-xs-12 col-form-label">tax_tvq_info_field</label>
                            <div class="col-xs-10">
                                <input class="form-control" type="text" value="{{ old('tax_tvq_info') }}"
                                    name="tax_tvq_info" required id="tax_tvq_info" placeholder="tax_tvq_info_field">
                            </div>
                        </div>
                    @endif

                    @if (Setting::get('wallet', 0) == 1)
                        <div class="form-group col-12">
                            <label for="wallet"
                                class="col-xs-12 col-form-label">{{ translateKeyword('Wallet_Amount') }}</label>
                            <div class="col-xs-4">
                                <input class="form-control" type="number" name="wallet" value="{{ old('wallet') }}"
                                    required id="wallet" data-orignal-value onchange="updateOrignalValue()"
                                    placeholder="{{ translateKeyword('Wallet_Amount') }}">
                            </div>
                            <input type="hidden" name="wallet_suggestion" id="wallet_suggestion" />
                            <div class="col-xs-2">
                                <input type="button"
                                    value="{{ trans('currency.' . Setting::get('currency')) . Setting::get('wallet_suggestion1') }}"
                                    onclick="setWalletSuggestion({{ Setting::get('wallet_suggestion1') }})"
                                    class="form-control" />
                            </div>
                            <div class="col-xs-2">
                                <input type="button"
                                    value="{{ trans('currency.' . Setting::get('currency')) . Setting::get('wallet_suggestion2') }}"
                                    onclick="setWalletSuggestion({{ Setting::get('wallet_suggestion2') }})"
                                    class="form-control" />
                            </div>
                            <div class="col-xs-2">
                                <input type="button"
                                    value="{{ trans('currency.' . Setting::get('currency')) . Setting::get('wallet_suggestion3') }}"
                                    onclick="setWalletSuggestion({{ Setting::get('wallet_suggestion3') }})"
                                    class="form-control" />
                            </div>

                            <div class="col-xs-1">
                                <input type="button" value="Clear" onclick="resetWalletToOrignalValue()"
                                    class="form-control" />
                            </div>
                        </div>
                    @endif

                    <div class="form-group col-12">
                        <label for="zipcode" class="col-xs-12 col-form-label"></label>
                        <div class="col-xs-10">
                            <button type="submit"
                                class="btn btn-primary">{{ translateKeyword('Add Provider') }}</button>
                            <a href="{{ route('admin.provider.index') }}"
                                class="btn btn-default">{{ translateKeyword('cancel') }}</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        function setWalletSuggestion(amount) {
            const walletValue = parseInt($('#wallet').val());
            const currentValue = isNaN(walletValue) ? 0 : parseInt(walletValue);
            $('#wallet').val(currentValue + amount);
        }

        function resetWalletToOrignalValue() {
            const walletInput = $('#wallet');
            const orignalValue = parseInt(walletInput.attr('data-orignal-value'));
            walletInput.val(!isNaN(orignalValue) ? orignalValue : '');
        }

        function updateOrignalValue() {
            const walletInput = $('#wallet');
            const value = parseInt(walletInput.val());
            !isNaN(value) && walletInput.attr('data-orignal-value', value);
        }

        $(document).ready(function() {

            $("#show_hide_password a").on('click', function(event) {
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

            $("#show_hide_password_confirmation a").on('click', function(event) {
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
