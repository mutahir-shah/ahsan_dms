<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt Voucher</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            /* Use a font that supports both Arabic and English */
            font-size: 12px;
            color: #333;
            margin: 0;
            padding: 0;

            font-weight: normal;
            /* Ensure normal weight */
        }

        /* Wrapper for the invoice content */
        .invoice-table-wrapper {
            width: 100%;
            padding: 20px;
            box-sizing: border-box;
        }

        /* General table styling */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        /* Header and Logo */
        .inv-logo-heading img {
            max-width: 150px;
        }

        .inv-logo-heading td {
            vertical-align: top;
        }

        .inv-logo-heading td:nth-child(2) {
            text-align: right;
            font-weight: bold;
            font-size: 21px;
            text-transform: uppercase;
            color: #000;
        }

        /* Invoice number and date section */
        .inv-num p {
            margin: 10px 0 0 0;
        }

        .inv-num-date td {
            padding: 5px;
            border: 1px solid #ddd;
        }

        .inv-num-date td:first-child {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        /* Details section */
        .inv-unpaid p {
            margin: 0;
        }

        .inv-unpaid span {
            font-weight: bold;
        }

        /* Item details table */
        .inv-desc td {
            padding: 8px;
            border: 1px solid #ddd;
            text-align: center;
        }

        .inv-desc tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .inv-desc tr:first-child {
            background-color: #f2f2f2;
            font-weight: bold;
            color: #333;
            text-align: center;
        }

        /* Signature section */
        .inv-desc tr:last-child td {
            padding: 50px 10px 2px 10px;
        }

        /* Additional styling for mobile view (if needed) */
        .inv-desc-mob {
            display: none;
        }

        @media only screen and (max-width: 600px) {
            .inv-desc {
                display: none;
            }

            .inv-desc-mob {
                display: block;
            }
        }


        .rtl {
            direction: rtl;
        }
    </style>
</head>

<body>
    <div class="invoice-table-wrapper" style="width: 100%;">
        <table width="100%" style="border-collapse: collapse;">
            <tbody>
                <tr class="inv-logo-heading">
                    <td><img src="{{ asset('user-uploads/app-logo/06eace9938c8f15983f12a5430e8b294.png') }}" alt="ilab Information Technologies" id="logo" style="max-width: 150px;"></td>
                    <td align="right" style="font-weight: bold; font-size: 21px; color: #000; text-transform: uppercase; margin-top: 20px;">
                        سند القبض
                    </td>
                </tr>
                <tr class="inv-num">
                    <td style="font-size: 14px; color: #000;">
                        <p style="margin-top: 10px; margin-bottom: 0;">
                            ilab Information Technologies<br>
                            +966920008946
                        </p><br>
                    </td>
                    <td align="right">
                        <table class="inv-num-date" style="font-size: 13px; color: #000; margin-top: 10px;">
                            <tbody>
                                <tr>
                                    <td style="background-color: #f2f2f2;">
                                        عدد إيصال
                                    </td>
                                    <td>{{ $receiptVoucher->voucher_number }}</td>
                                </tr>
                                <tr>
                                    <td style="background-color: #f2f2f2; ">
                                        تاريخ استلام
                                    </td>
                                    <td>{{ $receiptVoucher->voucher_date->translatedFormat(company()->date_format) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="height: 20px;"></td>
                </tr>
            </tbody>
        </table>

        <table width="100%" style="border-collapse: collapse;">
            <tbody>
                <tr class="inv-unpaid">
                    <td style="font-size: 14px; color: #000;">
                        <p style="margin-bottom: 0;">
                            @if (
                            ($receiptVoucher->driver) &&
                            ($receiptVoucher->driver->name ||
                            $receiptVoucher->driver->email ||
                            $receiptVoucher->driver->work_mobile_no))
                            <span style="color: #808080;">تم الاستلام من السائق</span><br>
                            @if ($receiptVoucher->driver && $receiptVoucher->driver->name)
                            {{ $receiptVoucher->driver->name }}<br>
                            @endif

                            @if ($receiptVoucher->driver && $receiptVoucher->driver->email)
                            {{ $receiptVoucher->driver->email }}<br>
                            @endif

                            @if ($receiptVoucher->driver && $receiptVoucher->driver->work_mobile_with_phone_code)
                            {{ $receiptVoucher->driver->work_mobile_with_phone_code }}<br>
                            @endif

                            @endif
                        </p>
                    </td>
                    <td align="right">
                        <!-- Empty column -->
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="height: 30px;"></td>
                </tr>
            </tbody>
        </table>

        <table width="100%" style="border-collapse: collapse;" class="inv-desc">
            <tbody>
                <tr style="background-color: #f2f2f2; color: #808080; font-weight: normal;">
                    <td>مدينة</td>
                    <td align="center">
                        <p class="rtl">رقم القسيمة</p>
                    </td>
                    <td align="center">رقم حساب</td>
                    <td align="center">عمل</td>
                    <td align="right">حساب آخر</td>
                </tr>
                <tr style="color: #000; font-weight: normal; background-color:#fff">
                    <td>{{ $receiptVoucher->driver->branch->name}}</td>
                    <td align="center">{{ $receiptVoucher->driver->iqaama_number }}</td>
                    <td align="center"> @if(!empty($bussiness))
                        {{ $bussiness->platform_id ?: '---' }}
                        @else
                        ---
                        @endif
                    </td>
                    <td align="center"> @if ($receiptVoucher->bussiness)
                        {{ $receiptVoucher->business->name ? : '---'}}
                        @else
                        ---
                        @endif
                    </td>
                    <td align="right"> {{ $receiptVoucher->other_business ?: '---' }}</td>
                </tr>
                <tr style="background-color: #f2f2f2; color: #808080;">

                    <td align="center">من التاريخ</td>
                    <td align="center">تاريخ الانتهاء</td>
                    <td align="right">كمية</td>
                    <td align="right" colspan="2">مبلغ المحفظة</td>
                </tr>
                <tr style="color: #000; font-weight: normal;">
                    <td>{{ $receiptVoucher->start_date->format(company()->date_format) }}</td>
                    <td align="center">{{ $receiptVoucher->end_date->format(company()->date_format) }}</td>
                    <td align="right">{{ $receiptVoucher->total_amount }}</td>
                    <td align="right" colspan="2">{{ $receiptVoucher->wallet_amount }}</td>
                </tr>
                <tr style="background-color: #f2f2f2; color: #808080; ">
                    <td>توقيع المحاسب</td>
                    <td align="center">توقيع السائق</td>
                    <td align="right" colspan="3">توقيع المشرف</td>
                </tr>
                <tr style="color: #000; font-weight: normal;">
                    <td align="center" style="padding: 50px 10px 2px 10px;">________________________________</td>
                    <td align="center" style="padding: 50px 10px 2px 10px;"> @if ($receiptVoucher->signature != "")
                        <img src="{{ $receiptVoucher->signature }}" alt="Driver Sign" width="200px" height="100px">
                        @else ________________________________ @endif
                    </td>
                    <td align="center" colspan="3" style="padding: 50px 10px 2px 10px;">
                        <span style="font-size: 14px;"> {{ $receiptVoucher->creator->name }}</span>
                    </td>
                </tr>
            </tbody>
        </table>

        <div style="float: right; margin-top: 30px;">
            <!-- Additional content here -->
        </div>
    </div>

</body>

</html>