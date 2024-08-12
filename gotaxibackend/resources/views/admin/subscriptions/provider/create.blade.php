@extends('admin.layout.base')
@extends('admin.layout.base2')

@section('title', '')


@section('content')


    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="box box-block bg-white border-radius-10">
                <a href="{{ route('admin.subscription-provider.index') }}" class="btn btn-default pull-right"><i
                        class="fa fa-angle-left"></i> {{ translateKeyword('back') }}</a>

                <h5 style="margin-bottom: 2em;">{{ translateKeyword('add-subscription') }}</h5>
                @include('common.notify')
                <form class="form-horizontal" action="{{ route('admin.subscription-provider.store') }}" method="POST"
                    enctype="multipart/form-data" role="form">
                    {{ csrf_field() }}
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
                                            value="{{ old('title_' . $language->id) }}" name="title_{{ $language->id }}"
                                            {{ $index === 0 ? 'required' : '' }} id="title_{{ $language->id }}"
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
                            <input class="form-control" min="1" type="number" value="{{ old('value') }}"
                                name="value" required id="value" placeholder="{{ translateKeyword('amount') }}...">
                        </div>
                    </div>

                    {{-- <div class="form-group row">
                        <label for="value" class="col-xs-2 col-form-label">Trial Period</label>
                        <div class="col-xs-3">
                            <input class="form-control" min="0" type="number" value="{{ old('trial_period') || 0 }}"
                                   name="trial_period" required id="trial_period" placeholder="Trial Period...">
                        </div>
                    </div> --}}

                    <input name="type" type="hidden" value="DRIVER" />
                    {{-- <div class="form-group row">
                        <label for="value" class="col-xs-2 col-form-label">Type</label>
                        <div class="col-xs-3">
                            <select name="type" id="type" style="width: 100%; padding: .4rem">
                                @if (Setting::get('rider_subscription_module', 0) == 1)
                                <option value="provider" >User</option>
                                @endif

                                @if (Setting::get('driver_subscription_module', 0) == 1)
                                <option value="DRIVER">Driver</option>
                                @endif
                            </select>
                        </div>
                    </div> --}}


                    <div class="form-group row">
                        <label for="days"
                            class="col-xs-2 col-form-label">{{ translateKeyword('interval-day(s)') }}</label>
                        <div class="col-xs-3">
                            <input class="form-control" min="1" type="number" value="{{ old('days') }}"
                                name="days" id="days" placeholder="{{ translateKeyword('interval-day(s)') }}..."
                                required>
                        </div>
                    </div>
                    <div class="form-group row" id="rides_field">
                        <label for="rides" class="col-xs-2 col-form-label">{{ translateKeyword('rides-new') }}</label>
                        <div class="col-xs-3">
                            <input class="form-control" min="0" type="number" value="{{ old('rides') }}"
                                name="rides" id="rides" placeholder="{{ translateKeyword('rides-new') }}...">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="rides" class="col-xs-2 col-form-label">{{ translateKeyword('unlimited') }}</label>
                        <div class="col-xs-3">
                            <input type="hidden" value="Limited" name="limit_status" />
                            <input type="checkbox" class="js-switch" data-color="#43b968" value="Unlimited"
                                name="limit_status" id="limit_status" onchange="toggleRide()">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="submit" class="col-xs-2 col-form-label"></label>
                        <div class="col-xs-3">
                            <button type="submit"
                                class="btn btn-primary">{{ translateKeyword('add-subscription') }}</button>
                            <a href="{{ route('admin.subscription-provider.index') }}"
                                class="btn btn-default">{{ translateKeyword('add-subscription') }}</a>
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

        document.addEventListener("DOMContentLoaded", function() {
            // Inner tabs
            const innerTabs = document.querySelectorAll('#myInnerTab .nav-link');

            innerTabs.forEach(tab => {
                tab.addEventListener('click', function(e) {
                    e.preventDefault();
                    const target = this.getAttribute('href');
                    document.querySelector(target).classList.add('show', 'active');
                    innerTabs.forEach(t => {
                        if (t !== tab) {
                            const paneId = t.getAttribute('href');
                            document.querySelector(paneId).classList.remove('show',
                                'active');
                        }
                    });
                });
            });
        });
    </script>
@endsection
