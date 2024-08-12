@extends('layout.base')
@section('title', 'Testimonials')
@section('content')

    <link rel="stylesheet" href="{{ asset('mainindex/css/style3.css') }}">
    <link rel="stylesheet"
          href="{{ asset('conexi/css/style-' . Setting::get('website_theme_color', 'default') . '.css') }}">
    <link rel="stylesheet" href="{{ asset('conexi/css/responsive.css') }}">
    <section class="tj-banner-form"
             style="background: url('{{ Setting::get('testinomial_image', '')}}') no-repeat; background-size: cover;">

        <div class="container mt-5">

            <div class="row">

                <!--Header Banner Caption Content Start-->

                <div class="col-md-12 col-sm-12">

                    <div class="banner-caption">

                        <div class="banner-inner bounceInLeft animated delay-0s text-center">

                            <h2>{{translateKeyword('testimonials')}}</h2>


                        </div>

                    </div>

                </div>


            </div>

        </div>

    </section>


    <section class="single-blog-details-page">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="single-blog-style-one">
                        <div class="image-block mt-5">
                            <div class="inner-block">
                                <img src="{{ asset('conexi/images/blog/single-blog-1-1.jpg') }}" alt="Awesome Image"/>
                            </div><!-- /.inner-block -->
                        </div><!-- /.image-block -->
                        <div class="text-block">
                            <div class="meta-info">
                                <a href="#" class="date-block">20 Feb, 2023</a>
                                <a href="#">by Admin</a>
                                <span class="sep">.</span>
                                <a href="#">3 Comments</a>
                            </div><!-- /.meta-info -->
                            <h3 class="post-title">Earning with {{ Setting::get('site_title', '') }}</h3>
                            <p>
                            <ol>
                                <li>
                                    <h5>
                                        Become a Provider and Start Earning with Beegone!
                                    </h5>
                                    With Beegone, you can become a driver and earn money by driving people to their
                                    destinations. Our app connects you with passengers looking for a ride, so you can
                                    make money on your own schedule.
                                </li>
                                <li>
                                    <h5>
                                        Drive with Beegone and Earn More Than a Taxi Provider
                                    </h5>
                                    Beegone offers competitive rates for drivers, so you can earn more than a
                                    traditional taxi driver. Plus, you'll have the freedom to choose when and where you
                                    work.
                                </li>
                                <li>
                                    <h5>
                                        Increase Your Income with Beegone's Referral Program
                                    </h5>
                                    Want to earn even more with Beegone? Refer friends to our app and receive a bonus
                                    for every successful referral. It's a win-win for both you and your friends.
                                </li>
                                <li>
                                    <h5>
                                        Get Paid Quickly and Easily with Beegone
                                    </h5>
                                    We know that getting paid quickly is important to you. That's why Beegone offers
                                    easy and fast payment options, so you can get paid as soon as possible.
                                </li>
                                <li>
                                    <h5>
                                        Join the Beegone Community and Start Earning Today
                                    </h5>
                                    Join the Beegone community of drivers and start earning money today. With our
                                    user-friendly app and supportive community, you'll have everything you need to
                                    succeed as a driver.
                                </li>
                            </ol>
                            </p>
                        </div><!-- /.text-block -->
                    </div><!-- /.single-blog-style-one -->
                    <div class="share-block">
                        <div class="left-block">
                            <p>Tags<a href="#">{{translateKeyword('hybrid') }}</a><a href="#">{{translateKeyword('luxury-new') }}</a></p>
                        </div><!-- /.left-block -->
                        <div class="social-block">
                            <a href="#"><i class="fa fa-twitter"></i></a>
                            <a href="#"><i class="fa fa-facebook-f"></i></a>
                            <a href="#"><i class="fa fa-youtube-play"></i></a>
                        </div><!-- /.social-block -->
                    </div><!-- /.share-block -->
                    <div class="comments-block">
                        <div class="block-title">
                            <h2>2 Comments</h2>
                        </div><!-- /.block-title -->
                        <div class="single-comment-one">
                            <div class="image-block">
                                <div class="inner-block">
                                    <img src="{{ asset('conexi/images/blog/comment-1-1.jpg') }}" alt="Awesome Image"/>
                                </div><!-- /.inner-block -->
                            </div><!-- /.image-block -->
                            <div class="text-block">
                                <h3>Armida Faurrieta <span class="date-line">20 Feb, 2023</span></h3>
                                <p>As a frequent user of the taxi app, I really appreciate the efforts you're making to
                                    improve the user experience. Your post about the recent improvements to the app's
                                    navigation and search features was especially helpful. Thank you for continuing to
                                    make the app better and better!</p>
                                <a href="#" class="reply-btn">Reply</a>
                            </div><!-- /.text-block -->
                        </div><!-- /.single-comment-one -->
                        <div class="single-comment-one">
                            <div class="image-block">
                                <div class="inner-block">
                                    <img src="{{ asset('conexi/images/blog/comment-1-2.jpg') }}" alt="Awesome Image"/>
                                </div><!-- /.inner-block -->
                            </div><!-- /.image-block -->
                            <div class="text-block">
                                <h3>Ching Torsiello <span class="date-line">20 Feb, 2023</span></h3>
                                <p>Your post about the latest updates to the taxi app was really informative! I
                                    appreciate the way you explained the new features and how they will benefit users.
                                    I'm excited to try them out on my next ride.</p>
                                <a href="#" class="reply-btn">Reply</a>
                            </div><!-- /.text-block -->
                        </div><!-- /.single-comment-one -->
                    </div><!-- /.comments-block -->
                    <div class="reply-comment-block">
                        <div class="block-title">
                            <h2>{{translateKeyword('Leave a comment')}}</h2>
                        </div><!-- /.block-title -->
                        <form action="" class="contact-form-one row">
                            <div class="col-lg-6">
                                <div class="input-holder">
                                    <input type="text" name="name" placeholder="{{ translateKeyword('your_name') }}">
                                </div><!-- /.input-holder -->
                            </div><!-- /.col-lg-6 -->
                            <div class="col-lg-6">
                                <div class="input-holder">
                                    <input type="text" name="name" placeholder="{{ translateKeyword('your_email')}}">
                                </div><!-- /.input-holder -->
                            </div><!-- /.col-lg-6 -->
                            <div class="col-lg-12">
                                <div class="input-holder">
                                    <textarea name="message" placeholder="{{ translateKeyword('Write message') }}"></textarea>
                                </div><!-- /.input-holder -->
                            </div><!-- /.col-lg-6 -->
                            <div class="col-lg-12">
                                <div class="input-holder">
                                    <button type="submit">{{ translateKeyword('Submit Comment') }}</button>
                                </div><!-- /.input-holder -->
                            </div><!-- /.col-lg-6 -->
                        </form><!-- /.contact-form-one -->
                    </div><!-- /.reply-comment-block -->
                </div><!-- /.col-lg-8 -->
                <div class="col-lg-4">
                    <div class="sidebar">
                        <div class="single-sidebar author-widget mt-5">
                            <div class="image-block">
                                <img src="{{ asset('conexi/images/blog/auhor-1-1.jpg') }}" alt="Awesome Image"/>
                            </div><!-- /.image-block -->
                            <h3>{{translateKeyword('About Author') }}</h3>
                            <p>Admin</p>
                            <div class="social-block">
                                <a href="#"><i class="fa fa-twitter"></i></a>
                                <a href="#"><i class="fa fa-facebook-f"></i></a>
                                <a href="#"><i class="fa fa-youtube-play"></i></a>
                            </div><!-- /.social-block -->
                        </div><!-- /.single-sidebar author-widget -->
                        <div class="single-sidebar latest-post-widget">
                            <div class="widget-title">
                                <h3>{{ translateKeyword('Recent Post') }}</h3>
                            </div><!-- /.widget-title -->
                            <div class="post-wrapper">
                                <div class="single-latest-post">
                                    <div class="image-block">
                                        <div class="inner-block">
                                            <img src="{{ asset('conexi/images/blog/lp-1-1.jpg') }}"
                                                 alt="Awesome Image"/>
                                        </div><!-- /.inner-block -->
                                    </div><!-- /.image-block -->
                                    <div class="text-block">
                                        <span class="date-line">18 FEb, 2023</span>
                                        <h3><a href="blogs">Car with private and discreet cabman for a...</a></h3>
                                    </div><!-- /.text-block -->
                                </div><!-- /.single-latest-post -->
                                <div class="single-latest-post">
                                    <div class="image-block">
                                        <div class="inner-block">
                                            <img src="{{ asset('conexi/images/blog/lp-1-2.jpg') }}"
                                                 alt="Awesome Image"/>
                                        </div><!-- /.inner-block -->
                                    </div><!-- /.image-block -->
                                    <div class="text-block">
                                        <span class="date-line">10 FEb, 2023</span>
                                        <h3><a href="blogs"> Our taxis commit to make your trips unique</a></h3>
                                    </div><!-- /.text-block -->
                                </div><!-- /.single-latest-post -->
                                <div class="single-latest-post">
                                    <div class="image-block">
                                        <div class="inner-block">
                                            <img src="{{ asset('conexi/images/blog/lp-1-3.jpg') }}"
                                                 alt="Awesome Image"/>
                                        </div><!-- /.inner-block -->
                                    </div><!-- /.image-block -->
                                    <div class="text-block">
                                        <span class="date-line">08 FEb, 2023</span>
                                        <h3><a href="blogs">Travel in style on the one day that counts</a></h3>
                                    </div><!-- /.text-block -->
                                </div><!-- /.single-latest-post -->
                            </div><!-- /.post-wrapper -->
                        </div><!-- /.single-sidebar author-widget -->
                        <div class="single-sidebar tags-widget">
                            <div class="widget-title">
                                <h3>{{ translateKeyword('Popular Tags')}}</h3>
                            </div><!-- /.widget-title -->
                            <div class="tags-list">
                                <a href="#">{{translateKeyword('hybrid') }}</a>
                                <a href="#">{{translateKeyword('transport') }}</a>
                                <a href="#">{{translateKeyword('Car')}}</a>
                                <a href="#">{{translateKeyword('luxury-new') }}</a>
                                <a href="#">{{ translateKeyword('taxi') }}</a>
                                <a href="#">{{ translateKeyword('Traveling') }}</a>
                            </div><!-- /.tags-list -->
                        </div><!-- /.single-sidebar -->
                        <div class="single-sidebar tags-widget">
                            <div class="widget-title">
                                <h3>{{ translateKeyword('Categories') }}</h3>
                            </div><!-- /.widget-title -->
                            <ul class="categories-list">
                                <li><a href="#">{{ translateKeyword('Transport') }}</a></li>
                                <li><a href="#">{{ translateKeyword('Traveling') }}</a></li>
                                <li><a href="#">{{translateKeyword('Long Trips') }}</a></li>
                                <li><a href="#">{{ translateKeyword('Journey') }}</a></li>
                                <li><a href="#">{{ translateKeyword('Hyrbird Taxis') }}</a></li>
                            </ul><!-- /.categories-list -->
                        </div><!-- /.single-sidebar -->
                    </div><!-- /.sidebar -->
                </div><!-- /.col-lg-4 -->
            </div><!-- /.row -->
        </div><!-- /.container -->
    </section><!-- /.single-blog-details-page -->
    @if (Setting::get('services_container') == 1)

        <section class="funfact-style-one">
            <div class="container">
                <div class="block-title text-center">
                    <div class="dot-line"></div><!-- /.dot-line -->
                    <p>{{ translateKeyword('bg_7') }}</p>
                    <h2>{{ translateKeyword('bg_6') }}</h2>
                </div><!-- /.block-title text-center -->
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="single-funfact-one hvr-float-shadow">
                            <i class="conexi-icon-team"></i>
                            <p>"I recently used Beegone for a night out with friends and was impressed with their
                                professional and prompt service. I will definitely use them again."</p>
                            <h4>Sofia Johansson</h4>
                            <p>Enkoping</p>
                        </div><!-- /.single-funfact-one -->
                    </div><!-- /.col-lg-3 -->
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="single-funfact-one hvr-float-shadow">
                            <i class="conexi-icon-team"></i>
                            <p>"Beegone is the best taxi service I have ever used. Their drivers are courteous and
                                always on time. I highly recommend them."</p>
                            <h4>Axel Lindberg</h4>
                            <p>Balsta</p>

                        </div><!-- /.single-funfact-one -->
                    </div><!-- /.col-lg-3 -->
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="single-funfact-one hvr-float-shadow">
                            <i class="conexi-icon-team"></i>
                            <p>"Beegone has made my daily commute to work so much easier. Their drivers are friendly and
                                the vehicles are always clean and well-maintained."</p>
                            <h4>Erik Lundqvist</h4>
                            <p>Uppsala</p>
                        </div><!-- /.single-funfact-one -->
                    </div><!-- /.col-lg-3 -->
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="single-funfact-one hvr-float-shadow">
                            <i class="conexi-icon-team"></i>
                            <p>"I have used Beegone several times now and have never been disappointed. Their drivers
                                are knowledgeable and the fares are reasonable. Highly recommend!"</p>
                            <h4>Karin Andersson</h4>
                            <p>Skokloster</p>
                        </div><!-- /.single-funfact-one -->
                    </div><!-- /.col-lg-3 -->
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="single-funfact-one hvr-float-shadow">
                            <i class="conexi-icon-team"></i>
                            <p>"Beegone is my go-to taxi service for all my transportation needs. Their drivers are
                                reliable and always get me to my destination on time."</p>
                            <h4>Johan Berg</h4>
                            <p>Knivsta</p>
                        </div><!-- /.single-funfact-one -->
                    </div><!-- /.col-lg-3 -->
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="single-funfact-one hvr-float-shadow">
                            <i class="conexi-icon-team"></i>
                            <p>"I have recommended Beegone to all my friends and family. Their drivers are friendly, the
                                vehicles are comfortable, and the service is top-notch."</p>
                            <h4>Anna Nilsson</h4>
                            <p>Balsta</p>
                        </div><!-- /.single-funfact-one -->
                    </div><!-- /.col-lg-3 -->
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="single-funfact-one hvr-float-shadow">
                            <i class="conexi-icon-team"></i>
                            <p>"I have been using Beegone for years and have never had a bad experience. Their drivers
                                are always professional and the fares are reasonable."</p>
                            <h4>Magnus Soderberg</h4>
                            <p>Enkoping</p>
                        </div><!-- /.single-funfact-one -->
                    </div><!-- /.col-lg-3 -->
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="single-funfact-one hvr-float-shadow">
                            <i class="conexi-icon-team"></i>
                            <p>"Beegone is the only taxi service I trust to get me to the airport on time. Their drivers
                                are knowledgeable and always take the quickest route."</p>
                            <h4>Maria Andersson</h4>
                            <p>Uppsala</p>
                        </div><!-- /.single-funfact-one -->
                    </div><!-- /.col-lg-3 -->
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="single-funfact-one hvr-float-shadow">
                            <i class="conexi-icon-team"></i>
                            <p>"Beegone is the best taxi service in town. Their drivers are friendly and always go above
                                and beyond to make sure I am satisfied with my ride."</p>
                            <h4>Anders Pettersson</h4>
                            <p>Skokloster</p>
                        </div><!-- /.single-funfact-one -->
                    </div><!-- /.col-lg-3 -->
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="single-funfact-one hvr-float-shadow">
                            <i class="conexi-icon-team"></i>
                            <p>"I recently used Beegone for a business trip and was impressed with their level of
                                professionalism. The driver was knowledgeable and the vehicle was comfortable."</p>
                            <h4>Lisa Eriksson</h4>
                            <p>Knivsta</p>
                        </div><!-- /.single-funfact-one -->
                    </div><!-- /.col-lg-3 -->
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="single-funfact-one hvr-float-shadow">
                            <i class="conexi-icon-team"></i>
                            <p>"I have never had a bad experience with Beegone. Their drivers are reliable and the
                                service is always prompt."</p>
                            <h4>Henrik Lindstrom</h4>
                            <p>Balsta</p>
                        </div><!-- /.single-funfact-one -->
                    </div><!-- /.col-lg-3 -->
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="single-funfact-one hvr-float-shadow">
                            <i class="conexi-icon-team"></i>
                            <p>"I have used Beegone for both personal and business transportation needs and have always
                                been satisfied with their service. Highly recommend!"</p>
                            <h4>Elin Persson</h4>
                            <p>Enkoping</p>
                        </div><!-- /.single-funfact-one -->
                    </div><!-- /.col-lg-3 -->
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="single-funfact-one hvr-float-shadow">
                            <i class="conexi-icon-team"></i>
                            <p>"Beegone is the only taxi service I use. Their drivers are courteous and always take the
                                quickest route to my destination."</p>
                            <h4>Oscar Andersson</h4>
                            <p>Uppsala</p>
                        </div><!-- /.single-funfact-one -->
                    </div><!-- /.col-lg-3 -->
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="single-funfact-one hvr-float-shadow">
                            <i class="conexi-icon-team"></i>
                            <p>"I recently used Beegone for a night out with friends and was impressed with their level
                                of service. The driver was friendly and the fare was reasonable."</p>
                            <h4>Ingrid Johansson</h4>
                            <p>Skokloster</p>
                        </div><!-- /.single-funfact-one -->
                    </div><!-- /.col-lg-3 -->
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="single-funfact-one hvr-float-shadow">
                            <i class="conexi-icon-team"></i>
                            <p>"Beegone is the best taxi service in town. Their drivers are knowledgeable and always
                                take the most efficient route to my destination."</p>
                            <h4>Peter Eriksson</h4>
                            <p>Knivsta</p>
                        </div><!-- /.single-funfact-one -->
                    </div><!-- /.col-lg-3 -->
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="single-funfact-one hvr-float-shadow">
                            <i class="conexi-icon-team"></i>
                            <p>"I have been using Beegone for years and have never had a bad experience. Their drivers
                                are reliable and the vehicles are always clean and well-maintained."</p>
                            <h4>Sofia Lundberg</h4>
                            <p>Balsta</p>
                        </div><!-- /.single-funfact-one -->
                    </div><!-- /.col-lg-3 -->
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="single-funfact-one hvr-float-shadow">
                            <i class="conexi-icon-team"></i>
                            <p>"I recently used Beegone for a business trip and was impressed with their
                                professionalism. The driver was knowledgeable and the fare was reasonable."</p>
                            <h4>Daniel Persson</h4>
                            <p>Enkoping</p>
                        </div><!-- /.single-funfact-one -->
                    </div><!-- /.col-lg-3 -->
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="single-funfact-one hvr-float-shadow">
                            <i class="conexi-icon-team"></i>
                            <p>"Beegone is my go-to taxi service for all my transportation needs. Their drivers are
                                friendly and always get me to my destination on time."</p>
                            <h4>Emilia Gustavsson</h4>
                            <p>Uppsala</p>
                        </div><!-- /.single-funfact-one -->
                    </div><!-- /.col-lg-3 -->
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="single-funfact-one hvr-float-shadow">
                            <i class="conexi-icon-team"></i>
                            <p>"Jag är mycket nöjd med Beegone-taxitjänsten. De har alltid varit punktliga och
                                professionella när jag har använt dem för mina resor runt Balsta. Jag rekommenderar dem
                                starkt."</p>
                            <h4>Johanna Andersson</h4>
                            <p>Balsta</p>
                        </div><!-- /.single-funfact-one -->
                    </div><!-- /.col-lg-3 -->
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="single-funfact-one hvr-float-shadow">
                            <i class="conexi-icon-team"></i>
                            <p>"Beegone-taxitjänsten är den bästa i stan. Jag har alltid fått en bekväm och trygg resa
                                med dem. Deras förare är mycket vänliga och hjälpsamma.</p>
                            <h4>Erik Lundqvist"</h4>
                            <p>Enköping</p>
                        </div><!-- /.single-funfact-one -->
                    </div><!-- /.col-lg-3 -->
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="single-funfact-one hvr-float-shadow">
                            <i class="conexi-icon-team"></i>
                            <p>"Jag har använt Beegone flera gånger för mina affärsresor och de har alltid varit
                                pålitliga och punktliga. Jag har också använt dem för mina privata resor och har alltid
                                varit nöjd med deras service."</p>
                            <h4>Malin Johansson</h4>
                            <p>Håbo</p>
                        </div><!-- /.single-funfact-one -->
                    </div><!-- /.col-lg-3 -->
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="single-funfact-one hvr-float-shadow">
                            <i class="conexi-icon-team"></i>
                            <p>"Beegone är mitt första val när det gäller taxi i Balsta-området. De har alltid varit
                                pålitliga och jag har aldrig haft några problem med deras service."</p>
                            <h4>Andreas Karlsson</h4>
                            <p>Balsta</p>
                        </div><!-- /.single-funfact-one -->
                    </div><!-- /.col-lg-3 -->
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="single-funfact-one hvr-float-shadow">
                            <i class="conexi-icon-team"></i>
                            <p>"Jag har använt Beegone flera gånger för mina resor till flygplatsen och har alltid fått
                                en bekväm och trygg resa. Jag rekommenderar dem starkt till alla som behöver en pålitlig
                                taxitjänst."</p>
                            <h4>Maria Bergström</h4>
                            <p>Tierp</p>
                        </div><!-- /.single-funfact-one -->
                    </div><!-- /.col-lg-3 -->
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="single-funfact-one hvr-float-shadow">
                            <i class="conexi-icon-team"></i>
                            <p>"Beegone-taxitjänsten är den bästa jag någonsin har använt. Deras förare är mycket
                                vänliga och professionella, och deras bilar är alltid rena och väl underhållna."</p>
                            <h4>Anders Nilsson</h4>
                            <p>Uppsala</p>
                        </div><!-- /.single-funfact-one -->
                    </div><!-- /.col-lg-3 -->
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="single-funfact-one hvr-float-shadow">
                            <i class="conexi-icon-team"></i>
                            <p>"Jag är mycket nöjd med Beegone-taxitjänsten. De har alltid varit punktliga och jag har
                                aldrig missat ett möte på grund av sen ankomst. Jag rekommenderar dem till alla som
                                behöver en pålitlig taxitjänst."</p>
                            <h4>Sofia Gustafsson</h4>
                            <p>Knivsta</p>
                        </div><!-- /.single-funfact-one -->
                    </div><!-- /.col-lg-3 -->
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="single-funfact-one hvr-float-shadow">
                            <i class="conexi-icon-team"></i>
                            <p>"Beegone är det enda taxi-företag jag använder i Balsta. Deras service är alltid utmärkt
                                och jag har aldrig haft några problem med dem. Jag rekommenderar dem starkt."</p>
                            <h4>Fredrik Andersson</h4>
                            <p>Balsta</p>
                        </div><!-- /.single-funfact-one -->
                    </div><!-- /.col-lg-3 -->
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="single-funfact-one hvr-float-shadow">
                            <i class="conexi-icon-team"></i>
                            <p>"Jag har använt Beegone för mina resor runt Sigtuna och har alltid fått en bekväm och
                                trygg resa. Deras förare är mycket kunniga och hjälpsamma. Jag rekommenderar dem till
                                alla som behöver en pålitlig taxitjänst."</p>
                            <h4>Emma Larsson</h4>
                            <p>Sigtuna</p>
                        </div><!-- /.single-funfact-one -->
                    </div><!-- /.col-lg-3 -->
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="single-funfact-one hvr-float-shadow">
                            <i class="conexi-icon-team"></i>
                            <p>"Beegone-taxitjänsten är den bästa i Balsta-området. Deras bilar är alltid rena och väl
                                underhållna, och deras förare är mycket professionella och vänliga. Jag rekommenderar
                                dem starkt."</p>
                            <h4>Niklas Sundberg</h4>
                            <p>Balsta</p>
                        </div><!-- /.single-funfact-one -->
                    </div><!-- /.col-lg-3 -->
                </div><!-- /.row -->
            </div><!-- /.container -->
        </section><!-- /.funfact-style-one -->
    @endif

@endsection