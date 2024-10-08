<style>
    @font-face {
        font-family: 'THSarabunNew';
        font-style: normal;
        font-weight: normal;
        src: url("{{ storage_path('fonts/THSarabunNew.ttf') }}") format('truetype');
    }

    @font-face {
        font-family: 'THSarabunNew';
        font-style: normal;
        font-weight: bold;
        src: url("{{ storage_path('fonts/THSarabunNew_Bold.ttf') }}") format('truetype');
    }

    @font-face {
        font-family: 'THSarabunNew';
        font-style: italic;
        font-weight: bold;
        src: url("{{ storage_path('fonts/THSarabunNew_Bold_Italic.ttf') }}") format('truetype');
    }

    @font-face {
        font-family: 'THSarabunNew';
        font-style: italic;
        font-weight: bold;
        src: url("{{ storage_path('fonts/THSarabunNew_Italic.ttf') }}") format('truetype');
    }
</style>

<style>
    * {
        font-family: {{ $font }}, DejaVu Sans, sans-serif;
    }
</style>


@if ($invoiceSetting->is_chinese_lang)
    <style>
        @font-face {
            font-family: SimHei;
            /*font-style: normal;*/
            /*font-weight: bold;*/
            src: url('{{ asset('fonts/simhei.ttf') }}') format('truetype');
        }

        body {
            font-weight: normal !important;
        }
    </style>
@endif
@if ($invoiceSetting->locale == 'vi')
    <style>
        @font-face {
            font-family: 'BeVietnamPro';
            font-style: normal;
            font-weight: normal;
            src: url("{{ storage_path('fonts/BeVietnamPro-Black.ttf') }}") format('truetype');
        }

        @font-face {
            font-family: 'BeVietnamPro';
            font-style: italic;
            font-weight: normal;
            src: url("{{ storage_path('fonts/BeVietnamPro-BlackItalic.ttf') }}") format('truetype');
        }

        @font-face {
            font-family: 'BeVietnamPro';
            font-style: italic;
            font-weight: bold;
            src: url("{{ storage_path('fonts/BeVietnamPro-bold.ttf') }}") format('truetype');
        }
    </style>
@endif
