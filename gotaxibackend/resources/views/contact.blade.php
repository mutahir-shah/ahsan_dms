@extends('layout.base')
@section('title', 'Delivery/Transport Hub')
@section('content')
    <section class="contact_area">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6 map_area">
                    <iframe src="{{Setting::get('map_contact_page', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2021.1846708706564!2d17.534999115985556!3d59.56333258174131!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x465fafb441db8b9f%3A0xf8d4383d87f2392c!2sMastv%C3%A4gen%2013%2C%20746%2032%20B%C3%A5lsta!5e0!3m2!1sen!2sse!4v1644350205517!5m2!1sen!2sse')}}"
                            width="500" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                    @if(Setting::get('contact_info_container') == 1)
                        <div class="app_contact_info">
                            <span class="triangle"></span>
                            @if($contactSettings && $contactSettings->contact_address != '')
                                <div class="info_item">
                                    <i class="ti-location-pin"></i>
                                    <h6>{{ translateKeyword('address') }}:</h6>
                                    <p>{{$contactSettings->contact_address}}</p>
                                </div>
                            @endif

                            @if(Setting::get('contact_number_show', 0) == 1 && Setting::get('contact_number') != '')
                                <div class="info_item">
                                    <i class="ti-mobile"></i>
                                    <h6>{{ translateKeyword('phone') }}:</h6>
                                    <p>
                                        <a href="tel:{{ str_replace(' ', '', Setting::get('contact_number', '')) }}">{{ str_replace(' ', '', Setting::get('contact_number', '')) }}</a>
                                    </p>
                                </div>
                            @endif

                            @if(Setting::get('contact_email_address') != '')
                                <div class="info_item">
                                    <i class="ti-email"></i>
                                    <h6>{{ translateKeyword('email') }}:</h6>
                                    <p>
                                        <a href="mailto:{{Setting::get('contact_email_address', '')}}">{{Setting::get('contact_email_address', '')}}</a>
                                    </p>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
                <div class="col-lg-6 p0">
                    <div class="contact_info">
                        <div class="section_title">
                            <h5>{{ translateKeyword('how_can_we_help_you') }}?</h5>
                            <h2>{{ translateKeyword('have_a_question') }}?</h2>
                        </div>
                        @if(Session::has('flash_error'))
                            <div class="alert alert-danger alert-dismissible">
                                {{-- <a href="javascript:;" class="close" data-dismiss="alert" aria-label="close">&times;</a> --}}
                                <p class="m-0"><strong>{{ translateKeyword('Error!')}}</strong> {{ Session::get('flash_error') }}</p>
                                </ul>
                            </div>
                        @endif
                        @if(Session::has('flash_success'))
                            <div class="alert alert-success alert-dismissible">
                                <a href="javascript:" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <p class="m-0"><strong>{{ translateKeyword('Success!')}}</strong> {{ Session::get('flash_success') }}</p>
                                </ul>
                            </div>
                        @endif
                        <form action="{{ route('contact-enquiry') }}" id="contact-form" class="contact_form"
                              data-pickme="contact" method="POST">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <input type="text" class="form-control" id="name" name="name" placeholder="{{ translateKeyword('your_name') }}"
                                       required>
                                <label class="border_line"></label>
                            </div>
                            <div class="form-group">
                                <input type="email" class="form-control" id="email" name="email"
                                       placeholder="{{ translateKeyword('your_email') }}" required>
                                <label class="border_line"></label>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" id="subject" name="subject"
                                       placeholder="{{ translateKeyword('subject') }}" required>
                                <label class="border_line"></label>
                            </div>
                            <div class="form-group">
                                <textarea id="message" name="content" cols="30" rows="10" class="form-control"
                                          placeholder="{{ translateKeyword('your_message') }}" required></textarea>
                                <label class="border_line"></label>
                            </div>
                            <div class="form-group">
                                <button type="submit" name="submit" class="slider_btn yellow_hover">{{ translateKeyword('send_message') }}
                                </button>
                            </div>


                            <div class="form-result alert">
                                <div class="content"></div>
                            </div>
                            <!-- /.form-result-->
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection