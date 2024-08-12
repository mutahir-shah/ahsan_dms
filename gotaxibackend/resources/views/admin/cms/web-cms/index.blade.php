@extends('admin.layout.base')
@extends('admin.layout.base2')

@section('title', 'Site CMS')

@section('content')

<link rel="stylesheet" href="{{ asset('admin') }}/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('admin') }}/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">


    <div class="content-wrapper">
        <section class="content">
            <div class="row">
                <div class="col-12">
                    <div class="card border-radius-10">
                        <div class="card-header" style="border-bottom: none">
                            @include('common.notify')
                            <h3 class="card-title">{{ translateKeyword('site_settings') }}</h3>
                        </div>
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#site_content" role="tab"
                                    aria-selected="true">
                                    {{ translateKeyword('Website Content') }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#contact" role="tab" aria-selected="false">
                                    {{ translateKeyword('Contact Page') }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#site_media" role="tab"
                                    aria-selected="false">
                                    {{ translateKeyword('Website Media') }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#site_color" role="tab"
                                    aria-selected="false">
                                    {{ translateKeyword('Website Color') }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#google_map" role="tab"
                                    aria-selected="false">
                                    {{ translateKeyword('Google Map') }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#social-links" role="tab"
                                    aria-selected="false">
                                    {{ translateKeyword('Social Links') }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#app-links" role="tab"
                                    aria-selected="false">
                                    {{ translateKeyword('app_links') }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#faqs" role="tab" aria-selected="false">
                                    {{ translateKeyword('faqs') }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#privacy_policy" role="tab"
                                    aria-selected="false">
                                    {{ translateKeyword('Privacy Policy') }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#terms" role="tab" aria-selected="false">
                                    {{ translateKeyword('terms_conditions') }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#driver" role="tab" aria-selected="false">
                                    {{ translateKeyword('driver') }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#about" role="tab" aria-selected="false">
                                    {{ translateKeyword('f_33') }}
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane show active" id="site_content" role="tabpanel">
                                <form action="{{ route('admin.cms.web-content-update') }}" id="contentSettingsForm"
                                    method="post">
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <div class="col-12">
                                            <ul class="nav nav-tabs" id="myInnerTab" role="tablist"
                                                style="margin: 10px 0 10px 10px">

                                                @foreach ($languages as $index => $language)
                                                    <li class="nav-item">
                                                        <a class="nav-link {{ $index === 0 ? 'active' : '' }}"
                                                            data-toggle="tab" href="#{{ $language->name }}" role="tab"
                                                            aria-selected="{{ $index === 0 ? 'true' : 'false' }}">
                                                            {{ $language->name }}
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                            <div class="tab-content">
                                                @foreach ($languages as $index => $language)
                                                    <div class="tab-pane {{ $index === 0 ? 'show active' : '' }}"
                                                        id="{{ $language->name }}" role="tabpanel">
                                                        <div class="col-12 mt-1">
                                                            <div class="form-group row">
                                                                <label for="site_title_{{ $language->name }}"
                                                                    class="col-xs-2 col-form-label">{{ translateKeyword('site-title') }}</label>
                                                                <div class="col-xs-10">
                                                                    @php($webContent = collect($webContents)->firstWhere('language_id', $language->id))
                                                                    <input class="form-control" type="text"
                                                                        value="{{ $webContent ? $webContent['site_title'] : '' }}"
                                                                        name="site_title_{{ $language->name }}"
                                                                        {{ $index === 0 ? 'required' : '' }}
                                                                        id="site_title_{{ $language->name }}"
                                                                        placeholder="{{ translateKeyword('site-title') }} {{ $language->name }}">
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label for="site_sub_title_{{ $language->name }}"
                                                                    class="col-xs-2 col-form-label">{{ translateKeyword('site-sub-title') }}</label>
                                                                <div class="col-xs-10">
                                                                    <input class="form-control" type="text"
                                                                        value="{{ $webContent ? $webContent['site_sub_title'] : '' }}"
                                                                        name="site_sub_title_{{ $language->name }}"
                                                                        {{ $index === 0 ? 'required' : '' }}
                                                                        id="site_sub_title_{{ $language->name }}"
                                                                        placeholder="{{ translateKeyword('site-sub-title') }} {{ $language->name }}">
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label for="meta_title_{{ $language->name }}"
                                                                    class="col-xs-2 col-form-label">{{ translateKeyword('meta-title') }}</label>
                                                                <div class="col-xs-10">
                                                                    <input class="form-control" type="text"
                                                                        value="{{ $webContent ? $webContent['meta_title'] : '' }}"
                                                                        name="meta_title_{{ $language->name }}"
                                                                        id="meta_title_{{ $language->name }}"
                                                                        placeholder="{{ translateKeyword('meta-title') }} {{ $language->name }}">
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label for="meta_keywords_{{ $language->name }}"
                                                                    class="col-xs-2 col-form-label">{{ translateKeyword('meta-keywords') }}</label>
                                                                <div class="col-xs-10">
                                                                    <input class="form-control" type="text"
                                                                        value="{{ $webContent ? $webContent['meta_keyword'] : '' }}"
                                                                        name="meta_keywords_{{ $language->name }}"
                                                                        id="meta_keywords_{{ $language->name }}"
                                                                        placeholder="{{ translateKeyword('meta-keywords') }} {{ $language->name }}">
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label for="meta_description_{{ $language->name }}"
                                                                    class="col-xs-2 col-form-label">{{ translateKeyword('meta-description') }}</label>
                                                                <div class="col-xs-10">
                                                                    <textarea class="form-control" name="meta_description_{{ $language->name }}"
                                                                        id="meta_description_{{ $language->name }}"
                                                                        placeholder="{{ translateKeyword('meta-description') }} {{ $language->name }}" maxlength="160">{{ $webContent ? $webContent['meta_description'] : '' }}</textarea>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label for="introduction_text_{{ $language->name }}"
                                                                    class="col-xs-2 col-form-label">{{ translateKeyword('introduction-text') }}</label>
                                                                <div class="col-xs-10">
                                                                    <textarea class="form-control" name="introduction_text_{{ $language->name }}"
                                                                        id="introduction_text_{{ $language->name }}"
                                                                        placeholder="{{ translateKeyword('introduction-text') }} {{ $language->name }}" maxlength="1000">{{ $webContent ? $webContent['introduction_text'] : '' }}</textarea>
                                                                </div>
                                                            </div>
                                                            <!-- Add more fields for each language as needed -->
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    @if ($edit_permission == 1)
                                        <div class="panel panel-default box box-block bg-white">
                                            <div class="col-12">
                                                <button type="submit"
                                                    class="btn btn-primary">{{ translateKeyword('update-web-settings') }}</button>
                                            </div>
                                        </div>
                                    @endif
                                </form>

                            </div>
                            <div class="tab-pane" id="contact" role="tabpanel">
                                <form action="{{ route('admin.cms.contact-update') }}" id="contactSettingsForm"
                                    method="post">
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <div class="col-12">
                                            <ul class="nav nav-tabs" id="myInnerTab" role="tablist"
                                                style="margin: 10px 0 10px 10px">
                                                @foreach ($languages as $index => $language)
                                                    <li class="nav-item">
                                                        <a class="nav-link {{ $index === 0 ? 'active' : '' }}"
                                                            data-toggle="tab" href="#contact_{{ $language->name }}"
                                                            role="tab"
                                                            aria-selected="{{ $index === 0 ? 'true' : 'false' }}">
                                                            {{ $language->name }}
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                            <div class="tab-content">
                                                @foreach ($languages as $index => $language)
                                                    @php($contactSetting = $contactSettings->firstWhere('language_id', $language->id))
                                                    <div class="tab-pane {{ $index === 0 ? 'show active' : '' }}"
                                                        id="contact_{{ $language->name }}" role="tabpanel">
                                                        <div class="col-12 mt-1">
                                                            <div class="form-group row">
                                                                <label for="contact_city_{{ $language->name }}"
                                                                    class="col-xs-2 col-form-label">{{ translateKeyword('contact-city') }}</label>
                                                                <div class="col-xs-10">
                                                                    <input class="form-control" type="text"
                                                                        value="{{ $contactSetting ? $contactSetting->contact_city : '' }}"
                                                                        name="contact_city_{{ $language->id }}"
                                                                        id="contact_city_{{ $language->id }}"
                                                                        placeholder="{{ translateKeyword('contact-city') }}">
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label for="contact_address_{{ $language->name }}"
                                                                    class="col-xs-2 col-form-label">{{ translateKeyword('contact-address') }}</label>
                                                                <div class="col-xs-10">
                                                                    <input class="form-control" type="text"
                                                                        value="{{ $contactSetting ? $contactSetting->contact_address : '' }}"
                                                                        name="contact_address_{{ $language->id }}"
                                                                        id="contact_address_{{ $language->id }}"
                                                                        placeholder="{{ translateKeyword('contact-address') }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-xs-2 col-form-label">
                                                    <label for="UPI_key" class="col-form-label">
                                                        {{ translateKeyword('contact-phone-show/hide') }}
                                                    </label>
                                                </div>
                                                <div class="col-xs-10">
                                                    <input @if (Setting::get('contact_number_show') == 1) checked @endif
                                                        name="contact_number_show" id="contact_number_show"
                                                        type="checkbox" class="js-switch" data-color="#43b968">
                                                </div>

                                            </div>

                                            <div class="form-group row">
                                                <label for="Contact Phone"
                                                    class="col-xs-2 col-form-label">{{ translateKeyword('contact-phone') }}</label>
                                                <div class="col-xs-10">
                                                    <input class="form-control" type="text"
                                                        value="{{ str_replace(' ', '', Setting::get('contact_number', '')) }}"
                                                        name="contact_number" id="contact_number"
                                                        placeholder="{{ translateKeyword('contact-phone') }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @if ($edit_permission == 1)
                                        <div class="panel panel-default box box-block bg-white">
                                            <div class="col-12">
                                                <button type="submit"
                                                    class="btn btn-primary">{{ translateKeyword('update-web-settings') }}</button>
                                            </div>
                                        </div>
                                    @endif
                                </form>

                            </div>
                            <div class="tab-pane" id="site_media" role="tabpanel">
                                <form action="{{ route('admin.cms.web-media') }}" id="mediaSettingsForm" method="post"
                                    enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group row">
                                                <label for="site_logo"
                                                    class="col-xs-2 col-form-label">{{ translateKeyword('site-logo-(dimension:-80-x-80)') }}</label>
                                                <div class="col-xs-10">
                                                    @if (Setting::get('site_logo') != '')
                                                        <img style="height: 90px; margin-bottom: 15px;"
                                                            src="{{ Setting::get('site_logo', asset('logo-black.png')) }}">
                                                    @endif
                                                    <input type="file" accept="image/*" name="site_logo"
                                                        class="dropify form-control-file" id="site_logo"
                                                        aria-describedby="fileHelp" multiple>
                                                </div>
                                            </div>


                                            <div class="form-group row">
                                                <label for="site_icon"
                                                    class="col-xs-2 col-form-label">{{ translateKeyword('site-icon') }}</label>
                                                <div class="col-xs-10">
                                                    @if (Setting::get('site_icon') != '')
                                                        <img style="height: 90px; margin-bottom: 15px;"
                                                            src="{{ Setting::get('site_icon') }}">
                                                    @endif
                                                    <input type="file" accept="image/*" name="site_icon"
                                                        class="dropify form-control-file" id="site_icon"
                                                        aria-describedby="fileHelp">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="connexi_booking_form_image"
                                                    class="col-xs-2 col-form-label">{{ translateKeyword('connexi-booking-form-image-(dimension:-500-×-400)') }}</label>
                                                <div class="col-xs-10">
                                                    @if (Setting::get('connexi_booking_form_image') != '')
                                                        <img style="height: 90px; margin-bottom: 15px;"
                                                            src="{{ Setting::get('connexi_booking_form_image') }}">
                                                    @endif
                                                    <input type="file" accept="image/*"
                                                        name="connexi_booking_form_image"
                                                        class="dropify form-control-file" id="connexi_booking_form_image"
                                                        aria-describedby="fileHelp">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="booking_form_image"
                                                    class="col-xs-2 col-form-label">{{ translateKeyword('booking-form-image-(dimension:-500-×-400)') }}</label>
                                                <div class="col-xs-10">
                                                    @if (Setting::get('booking_form_image') != '')
                                                        <img style="height: 90px; margin-bottom: 15px;"
                                                            src="{{ Setting::get('booking_form_image') }}">
                                                    @endif
                                                    <input type="file" accept="image/*" name="booking_form_image"
                                                        class="dropify form-control-file" id="booking_form_image"
                                                        aria-describedby="fileHelp">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="advantage_image_1"
                                                    class="col-xs-2 col-form-label">{{ translateKeyword('advantage-area-image-1-(dimension:-390-×-298)') }}</label>
                                                <div class="col-xs-10">
                                                    @if (Setting::get('advantage_image_1') != '')
                                                        <img style="height: 90px; margin-bottom: 15px;"
                                                            src="{{ Setting::get('advantage_image_1') }}">
                                                    @endif
                                                    <input type="file" accept="image/*" name="advantage_image_1"
                                                        class="dropify form-control-file" id="advantage_image_1"
                                                        aria-describedby="fileHelp">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="advantage_image_2"
                                                    class="col-xs-2 col-form-label">{{ translateKeyword('advantage-area-image-2-(dimension:-390-×-298)') }}</label>
                                                <div class="col-xs-10">
                                                    @if (Setting::get('advantage_image_2') != '')
                                                        <img style="height: 90px; margin-bottom: 15px;"
                                                            src="{{ Setting::get('advantage_image_2') }}">
                                                    @endif
                                                    <input type="file" accept="image/*" name="advantage_image_2"
                                                        class="dropify form-control-file" id="advantage_image_2"
                                                        aria-describedby="fileHelp">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="call_us_image"
                                                    class="col-xs-2 col-form-label">{{ translateKeyword('call-us-image-(dimension:-509-x-339)') }}</label>
                                                <div class="col-xs-10">
                                                    @if (Setting::get('call_us_image') != '')
                                                        <img style="height: 90px; margin-bottom: 15px;"
                                                            src="{{ Setting::get('call_us_image') }}">
                                                    @endif
                                                    <input type="file" accept="image/*" name="call_us_image"
                                                        class="dropify form-control-file" id="call_us_image"
                                                        aria-describedby="fileHelp">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="site_icon"
                                                    class="col-xs-2 col-form-label">{{ translateKeyword('site-banner-image-(dimension:-1500-x-1000)') }}</label>
                                                <div class="col-xs-10">
                                                    @if (Setting::get('f_mainBanner') != '')
                                                        <img style="height: 90px; margin-bottom: 15px;"
                                                            src="{{ Setting::get('f_mainBanner') }}">
                                                    @endif
                                                    <input type="file" accept="image/*" name="f_mainBanner"
                                                        class="dropify form-control-file" id="f_mainBanner"
                                                        aria-describedby="fileHelp">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="site_icon"
                                                    class="col-xs-2 col-form-label">{{ translateKeyword('faqs-image-(dimension:-1500-x-1000)') }}</label>
                                                <div class="col-xs-10">
                                                    @if (Setting::get('faq_image') != '')
                                                        <img style="height: 90px; margin-bottom: 15px;"
                                                            src="{{ Setting::get('faq_image') }}">
                                                    @endif
                                                    <input type="file" accept="image/*" name="faq_image"
                                                        class="dropify form-control-file" id="faq_image"
                                                        aria-describedby="fileHelp">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="site_icon"
                                                    class="col-xs-2 col-form-label">{{ translateKeyword('blogs-image-(dimension:-1500-x-1000)') }}</label>
                                                <div class="col-xs-10">
                                                    @if (Setting::get('blogs_image') != '')
                                                        <img style="height: 90px; margin-bottom: 15px;"
                                                            src="{{ Setting::get('blogs_image') }}">
                                                    @endif
                                                    <input type="file" accept="image/*" name="blogs_image"
                                                        class="dropify form-control-file" id="blogs_image"
                                                        aria-describedby="fileHelp">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="site_icon"
                                                    class="col-xs-2 col-form-label">{{ translateKeyword('testinomials-image-(dimension:-1500-x-1000)') }}</label>
                                                <div class="col-xs-10">
                                                    @if (Setting::get('testinomial_image') != '')
                                                        <img style="height: 90px; margin-bottom: 15px;"
                                                            src="{{ Setting::get('testinomial_image') }}">
                                                    @endif
                                                    <input type="file" accept="image/*" name="testinomial_image"
                                                        class="dropify form-control-file" id="testinomial_image"
                                                        aria-describedby="fileHelp">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="mockup_one"
                                                    class="col-xs-2 col-form-label">{{ translateKeyword('phone-mockup-1-(dimension:-346-×-641)') }}</label>
                                                <div class="col-xs-10">
                                                    @if (Setting::get('mockup_one') != '')
                                                        <img style="height: 90px; margin-bottom: 15px;"
                                                            src="{{ Setting::get('mockup_one') }}">
                                                    @endif
                                                    <input type="file" accept="image/*" name="mockup_one"
                                                        class="dropify form-control-file" id="mockup_one"
                                                        aria-describedby="fileHelp">
                                                </div>
                                            </div>


                                            <div class="form-group row">
                                                <label for="mockup_two"
                                                    class="col-xs-2 col-form-label">{{ translateKeyword('phone-mockup-2-(dimension:-346-×-641)') }}</label>
                                                <div class="col-xs-10">
                                                    @if (Setting::get('mockup_two') != '')
                                                        <img style="height: 90px; margin-bottom: 15px;"
                                                            src="{{ Setting::get('mockup_two') }}">
                                                    @endif
                                                    <input type="file" accept="image/*" name="mockup_two"
                                                        class="dropify form-control-file" id="mockup_two"
                                                        aria-describedby="fileHelp">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="website_login"
                                                    class="col-xs-2 col-form-label">{{ translateKeyword('website-login-image-(dimension:-903-×-1368)') }}</label>
                                                <div class="col-xs-10">
                                                    @if (Setting::get('website_login') != '')
                                                        <img style="height: 90px; margin-bottom: 15px;"
                                                            src="{{ Setting::get('website_login') }}">
                                                    @endif
                                                    <input type="file" accept="image/*" name="website_login"
                                                        class="dropify form-control-file" id="website_login"
                                                        aria-describedby="fileHelp">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="website_register"
                                                    class="col-xs-2 col-form-label">{{ translateKeyword('website-register-image-(dimension:-903-×-1368)') }}</label>
                                                <div class="col-xs-10">
                                                    @if (Setting::get('website_register') != '')
                                                        <img style="height: 90px; margin-bottom: 15px;"
                                                            src="{{ Setting::get('website_register') }}">
                                                    @endif
                                                    <input type="file" accept="image/*" name="website_register"
                                                        class="dropify form-control-file" id="website_register"
                                                        aria-describedby="fileHelp">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="slider_image1"
                                                    class="col-xs-2 col-form-label">{{ translateKeyword('slider-image-1-(dimension:-1500-x-1000)') }}</label>
                                                <div class="col-xs-10">
                                                    @if (Setting::get('slider_image1') != '')
                                                        <img style="height: 90px; margin-bottom: 15px;"
                                                            src="{{ Setting::get('slider_image1') }}">
                                                    @endif
                                                    <input type="file" accept="image/*" name="slider_image1"
                                                        class="dropify form-control-file" id="slider_image1"
                                                        aria-describedby="fileHelp">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="slider_image2"
                                                    class="col-xs-2 col-form-label">{{ translateKeyword('slider-image-2-(dimension:-1500-x-1000)') }}</label>
                                                <div class="col-xs-10">
                                                    @if (Setting::get('slider_image2') != '')
                                                        <img style="height: 90px; margin-bottom: 15px;"
                                                            src="{{ Setting::get('slider_image2') }}">
                                                    @endif
                                                    <input type="file" accept="image/*" name="slider_image2"
                                                        class="dropify form-control-file" id="slider_image2"
                                                        aria-describedby="fileHelp">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="slider_image3"
                                                    class="col-xs-2 col-form-label">{{ translateKeyword('slider-image-3-(dimension:-1500-x-1000)') }}</label>
                                                <div class="col-xs-10">
                                                    @if (Setting::get('slider_image3') != '')
                                                        <img style="height: 90px; margin-bottom: 15px;"
                                                            src="{{ Setting::get('slider_image3') }}">
                                                    @endif
                                                    <input type="file" accept="image/*" name="slider_image3"
                                                        class="dropify form-control-file" id="slider_image3"
                                                        aria-describedby="fileHelp">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="slider_image4"
                                                    class="col-xs-2 col-form-label">{{ translateKeyword('slider-image-4-(dimension:-1500-x-1000)') }}</label>
                                                <div class="col-xs-10">
                                                    @if (Setting::get('slider_image4') != '')
                                                        <img style="height: 90px; margin-bottom: 15px;"
                                                            src="{{ Setting::get('slider_image4') }}">
                                                    @endif
                                                    <input type="file" accept="image/*" name="slider_image4"
                                                        class="dropify form-control-file" id="slider_image4"
                                                        aria-describedby="fileHelp">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="slider_image5"
                                                    class="col-xs-2 col-form-label">{{ translateKeyword('slider-image-5-(dimension:-1500-x-1000)') }}</label>
                                                <div class="col-xs-10">
                                                    @if (Setting::get('slider_image5') != '')
                                                        <img style="height: 90px; margin-bottom: 15px;"
                                                            src="{{ Setting::get('slider_image5') }}">
                                                    @endif
                                                    <input type="file" accept="image/*" name="slider_image5"
                                                        class="dropify form-control-file" id="slider_image5"
                                                        aria-describedby="fileHelp">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="admin_panel"
                                                    class="col-xs-2 col-form-label">{{ translateKeyword('admin-panel-image-(dimension:-1296-×-864)') }}</label>
                                                <div class="col-xs-10">
                                                    @if (Setting::get('admin_panel') != '')
                                                        <img style="height: 90px; margin-bottom: 15px;"
                                                            src="{{ Setting::get('admin_panel') }}">
                                                    @endif
                                                    <input type="file" accept="image/*" name="admin_panel"
                                                        class="dropify form-control-file" id="admin_panel"
                                                        aria-describedby="fileHelp">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-xs-2 col-form-label">
                                                    <label for="UPI_key" class="col-form-label">
                                                        {{ translateKeyword('video-on-web') }}
                                                    </label>
                                                </div>
                                                <div class="col-xs-10">
                                                    <input @if (Setting::get('video_on_web') == 1) checked @endif
                                                        name="video_on_web" id="video_on_web" type="checkbox"
                                                        class="js-switch" data-color="#43b968">
                                                </div>

                                            </div>
                                            <div class="form-group row">
                                                <label for="site_icon"
                                                    class="col-xs-2 col-form-label">{{ translateKeyword('home-page-video-(dimension:-640-×-352)') }}</label>
                                                <div class="col-xs-10">
                                                    @if (Setting::get('home_page_video') != '')
                                                        <video class="embed-responsive-item"
                                                            src="{{ Setting::get('home_page_video') }}" controls
                                                            style="height: 90px; margin-bottom: 15px; object-fit: fill;"></video>
                                                    @endif
                                                    <input type="file" accept="video/*" name="home_page_video"
                                                        class="dropify form-control-file" id="home_page_video"
                                                        aria-describedby="fileHelp">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @if ($edit_permission == 1)
                                        <div class="panel panel-default box box-block bg-white">
                                            <div class="col-12">
                                                <button type="submit"
                                                    class="btn btn-primary">{{ translateKeyword('update-web-settings') }}</button>
                                            </div>
                                        </div>
                                    @endif
                                </form>

                            </div>
                            <div class="tab-pane" id="site_color" role="tabpanel">
                                <form action="{{ route('admin.cms.web-color') }}" id="mediaSettingsForm" method="post"
                                    enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <div class="row py-5">
                                        <div class="col-12">
                                            <div class="form-group row">
                                                <label for="site_color"
                                                    class="col-xs-2 col-form-label">{{ translateKeyword('Website Color') }}</label>
                                                <div class="col-xs-10">
                                                    <input type="color" name="site_color" id="site_color"
                                                        value="{{ Setting::get('site_color') }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @if ($edit_permission == 1)
                                        <div class="panel panel-default box box-block bg-white">
                                            <div class="col-12">
                                                <button type="submit"
                                                    class="btn btn-primary">{{ translateKeyword('update-web-settings') }}</button>
                                            </div>
                                        </div>
                                    @endif
                                </form>

                            </div>
                            <div class="tab-pane" id="google_map" role="tabpanel">
                                <form action="{{ route('admin.cms.google-map') }}" id="mediaSettingsForm"
                                    method="post" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <div class="row py-5">
                                        <div class="col-12">
                                            <div class="form-group row">
                                                <label class="col-xs-12 col-form-label">Base Location</label><br />
                                                <label for="store_link_android"
                                                    class="col-xs-2 col-form-label">Latitude</label>
                                                <div class="col-xs-4">
                                                    <input class="form-control" type="text"
                                                        value="{{ Setting::get('latitude', '') }}" name="latitude"
                                                        id="latitude" placeholder="Latitude" required>
                                                </div>
                                                <label for="store_link_android"
                                                    class="col-xs-2 col-form-label">Longitude</label>
                                                <div class="col-xs-4">
                                                    <input class="form-control" type="text"
                                                        value="{{ Setting::get('longitude', '') }}" name="longitude"
                                                        id="longitude" placeholder="Longitude" required>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="map_contact_page" class="col-xs-2 col-form-label">Map iFrame
                                                    source -
                                                    Contact
                                                    Page</label>
                                                <div class="col-xs-10">
                                                    <input class="form-control" type="text"
                                                        value="{{ Setting::get('map_contact_page', '') }}"
                                                        name="map_contact_page" id="map_contact_page"
                                                        placeholder="Map contact page">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="map_key" class="col-xs-2 col-form-label">Google Map Api
                                                    Key</label>
                                                <div class="col-xs-10">
                                                    <input class="form-control" type="text"
                                                        value="{{ Setting::get('map_key') }}" name="map_key"
                                                        id="map_key" placeholder="Site Copyright">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @if ($edit_permission == 1)
                                        <div class="panel panel-default box box-block bg-white">
                                            <div class="col-12">
                                                <button type="submit"
                                                    class="btn btn-primary">{{ translateKeyword('update-web-settings') }}</button>
                                            </div>
                                        </div>
                                    @endif
                                </form>

                            </div>
                            <div class="tab-pane" id="social-links" role="tabpanel">
                                <form action="{{ route('admin.cms.update-social-links') }}" id="socialLinksForm"
                                    method="post">
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <div class="col-12 mt-2">
                                            <div class="form-group row">
                                                <label for="f_f_link"
                                                    class="col-xs-2 col-form-label">{{ translateKeyword('facebook-page-link') }}</label>
                                                <div class="col-xs-10">
                                                    <input class="form-control" type="text"
                                                        value="{{ $socialLinks->facebook ?? '' }}" name="f_f_link"
                                                        id="f_f_link"
                                                        placeholder="{{ translateKeyword('facebook-page-link') }}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="f_i_link"
                                                    class="col-xs-2 col-form-label">{{ translateKeyword('instagram-link') }}</label>
                                                <div class="col-xs-10">
                                                    <input class="form-control" type="text"
                                                        value="{{ $socialLinks->instagram ?? '' }}" name="f_i_link"
                                                        id="f_i_link"
                                                        placeholder="{{ translateKeyword('instagram-link') }}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="f_l_link"
                                                    class="col-xs-2 col-form-label">{{ translateKeyword('linkedin-link') }}</label>
                                                <div class="col-xs-10">
                                                    <input class="form-control" type="text"
                                                        value="{{ $socialLinks->linkedin ?? '' }}" name="f_l_link"
                                                        id="f_l_link"
                                                        placeholder="{{ translateKeyword('linkedin-link') }}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="f_t_link"
                                                    class="col-xs-2 col-form-label">{{ translateKeyword('twitter-link') }}</label>
                                                <div class="col-xs-10">
                                                    <input class="form-control" type="text"
                                                        value="{{ $socialLinks->twitter ?? '' }}" name="f_t_link"
                                                        id="f_t_link"
                                                        placeholder="{{ translateKeyword('twitter-link') }}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="f_y_link"
                                                    class="col-xs-2 col-form-label">{{ translateKeyword('youtube-link') }}</label>
                                                <div class="col-xs-10">
                                                    <input class="form-control" type="text"
                                                        value="{{ $socialLinks->youtube ?? '' }}" name="f_y_link"
                                                        id="f_y_link"
                                                        placeholder="{{ translateKeyword('youtube-link') }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @if ($edit_permission == 1)
                                        <div class="panel panel-default box box-block bg-white">
                                            <div class="col-12">
                                                <button type="submit"
                                                    class="btn btn-primary">{{ translateKeyword('update-web-settings') }}</button>
                                            </div>
                                        </div>
                                    @endif
                                </form>

                            </div>
                            <div class="tab-pane" id="app-links" role="tabpanel">
                                <form action="{{ route('admin.cms.update-app-links') }}" id="appLinksForm"
                                    method="post">
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <div class="col-12 mt-3">
                                            <div class="form-group row">
                                                <label for="f_u_url"
                                                    class="col-xs-2 col-form-label">{{ translateKeyword('user_app_playstore_link') }}</label>
                                                <div class="col-xs-10">
                                                    <input class="form-control" type="text" value="{{ $appLinks ? $appLinks->f_u_url : '' }}" name="f_u_url" id="f_u_url"
                                                        placeholder="{{ translateKeyword('user_app_playstore_link') }}">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="f_p_url"
                                                    class="col-xs-2 col-form-label">{{ translateKeyword('provider-app-playStore-link') }}</label>
                                                <div class="col-xs-10">
                                                    <input class="form-control" type="text" value="{{ $appLinks ? $appLinks->f_p_url : '' }}" name="f_p_url" id="f_p_url"
                                                        placeholder="{{ translateKeyword('provider-app-playStore-link') }}">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="user_store_link_ios"
                                                    class="col-xs-2 col-form-label">{{ translateKeyword('user-appstore-link') }}</label>
                                                <div class="col-xs-10">
                                                    <input class="form-control" type="text" value="{{ $appLinks ? $appLinks->user_store_link_ios : '' }}"
                                                        name="user_store_link_ios" id="user_store_link_ios"
                                                        placeholder="{{ translateKeyword('user-appstore-link') }}">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="driver_store_link_ios"
                                                    class="col-xs-2 col-form-label">{{ translateKeyword('provider-appstore-link') }}</label>
                                                <div class="col-xs-10">
                                                    <input class="form-control" type="text" value="{{ $appLinks ? $appLinks->driver_store_link_ios : '' }}"
                                                        name="driver_store_link_ios" id="driver_store_link_ios"
                                                        placeholder="{{ translateKeyword('provider-appstore-link') }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @if ($edit_permission == 1)
                                        <div class="panel panel-default box box-block bg-white">
                                            <div class="col-12">
                                                <button type="submit"
                                                    class="btn btn-primary">{{ translateKeyword('update-web-settings') }}</button>
                                            </div>
                                        </div>
                                    @endif
                                </form>
                            </div>
                            <div class="tab-pane" id="faqs" role="tabpanel">
                                <!-- DataTable HTML Table -->
                                <div class="box box-block">
                                    <h5 class="mb-1">{{ translateKeyword('faqs') }}</h5>
                                    @if ($add_permission)
                                        <a href="{{ route('admin.webfaqs.create') }}" style="margin-left: 1em;"
                                            class="btn btn-primary pull-right color-white"><i class="fa fa-plus"></i>
                                            {{ translateKeyword('add-new-faq') }}</a>
                                    @endif
                                    <table class="table table-striped table-bordered dataTable w-100" id="table-1">
                                        <thead>
                                            <tr>
                                                <th>{{ translateKeyword('id') }}</th>
                                                <th>{{ translateKeyword('question') }}</th>
                                                <th>{{ translateKeyword('answer') }}</th>
                                                <th>{{ translateKeyword('action') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($webFaqs as $index => $faq)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $faq->question }}</td>
                                                    <td>{{ $faq->answer }}</td>
                                                    <td>{{ $faq->type }}</td>
                                                    <td>
                                                        <form action="{{ route('admin.webfaqs.destroy', $faq->id) }}"
                                                            method="POST">
                                                            {{ csrf_field() }}
                                                            <input type="hidden" name="_method" value="DELETE">
                                                            @if ($edit_permission == 1)
                                                                <a href="{{ route('admin.webfaqs.edit', $faq->id) }}"
                                                                    class="btn btn-info"><i class="fa fa-edit"></i>
                                                                    {{ translateKeyword('edit') }}</a>
                                                            @endif
                                                            @if ($delete_permission == 1)
                                                                <button class="btn btn-danger"
                                                                    onclick="return confirm('Are you sure?')"><i
                                                                        class="fa fa-trash"></i>
                                                                    {{ translateKeyword('delete') }}
                                                                </button>
                                                            @endif
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>{{ translateKeyword('id') }}</th>
                                                <th>{{ translateKeyword('question') }}</th>
                                                <th>{{ translateKeyword('answer') }}</th>
                                                <th>{{ translateKeyword('action') }}</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>

                            </div>
                            <div class="tab-pane" id="privacy_policy" role="tabpanel">
                                <form action="{{ route('admin.cms.web-pages-content') }}" id="privacyContentForm"
                                    method="post">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="form_type" value="privacy">
                                    <div class="row">
                                        <div class="col-12">
                                            <ul class="nav nav-tabs" id="myInnerTab" role="tablist"
                                                style="margin: 10px 0 10px 10px">
                                                @foreach ($languages as $index => $language)
                                                    <li class="nav-item">
                                                        <a class="nav-link {{ $index === 0 ? 'active' : '' }}"
                                                            data-toggle="tab" href="#{{ $language->name }}_privacy"
                                                            role="tab"
                                                            aria-selected="{ $index === 0 ? 'true' : 'false' }}">
                                                            {{ $language->name }}
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                            <div class="tab-content">
                                                @foreach ($languages as $index => $language)
                                                    @php($pageContent = $pagesContent->firstWhere('language_id', $language->id))
                                                    <div class="tab-pane {{ $index === 0 ? 'active' : '' }}"
                                                        id="{{ $language->name }}_privacy" role="tabpanel">
                                                        <div class="form-group row">
                                                            <label
                                                                class="col-xs-2 col-form-label">{{ translateKeyword('privacy_policy') }}</label>
                                                            <div class="col-xs-10">
                                                                <textarea name="privacy_content[{{ $language->id }}]" id="privacyEditor_{{ $language->id }}">{{ $pageContent ? $pageContent->privacy_content : '' }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    @if ($edit_permission == 1)
                                        <div class="panel panel-default box box-block bg-white">
                                            <div class="col-12">
                                                <button type="submit"
                                                    class="btn btn-primary">{{ translateKeyword('update-web-settings') }}</button>
                                            </div>
                                        </div>
                                    @endif
                                </form>
                            </div>
                            <div class="tab-pane" id="terms" role="tabpanel">
                                <form action="{{ route('admin.cms.web-pages-content') }}" id="termsContentForm"
                                    method="post">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="form_type" value="terms">
                                    <div class="row">
                                        <div class="col-12">
                                            <ul class="nav nav-tabs" id="myInnerTab" role="tablist"
                                                style="margin: 10px 0 10px 10px">
                                                @foreach ($languages as $index => $language)
                                                    <li class="nav-item">
                                                        <a class="nav-link {{ $index === 0 ? 'active' : '' }}"
                                                            data-toggle="tab" href="#{{ $language->name }}_terms"
                                                            role="tab"
                                                            aria-selected="{ $index === 0 ? 'true' : 'false' }}">
                                                            {{ $language->name }}
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                            <div class="tab-content">
                                                @foreach ($languages as $index => $language)
                                                    @php($pageContent = $pagesContent->firstWhere('language_id', $language->id))
                                                    <div class="tab-pane {{ $index === 0 ? 'show active' : '' }}"
                                                        id="{{ $language->name }}_terms" role="tabpanel">
                                                        <div class="form-group row">
                                                            <label
                                                                class="col-xs-2 col-form-label">{{ translateKeyword('terms_conditions') }}</label>
                                                            <div class="col-xs-10">
                                                                <textarea name="terms_content[{{ $language->id }}]" id="termsEditor_{{ $language->id }}">{{ $pageContent ? $pageContent->terms_content : '' }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    @if ($edit_permission == 1)
                                        <div class="panel panel-default box box-block bg-white">
                                            <div class="col-12">
                                                <button type="submit"
                                                    class="btn btn-primary">{{ translateKeyword('update-web-settings') }}</button>
                                            </div>
                                        </div>
                                    @endif
                                </form>
                            </div>
                            <div class="tab-pane" id="driver" role="tabpanel">
                                <form action="{{ route('admin.cms.web-pages-content') }}" id="driverContentForm"
                                    method="post">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="form_type" value="driver">
                                    <div class="row">
                                        <div class="col-12">
                                            <ul class="nav nav-tabs" id="myInnerTab" role="tablist"
                                                style="margin: 10px 0 10px 10px">
                                                @foreach ($languages as $index => $language)
                                                    <li class="nav-item">
                                                        <a class="nav-link {{ $index === 0 ? 'active' : '' }}"
                                                            data-toggle="tab" href="#{{ $language->name }}_drivers"
                                                            role="tab"
                                                            aria-selected="{ $index === 0 ? 'true' : 'false' }}">
                                                            {{ $language->name }}
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                            <div class="tab-content">
                                                @foreach ($languages as $index => $language)
                                                    @php($pageContent = $pagesContent->firstWhere('language_id', $language->id))
                                                    <div class="tab-pane {{ $index === 0 ? 'show active' : '' }}"
                                                        id="{{ $language->name }}_drivers" role="tabpanel">
                                                        <div class="form-group row">
                                                            <label
                                                                class="col-xs-2 col-form-label">{{ translateKeyword('driver') }}</label>
                                                            <div class="col-xs-10">
                                                                <textarea name="driver_content[{{ $language->id }}]" id="driverEditor_{{ $language->id }}">{{ $pageContent ? $pageContent->driver_content : '' }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    @if ($edit_permission == 1)
                                        <div class="panel panel-default box box-block bg-white">
                                            <div class="col-12">
                                                <button type="submit"
                                                    class="btn btn-primary">{{ translateKeyword('update-web-settings') }}</button>
                                            </div>
                                        </div>
                                    @endif
                                </form>
                            </div>
                            <div class="tab-pane" id="about" role="tabpanel">
                                <form action="{{ route('admin.cms.web-pages-content') }}" id="aboutContentForm"
                                    method="post">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="form_type" value="about">
                                    <div class="row">
                                        <div class="col-12">
                                            <ul class="nav nav-tabs" id="myInnerTab" role="tablist"
                                                style="margin: 10px 0 10px 10px">
                                                @foreach ($languages as $index => $language)
                                                    <li class="nav-item">
                                                        <a class="nav-link {{ $index === 0 ? 'active' : '' }}"
                                                            data-toggle="tab" href="#{{ $language->name }}_about"
                                                            role="tab"
                                                            aria-selected="{ $index === 0 ? 'true' : 'false' }}">
                                                            {{ $language->name }}
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                            <div class="tab-content">
                                                @foreach ($languages as $index => $language)
                                                    @php($pageContent = $pagesContent->firstWhere('language_id', $language->id))
                                                    <div class="tab-pane {{ $index === 0 ? 'show active' : '' }}"
                                                        id="{{ $language->name }}_about" role="tabpanel">
                                                        <div class="form-group row">
                                                            <label
                                                                class="col-xs-2 col-form-label">{{ translateKeyword('f_33') }}</label>
                                                            <div class="col-xs-10">
                                                                <textarea name="about_content[{{ $language->id }}]" id="aboutEditor_{{ $language->id }}">{{ $pageContent ? $pageContent->about_content : '' }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    @if ($edit_permission == 1)
                                        <div class="panel panel-default box box-block bg-white">
                                            <div class="col-12">
                                                <button type="submit"
                                                    class="btn btn-primary">{{ translateKeyword('update-web-settings') }}</button>
                                            </div>
                                        </div>
                                    @endif
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </section>
    </div>

    <script src="{{ asset('admin') }}/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="{{ asset('admin') }}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="{{ asset('admin') }}/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="{{ asset('admin') }}/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
@endsection

@section('script')
    <script src="//cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>
    <script type="text/javascript">
        @foreach ($languages as $language)
            CKEDITOR.replace('privacyEditor_{{ $language->id }}');
            CKEDITOR.replace('termsEditor_{{ $language->id }}');
            CKEDITOR.replace('driverEditor_{{ $language->id }}');
            CKEDITOR.replace('aboutEditor_{{ $language->id }}');
        @endforeach

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

        // $(document).ready(function() {
        // $('#privacyContentForm').on('submit', function(e) {
        //     e.preventDefault();

        //     var formData = new FormData(this);

        //     $.ajax({
        //         url: $(this).attr('action'),
        //         type: 'POST',
        //         data: formData,
        //         processData: false,
        //         contentType: false,
        //         success: function(response) {
        //             console.log('Success:', response);
        //             location.reload();
        //             // Handle success actions (e.g., display a success message, update the UI)
        //         },
        //         error: function(error) {
        //             console.error('Error:', error);
        //             // Handle error actions (e.g., display an error message)
        //         }
        //     });
        // });
        // $('#termsContentForm').on('submit', function(e) {
        //     e.preventDefault();

        //     var formData = new FormData(this);

        //     $.ajax({
        //         url: $(this).attr('action'),
        //         type: 'POST',
        //         data: formData,
        //         processData: false,
        //         contentType: false,
        //         success: function(response) {
        //             console.log('Success:', response);
        //             location.reload();
        //             // Handle success actions (e.g., display a success message, update the UI)
        //         },
        //         error: function(error) {
        //             console.error('Error:', error);
        //             // Handle error actions (e.g., display an error message)
        //         }
        //     });
        // });
        // $('#driverContentForm').on('submit', function(e) {
        //     e.preventDefault();

        //     var formData = new FormData(this);

        //     $.ajax({
        //         url: $(this).attr('action'),
        //         type: 'POST',
        //         data: formData,
        //         processData: false,
        //         contentType: false,
        //         success: function(response) {
        //             console.log('Success:', response);
        //             location.reload();
        //             // Handle success actions (e.g., display a success message, update the UI)
        //         },
        //         error: function(error) {
        //             console.error('Error:', error);
        //             // Handle error actions (e.g., display an error message)
        //         }
        //     });
        // });
        // $('#aboutContentForm').on('submit', function(e) {
        //     e.preventDefault();

        //     var formData = new FormData(this);

        //     $.ajax({
        //         url: $(this).attr('action'),
        //         type: 'POST',
        //         data: formData,
        //         processData: false,
        //         contentType: false,
        //         success: function(response) {
        //             console.log('Success:', response);
        //             location.reload();
        //             // Handle success actions (e.g., display a success message, update the UI)
        //         },
        //         error: function(error) {
        //             console.error('Error:', error);
        //             // Handle error actions (e.g., display an error message)
        //         }
        //     });
        // });
        // })
    </script>
@endsection
