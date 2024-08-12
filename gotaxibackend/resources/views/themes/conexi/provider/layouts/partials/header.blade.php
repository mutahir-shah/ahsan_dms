<!--begin::Header-->
<header class="site-header header-one">
    <div class="top-bar">
        <div class="container">
            <div class="left-block">
                <a href="{{ route('website.login') }}"><i class="fa fa-user-circle"></i> Log In</a>

                {{-- <a href="{{ route('customer.register') }}"><i class="fa fa-user-circle"></i> Register</a> --}}

                <a href="{{ route('provider.login') }}"><i class="fa fa-user-circle"></i> Become A Provider</a>


                <a href="mailto:{{ Setting::get('contact_email_address', 'needhelp@meemcolart.com') }}"><i
                        class="fa fa-envelope"></i> {{ Setting::get('contact_email_address', 'needhelp@meemcolart.com') }}
                </a>
            </div><!-- /.left-block -->

            <div class="logo-block">
                <a href="/"><img src="{{ Setting::get('site_logo', '') }}" alt="Logo Image" /></a>
            </div><!-- /.logo-block -->
            <div class="social-block ">
                <a href="{{ Setting::get('f_t_link') }}" target="_blank"><i class="fa fa-twitter"></i></a>
                <a href="{{ Setting::get('f_f_link') }}" target="_blank"><i class="fa fa-facebook-f"></i></a>
                <a href="{{ Setting::get('f_l_link') }}" target="_blank"><i class="fa fa-linkedin"></i></a>
                <a href="{{ Setting::get('f_i_link') }}" target="_blank"><i class="fa fa-instagram"></i></a>

            </div><!-- /.social-block -->
            <div class="float-right">

                <div class="dropdown">
                    <button class=" language-btn dropdown-toggle" type="button" id="languageDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="path-to-flag/en.png" alt=""> English
                    </button>
                    <div class="dropdown-menu" aria-labelledby="languageDropdown">
                        <a class="dropdown-item" href="?lang=fr"><img src="path-to-flag/fr.png" alt=""> English</a>
                        <a class="dropdown-item" href="?lang=es"><img src="path-to-flag/es.png" alt=""> Arabic</a>
                        <!-- Add more languages as needed -->
                    </div>
                </div>

            </div>
        </div><!-- /.container -->
    </div><!-- /.top-bar -->
    <nav class="navbar navbar-expand-lg navbar-light header-navigation stricky">
        <div class="container clearfix">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="logo-box clearfix">
                <button class="menu-toggler" data-target="#main-nav-bar">
                    <span class="fa fa-bars"></span>
                </button>
            </div><!-- /.logo-box -->
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="main-navigation" id="main-nav-bar">
                <ul class="navigation-box">
                    <li class=" current ">
                        <a href="/">Home</a>
                    </li>
                    <li><a href="/contact">Contact Us</a></li>

                    <li><a href="{{ route('provider.login') }}">{{ translateKeyword('login') }}</a></li>
                    <li><a href="{{ route('provider.register') }}">{{ translateKeyword('register') }}</a></li>
                </ul>
                <div class="dropdown menu-down" style="display: none;">
                    <button class=" language-btn dropdown-toggle" type="button" id="languageDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="path-to-flag/en.png" alt=""> English
                    </button>
                    <div class="dropdown-menu" aria-labelledby="languageDropdown">
                        <a class="dropdown-item" href="?lang=fr"><img src="path-to-flag/fr.png" alt=""> English</a>
                        <a class="dropdown-item" href="?lang=es"><img src="path-to-flag/es.png" alt=""> Arabic</a>
                        <!-- Add more languages as needed -->
                    </div>
                </div>
            </div><!-- /.navbar-collapse -->
            <div class="right-side-box text-center">
                <div class="contact-btn-block">
                    <a href="tel:{{ str_replace(' ', '', Setting::get('contact_number', '')) }}">
                        <span class="icon-block">
                            <i class="conexi-icon-phone-call"></i>
                        </span>
                        <span class="text-block">
                            {{ str_replace(' ', '', Setting::get('contact_number', '')) }}
                            <span class="tag-line">Contact Number</span>
                        </span>
                    </a>
                    <div class="float-right">



                    </div>
                </div>



            </div><!-- /.right-side-box -->
        </div>
        <!-- /.container -->
    </nav>
</header><!-- /.site-header header-one -->
<!--end::Header-->