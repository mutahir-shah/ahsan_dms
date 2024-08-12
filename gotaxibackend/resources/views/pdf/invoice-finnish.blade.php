@php use App\Card; @endphp
        <!DOCTYPE html>
@php
    // dd($userRequest);
@endphp
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">

    <style type="text/css">

        /* Google Fonts */
        @import url('https://fonts.googleapis.com/css?family=Montserrat:100,200,300,400,500,600,700,800,900|Poppins:100,200,300,400,500,600,700,800,900&display=swap');
        /* Global CSS */
        html {
            scroll-behavior: smooth;
        }

        body {
            /*background: #525659;*/
            font-family: 'Poppins', sans-serif;
            font-size: 16px;
            color: #333333;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: 'Montserrat', sans-serif;
        }

        p {
            font-family: 'Poppins', sans-serif;
            color: #333333;
        }

        .img-fluid {
            max-width: 100%;
            height: auto;
        }

        .section-one {
            background: #fff;
            width: 700px;
            display: block;
            margin: 0 auto;
            margin-top: 60px;
            padding: 0px 50px;
        }

        .one {
            padding: 10px 35px 0px 35px;
        }

        .section-one p {
            color: #676666;
            font-size: 13px;
            margin-top: -15px;
        }

        .section-one h2 {
            font-size: 36px;
            text-transform: uppercase;
            font-weight: 700;
            color: #fff;
            text-align: right;
            padding: 15px 10px;
            margin: 0;
        }

        .section-one .two h1 {
            color: #283592;
            font-size: 40px;
            font-weight: 800;
            margin-bottom: 0;
            padding-left: 0;
            margin-top: 0px;
        }

        .section-one .two p {
            color: #ec3485;
            font-weight: 700;
            font-size: 14px;
            margin: 0px;
        }

        .section-one .two .service {
            color: #434343;
            font-weight: 700;
        }

        .section-one .three p {
            color: #434343;
            font-size: 13px;
            margin-top: -2px;
            font-weight: 500;
        }

        .section-one .pad h4 {
            margin-top: 0px;
        }

        .section-two {
            background: #fff;
            width: 800px;
            display: block;
            margin: 0 auto;
            padding: 0px 50px 30px 50px;
        }

        .two {
            padding: 0px 35px;
        }

        .section-two h2 {
            color: #283592;
            font-size: 40px;
            font-weight: 800;
            margin-bottom: 0;
        }

        .section-two p {
            color: #ec3485;
            font-weight: 700;
            font-size: 14px;
        }

        .section-two .serv {
            margin-bottom: 0;
        }

        .section-two .service {
            color: #434343;
            font-weight: 700;
        }

        .table .thead-dark th {
            font-size: 14px;
            background: #75797b;
            color: #fff;
            padding: 8px 0px;
        }

        .table-bordered th {
            font-size: 14px;
            padding: 10px 0px;
            color: #75797b;
        }

        .table-bordered td {
            font-size: 14px;
        }

        .table-bordered th {
            border: 1px solid #dee2e6;
            text-align: center;
        }

        .table-bordered td {
            border: 1px solid #dee2e6;
            text-align: center;
        }

        .table .thead-dark th {
            font-size: 14px;
            padding: 10px;
        }

        .table-bordered th {
            font-size: 14px;
            font-weight: 500;
        }

        .table-bordered td {
            font-size: 14px;
            font-weight: 500;
            padding: 10px;
        }


        .section-one .four p {
            color: #676666;
            font-size: 13px;
            margin-top: -15px;
        }

        .section-one .four h5 {
            margin-top: -15px;
        }

        @media (max-width: 767.98px) {
            .section-one {
                padding: 30px 10px 0px 10px;
                width: 100%;
                margin-top: 0px;
            }

            .section-one .col-md-2 {
                width: 0%;
            }

            .one {

                padding: 20px 0px 0px 0px;
            }

            .section-one img {
                width: 200px;
                padding-bottom: 15px;
            }

            .section-one h2 {
                font-size: 19px;
            }

            .two {
                padding: 0px 0px;
            }


            .table .thead-dark th {
                font-size: 12px;
            }

            .table-bordered th {
                font-size: 12px;
            }

            .table-bordered {
                margin-left: -5px;
            }


        }

    </style>

</head>

<body>

<section class="section-one">
    <div class="container">
        <div class="row one">

            <table width="100%">
                <tr class="three">
                    {{-- <td align="left" style="width: 40%;vertical-align: top;">
                        <h6 style="margin-top: 0;margin-bottom: 5px;font-size: 15px;font-weight: 800;">Tax Invoice<br>Tyreguru</h6>
                        <p style="margin-bottom: 5px;">Building 4, Ground Floor, Dubai Media City, Dubai, United Arab Emirates</p>
                        <p style="margin-bottom: 5px;">Ph# 04 4327676</p>
                        <p style="margin-bottom: 5px;">TRN# 2322734223202093</p>
                    </td> --}}
                    <td style="width: 20%;vertical-align: top;">
                        <img src="{{ Setting::get('site_logo') }}" style=" width: 120px;">
                    </td>
                    <td align="left" style="width: 40%;vertical-align: top;">

                    </td>
                    {{-- @dd($order) --}}
                    <td align="left" style="width: 40%;vertical-align: top;">
                        <h3 style="margin-bottom: 5px;">Tapahtuma nro. {{ $userRequest->booking_id }}</h3>
                        <p style="margin-bottom: 5px;">
                            Päivämäärä: {{ $userRequest->updated_at->toFormattedDateString() }}</p>
                        <p style="margin-bottom: 5px;">
                            Kuljettaja: {{ $userRequest->user->first_name . ' ' . $userRequest->user->last_name  }}</p>
                        @if (Setting::get('partner_company_info', 0) == 1)
                            <p style="margin-bottom: 5px;">Yrityksen
                                nimi: {{ $userRequest->provider->company_name }}</p>
                            <p style="margin-bottom: 5px;">Yrityksen
                                osoite: {{ $userRequest->provider->company_address }}</p>
                            <p style="margin-bottom: 5px;">Y-Tunnus: {{ $userRequest->provider->company_vat }}</p>
                        @endif
                    </td>
                </tr>
            </table>
            <br/>
            <table width="100%">
                <tr class="three">
                    <td align="left" style="width: 40%;vertical-align: top;">
                        <p style="margin-bottom: 5px;"><b>Noutopaikka:</b> {{ $userRequest->s_address }}
                            - {{ $userRequest->started_at->toDayDateTimeString() }}</p>
                        <p style="margin-bottom: 5px;"><b>Maaranpaa:</b> {{ $userRequest->d_address }}
                            - {{ $userRequest->finished_at->toDayDateTimeString() }}</p>
                    </td>
                </tr>
            </table>
            <br>
            @php
                $total = 0;
                $vat = 0;
                // $vat = $order->tax ? (double)$order->tax : 0;
            @endphp

            <table width="100%" class="table-bordered">
                <tr class="three">
                    <td align="left"><b>Palvelu</b></td>
                    <td align="left"><b>Netto</b></td>
                    <td align="left"><b>Arvonlisavero {{ Setting::get('tax_percentage', 10) }}%</b></td>
                    <td align="left"><b>Hinta sis. ALV</b></td>
                </tr>
                <tr class="three">
                    <td align="left"><b>{{ $userRequest->service_type->name }}</b></td>
                    <td align="left"><b>{{ currency($userRequest->payment->distance) }}</b></td>
                    <td align="left"><b>{{ currency($userRequest->payment->tax) }}</b></td>
                    <td align="left"><b>{{ currency($userRequest->payment->distance + $userRequest->payment->tax) }}</b>
                    </td>
                </tr>
            </table>
            <br/>
            @if($userRequest->payment_mode == 'CARD')
                <table width="100%">
                    <tr class="three">
                        <td align="left" style="width: 60%; vertical-align: top;">
                            @if ($userRequest->tip_amount)
                                <p>Tipin määrä: {{ currency($userRequest->tip_amount) }}</p>
                            @endif
                        </td>
                        <td align="left" style="vertical-align: top;">
                            @php
                                $card = Card::get()->first();
                            @endphp
                            <p>Veloitettu kortilta ****{{ $card->last_four }}</p>
                        </td>
                    </tr>
                </table>
            @elseif($userRequest->payment_mode == 'CASH')
                <table width="100%">
                    <tr class="three">
                        <td align="left" style="width: 80%;vertical-align: top;">
                        <td align="left" style="vertical-align: top;">
                            <p>Veloitus käteisellä</p>
                        </td>
                    </tr>
                </table>
            @endif

        </div>
    </div>
</section>

</body>
</html>