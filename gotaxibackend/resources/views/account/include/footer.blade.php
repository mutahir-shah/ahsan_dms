<footer class="footer">
    <div class="container-fluid">
        <div class="row text-xs-center">
            <div class="col-sm-4 text-sm-left mb-0-5 mb-sm-0">
                <a href="{{ Setting::get('site_copyright_url', '#') }}" target="_blank"><p>&copy; {{ date('Y') . Setting::get('site_copyright', '') }}</p></a>
            </div>
        </div>
    </div>
</footer>