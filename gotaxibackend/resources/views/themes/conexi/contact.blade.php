@extends('themes.conexi.layouts.app')
@section('content')
<section class="inner-banner">
    <div class="container">
        <ul class="thm-breadcrumb">
            <li><a href="/">Home</a></li>
            <li><span class="sep">.</span></li>
            <li><span class="page-title">Contact</span></li>
        </ul><!-- /.thm-breadcrumb -->
        <h2>Contact</h2>
    </div><!-- /.container -->
</section><!-- /.inner-banner -->

<div class="contact-page-map-wrapper">
    <div class="google-map" id="contact-google-map" data-map-lat="40.712784" data-map-lng="-74.005941" data-icon-path="conexi/images/resources/map-pin-1-1.png') }}"
        data-map-title="Brooklyn, New York, United Kingdom" data-map-zoom="11" data-markers='{"marker-1": [40.712784, -74.005941, "<h4>Main Office</h4><p>Babylon Branch , Lindenhurst, UK</p>"],
                "marker-2": [40.728157, -74.077642, "<h4>Branch Office</h4> <p>291 Park Ave S, East Meadow, UK</p>"]}'></div>
    <div class="contact-info-block">
        <p>Giga Mall, DHA 2 <br> Rawalpindi, Pakistan</p>
        <ul class="contact-infos">
            <li><i class="fa fa-envelope"></i> {{ Setting::get('contact_email_address', 'needhelp@meemcolart.com') }}</li>
            <li><i class="fa fa-phone-square"></i> {{ Setting::get('contact_number', '+92 315 1430599') }}</li>
        </ul><!-- /.contact-infos -->
    </div><!-- /.contact-info-block -->
</div><!-- /.contact-page-map-wrapper -->
<section class="contact-form-style-one">
    <div class="container">
        <div class="block-title text-center">
            <div class="dot-line"></div><!-- /.dot-line -->
            <p>HOW CAN WE HELP YOU??</p>
            <h2>Have a Question??</h2>
        </div><!-- /.block-title -->

        <form class="contact-form-one row contact_form" method="post" action="{{ route('contact-enquiry') }}" id="contact-form"
            data-pickme="contact" method="POST">
            {{ csrf_field() }}
            <div class="col-lg-6">
                <div class="input-holder">
                    <input class="form-control" type="text" id="name" name="name" placeholder="{{ translateKeyword('your_name') }}" required>
                </div><!-- /.input-holder -->
            </div><!-- /.col-lg-6 -->
            <div class="col-lg-6">
                <div class="input-holder">
                    <input class="form-control" type="email" id="email" name="email"
                        placeholder="{{ translateKeyword('your_email') }}" required>
                </div><!-- /.input-holder -->
            </div><!-- /.col-lg-6 -->
            <div class="col-lg-12">
                <div class="input-holder">
                    <input class="form-control" type="text" id="subject" name="subject"
                        placeholder="{{ translateKeyword('subject') }}" required>
                </div><!-- /.input-holder -->
            </div><!-- /.col-lg-6 -->
            <div class="col-lg-12">
                <div class="input-holder">
                    <textarea class="form-control" name="form_message" placeholder="{{ translateKeyword('your_message') }}" required></textarea>
                </div><!-- /.input-holder -->
            </div><!-- /.col-lg-6 -->
            <div class="col-lg-12">
                <div class="input-holder text-center">
                    <input id="form_botcheck" name="form_botcheck" class="form-control" type="hidden" value="">
                    <button class="theme-btn btn-style-two" type="submit" data-loading-text="Please wait..."><span>{{ translateKeyword('send_message') }}</span>
                    </button>
                </div><!-- /.input-holder -->
            </div><!-- /.col-lg-6 -->
        </form><!-- /.contact-form-one -->
    </div><!-- /.container -->
</section>
@endsection

@push('scripts')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCdzwoPinA9Cq9XpgjywLXro8AHYfzXFrk" async></script>
<script src="{{ asset('conexi/js/gmaps.js')}}"></script>
<script src="{{ asset('conexi/js/map-helper.js')}}"></script>
<script src="{{ asset('conexi/js/validate.js')}}"></script>
<script src="{{ asset('conexi/js/theme.js')}}"></script>
@endpush