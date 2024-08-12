<footer class="footer">
    <div class="container-fluid">
        <div class="row text-xs-center">
            <div class="col-sm-4 text-sm-left mb-0-5 mb-sm-0">
                <a href="{{ Setting::get('site_copyright_url', '#') }}" target="_blank"><p>&copy; {{ date('Y') . Setting::get('site_copyright', '') }}</p></a>
            </div>
        </div>
    </div>
</footer>
@if (Setting::get('tawk_support') == 1)
    <!--StartofTawk.toScript-->
    <script type="text/javascript">
        var Tawk_API = Tawk_API || {},
            Tawk_LoadStart = new Date();
        (function () {
            var s1 = document.createElement("script"),
                s0 = document.getElementsByTagName("script")[0];
            s1.async = true;
            s1.src = 'https://embed.tawk.to/633f332a37898912e96d44dc/default';
            s1.charset = 'UTF-8';
            s1.setAttribute('crossorigin', '*');
            s0.parentNode.insertBefore(s1, s0);
        })();
    </script>
    <!--End of Tawk.to Script-->
@endif