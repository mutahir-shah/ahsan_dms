@extends('admin.layout.base')

@section('title', 'Site Settings ')

@section('content')

    <div class="content-area py-1">
        <div class="container-fluid">
            @include('common.notify')
            <div class="box box-block bg-white">
                <h5>{{ translateKeyword('site_settings')}}</h5>

                <form class="form-horizontal" action="{{ route('admin.settings.store') }}" method="POST"
                      enctype="multipart/form-data" role="form">
                    {{ csrf_field() }}

                    <div class="form-group row">
                        <label for="site_title" class="col-xs-2 col-form-label">{{ translateKeyword('Site_Name')}}</label>
                        <div class="col-xs-10">
                            <input class="form-control" type="text" value="{{ Setting::get('site_title', '') }}"
                                   name="site_title" required id="site_title" placeholder="{{ translateKeyword('Site_Name')}}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="site_sub_title" class="col-xs-2 col-form-label">{{ translateKeyword('Site Sub title')}}</label>
                        <div class="col-xs-10">
                            <input class="form-control" type="text" value="{{ Setting::get('site_sub_title', '') }}"
                                   name="site_sub_title" id="site_sub_title" placeholder="{{ translateKeyword('Site Sub title')}}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-xs-2 col-form-label">
                            <label for="UPI_key" class="col-form-label">
                                {{ translateKeyword('job-button')}}
                            </label>
                        </div>
                        <div class="col-xs-10">
                            <input @if (Setting::get('ride_btn') == 1) checked @endif name="ride_btn" id="ride_btn"
                                   type="checkbox" class="js-switch" data-color="#43b968">
                        </div>

                    </div>

                    <div class="form-group row">
                        <div class="col-xs-2 col-form-label">
                            <label for="UPI_key" class="col-form-label">
                                {{ translateKeyword('offers-section')}}
                            </label>
                        </div>
                        <div class="col-xs-10">
                            <input @if (Setting::get('offer_section') == 1) checked @endif name="offer_section"
                                   id="offer_section"
                                   type="checkbox" class="js-switch" data-color="#43b968">
                        </div>

                    </div>

                    <div class="form-group row">
                        <div class="col-xs-2 col-form-label">
                            <label for="UPI_key" class="col-form-label">
                                {{ translateKeyword('features-section')}}
                            </label>
                        </div>
                        <div class="col-xs-10">
                            <input @if (Setting::get('features_section') == 1) checked @endif name="features_section"
                                   id="features_section" type="checkbox" class="js-switch" data-color="#43b968">
                        </div>

                    </div>

                    <div class="form-group row">
                        <label for="site_logo" class="col-xs-2 col-form-label">{{ translateKeyword('Site_Logo')}}</label>
                        <div class="col-xs-10">
                            @if (Setting::get('site_logo') != '')
                                <img style="height: 90px; margin-bottom: 15px;"
                                     src="{{ Setting::get('site_logo', asset('logo-black.png')) }}">
                            @endif
                            <input type="file" accept="image/*" name="site_logo" class="dropify form-control-file"
                                   id="site_logo" aria-describedby="fileHelp">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="tax_percentage" class="col-xs-2 col-form-label">{{ translateKeyword('Copyright_Content')}}</label>
                        <div class="col-xs-10">
                            <input class="form-control" type="text"
                                   value="&copy; {{ Setting::get('site_copyright', date('Y') . ' Meemcolart') }}"
                                   name="site_copyright" id="site_copyright" placeholder="{{ translateKeyword('Copyright_Content')}}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="f_u_url" class="col-xs-2 col-form-label">{{ translateKeyword('user_app_playstore_link')}}</label>
                        <div class="col-xs-10">
                            <input class="form-control" type="text" value="{{ Setting::get('f_u_url', '') }}"
                                   name="f_u_url" id="f_u_url" placeholder="{{ translateKeyword('user_app_playstore_link')}}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="f_p_url" class="col-xs-2 col-form-label">{{ translateKeyword('provider-app-playStore-link')}}</label>
                        <div class="col-xs-10">
                            <input class="form-control" type="text" value="{{ Setting::get('f_p_url', '') }}"
                                   name="f_p_url" id="f_p_url" placeholder="{{ translateKeyword('provider-app-playStore-link')}}">
                        </div>
                    </div>
                    <h5>Contact Page Settings</h5></br>
                    <div class="form-group row">
                        <label for="Website Link" class="col-xs-2 col-form-label">{{ translateKeyword('user_app_playstore_link')}}</label>
                        <div class="col-xs-10">
                            <input class="form-control" type="text" value="{{ Setting::get('site_link', '') }}"
                                   name="site_link" id="site_link" placeholder="Website Link">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="Contact Message" class="col-xs-2 col-form-label">{{ translateKeyword('Contact Message')}}</label>
                        <div class="col-xs-10">
                            <input class="form-control" type="text" value="{{ Setting::get('contact_message', '') }}"
                                   name="contact_message" id="contact_message" placeholder="{{ translateKeyword('Contact Message')}}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="Contact City" class="col-xs-2 col-form-label">{{ translateKeyword('ontact-city')}}</label>
                        <div class="col-xs-10">
                            <input class="form-control" type="text" value="{{ Setting::get('contact_city', '') }}"
                                   name="contact_city" id="contact_city" placeholder="{{ translateKeyword('ontact-city')}}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="Contact Address" class="col-xs-2 col-form-label">{{ translateKeyword('contact-address')}}</label>
                        <div class="col-xs-10">
                            <input class="form-control" type="text" value="{{ Setting::get('contact_address', '') }}"
                                   name="contact_address" id="contact_address" placeholder="{{ translateKeyword('contact-address')}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="Contact Email" class="col-xs-2 col-form-label">{{ translateKeyword('contact-email')}}</label>
                        <div class="col-xs-10">
                            <input class="form-control" type="text" value="{{ Setting::get('contact_email', '') }}"
                                   name="contact_email_address" id="contact_email_address" placeholder="{{ translateKeyword('contact-email')}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-xs-2 col-form-label">
                            <label for="UPI_key" class="col-form-label">
                                {{ translateKeyword('contact-phone-show/hide')}}
                            </label>
                        </div>
                        <div class="col-xs-10">
                            <input @if (Setting::get('contact_number_show') == 1) checked
                                   @endif name="contact_number_show" id="contact_number_show"
                                   type="checkbox" class="js-switch" data-color="#43b968">
                        </div>

                    </div>
                    <div class="form-group row">
                        <label for="Contact Phone" class="col-xs-2 col-form-label">{{ translateKeyword('contact-phone')}}</label>
                        <div class="col-xs-10">
                            <input class="form-control" type="text"
                                   value="{{ str_replace(' ', '', Setting::get('contact_number', '')) }}"
                                   name="contact_number" id="contact_number" placeholder="{{ translateKeyword('contact-phone')}}">
                        </div>
                    </div>
                    <h5>{{ translateKeyword('Frontend Text Settings')}}</h5></br>

                    <div class="form-group row">
                        <label for="f_img2" class="col-xs-2 col-form-label">{{ translateKeyword('image')}} 1</label>
                        <div class="col-xs-10">
                            @if (Setting::get('f_img2') != '')
                                <img style="height: 90px; margin-bottom: 15px;"
                                     src="{{ Setting::get('f_img2', 'https://pngimg.com/uploads/taxi/taxi_PNG16.png') }}">
                            @endif
                            <input type="file" accept="image/*" name="f_img2" class="dropify form-control-file"
                                   id="f_img2" aria-describedby="fileHelp">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-xs-10">
                            <input class="form-control" type="text" value="{{ Setting::get('f_text1', '') }}"
                                   name="f_text1" id="f_text1" placeholder="{{ translateKeyword('Enter Text Here')}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-xs-10">
                            <input class="form-control" type="text" value="{{ Setting::get('f_text2', '') }}"
                                   name="f_text2" id="f_text2" placeholder="{{ translateKeyword('Enter Text Here')}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-xs-10">
                            <input class="form-control" type="text" value="{{ Setting::get('f_text6', '') }}"
                                   name="f_text6" id="f_text6" placeholder="{{ translateKeyword('Enter Text Here')}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-xs-10">
                            <input class="form-control" type="text" value="{{ Setting::get('f_text7', '') }}"
                                   name="f_text7" id="f_text7" placeholder="{{ translateKeyword('Enter Text Here')}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-xs-10">
                            <input class="form-control" type="text" value="{{ Setting::get('f_text8', '') }}"
                                   name="f_text8" id="f_text8" placeholder="{{ translateKeyword('Enter Text Here')}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-xs-10">
                            <input class="form-control" type="text" value="{{ Setting::get('f_text9', '') }}"
                                   name="f_text9" id="f_text9" placeholder="{{ translateKeyword('Enter Text Here')}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-xs-10">
                            <input class="form-control" type="text" value="{{ Setting::get('f_text10', '') }}"
                                   name="f_text10" id="f_text10" placeholder="{{ translateKeyword('Enter Text Here')}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-xs-10">
                            <input class="form-control" type="text" value="{{ Setting::get('f_text11', '') }}"
                                   name="f_text11" id="f_text11" placeholder="{{ translateKeyword('Enter Text Here')}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-xs-10">
                            <input class="form-control" type="text" value="{{ Setting::get('f_text12', '') }}"
                                   name="f_text12" id="f_text12" placeholder="{{ translateKeyword('Enter Text Here')}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-xs-10">
                            <input class="form-control" type="text" value="{{ Setting::get('f_text13', '') }}"
                                   name="f_text13" id="f_text13" placeholder="{{ translateKeyword('Enter Text Here')}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-xs-10">
                            <input class="form-control" type="text" value="{{ Setting::get('f_text14', '') }}"
                                   name="f_text14" id="f_text14" placeholder="{{ translateKeyword('Enter Text Here')}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-xs-10">
                            <input class="form-control" type="text" value="{{ Setting::get('f_text15', '') }}"
                                   name="f_text15" id="f_text15" placeholder="{{ translateKeyword('Enter Text Here')}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-xs-10">
                            <input class="form-control" type="text" value="{{ Setting::get('f_text16', '') }}"
                                   name="f_text16" id="f_text16" placeholder="{{ translateKeyword('Enter Text Here')}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-xs-10">
                            <input class="form-control" type="text" value="{{ Setting::get('f_text17', '') }}"
                                   name="f_text17" id="f_text17" placeholder="{{ translateKeyword('Enter Text Here')}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-xs-10">
                            <input class="form-control" type="text" value="{{ Setting::get('f_text18', '') }}"
                                   name="f_text18" id="f_text18" placeholder="{{ translateKeyword('Enter Text Here')}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-xs-10">
                            <input class="form-control" type="text" value="{{ Setting::get('f_text19', '') }}"
                                   name="f_text19" id="f_text19" placeholder="{{ translateKeyword('Enter Text Here')}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-xs-10">
                            <input class="form-control" type="text" value="{{ Setting::get('f_text20', '') }}"
                                   name="f_text20" id="f_text20" placeholder="{{ translateKeyword('Enter Text Here')}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-xs-10">
                            <input class="form-control" type="text" value="{{ Setting::get('f_text21', '') }}"
                                   name="f_text21" id="f_text21" placeholder="{{ translateKeyword('Enter Text Here')}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-xs-10">
                            <input class="form-control" type="text" value="{{ Setting::get('f_text22', '') }}"
                                   name="f_text22" id="f_text22" placeholder="{{ translateKeyword('Enter Text Here')}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-xs-10">
                            <input class="form-control" type="text" value="{{ Setting::get('f_text23', '') }}"
                                   name="f_text23" id="f_text23" placeholder="{{ translateKeyword('Enter Text Here')}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-xs-10">
                            <input class="form-control" type="text" value="{{ Setting::get('f_text24', '') }}"
                                   name="f_text24" id="f_text24" placeholder="{{ translateKeyword('Enter Text Here')}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-xs-10">
                            <input class="form-control" type="text" value="{{ Setting::get('f_text25', '') }}"
                                   name="f_text25" id="f_text25" placeholder="{{ translateKeyword('Enter Text Here')}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-xs-10">
                            <input class="form-control" type="text" value="{{ Setting::get('f_text26', '') }}"
                                   name="f_text26" id="f_text26" placeholder="{{ translateKeyword('Enter Text Here')}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-xs-10">
                            <input class="form-control" type="text" value="{{ Setting::get('f_text27', '') }}"
                                   name="f_text27" id="f_text27" placeholder="{{ translateKeyword('Enter Text Here')}}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="zipcode" class="col-xs-2 col-form-label"></label>
                        <div class="col-xs-10">
                            <button type="submit" class="btn btn-primary">{{ translateKeyword('update_site_settings')}}</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
