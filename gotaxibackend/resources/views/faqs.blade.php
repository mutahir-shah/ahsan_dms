@extends('layout.base')
@section('title', 'FAQs')
@section('content')

    <link rel="stylesheet" href="{{ asset('mainindex/css/style3.css') }}">
    <link rel="stylesheet"
          href="{{ asset('conexi/css/style-' . Setting::get('website_theme_color', 'default') . '.css') }}">
    <link rel="stylesheet" href="{{ asset('conexi/css/responsive.css') }}">
    <section class="tj-banner-form"
             style="background: url('{{ Setting::get('faq_image', '')}}') no-repeat; background-size: cover;">

        <div class="container mt-5">

            <div class="row">

                <!--Header Banner Caption Content Start-->

                <div class="col-md-12 col-sm-12">

                    <div class="banner-caption">

                        <div class="banner-inner bounceInLeft animated delay-0s text-center">

                            {{-- <h2>{{ $title }}</h2> --}}
                            <h2>{{ translateKeyword('frequently_asked_questions') }}</h2>


                        </div>

                    </div>

                </div>


            </div>

        </div>

    </section>

    <section class="single-taxi-faq-one thm-gray-bg">
        <div class="container">
            <div class="block-title text-center">
                <div class="dot-line"></div><!-- /.dot-line -->
                <p>{{ translateKeyword('our_faqs') }}</p>
                <h2>{{ translateKeyword('question_answers') }}</h2>
            </div><!-- /.block-title -->
            <div class="accrodion-grp" data-grp-name="faq-accrodion">
                @foreach ($faqs as $index => $faq)
                <div class="accrodion {{ $index === 0 ? 'active' : '' }}">
                    <div class="accrodion-title">
                        <h4>{{ $faq->question }}</h4>
                    </div>
                    <div class="accrodion-content">
                        <div class="inner">
                            <p>{{ $faq->answer }}</p>
                        </div><!-- /.inner -->
                    </div>
                </div>
                @endforeach
                
            </div>
        </div><!-- /.container -->
    </section><!-- /.single-taxi-faq-one -->
@endsection
@section('scripts')
    {{-- <script src="{{ asset('conexi/js/jquery.js') }}"></script>
    <script src="{{ asset('conexi/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('conexi/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('conexi/js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('conexi/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('conexi/js/waypoints.min.js') }}"></script>
    <script src="{{ asset('conexi/js/jquery.counterup.min.js') }}"></script>
    <script src="{{ asset('conexi/js/jquery.bxslider.min.js') }}"></script>
    <script src="{{ asset('conexi/js/theme.js') }}"></script> --}}
    @stack('scripts')

@endsection