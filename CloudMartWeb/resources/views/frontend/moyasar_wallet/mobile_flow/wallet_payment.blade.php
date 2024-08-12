<!DOCTYPE html>
@if(\App\Models\Language::where('code', Session::get('locale', Config::get('app.locale')))->first()->rtl == 1)
<html dir="rtl" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@else
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@endif
<head>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="app-url" content="{{ getBaseURL() }}">
    <meta name="file-base-url" content="{{ getFileBaseURL() }}">

    <title>@yield('meta_title', get_setting('website_name').' | '.get_setting('site_motto'))</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="index, follow">
    <meta name="description" content="@yield('meta_description', get_setting('meta_description') )" />
    <meta name="keywords" content="@yield('meta_keywords', get_setting('meta_keywords') )">
    <!-- Moyasar Styles -->
    <link rel="stylesheet" href="https://cdn.moyasar.com/mpf/1.5.6/moyasar.css">

    <!-- Moyasar Scripts -->
    <script src="https://polyfill.io/v3/polyfill.min.js?features=fetch"></script>
    <script src="https://cdn.moyasar.com/mpf/1.5.6/moyasar.js"></script>
</head>
    <body>
    <div style="border: 1px solid #ccc;padding: 35px;">
	  <h1 style="text-align:center">Moyasar Payment</h1>
	  <div class="mysr-form"></div>
	</div>


    <script>
    Moyasar.init({
        // Required
        // Specify where to render the form
        // Can be a valid CSS selector and a reference to a DOM element
        element: '.mysr-form',

        // Required
        // Amount in the smallest currency unit
        // For example:
        // 10 SAR = 10 * 100 Halalas
        // 10 KWD = 10 * 1000 Fils
        // 10 JPY = 10 JPY (Japanese Yen does not have fractions)
        amount: "{{Session::get('payment_data')['amount']*100}}",

        // Required
        // Currency of the payment transation
        currency: 'SAR',

        // Required
        // A small description of the current payment process
        description: 'Wallet Payment',

        // Required
        publishable_api_key: "{{ config('app.moyasar_public_key') }}",

        // Required
        // This URL is used to redirect the user when payment process has completed
        // Payment can be either a success or a failure, which you need to verify on you system (We will show this in a couple of lines)
        callback_url: "{{ route('api.moyasar.payment') }}",

        // Optional
        // Required payments methods
        // Default: ['creditcard', 'applepay', 'stcpay']
        methods: [
            'creditcard',
			'stcpay'
        ],
    });
</script>
</body>
</html>
