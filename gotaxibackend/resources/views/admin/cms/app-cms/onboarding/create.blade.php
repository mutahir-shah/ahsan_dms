@extends('admin.layout.base')
@extends('admin.layout.base2')
@section('title', 'Add Faq ')

@section('content')

    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="box box-block bg-white border-radius-10">
                <a href="{{ route('admin.cms.app') }}" class="btn btn-default pull-right"><i class="fa fa-angle-left"></i>
                    {{ translateKeyword('back') }}</a>

                <h5 style="margin-bottom: 2em;">{{ translateKeyword('add-onboarding') }}</h5>
                @include('common.notify')
                <form class="form-horizontal" action="{{ route('admin.onboardings.store') }}" method="POST"
                    enctype="multipart/form-data" role="form">
                    {{ csrf_field() }}
                    <ul class="nav nav-tabs" id="myInnerTab" role="tablist" style="margin-bottom: 10px">
                        @php($languages = getLanguages())
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
                                <div class="col-12 mt-1">
                                    <div class="form-group row">
                                        <label for="name"
                                            class="col-xs-12 col-form-label">{{ translateKeyword('onboarding-title') }}</label>
                                        <div class="col-xs-10">
                                            <input class="form-control" type="text" value=""
                                                name="onboarding_user_title{{ $language->id }}"
                                                id="onboarding_user_title{{ $language->id }}"
                                                placeholder="{{ translateKeyword('onboarding-user-title') }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="name"
                                            class="col-xs-12 col-form-label">{{ translateKeyword('onboarding-description') }}</label>
                                        <div class="col-xs-10">
                                            <input class="form-control" type="text" value=""
                                                name="onboarding_user_description{{ $language->id }}"
                                                id="onboarding_user_description{{ $language->id }}"
                                                placeholder="{{ translateKeyword('onboarding-user-description') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <hr>
                        <div class="form-group row">
                            <label for="name" class="col-xs-12 col-form-label">{{ translateKeyword('type') }}</label>
                            <div class="col-xs-10">
                                <select class="form-control" name="type" id="type"
                                    placeholder="{{ translateKeyword('cancellation-reason') }}...">
                                    <option value="USER">User</option>
                                    <option value="DRIVER">Driver</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="onboarding_user_image1"
                                class="col-xs-3 col-form-label">{{ translateKeyword('onboarding-image') }} 1
                            </label>
                            <div class="col-xs-10">
                                <input type="file" accept="image/*" name="onboarding_image"
                                    class="dropify form-control-file" id="onboarding_image"
                                    aria-describedby="fileHelp">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="zipcode" class="col-xs-12 col-form-label"></label>
                        <div class="col-xs-10">
                            <button type="submit" class="btn btn-primary">{{ translateKeyword('add') }}</button>
                            <a href="{{ route('admin.cms.app') }}"
                                class="btn btn-default">{{ translateKeyword('cancel') }}</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
