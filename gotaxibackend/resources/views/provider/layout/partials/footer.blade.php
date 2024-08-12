<section class="tj-footer">

    <div class="container">

        <div class="row">

            <div class="col-md-4 text-center">

                <div class="about-widget widget">

                    <h3>About {{Setting::get('site_title', '')}}</h3>

                    <p>{{Setting::get('f_text27', '')}}</p>

                    <ul class="fsocial-links">

                        @if(Setting::get('f_f_link'))
                            <li><a target="_blank" href="{{Setting::get('f_f_link', '')}}"><i
                                            class="fab fa-facebook-f"></i></a></li>
                        @endif

                        @if(Setting::get('f_t_link'))
                            <li><a target="_blank" href="{{Setting::get('f_t_link', '')}}"><i
                                            class="fab fa-twitter"></i></a></li>
                        @endif

                        @if(Setting::get('f_l_link'))
                            <li><a target="_blank" href="{{Setting::get('f_l_link', '')}}"><i
                                            class="fab fa-linkedin-in"></i></a></li>
                        @endif

                        @if(Setting::get('f_i_link'))
                            <li><a target="_blank" href="{{Setting::get('f_i_link', '')}}"><i
                                            class="fab fa-instagram"></i></a></li>
                        @endif

                    </ul>

                </div>

            </div>

            <div class="col-md-4 text-center">

                <div class="links-widget widget">

                    <h3>Explore</h3>

                    <ul class="flinks-list">

                        <li><a href="contact">{{ translateKeyword('contact_us') }}</a></li>

                        <li><a href="privacy">{{ translateKeyword('privacy_policy') }}</a></li>

                        <li><a href="terms">{{ translateKeyword('terms_conditions') }}</a></li>

                    </ul>

                </div>

            </div>

            <div class="col-md-4 text-center">

                <div class="contact-info widget">

                    <h3>{{ translateKeyword('contact') }}</h3>

                    <ul class="contact-box">

                        @if(Setting::get('contact_address'))
                            <li>

                                <i class="fas fa-home" aria-hidden="true"></i> {{Setting::get('contact_address', '')}}

                            </li>
                        @endif
                        @if(Setting::get('contact_email'))
                            <li>

                                <i class="far fa-envelope-open"></i>

                                <a href="mailto:{{Setting::get('contact_email', '')}}">

                                    {{Setting::get('contact_email', '')}}</a>

                            </li>
                        @endif
                        @if(Setting::get('contact_number_show', 0) == 1 && Setting::get('contact_number'))
                            <li>

                                <i class="fas fa-phone-square"></i>

                                {{ str_replace(' ', '', Setting::get('contact_number', '')) }}

                            </li>
                        @endif
                        @if(Setting::get('site_link'))
                            <li>

                                <i class="fas fa-globe-asia"></i>

                                <a href="{{Setting::get('site_link', '')}}">{{Setting::get('site_link', '')}}</a>

                            </li>
                        @endif

                    </ul>

                </div>

            </div>

        </div>

    </div>

</section>

<!--Footer Content End-->

<!--Footer Copyright Start-->

<section class="tj-copyright">

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-sm-4"></div>
            <div class="col-md-4 col-sm-4" align="center">
                <a href="{{ Setting::get('site_copyright_url', '#') }}" target="_blank"><span>&copy; {{  date('Y') . Setting::get('site_copyright', '')}}</span></a>
            </div>
            <div class="col-md-4 col-sm-4"></div>
        </div>
    </div>

</section>
