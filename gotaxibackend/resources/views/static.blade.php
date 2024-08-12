@extends('layout.base')
@section('title', 'Delivery/Transport Hub')
@section('content')
    <link rel="stylesheet" href="{{ asset('mainindex/css/style3.css') }}">
    <section class="tj-banner-form"
             style="background: url('{{ Setting::get('f_mainBanner', '')}}') no-repeat; background-size: cover;">

        <div class="container mt-5">

            <div class="row">

                <!--Header Banner Caption Content Start-->

                <div class="col-md-12 col-sm-12">

                    <div class="banner-caption">

                        <div class="banner-inner bounceInLeft animated delay-0s text-center">

                            <h2>{{ $title }}</h2>


                        </div>

                    </div>

                </div>


            </div>

        </div>

    </section>
    <section>
        <div class="row gray-section no-margin">
            <div class="container">
                <div class="content-block text-center">
                    <div class="title-divider"></div>
                    <p><br/><br/><br/>{!! Setting::get($page) !!}</p>
                </div>
            </div>
        </div>
    </section>
@endsection