@php use App\Card; @endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">

    <style type="text/css">
        /* Google Fonts */
        @import url('https://fonts.googleapis.com/css?family=Montserrat:100,200,300,400,500,600,700,800,900|Poppins:100,200,300,400,500,600,700,800,900&display=swap');

        /* @font-face {
            font-family: 'Montserrat';
            src: url({{ public_path('fonts/Montserrat/Montserrat.ttf') }}) format("truetype");
            font-weight: 100,200,300,400,500,600,700,800,900; // use the matching font-weight here ( 100, 200, 300, 400, etc).
            font-style: normal; // use the matching font-style here
        }

        @font-face {
            font-family: 'Poppins';
            src: url({{ public_path('fonts/Poppins/Poppins.ttf') }}) format("truetype");
            font-weight: 100,200,300,400,500,600,700,800,900; // use the matching font-weight here ( 100, 200, 300, 400, etc).
            font-style: normal; // use the matching font-style here
        } */

        /* Global CSS */
        html {
            scroll-behavior: smooth;
        }

        body {
            /*background: #525659;*/
            font-family: Montserrat, Poppins, Helvetica, Arial, sans-serif;
            font-size: 16px;
            color: #333333;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: Montserrat, Poppins, Helvetica, Arial, sans-serif;
        }

        p {
            font-family: Montserrat, Poppins, Helvetica, Arial, sans-serif;
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
            /* text-align: center; */
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
        <div class="row">

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
                        <h3 style="margin-bottom: 5px;">Invoice No. {{ $userRequest->booking_id }}</h3>
                        <p style="margin-bottom: 5px;">Date: {{ $userRequest->updated_at->toFormattedDateString() }}</p>
                        <p style="margin-bottom: 5px;">
                            Recipient: {{ $userRequest->user->first_name . ' ' . $userRequest->user->last_name  }}</p>
                    </td>
                </tr>
            </table>
            <hr/>
            <table width="100%">
                <tr class="three">
                    <td align="left" style="width: 40%;vertical-align: top;">
                        <p style="margin-bottom: 5px;"><b>Origin:</b> {{ $userRequest->s_address }}
                            | <b>{{ $userRequest->started_at->toDayDateTimeString() }}</b></p>
                            <hr/>
                        <p style="margin-bottom: 5px;"><b>Destination:</b> {{ $userRequest->d_address }}
                            | <b>{{ $userRequest->finished_at->toDayDateTimeString() }}</b></p>
                    </td>
                </tr>
            </table>
            <hr/>
            <table width="100%">
                <tr class="three">
                    <td align="left" style="width: 40%;vertical-align: top;">
                        <p>Service: <b>{{ $userRequest->service_type->name }}</b> | Distance: <b>{{ distance($userRequest->payment->distance) }}</b> |
                            Travel Time: <b>{{ $userRequest->travel_time }}</b></p>
                    </td>
                </tr>
            </table>
            <hr/>
            <table width="100%">
                <tr class="three">
                    <td align="left" style="width: 100%; vertical-align: top;">
                        <p style="margin-bottom: 5px;"> @if ($userRequest->tip_amount_driver) <b> Thank you! {{ $userRequest->user->full_name }} for giving a tip of {{ currency($userRequest->tip_amount_driver) }} to {{ $userRequest->provider->full_name }}</b> @endif <br/> We hope you enjoyed your ride this evening</p>
                        <hr/>
                        <p style="margin-bottom: 5px;">You rode with <b>{{ $userRequest->provider->full_name }}</b>
                            @if (Setting::get('partner_company_info', 0) == 1 && $userRequest->provider->company_name && $userRequest->provider->company_address && $userRequest->provider->company_vat)
                                <br/>{{ $userRequest->provider->company_name }} - {{ $userRequest->provider->company_address }} (<b>VAT:</b> {{ $userRequest->provider->company_vat }})
                            @endif
                        </p>
                    </td>
                </tr>
            </table>
            </div>
            @php
                $total = 0;
                $vat = 0;
                // $vat = $order->tax ? (double)$order->tax : 0;
            @endphp
            <hr/>
            <table width="100%">
                <tr class="three">
                    <td align="left"><b>Fare Breakdown</b></td>
                    {{-- <td align="left">{{ $userRequest->booking_id }}</td> --}}
                </tr>
                <tr class="three">
                    <td colspan="2" align="left"><hr/></td>
                    {{-- <td align="left">{{ $userRequest->booking_id }}</td> --}}
                </tr>
                <tr class="three">
                    <td align="left"><b>Ride Amount</b></td>
                    <td align="left">{{ currency($userRequest->payment->t_price) }}</td>
                </tr>
                @if ($userRequest->payment->peak_active)
                <tr class="three">
                    <td align="left"><b>Peak Amount</b></td>
                    <td align="left">{{ currency($userRequest->payment->peak_price) }}</td>
                </tr>
                @endif
                @if ($userRequest->payment->surge_active)
                <tr class="three">
                    <td align="left"><b>Surge Amount</b></td>
                    <td align="left">{{ currency($userRequest->payment->surge) }}</td>
                </tr>
                @endif
                @if ($userRequest->payment->booking_fee_active)
                <tr class="three">
                    <td align="left"><b>Booking Fee Amount</b></td>
                    <td align="left">{{ currency($userRequest->payment->booking_fee) }}</td>
                </tr>
                @endif
                @if ($userRequest->payment->commission_active)
                <tr class="three">
                    <td align="left"><b>Company Comission Amount</b></td>
                    <td align="left">{{ currency($userRequest->payment->commision) }}</td>
                </tr>
                @endif
                @if ($userRequest->payment->tax_active)
                <tr class="three">
                    <td align="left"><b>Tax {{ Setting::get('tax_percentage', 10) }}%</b></td>
                    <td align="left">{{ currency($userRequest->payment->tax) }}</td>
                </tr>
                @endif
                @if ($userRequest->payment->government_charges_active)
                <tr class="three">
                    <td align="left"><b>Government Charges Amount</b></td>
                    <td align="left">{{ currency($userRequest->payment->government_charges) }}</td>
                </tr>
                @endif
                @if ($userRequest->payment->toll_fee_active)
                <tr class="three">
                    <td align="left"><b>Toll Fee Amount</b></td>
                    <td align="left">{{ currency($userRequest->payment->toll_fee) }}</td>
                </tr>
                @endif
                @if ($userRequest->payment->airport_charges_active)
                <tr class="three">
                    <td align="left"><b>Airport Charges Amount</b></td>
                    <td align="left">{{ currency($userRequest->payment->airport_charges) }}</td>
                </tr>
                @endif
                @if ($userRequest->payment->discount > 0)
                <tr class="three">
                    <td align="left"><b>Discount Amount</b></td>
                    <td align="left">{{ currency($userRequest->payment->discount) }}</td>
                </tr>
                @endif
                @if ($userRequest->payment->bank_charges_active && $userRequest->payment->payment_mode == 'CARD')
                <tr class="three">
                    <td align="left"><b>Bank Charges Amount</b></td>
                    <td align="left">{{ currency($userRequest->payment->bank_charges_amount) }}</td>
                </tr>
                @endif
                <tr style="border: none;">
                    <td colspan="2">
                        <hr />
                    </td>
                </tr>
                <tr class="three">
                    <td align="left"><b>Grand Total</b></td>
                    <td align="left"><b>{{ currency($userRequest->payment->total) }}</b></td>
                </tr>
                <tr style="border: none;">
                    <td colspan="2">
                        <hr />
                    </td>
                </tr>
            </table>
            <br/>
            @if($userRequest->payment_mode == 'CARD' && $userRequest->payment->payable != 0)
                <table width="100%">
                    <tr class="three">
                        <td align="left" style="vertical-align: top;">
                            @if ($userRequest->prebooking_amount !== null)
                                @php
                                    $cardDetails = json_decode($userRequest->prebooking_card_details);
                                @endphp
                            @else
                                @php
                                    $cardDetails = json_decode($userRequest->payment->card_details);
                                @endphp
                            @endif
                            @if($cardDetails)
                                <p>
                                    <img src="{{ asset('main/assets/img/' . strtolower($cardDetails->brand) . '-logo.webp') }}" style="height:23px;width:41px;" alt="{{ $cardDetails->brand }} Logo" /> 
                                    <b>Payment: {{ $cardDetails->brand }} ****{{ $cardDetails->last_four }} | {{ currency($userRequest->payment->total) }}</b></span>
                                </p>
                                @if ($userRequest->prebooking_amount !== null)
                                    <p>A temporary hold of {{ currency($userRequest->prebooking_amount) }} was placed on your payment method ****{{ $cardDetails->last_four }}. This is not a charge and will be removed. It should disappear from your bank statement shortly.</p>
                                @endif
                            @endif
                        </td>
                    </tr>
                </table>
            @elseif($userRequest->payment_mode == 'CASH')
                <table width="100%">
                    <tr class="three">
                        <td align="left" style="vertical-align: top;">
                            <p> 
                                <img src="{{ asset('main/assets/img/cash-icon-removebg-preview.png') }}" style="height:35px;width:41px;" alt="Cash Logo">
                                Payment: <b>Cash | {{ $userRequest->updated_at->toFormattedDateString() }} | {{ currency($userRequest->payment->total) }}</b></p>
                        </td>
                    </tr>
                </table>
            @endif
            <table width="100%">
                <tr class="three">
                    <td align="left" style="width: 100%; vertical-align: top;">
                        <p class="text-black-50">* Fare does not include fees that may be charged by your bank. Please contact your bank
                            directly for inquiries.</p>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</section>

</body>
</html>