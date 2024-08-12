<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1">


    <title>{{ Setting::get('site_title','Open Delivery') }}</title>


    <meta name="description" content="">

    <meta name="author" content="">

    <link rel="shortcut icon" type="image/png" href="{{ Setting::get('site_icon') }}"/>


    <link href="{{asset('asset/css/bootstrap.min.css')}}" rel="stylesheet">

    <link href="{{asset('asset/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">

    <link href="{{asset('asset/css/style.css')}}" rel="stylesheet">

</head>

<body>

<div id="wrapper">

    <div class="overlay" id="overlayer" data-toggle="offcanvas"></div>


    <nav class="navbar navbar-inverse navbar-fixed-top" id="sidebar-wrapper" role="navigation">

        <ul class="nav sidebar-nav">

            <li>

            </li>

            <li class="full-white">

                <a href="<?php echo e(url('/register')); ?>">SIGN UP AS USER</a>

            </li>

            <li class="white-border">

                <a href="<?php echo e(url('/provider/register')); ?>">BECOME A PARTNER</a>

            </li>


            <!-- <li>

                    <a href="<?php echo e(url('/ride')); ?>">User</a>

                </li>

                <li>

                    <a href="<?php echo e(url('/drive')); ?>">Partner</a>

                </li> -->


            <li>

                <a href="#">Terms and Conditions</a>

            </li>

            <li>

                <a href="{{ url('/privacy') }}">Privacy Policy</a>

            </li>

            <li>

                <a href="#">Refund Policy</a>

            </li>


            <li>

                <a href="#">Contact</a>

            </li>

            <li>

                <a href="#">Get the app on</a>

            </li>


            <li>

                <a href="<?php echo e(Setting::get('store_link_ios','#')); ?>"><img
                            src="<?php echo e(asset('/asset/img/appstore-white.png')); ?>"></a>

            </li>

            <li>

                <a href="<?php echo e(Setting::get('store_link_android','#')); ?>"><img
                            src="<?php echo e(asset('/asset/img/playstore-white.png')); ?>"></a>

            </li>

        </ul>

    </nav>


    <div id="page-content-wrapper">

        <header>

            <nav class="navbar navbar-fixed-top">

                <div class="container-fluid">

                    <div class="navbar-header">

                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                                data-target="#bs-example-navbar-collapse-1" aria-expanded="false">

                            <span class="sr-only">Toggle navigation</span>

                            <span class="icon-bar"></span>

                            <span class="icon-bar"></span>

                            <span class="icon-bar"></span>

                        </button>


                        <button type="button" class="hamburger is-closed" data-toggle="offcanvas">

                            <span class="hamb-top"></span>

                            <span class="hamb-middle"></span>

                            <span class="hamb-bottom"></span>

                        </button>


                        <a class="navbar-brand" href="<?php echo e(url('/')); ?>"><img
                                    src="{{ Setting::get('site_logo', '')  }}"></a>

                    </div>

                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">


                        <!-- <ul class="nav navbar-nav">

                                <li <?php if (Request::url() == url('/ride')): ?> class="active" <?php endif; ?>

                                <a href="<?php echo e(url('/ride')); ?>">User</a>

                                </li>

                                <li <?php if (Request::url() == url('/drive')): ?> class="active" <?php endif; ?>

                                <a href="<?php echo e(url('/drive')); ?>">Partner</a>

                                </li>

                            </ul> -->
                        <ul class="nav navbar-nav">

                            <li><h3 class="banner-head2"><span
                                            class="strong">{{ Setting::get('site_title', '')  }}</h3></li>

                        </ul>

                        <ul class="nav navbar-nav navbar-right">


                            <li><a href="<?php echo e(url('/login')); ?>">Signin</a></li>

                            <li><a class="menu-btn" href="<?php echo e(url('/provider/register')); ?>">Become a
                                    Partner</a></li>

                        </ul>

                    </div>

                </div>

            </nav>

        </header>


        <?php echo $__env->yieldContent('content'); ?>

        <div class="page-content">

            <div class="footer row no-margin">

                <div class="container">


                    <div class="row no-margin">

                        <div class="col-md-3 col-sm-3 col-xs-12">

                            <div class="logo-img">

                                <img style="height:50px" src="{{ Setting::get('site_logo', '')  }}">

                                <h5><br>Connect us</h5>

                                <ul class="social">

                                    <li><a href="#"><i class="fa fa-facebook"></i></a></li>

                                    <li><a href="#"><i class="fa fa-twitter"></i></a></li>

                                </ul>

                            </div>


                        </div>

                        <div class="col-md-3 col-sm-3 col-xs-12">

                            <h5>Get the app on</h5>

                            <ul class="app">

                                <li>

                                    <a href="<?php echo e(Setting::get('store_link_ios','#')); ?>">

                                        <img src="<?php echo e(asset('asset/img/appstore.png')); ?>">

                                    </a>

                                </li>

                                <li>

                                    <a href="<?php echo e(Setting::get('store_link_android','#')); ?>">

                                        <img src="<?php echo e(asset('asset/img/playstore.png')); ?>">

                                    </a>

                                </li>

                            </ul>

                        </div>


                        <div class="col-md-3 col-sm-3 col-xs-12">

                            <ul>

                                <li><a href="<?php echo e(url('ride')); ?>">Signup to User</a></li>

                                <li><a href="<?php echo e(url('drive')); ?>">Become a Partner</a></li>


                            </ul>

                        </div>


                        <div class="col-md-3 col-sm-3 col-xs-12">

                            <ul>

                                <li><a href="#">Terms and Conditions</a></li>

                                <li><a href="{{ url('/privacy') }}">Privacy Policy</a></li>

                                <li><a href="#">Refund Policy</a></li>


                            </ul>

                        </div>


                    </div>


                    <div class="row no-margin">

                        <div class="col-md-12 copy">

                            <p><?php echo e(Setting::get('site_copyright', '&copy; ' . date('Y') . ' Open Delivery')); ?></p>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>


<script src="{{asset('asset/js/jquery.min.js')}}"></script>

<script src="{{asset('asset/js/bootstrap.min.js')}}"></script>

<script src="{{asset('asset/js/scripts.js')}}"></script>

</body>

</html>

