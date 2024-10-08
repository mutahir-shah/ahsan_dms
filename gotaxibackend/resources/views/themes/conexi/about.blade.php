@extends('themes.conexi.layouts.app')
@section('content')
    <section class="inner-banner">
        <div class="container">
            <ul class="thm-breadcrumb">
                <li><a href="/">Home</a></li>
                <li><span class="sep">.</span></li>
                <li><span class="page-title">{{ $title }}</span></li>
            </ul><!-- /.thm-breadcrumb -->
            <h2>{{ $title }}</h2>
        </div><!-- /.container -->
    </section><!-- /.inner-banner -->
    <section class="about-style-two">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    {!! Setting::get($page) !!}
                </div><!-- /.col-lg-12 -->
            </div><!-- /.row -->
        </div><!-- /.container -->
    </section><!-- /.about-style-two -->
    @if(Setting::get('hide_conexi_code') == 1)
        <hr class="style-one"/>
        <div class="brand-carousel-wrapper">
            <div class="container">
                <div class="brand-carousel-one owl-theme owl-carousel">
                    <div class="item">
                        <img src="{{ asset('conexi/images/brand/brand-1-1.jpg') }}" alt="Awesome Image"/>
                    </div><!-- /.item -->
                    <div class="item">
                        <img src="{{ asset('conexi/images/brand/brand-1-2.jpg') }}" alt="Awesome Image"/>
                    </div><!-- /.item -->
                    <div class="item">
                        <img src="{{ asset('conexi/images/brand/brand-1-3.jpg') }}" alt="Awesome Image"/>
                    </div><!-- /.item -->
                    <div class="item">
                        <img src="{{ asset('conexi/images/brand/brand-1-4.jpg') }}" alt="Awesome Image"/>
                    </div><!-- /.item -->
                    <div class="item">
                        <img src="{{ asset('conexi/images/brand/brand-1-5.jpg') }}" alt="Awesome Image"/>
                    </div><!-- /.item -->
                    <div class="item">
                        <img src="{{ asset('conexi/images/brand/brand-1-1.jpg') }}" alt="Awesome Image"/>
                    </div><!-- /.item -->
                    <div class="item">
                        <img src="{{ asset('conexi/images/brand/brand-1-2.jpg') }}" alt="Awesome Image"/>
                    </div><!-- /.item -->
                    <div class="item">
                        <img src="{{ asset('conexi/images/brand/brand-1-3.jpg') }}" alt="Awesome Image"/>
                    </div><!-- /.item -->
                    <div class="item">
                        <img src="{{ asset('conexi/images/brand/brand-1-4.jpg') }}" alt="Awesome Image"/>
                    </div><!-- /.item -->
                    <div class="item">
                        <img src="{{ asset('conexi/images/brand/brand-1-5.jpg') }}" alt="Awesome Image"/>
                    </div><!-- /.item -->
                </div><!-- /.brand-carousel-one -->
            </div><!-- /.container -->
        </div><!-- /.brand-carousel-wrapper -->
        <section class="feature-style-one thm-black-bg">
            <img src="{{ asset('conexi/images/background/feature-bg-1-1.png') }}" alt="Awesome Image"
                 class="feature-bg"/>
            <div class="container">
                <div class="block-title text-center">
                    <div class="dot-line"></div><!-- /.dot-line -->
                    <p>Conexi benefit list</p>
                    <h2 class="light">Why choose us</h2>
                </div><!-- /.block-title text-center -->
                <div class="row">
                    <div class="col-lg-4">
                        <div class="single-feature-one">
                            <div class="icon-block">
                                <i class="conexi-icon-insurance"></i>
                            </div><!-- /.icon-block -->
                            <h3><a href="#">Safety Guarantee</a></h3>
                            <p>Lorem ipsum dolor sit amet <br> cons adipisci elit vehicula est <br> non lac at quam.</p>
                            <a href="#" class="more-link">Read More</a>
                        </div><!-- /.single-feature-one -->
                    </div><!-- /.col-lg-4 -->
                    <div class="col-lg-4">
                        <div class="single-feature-one">
                            <div class="icon-block">
                                <i class="conexi-icon-seatbelt"></i>
                            </div><!-- /.icon-block -->
                            <h3><a href="#">DBS Cleared Providers</a></h3>
                            <p>Lorem ipsum dolor sit amet <br> cons adipisci elit vehicula est <br> non lac at quam.</p>
                            <a href="#" class="more-link">Read More</a>
                        </div><!-- /.single-feature-one -->
                    </div><!-- /.col-lg-4 -->
                    <div class="col-lg-4">
                        <div class="single-feature-one">
                            <div class="icon-block">
                                <i class="conexi-icon-consent"></i>
                            </div><!-- /.icon-block -->
                            <h3><a href="#">Free Quotation</a></h3>
                            <p>Lorem ipsum dolor sit amet <br> cons adipisci elit vehicula est <br> non lac at quam.</p>
                            <a href="#" class="more-link">Read More</a>
                        </div><!-- /.single-feature-one -->
                    </div><!-- /.col-lg-4 -->
                </div><!-- /.row -->
            </div><!-- /.container -->
        </section><!-- /.feature-style-one -->
        <section class="history-style-one">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="history-carousel-block ">
                            <ul class="slider  history-slider-one">
                                <li class="slide-item">
                                    <div class="image-block">
                                        <img src="{{ asset('conexi/images/resources/history-1-1.jpg') }}"
                                             alt="history image">
                                    </div><!-- /.image-block -->
                                </li>
                                <li class="slide-item">
                                    <div class="image-block">
                                        <img src="{{ asset('conexi/images/resources/history-1-1.jpg') }}"
                                             alt="history image">
                                    </div><!-- /.image-block -->
                                </li>
                                <li class="slide-item">
                                    <div class="image-block">
                                        <img src="{{ asset('conexi/images/resources/history-1-1.jpg') }}"
                                             alt="history image">
                                    </div><!-- /.image-block -->
                                </li>
                            </ul>
                            <div class="history-one-slider-btn">
                                <span class="carousel-btn left-btn"><i class="conexi-icon-left"></i></span>
                                <span class="carousel-btn right-btn"><i class="conexi-icon-right"></i></span>
                            </div><!-- /.carousel-btn-block banner-carousel-btn -->
                        </div><!-- /.history-carousel-block -->
                    </div><!-- /.col-lg-6 -->
                    <div class="col-lg-6">
                        <div class="content-block">
                            <div class="block-title">
                                <div class="dot-line"></div><!-- /.dot-line -->
                                <p>Conexi history</p>
                                <h2>How we reached <br> to this level</h2>
                            </div><!-- /.block-title -->
                            <div class="history-content history-content-one-pager">
                                <a href="#" class="pager-item active" data-slide-index="1">
                                    <h3>1987</h3>
                                    <p>There are many variations of passages of lorem ipsum available but the majority
                                        have suffered alteration in some form by injected humour or random words which
                                        don't look even slightly believable. If you are going to use a passage of lorem
                                        ipsum you need to be sure there isn't anything embarrassing.</p>
                                </a>
                                <a href="#" class="pager-item" data-slide-index="2">
                                    <h3>2009</h3>
                                    <p>There are many variations of passages of lorem ipsum available but the majority
                                        have suffered alteration in some form by injected humour or random words which
                                        don't look even slightly believable. If you are going to use a passage of lorem
                                        ipsum you need to be sure there isn't anything embarrassing.</p>
                                </a>
                                <a href="#" class="pager-item" data-slide-index="3">
                                    <h3>2019</h3>
                                    <p>There are many variations of passages of lorem ipsum available but the majority
                                        have suffered alteration in some form by injected humour or random words which
                                        don't look even slightly believable. If you are going to use a passage of lorem
                                        ipsum you need to be sure there isn't anything embarrassing.</p>
                                </a>
                            </div><!-- /.testimonials-one-pager -->
                        </div><!-- /.content-block -->
                    </div><!-- /.col-lg-6 -->
                </div><!-- /.row -->
            </div><!-- /.container -->
        </section><!-- /.history-style-one -->
        <section class="offer-style-one">
            <div class="container">
                <div class="block-title text-center">
                    <div class="dot-line"></div><!-- /.dot-line -->
                    <p>Check out our benefits</p>
                    <h2>What we’re offering</h2>
                </div><!-- /.block-title -->
                <div class="row">
                    <div class="col-lg-4">
                        <div class="single-offer-one hvr-float-shadow">
                            <div class="image-block">
                                <a href="#"><i class="fa fa-link"></i></a>
                                <img src="{{ asset('conexi/images/resources/offer-1-1.jpg') }}" alt="Awesome Image"/>
                            </div><!-- /.image-block -->
                            <div class="text-block">
                                <h3><a href="#">Credit booking</a></h3>
                                <p>There are many van of pasage of suffer alteration lipsum is simply free text.</p>
                                <a href="#" class="more-link">Read More</a>
                            </div><!-- /.text-block -->
                        </div><!-- /.single-offer-one -->
                    </div><!-- /.col-lg-4 -->
                    <div class="col-lg-4">
                        <div class="single-offer-one hvr-float-shadow">
                            <div class="image-block">
                                <a href="#"><i class="fa fa-link"></i></a>
                                <img src="{{ asset('conexi/images/resources/offer-1-2.jpg') }}" alt="Awesome Image"/>
                            </div><!-- /.image-block -->
                            <div class="text-block">
                                <h3><a href="#">Home pickups</a></h3>
                                <p>There are many van of pasage of suffer alteration lipsum is simply free text.</p>
                                <a href="#" class="more-link">Read More</a>
                            </div><!-- /.text-block -->
                        </div><!-- /.single-offer-one -->
                    </div><!-- /.col-lg-4 -->
                    <div class="col-lg-4">
                        <div class="single-offer-one hvr-float-shadow">
                            <div class="image-block">
                                <a href="#"><i class="fa fa-link"></i></a>
                                <img src="{{ asset('conexi/images/resources/offer-1-3.jpg') }}" alt="Awesome Image"/>
                            </div><!-- /.image-block -->
                            <div class="text-block">
                                <h3><a href="#">Long travels</a></h3>
                                <p>There are many van of pasage of suffer alteration lipsum is simply free text.</p>
                                <a href="#" class="more-link">Read More</a>
                            </div><!-- /.text-block -->
                        </div><!-- /.single-offer-one -->
                    </div><!-- /.col-lg-4 -->
                </div><!-- /.row -->
            </div><!-- /.container -->
        </section><!-- /.offer-style-one -->
        <section class="cta-style-one text-center">
            <div class="container">
                <p>Call 24 hour service available</p>
                <h3>Call now and book <br> our taxi for your next ride</h3>
                <a href="taxi" class="cta-btn">Choose Your Taxi</a>
            </div><!-- /.container -->
        </section><!-- /.cta-style-one -->
    @endif
@endsection