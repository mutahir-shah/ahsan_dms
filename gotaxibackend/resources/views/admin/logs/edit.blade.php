@extends('admin.layout.base')
@extends('admin.layout.base2')
@section('title', 'Update User ')

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
                            class="fa fa-angle-left"></i> {{ translateKeyword('back')}}</a>

                <h5 style="margin-bottom: 2em;">{{ translateKeyword('Update_User')}}</h5>
                @include('common.notify')
                <form class="form-horizontal" action="{{route('admin.user.update', $user->id )}}" method="POST"
                      enctype="multipart/form-data" role="form">
                    {{csrf_field()}}
                    <input type="hidden" name="_method" value="PATCH">
                    <div class="form-group row">
                        <label for="first_name" class="col-xs-2 col-form-label">{{ translateKeyword('first_name')}}</label>
                        <div class="col-xs-10">
                            <input class="form-control" type="text" value="{{ $user->first_name }}" name="first_name"
                                   required id="first_name" placeholder="{{ translateKeyword('first_name')}}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="last_name" class="col-xs-2 col-form-label">{{ translateKeyword('last_name')}}</label>
                        <div class="col-xs-10">
                            <input class="form-control" type="text" value="{{ $user->last_name }}" name="last_name"
                                   required id="last_name" placeholder="{{ translateKeyword('last_name')}}">
                        </div>
                    </div>

                    @if (Setting::get('email_field', 0) == 1)
                        <div class="form-group row">
                            <label for="email" class="col-xs-2 col-form-label">{{ translateKeyword('email')}}</label>
                            <div class="col-xs-10">
                                <input class="form-control" type="email" required name="email" value="{{ old('email', $user->email) }}"
                                    id="email" placeholder="{{ translateKeyword('email')}}">
                            </div>
                        </div>
                    @endif

                    @if (Setting::get('customer_pic_mandatory', 0) == 1)
                    <div class="form-group row">

                        <label for="picture" class="col-xs-2 col-form-label">{{ translateKeyword('picture')}}</label>
                        <div class="col-xs-10">
                            @if(isset($user->picture))
                                <img style="height: 90px; margin-bottom: 15px; border-radius:2em;"
                                     src=" {{  URL::to('/') }}/storage/{{$user->picture}}">
                            @endif
                            <input type="file" accept="image/*" name="picture" class="dropify form-control-file"
                                   id="picture" aria-describedby="fileHelp">
                        </div>
                    </div>
                    @endif
                    <div class="form-group row">
                        <label for="mobile" class="col-xs-2 col-form-label">{{ translateKeyword('mobile')}}</label>
                        <div class="col-xs-10">
                            <input class="form-control" type="text" value="{{ $user->mobile }}" name="mobile" required
                                   id="mobile" minlength="10" maxlength="15" placeholder="Mobile">
                        </div>
                    </div>
                    @if(Setting::get('gender') == 1)
                    <div class="form-group row">
                        <label for="gender" class="col-xs-2 col-form-label">{{ translateKeyword('gender')}}</label>
                        <div class="col-xs-10">
                            <label class="radio-inline">
                                <input type="radio" name="gender"
                                       value="male" {{ $user->gender == 'male' ? 'checked' : '' }}>&nbsp; {{ translateKeyword('male')}}
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="gender"
                                       value="female" {{ $user->gender == 'female' ? 'checked' : '' }}>&nbsp; {{ translateKeyword('Female')}}
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="gender"
                                       value="other" {{ $user->gender == 'other' ? 'checked' : '' }}>&nbsp; {{ translateKeyword('Other')}}
                            </label>
                        </div>
                    </div>
                    @endif
                    @if(Setting::get('gender_pref_enabled') == 1)
                        <div class="form-group row">
                            <label for="gender_pref" class="col-xs-2 col-form-label">{{ translateKeyword('gender-preference')}}</label>
                            <div class="col-xs-10">
                                <label class="radio-inline">
                                    <input type="radio" name="gender_pref"
                                           value="female" {{ $user->gender_pref == 'female' ? 'checked' : '' }}
                                    > {{ translateKeyword('female')}}
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="gender_pref"
                                           value="male" {{ $user->gender_pref == 'male' ? 'checked' : '' }}> {{ translateKeyword('male')}}
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="gender_pref"
                                           value="both" {{ $user->gender_pref == 'both' ? 'checked' : '' }}> {{ translateKeyword('both')}}
                                </label>
                            </div>
                        </div>
                    @endif

                    <div class="form-group row">
                        <label for="password" class="col-xs-2 col-form-label">{{ translateKeyword('password')}}</label>
                        <div class="col-xs-10">
                            <div class="input-group" id="show_hide_password">
                                <input class="form-control" type="password" name="password" id="password"
                                       placeholder="{{ translateKeyword('password')}}">
                                <div class="input-group-addon">
                                    <a href="javascript:"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if (Setting::get('address_user', 0) == 1)
                        <div class="form-group row">
                            <label for="address" class="col-xs-12 col-form-label">{{ translateKeyword('address')}}</label>
                            <div class="col-xs-10">
                                <input class="form-control" type="text" value="{{ old('address', $user->address) }}" name="address"
                                    required id="address" placeholder="{{ translateKeyword('address')}}">
                            </div>
                        </div>
                    @endif
                    @if (Setting::get('dob_user', 0) == 1)
                        <div class="form-group row">
                            <label for="dob" class="col-xs-12 col-form-label">{{ translateKeyword('date-of-birth')}}</label>
                            <div class="col-xs-10">
                                <input class="form-control" type="date" value="{{ old('dob', $user->dob) }}" name="dob"
                                    required id="dob" placeholder="{{ translateKeyword('date-of-birth')}}">
                            </div>
                        </div>
                    @endif
                    @if (Setting::get('zone_restrict_module', 0) == 1 && Setting::get('zone_module', 0) == 1)
                        <div class="form-group row">
                            <label for="mobile" class="col-xs-12 col-form-label">{{ translateKeyword('zone')}}</label>
                            <div class="col-xs-10">
                                <select name="zone_id" class="form-control">
                                    <option value="0" selected>{{ translateKeyword('no-zone')}}</option>
                                    @foreach ($zones as $zone)
                                        <option value="{{ $zone->id }}" 
                                            @if ($zone->id == $user->zone_id)
                                                selected
                                            @endif
                                        >{{ $zone->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endif
                    @if(Setting::get('wallet', 0) == 1)
                    <div class="form-group row">
                        <label for="wallet" class="col-xs-2 col-form-label">{{ translateKeyword('Wallet_Amount')}}</label>
                        <div class="col-xs-4">
                            <input class="form-control" type="number" name="wallet" value="{{ $user->wallet_balance }}"
                                   id="wallet" placeholder="{{ translateKeyword('Wallet_Amount')}}">
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
                        <label for="reward_points" class="col-xs-2 col-form-label">{{ translateKeyword('reward-points')}}</label>
                        <div class="col-xs-10">
                            <input class="form-control" type="text" name="reward_points"
                                   value="{{ $user->reward_points }}"
                                   id="reward_points" placeholder="{{ translateKeyword('reward-points')}}">
                        </div>
                    </div>
                    @endif
                    <div class="form-group row">
                        <label for="zipcode" class="col-xs-2 col-form-label"></label>
                        <div class="col-xs-10">
                            <button type="submit" class="btn btn-primary">{{ translateKeyword('Update_User')}}</button>
                            <a href="{{route('admin.user.index')}}" class="btn btn-default">{{ translateKeyword('cancel')}}</a>
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

        });

    </script>
@endsection
