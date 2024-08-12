<footer class="footer_area sec_pad">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-sm-6">
                <div class="f_widget about_widget text-center">
                    <a href="/" class="f_logo"><img style="height: 80px;border-radius:80px;"
                            src="{{ Setting::get('site_logo', '') }}" alt="site_logo" style="margin-top: 10px;"></a>
                    <div class="f_social_icon">
                        @if (getSocialLinks() && getSocialLinks()->facebook != '')
                            <a href="{{ getSocialLinks()->facebook ?? '#' }}" target="_blank" class="ti-facebook"></a>
                        @endif
                        @if (getSocialLinks() && getSocialLinks()->twitter != '')
                            <a href="{{ getSocialLinks()->twitter ?? '#' }}" target="_blank" class="ti-twitter-alt"></a>
                        @endif
                        @if (getSocialLinks() && getSocialLinks()->linkedin != '')
                            <a href="{{ getSocialLinks()->linkedin ?? '#' }}" target="_blank" class="ti-linkedin"></a>
                        @endif
                        @if (getSocialLinks() && getSocialLinks()->instagram != '')
                            <a href="{{ getSocialLinks()->instagram ?? '#' }}" target="_blank"
                                class="ti-instagram"></a></a>
                        @endif
                        @if (getSocialLinks() && getSocialLinks()->youtube != '')
                            <a href="{{ getSocialLinks()->youtube ?? '#' }}" target="_blank" class="ti-youtube"></a></a>
                        @endif
                    </div>
                    <p>{{ translateKeyword('copyright') }} © {{ date('Y') }} <a
                            href={{ Setting::get('site_copyright_url', '') }}>{{ Setting::get('site_copyright', '') }}</a>
                    </p>
                </div>
            </div>
            <div class="col-lg-4 col-sm-6 ">
                <div class="get_app_content text-center"
                    style=" margin: auto;
                width: 100%;
                padding: 10px;">
                    <h2 style="color: white; margin-bottom: 50px; margin-top: -15px">
                        {{ translateKeyword('applications') }}</h2>
                    <a href="{{ getAppLinks()->f_u_url ?? '#' }}" class="app_btn slider_btn" style="margin-bottom: 20px"
                        target="_blank"><img src="{{ asset('mainindex/img/icon/play-store.png') }}"
                            alt="play-store">{{ translateKeyword('google_play') }}</a>
                    <a href="{{ getAppLinks()->user_store_link_ios ?? '#' }}" class="app_btn slider_btn"
                        target="_blank"><img src="{{ asset('mainindex/img/icon/apple-store.png') }}"
                            alt="apple-store">{{ translateKeyword('apple_store') }}&nbsp;</a>
                </div>
            </div>
            <div class="col-lg-4 col-sm-6">
                <div class="f_widget link_widget">
                    <h2 class="f_title">{{ translateKeyword('help') }}?</h2>
                    <ul class="list-unstyled f_list">
                        <li><a href="contact">{{ translateKeyword('contact_us') }}</a></li>
                        <li><a href="privacy">{{ translateKeyword('privacy_policy') }}</a></li>
                        <li><a href="terms">{{ translateKeyword('terms_conditions') }}</a></li>
                    </ul>
                    {{-- <div style="margin-top: 10%;">
                        <h4 class="f_title notranslate">Switch Language</h4>
                        <a href="javascript:;"><div id="google_translate_element"></div></a>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
</footer>
