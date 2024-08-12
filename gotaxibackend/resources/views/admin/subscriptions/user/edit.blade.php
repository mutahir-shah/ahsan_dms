@extends('admin.layout.base')
@extends('admin.layout.base2')


@section('title', '')

@php
    $color = Setting::get('site_color', '');
@endphp

@section('content')


    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="box box-block bg-white border-radius-10">
                <a href="{{ route('admin.subscription-user.index') }}" class="btn btn-default pull-right"><i
                        class="fa fa-angle-left"></i> {{ translateKeyword('back') }}</a>

                <h5 style="margin-bottom: 2em;">{{ translateKeyword('update-subscription') }}</h5>
                @include('common.notify')
                <form class="form-horizontal" action="{{ route('admin.subscription-user.update', $subscription->id) }}"
                    method="POST" enctype="multipart/form-data" role="form">
                    {{ csrf_field() }}
                    <input type="hidden" name="_method" value="PATCH">

                    <ul class="nav nav-tabs" id="myInnerTab" role="tablist" style="margin: 10px 0 10px 0">
                        @php
                            $languages = getLanguages();
                        @endphp
                        @foreach ($languages as $index => $language)
                            <li class="nav-item">
                                <a class="nav-link {{ $index === 0 ? 'active' : '' }}" data-toggle="tab"
                                    href="#{{ $language->name }}" role="tab"
                                    aria-selected="{{ $index === 0 ? 'true' : 'false' }}">
                                    {{ $language->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                    <div class="tab-content">
                        @foreach ($languages as $index => $language)
                            <div class="tab-pane {{ $index === 0 ? 'show active' : '' }}" id="{{ $language->name }}"
                                role="tabpanel">
                                <div class="form-group row">
                                    <label for="title"
                                        class="col-xs-2 col-form-label">{{ translateKeyword('subscription-name') }}</label>
                                    <div class="col-xs-3">
                                        <input class="form-control" autocomplete="off" type="text"
                                            value="{{ old('title_' . $language->id, $subscription->translations->where('language_id', $language->id)->first()->name ?? '') }}"
                                            name="title_{{ $language->id }}" {{ $index === 0 ? 'required' : '' }}
                                            id="title_{{ $language->id }}"
                                            placeholder="{{ translateKeyword('subscription') }}...">
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <hr>
                    <div class="form-group row">
                        <label for="value" class="col-xs-2 col-form-label">{{ translateKeyword('amount') }}</label>
                        <div class="col-xs-3">
                            <input class="form-control" min="1" type="number" value="{{ $subscription->value }}"
                                name="value" required id="value" placeholder="{{ translateKeyword('amount') }}...">
                        </div>
                    </div>

                    {{-- <div class="form-group row">
                        <label for="value" class="col-xs-2 col-form-label">Trial Period</label>
                        <div class="col-xs-3">
                            <input class="form-control" min="0" type="number" value="{{ $subscription->trial_period }}"
                                   name="trial_period" required id="trial_period" placeholder="Trial Period...">
                        </div>
                    </div> --}}

                    <input name="type" type="hidden" value="USER" />
                    {{-- <div class="form-group row" style="display:none;">
                        <label for="value" class="col-xs-2 col-form-label">Type</label>
                        <div class="col-xs-3">
                            <input name="type" type="hidden" value="{{  $subscription->type }}" />
                            <select name="type" id="type" style="width: 100%; padding: .4rem" disabled>
                                @if (Setting::get('rider_subscription_module', 0) == 1)
                                    <option value="USER" @if (!$subscription->type || $subscription->type == 'USER') selected @endif>User</option>
                                @endif
                                @if (Setting::get('driver_subscription_module', 0) == 1)
                                    <option value="DRIVER"  @if ($subscription->type == 'DRIVER') selected @endif>Driver</option>
                                @endif
                            </select>
                        </div>
                    </div> --}}
                    <div class="form-group row">
                        <label for="days"
                            class="col-xs-2 col-form-label">{{ translateKeyword('interval-day(s)') }}</label>
                        <div class="col-xs-3">
                            <input class="form-control" min="1" type="number" value="{{ $subscription->days }}"
                                name="days" id="days" placeholder="{{ translateKeyword('days') }}..." required>
                        </div>
                    </div>

                    <div class="form-group row" id="rides_field">
                        <label for="rides" class="col-xs-2 col-form-label">{{ translateKeyword('rides-new') }}</label>
                        <div class="col-xs-3">
                            <input class="form-control" min="0" type="number" name="rides" id="rides"
                                placeholder="{{ translateKeyword('rides-new') }}..." value="{{ $subscription->rides }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="rides" class="col-xs-2 col-form-label">{{ translateKeyword('unlimited') }}</label>
                        <div class="col-xs-3">
                            <input type="hidden" value="Limited" name="limit_status" />
                            <input type="checkbox" class="js-switch" data-color="#43b968"
                                value="{{ translateKeyword('unlimited') }}" name="limit_status" id="limit_status"
                                @if ($subscription->rides == 'Unlimited') checked @endif onchange="toggleRide()">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="zipcode" class="col-xs-2 col-form-label"></label>
                        <div class="col-xs-3">
                            <button type="submit"
                                class="btn btn-primary">{{ translateKeyword('update-subscription') }}</button>
                            <a href="{{ route('admin.subscription-user.index') }}"
                                class="btn btn-default">{{ translateKeyword('cancel') }}</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        function toggleRide() {
            if (!$('#limit_status').is(":checked")) {
                $("#rides_field").fadeIn(700);
            } else {
                $("#rides_field").fadeOut(700);
            }
        }
    </script>
@endsection
