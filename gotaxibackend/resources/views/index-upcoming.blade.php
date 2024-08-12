<!DOCTYPE html>
<html lang="en">
@section('title', 'Delivery/Transport Hub')
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>{{ Setting::get('site_title','')}} - @yield('title' , '')</title>
    <!-- Favicons -->
    <link rel="shortcut icon" type="image/png" href="{{ Setting::get('site_icon') }}"/>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,600,600i,700,700i"
          rel="stylesheet">
    <!-- Vendor CSS Files -->
    <link href="{{ asset('website/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('website/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <!-- Template Main CSS File -->
    <link href="{{ asset('website/assets/css/style.css') }}" rel="stylesheet">
</head>

<body>

<!-- ======= Header ======= -->
<header id="header">
    <div class="container-fluid d-flex justify-content-between align-items-center">

        <div class="logo">
            {{-- <h1 class="text-light"><a href="#"><span>{{Setting::get('site_title','')}}</span></a></h1> --}}
            <a href="#"><img src="{{Setting::get('site_logo', '')}}" alt="" class="img-fluid"/></a>
        </div>

        <div class="contact-link float-right">
            <a href="#contact" class="scrollto">Contact Us</a>
        </div>

    </div>
</header><!-- End #header -->

<!-- ======= Hero Section ======= -->
<section id="hero">
    <div class="hero-container blur">
        <h1>
            {{-- {{Setting::get('site_title','')}} --}}
            <div>
                <img src="{{Setting::get('site_logo', '')}}" alt="" class="img-fluid" height="250" width="250"/>
            </div>
        </h1>
        <h2>makes your journey easier <a
                    href="mailto:{{Setting::get('contact_email_address', '')}}">{{Setting::get('contact_email_address', '')}}</a></h2>
        {{-- <div class="countdown" data-count="2023/12/3" data-template="%d days %h:%m:%s"></div> --}}
    </div>
</section><!-- End Hero -->

<main id="main">

    <!-- ======= Contact Us Section ======= -->
    <section id="contact" class="contact">
        <div class="container">

            <div class="section-title">
                <h2>Contact Us</h2>
            </div>

            <div class="row contact-info">

                <div class="col-md-4">
                    <div class="contact-address">
                        <i class="bi bi-geo-alt"></i>
                        <h3>Address</h3>
                        <address>{{Setting::get('contact_address', '')}}</address>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="contact-phone">
                        <i class="bi bi-phone"></i>
                        <h3>Phone Number</h3>
                        <p>
                            <a href="tel:{{ str_replace(' ', '', Setting::get('contact_number', '')) }}">{{ str_replace(' ', '', Setting::get('contact_number', '')) }}</a>
                        </p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="contact-email">
                        <i class="bi bi-envelope"></i>
                        <h3>Email</h3>
                        <p>
                            <a href="mailto:{{Setting::get('contact_email_address', '')}}">{{Setting::get('contact_email_address', '')}}</a>
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </section><!-- End Contact Us Section -->

</main><!-- End #main -->

<!-- ======= Footer ======= -->
<footer id="footer">
    <div class="container">
        <div class="copyright">
            <p>Copyright © {{ date('Y') }} <a href="/">{{Setting::get('site_title', '')}}</a></p>
        </div>
    </div>
</footer><!-- End #footer -->

<!-- Vendor JS Files -->
<script src="{{ asset('website/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('website/assets/vendor/php-email-form/validate.js') }}"></script>

<!-- Template Main JS File -->
<script src="{{ asset('website/assets/js/main.js') }}"></script>

</body>

</html>