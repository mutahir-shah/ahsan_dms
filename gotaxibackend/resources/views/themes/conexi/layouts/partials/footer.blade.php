<!--begin::Footer-->
<footer class="site-footer">
    <img src="{{ asset('conexi/images/background/footer-bg-1-1.png') }}" class="footer-bg" alt="Awesome Image" />
    <div class="upper-footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="footer-widget about-widget">
                        <div class="widget-title">
                            <h3>About</h3>
                        </div><!-- /.widget-title -->
                        <p>This {{ Setting::get('site_title', '') }} is the best taxi service in the world.</p>
                        <div class="social-block">
                            <a href="{{ Setting::get('f_t_link') }}" target="_blank"><i class="fa fa-twitter"></i></a>
                            <a href="{{ Setting::get('f_f_link') }}" target="_blank"><i
                                    class="fa fa-facebook-f"></i></a>
                            <a href="{{ Setting::get('f_l_link') }}" target="_blank"><i class="fa fa-linkedin"></i></a>
                            <a href="{{ Setting::get('f_i_link') }}" target="_blank"><i class="fa fa-instagram"></i></a>
                        </div><!-- /.social-block -->
                    </div><!-- /.footer-widget about-widget -->
                </div><!-- /.col-lg-3 -->
                <div class="col-lg-2">
                    <div class="footer-widget">
                        <div class="widget-title">
                            <h3>Links</h3>
                        </div><!-- /.widget-title -->
                        <ul class="link-lists">
                            {{-- <li><a href="/about">About</a></li> --}}
                            <li><a href="{{ route('bookride') }}">Get a Taxi</a></li>
                            @if(Setting::get('hide_conexi_code') == 1)
                            <li><a href="#">Our Reviews</a></li>
                            <li><a href="#">Latest News</a></li>
                            @endif
                            <li><a href="/contact">Contact</a></li>
                        </ul>
                    </div><!-- /.footer-widget -->
                </div><!-- /.col-lg-2 -->
                <div class="col-lg-3">
                    <div class="footer-widget">
                        <div class="widget-title">
                            <h3>Contact</h3>
                        </div><!-- /.widget-title -->
                        <p>{{ Setting::get('contact_address', '') }}
                            <br> {{ Setting::get('contact_city', '') }}{{ (Setting::get('country_code') !== '') ? ', ' . Setting::get('country_code', '') : ''  }}
                        </p>
                        <ul class="contact-infos">
                            <li>
                                <i class="fa fa-envelope"></i> {{ Setting::get('contact_email_address', 'needhelp@meemcolart.com') }}
                            </li>
                            <li>
                                <i class="fa fa-phone-square"></i>{{ str_replace(' ', '', Setting::get('contact_number', '')) }}
                            </li>
                        </ul><!-- /.contact-infos -->
                    </div><!-- /.footer-widget -->
                </div><!-- /.col-lg-3 -->
                <div class="col-lg-4">
                    <div class="footer-widget">
                        <div class="widget-title">
                            <h3>Newsletter</h3>
                        </div><!-- /.widget-title -->
                        <p>Sign up now for our mailing list to get all latest news <br> and updates
                            from {{ Setting::get('site_title') }} company.</p>
                        <form action="#" class="subscribe-form">
                            <input type="text" name="email" placeholder="Enter your email">
                            <button type="submit">Go</button>
                        </form>
                    </div><!-- /.footer-widget -->
                </div><!-- /.col-lg-4 -->
            </div><!-- /.row -->
        </div><!-- /.container -->
    </div><!-- /.upper-footer -->
    <div class="bottom-footer">
        <div class="container">
            <div class="inner-container">
                <div class="left-block">
                    <a href="/" class="footer-logo"><img src="{{ Setting::get('site_logo', '') }}" alt="Awesome Image" /></a>
                    <span>&copy; {{ date('Y') }} <a href="/">{{ Setting::get('site_copyright', 'meemcolart.com') }}</a></span>
                </div><!-- /.left-block -->


                {{-- <div class="col-lg-4 col-sm-6 ">
                    <div class="get_app_content text-center" style=" margin: auto;
                    width: 100%;
                    padding: 10px;">
                        <h2 style="color: white; margin-bottom: 50px; margin-top: -15px">Applications</h2>
                        <a href="{{Setting::get('f_u_url', '')}}" class="app_btn slider_btn"
                style="margin-bottom: 20px" target="_blank"><img src="{{ asset('conexi/images/background/play-store.png') }}" alt="play-store">Google
                Play</a>
                <a href="{{Setting::get('user_store_link_ios', '')}}" class="app_btn slider_btn" target="_blank"><img
                        src="{{ asset('conexi/images/background/apple-store.png') }}" alt="apple-store">Apple Store</a>
            </div>
        </div> --}}

        <div class="text-center">
            <a href="{{Setting::get('user_store_link_ios', '')}}" class="btn btn-store">
                <span class="fa fa-apple fa-3x pull-left"></span>
                <span class="btn-label">Download on the</span>
                <span class="btn-caption">App Store</span>
            </a>
            <a href="{{Setting::get('f_u_url', '')}}" class="btn btn-store">
                <span class="fa fa-android fa-3x pull-left"></span>
                <span class="btn-label">Download on the</span>
                <span class="btn-caption">Google Play</span>
            </a>
        </div>


        {{-- <div class="page-content page-container" id="page-content">
                    <div class="padding">
                        <div class="row container d-flex justify-content-center">
                            <div class="template-demo mt-2">
                                        <button class="btn btn-outline-dark btn-icon-text">
                                          <i class="fa fa-apple btn-icon-prepend mdi-36px"></i>
                                          <span class="d-inline-block text-left">
                                            <small class="font-weight-light d-block">Available on the</small>
                                            App Store
                                          </span>
                                        </button>
                                        <button class="btn btn-outline-dark btn-icon-text">
                                          <i class="fa fa-android btn-icon-prepend mdi-36px"></i>
                                          <span class="d-inline-block text-left">
                                            <small class="font-weight-light d-block">Get it on the</small>
                                            Google Play
                                          </span>
                                        </button>
                                      </div>
                            
                            
                            
                            
                        </div>
                    </div>
                </div> --}}

        <div class="right-block">
            <ul class="link-lists text-center">
                <li><a href="{{ route('terms') }}">Terms of Use</a></li>
                <li><a href="{{ route('privacy') }}">Privacy Policy</a></li>
            </ul>

        </div><!-- /.right-block -->
    </div><!-- /.inner-container -->
    </div><!-- /.container -->
    </div><!-- /.bottom-footer -->
</footer><!-- /.site-footer -->
<!--end::Footer-->