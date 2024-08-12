<!DOCTYPE html>
<html lang="en">
    
@include('themes.conexi.layouts.partials.head')
<!--begin::Body-->

<body>
    <div class="preloader"></div><!-- /.preloader -->
    <div class="page-wrapper">
        @include('themes.conexi.layouts.partials.header')
        @yield('content')
        @include('themes.conexi.layouts.partials.footer')
    </div>
    <a href="#" data-target="html" class="scroll-to-target scroll-to-top"><i class="fa fa-angle-up"></i></a>
    <!-- /.scroll-to-top -->
    @include('themes.conexi.layouts.partials.scripts')
</body>
<!--end::Body-->

</html>