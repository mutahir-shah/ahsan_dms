<header class="header_area">
    <div class="d-flex justify-content-center align-items-center text-dark" style="background: #fff">
        <i class="fa fa-envelope mr-1"></i>
        <a href="mailto:{{ Setting::get('contact_email_address', '') }}"
            class="text-dark">{{ Setting::get('contact_email_address', '') }}</a>
        @if (Setting::get('contact_number_show', 0) == 1 && Setting::get('contact_number'))
            <i class="fas fa-phone-volume ml-3"></i>
            <a href="tel:{{ Setting::get('contact_number', '') }}"
                class="text-dark">{{ str_replace(' ', '', Setting::get('contact_number', '')) }}</a>
        @endif
    </div>
    <div class="container-fluid d-flex">
        <nav class="navbar navbar-expand-lg navbar-light">
            <a href="/" class="logo"><img style="height: 80px" src="{{ Setting::get('site_logo', '') }}"
                    alt="site_logo"></a>
            <button class="navbar-toggler collapsed" type="button" data-toggle="collapse"
                data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="true"
                aria-label="Toggle navigation">
                <span class="menu_toggle">
                    <span class="hamburger">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                    <span class="hamburger-cross">
                        <span></span>
                        <span></span>
                    </span>
                </span>
            </button>

            <div class="collapse navbar-collapse offset" id="navbarSupportedContent" style="background: #ffffffcc;">
                <ul class="nav navbar-nav menu mr-auto">
                    @if (Setting::get('home_button') == 1)
                        <li class="nav-item {{ request()->is('/') ? 'active' : '' }}"><a class="nav-link"
                                href="{{ url('/') }}">@translateKeyword('home')</a>
                        </li>
                    @endif
                    @if (Setting::get('introduction') == 1)
                        <li class="nav-item {{ request()->is('about') ? 'active' : '' }}"><a class="nav-link"
                                href="{{ url('/about') }}">{{ translateKeyword('about_us') }}</a>
                        </li>
                    @endif
                    @if (Setting::get('blogs_switch') == 1)
                        <li class="nav-item {{ request()->is('blogs') ? 'active' : '' }}"><a class="nav-link"
                                href="{{ url('/blogs') }}">{{ translateKeyword('blogs') }}</a>
                        </li>
                    @endif
                    @if (Setting::get('testinomials_switch') == 1)
                        <li class="nav-item {{ request()->is('testimonials') ? 'active' : '' }}"><a class="nav-link"
                                href="{{ url('/testimonials') }}">{{ translateKeyword('testimonials') }}</a>
                        </li>
                    @endif
                    @if (Setting::get('faq_switch') == 1)
                        <li class="nav-item {{ request()->is('faqs') ? 'active' : '' }}"><a class="nav-link"
                                href="{{ url('/faqs') }}">{{ translateKeyword('faqs') }}</a></li>
                    @endif
                    <li class="nav-item {{ request()->is('contact') ? 'active' : '' }}"><a class="nav-link"
                            href="{{ url('/contact') }}">{{ translateKeyword('contact_us') }}</a>
                    </li>
                    @if (Setting::get('driver_on_web') == 1)
                        <li class="nav-item"><a class="nav-link"
                                href="{{ url('/provider/register') }}">{{ translateKeyword('become_a_driver') }}</a>
                        </li>
                    @endif
                    {{-- <div> --}}
                    @if (Setting::get('call_us') == 1)
                        <li class="nav-item d-lg-none">
                            <a class="nav-link"
                                href="tel:{{ str_replace(' ', '', Setting::get('contact_number', '')) }}"
                                class="book_btn">{{ translateKeyword('call_us') }}</a>
                        </li>
                    @endif
                    @if (Setting::get('login_on_web') == 1)
                        <li class="nav-item d-lg-none">
                            <a class="nav-link" href="login" class="book_btn">{{ translateKeyword('login') }}</a>
                        </li>
                    @endif
                    @if (Setting::get('register_on_web') == 1)
                        <li class="nav-item d-lg-none">
                            <a class="nav-link" href="register" class="book_btn">{{ translateKeyword('register') }}</a>
                        </li>
                    @endif
                    @if (Setting::get('multilanguage_enabled', 0) == 1)
                        @php($languages = getLanguages())
                        @if (count($languages) > 1)
                            <li class="nav-item d-lg-none">
                                <select class="selectpicker mr-2 ml-2" id="language-selector" data-width="fit"
                                    onchange="translateLanguage(this.value);">
                                    @foreach ($languages as $language)
                                        <option value="{{ route('language.locale', $language->id) }}"
                                            @if (Session::get('translation') == $language->id) selected @endif>
                                            {{ $language->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </li>
                        @endif
                    @endif
                    {{-- </div> --}}
                </ul>
            </div>
        </nav>
        <div class="menu_btn">
            @if (Setting::get('call_us') == 1)
                <a href="tel:{{ str_replace(' ', '', Setting::get('contact_number', '')) }}"
                    class="book_btn">{{ translateKeyword('call_us') }}</a>
            @endif
            @if (Setting::get('login_on_web') == 1)
                <a href="login" class="book_btn">{{ translateKeyword('login') }}</a>
            @endif
            @if (Setting::get('register_on_web') == 1)
                <a href="register" class="book_btn">{{ translateKeyword('register') }}</a>
            @endif
            @if (Setting::get('multilanguage_enabled', 0) == 1)
                @if (count($languages) > 1)
                    <select class="selectpicker mr-2 ml-2" id="language-selector" data-width="fit"
                        onchange="translateLanguage(this.value);">
                        @foreach ($languages as $language)
                            <option value="{{ route('language.locale', $language->id) }}"
                                @if (Session::get('translation') == $language->id) selected @endif>
                                {{ $language->name }}
                            </option>
                        @endforeach
                    </select>
                @endif
            @endif
        </div>
    </div>
</header>
