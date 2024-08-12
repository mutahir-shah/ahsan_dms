@extends('admin.layout.base')
@extends('admin.layout.base2')


@section('title', 'Update Provider ')

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
                <h5 style="margin-bottom: 2em;">{{ translateKeyword('Update Provider') }}</h5>
                @include('common.notify')
                <form class="form-horizontal" action="{{ route('admin.provider.update', $provider->id) }}" method="POST"
                    enctype="multipart/form-data" role="form">
                    {{ csrf_field() }}
                    <input type="hidden" name="_method" value="PATCH">
                    <div class="row">
                        <div class="row">
                            @if (Setting::get('driver_pic_mandatory', 0) == 1)
                                <div class="form-group col-12">
                                    <label for="picture"
                                        class="col-md-12 col-form-label">{{ translateKeyword('image') }}</label>
                                    <div class="col-md-10">
                                        @if (isset($provider->picture))
                                            <img style="height: 90px; margin-bottom: 15px; border-radius:2em;"
                                                src="{{ $provider->picture }}">
                                        @endif
                                        <input type="file" accept="image/*" name="avatar"
                                            class="dropify form-control-file" id="picture" aria-describedby="fileHelp">
                                    </div>
                                </div>
                            @endif
                            <div class="form-group col-4">
                                <label for="first_name"
                                    class="col-md-12 col-form-label">{{ translateKeyword('first_name') }}</label>
                                <div class="col-md-12">
                                    <input class="form-control" type="text" value="{{ $provider->first_name }}"
                                        name="first_name" required id="first_name"
                                        placeholder="{{ translateKeyword('first_name') }}">
                                </div>
                            </div>

                            {{-- <label class="col-md-12 col-form-label"></label> --}}
                            <div class="form-group col-4">
                                <label for="last_name"
                                    class="col-md-12 col-form-label">{{ translateKeyword('last_name') }}</label>
                                <div class="col-md-12">
                                    <input class="form-control" type="text" value="{{ $provider->last_name }}"
                                        name="last_name" required id="last_name"
                                        placeholder="{{ translateKeyword('last_name') }}">
                                </div>
                            </div>

                            <div class="col-4"></div>

                            @if (Setting::get('partner_company_info') == 1)
                                <label for="company_name"
                                    class="col-md-2 col-form-label">{{ translateKeyword('company_name') }}</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" value="{{ $provider->company_name }}"
                                        name="company_name" required id="company_name"
                                        placeholder="{{ translateKeyword('company_name') }}">
                                </div>
                                <label class="col-md-12 col-form-label"></label>

                                <label for="company_address"
                                    class="col-md-2 col-form-label">{{ translateKeyword('company_address') }}</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" value="{{ $provider->company_address }}"
                                        name="company_address" required id="company_address"
                                        placeholder="{{ translateKeyword('company_address') }}">
                                </div>
                                <label class="col-md-12 col-form-label"></label>

                                <label for="company_vat"
                                    class="col-md-2 col-form-label">{{ translateKeyword('company_vat') }}</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" value="{{ $provider->company_vat }}"
                                        name="company_vat" required id="company_vat"
                                        placeholder="{{ translateKeyword('company_vat') }}">
                                </div>
                            @endif
                            <label class="col-md-12 col-form-label"></label>
                            @if (Setting::get('gender', 0) == 1)
                                <div class="form-group col-4">
                                    <label for="gender"
                                        class="col-md-12 col-form-label">{{ translateKeyword('gender') }}</label>
                                    <div class="col-md-12">
                                        <label class="radio-inline">
                                            <input type="radio" name="gender" value="male"
                                                {{ $provider->gender == 'male' ? 'checked' : '' }}>&nbsp;
                                            {{ translateKeyword('male') }}
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="gender" value="female"
                                                {{ $provider->gender == 'female' ? 'checked' : '' }}>&nbsp;
                                            {{ translateKeyword('female') }}
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="gender" value="other"
                                                {{ $provider->gender == 'other' ? 'checked' : '' }}>&nbsp;
                                            {{ translateKeyword('other') }}
                                        </label>
                                    </div>
                                </div>
                            @endif
                            @if (Setting::get('gender_pref_enabled') == 1)
                                <label class="col-md-12 col-form-label"></label>

                                <div class="form-group col-4">
                                    <label for="gender_pref"
                                        class="col-md-12 col-form-label">{{ translateKeyword('gender-preference') }}</label>
                                    <div class="col-md-12">
                                        <label class="radio-inline">
                                            <input type="radio" name="gender_pref" value="female"
                                                {{ $provider->gender_pref == 'female' ? 'checked' : '' }}>
                                            {{ translateKeyword('female') }}
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="gender_pref" value="male"
                                                {{ $provider->gender_pref == 'male' ? 'checked' : '' }}>
                                            {{ translateKeyword('male') }}
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="gender_pref" value="both"
                                                {{ $provider->gender_pref == 'both' ? 'checked' : '' }}>
                                            {{ translateKeyword('both') }}
                                        </label>
                                    </div>
                                </div>
                            @endif

                            @if (Setting::get('email_field', 0) == 1)
                                <div class="form-group col-4">
                                    <label for="mobile"
                                        class="col-md-12 col-form-label">{{ translateKeyword('email') }}</label>
                                    <div class="col-md-12">
                                        <input class="form-control" type="text" value="{{ $provider->email }}"
                                            name="email" required id="email" placeholder="Email">
                                    </div>
                                </div>
                            @endif

                            <div class="form-group col-4">
                                <label for="mobile"
                                    class="col-md-12 col-form-label">{{ translateKeyword('mobile') }}</label>
                                <div class="col-md-12">
                                    <input class="form-control" type="text" value="{{ $provider->mobile }}"
                                        name="mobile" required id="mobile" minlength="10" maxlength="15"
                                        placeholder="Mobile">
                                </div>
                            </div>

                            <label class="col-md-12 col-form-label"></label>

                            <div class="form-group col-4">
                                <label for="password"
                                    class="col-md-12 col-form-label">{{ translateKeyword('password') }}</label>
                                <div class="col-md-12">
                                    <div class="input-group" id="show_hide_password">
                                        <input class="form-control" type="password" name="password" id="password"
                                            placeholder="{{ translateKeyword('password') }}">
                                        <div class="input-group-addon">
                                            <a href="javascript:"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            @if (Setting::get('tax_tps_info_field', 0) == 1)
                                <label for="tax_tps_info"
                                    class="col-md-2 col-form-labe">{{ translateKeyword('tax_tps_info_field') }}</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text"
                                        value="{{ $provider->tax_tps_info }}"name="tax_tps_info" required
                                        id="tax_tps_info" placeholder="{{ translateKeyword('tax_tps_info_field') }}"
                                        required>
                                </div>
                            @endif

                            @if (Setting::get('tax_tvq_info_field', 0) == 1)
                                <label for="tax_tvq_info"
                                    class="col-md-2 col-form-labe">{{ translateKeyword('tax_tvq_info_field') }}</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text"
                                        value="{{ $provider->tax_tvq_info }}"name="tax_tvq_info" required
                                        id="tax_tvq_info" placeholder="{{ translateKeyword('tax_tvq_info_field') }}">
                                </div>
                            @endif


                            <div class="form-group col-4">
                                <label for="mobile"
                                class="col-md-12 col-form-label">{{ translateKeyword('Fleet owner') }}</label>
                            <div class="col-md-12">
                                <select name="fleet" class="form-control">
                                    <option value="0" @if ($provider->fleet == '0') selected @endif>
                                        {{ translateKeyword('No Owner') }}</option>
                                    @foreach ($fleets as $fleet)
                                        <option value="{{ $fleet->id }}"
                                            @if ($fleet->id == $provider->fleet) selected @endif>{{ $fleet->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            </div>

                            <label class="col-md-12 col-form-label"></label>
                            @if (Setting::get('wallet', 0) == 1)
                                <div class="form-group col-12">
                                    <label for="wallet"
                                    class="col-md-12 col-form-label">{{ translateKeyword('Wallet_Amount') }}</label>
                                <div class="col-md-12">
                                    <div class="col-xs-4" style="padding-left: 0">
                                        <input class="form-control" type="number" value="{{ $provider->wallet }}"
                                            name="wallet" required id="wallet"
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
                                </div>
                                </div>
                                <label class="col-md-12 col-form-label"></label>
                            @endif

                            @if (Setting::get('address_driver', 0) == 1)
                                <div class="form-group row">
                                    <label for="address"
                                        class="col-xs-12 col-form-label">{{ translateKeyword('address') }}</label>
                                    <div class="col-xs-10">
                                        <input class="form-control" type="text"
                                            value="{{ old('address', $provider->address) }}" name="address" required
                                            id="address" placeholder="{{ translateKeyword('address') }}">
                                    </div>
                                </div>
                            @endif
                            @if (Setting::get('dob_driver', 0) == 1)
                                <div class="form-group row">
                                    <label for="dob"
                                        class="col-xs-12 col-form-label">{{ translateKeyword('date-of-birth') }}</label>
                                    <div class="col-xs-10">
                                        <input class="form-control" type="date"
                                            value="{{ old('dob', $provider->dob) }}" name="dob" required
                                            id="dob" placeholder="{{ translateKeyword('date-of-birth') }}">
                                    </div>
                                </div>
                            @endif
                            @if (Setting::get('zone_restrict_module', 0) == 1 && Setting::get('zone_module', 0) == 1)
                                <div class="form-group row">
                                    <label for="mobile"
                                        class="col-xs-12 col-form-label">{{ translateKeyword('zone') }}</label>
                                    <div class="col-xs-10">
                                        <select name="zone_id" class="form-control">
                                            <option value="0" selected>{{ translateKeyword('no-zone') }}</option>
                                            @foreach ($zones as $zone)
                                                <option value="{{ $zone->id }}"
                                                    @if ($zone->id == $provider->zone_id) selected @endif>{{ $zone->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @endif

                            <label class="col-md-12 col-form-label"></label>

                            <label for="zipcode" class="col-md-2 col-form-label"></label>
                            <div class="col-md-10">
                                <button type="submit"
                                    class="btn btn-primary">{{ translateKeyword('Update Provider') }}</button>
                                <a href="{{ route('admin.provider.index') }}"
                                    class="btn btn-default">{{ translateKeyword('cancel') }}</a>
                            </div>
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

        });
    </script>
@endsection
