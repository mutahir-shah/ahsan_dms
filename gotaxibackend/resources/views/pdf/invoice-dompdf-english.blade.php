<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice</title>
    <style>
        /* Google Fonts */
        @import url('https://fonts.googleapis.com/css?family=Montserrat:100,200,300,400,500,600,700,800,900|Poppins:100,200,300,400,500,600,700,800,900&display=swap');

        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }

        html {
            font-size: 80%;
        }

        body {
            font-family: Montserrat, Poppins, Helvetica, Arial, sans-serif;
        }

        a {
            color: #007bff;
            text-decoration: none;
            background-color: transparent;
        }

        a:hover {
            color: #0056b3;
            text-decoration: underline;
        }

        .fs-3 {
            font-size: 1.75rem !important;
        }

        .fw-semibold {
            font-weight: 600;
        }

        .fw-light {
            font-weight: 300 !important;
        }

        .fw-medium {
            font-weight: 500;
        }

        .container {
            width: 80%;
            margin-right: auto;
            margin-left: auto;
        }

        .me-2 {
            margin-right: 0.5rem !important;
        }

        .mb-1 {
            margin-bottom: 0.25rem;
        }

        .mb-2 {
            margin-bottom: 0.5rem !important;
        }

        .mb-4 {
            margin-bottom: 1.5rem !important;
        }

        .mt-2 {
            margin-top: 0.5rem !important;
        }

        .mt-3 {
            margin-top: 1rem !important;
        }

        .mb-3 {
            margin-bottom: 1rem !important;
        }

        .mt-4 {
            margin-top: 1.5rem !important;
        }

        .mt-5 {
            margin-top: 3rem !important;
        }

        .m-0 {
            margnin: 0 !important;
        }

        .my-3 {
            margin-top: 1rem !important;
            margin-bottom: 1rem !important;
        }

        .my-4 {
            margin-top: 1.5rem !important;
            margin-bottom: 1.5rem !important;
        }

        .overflow-hidden {
            overflow: hidden;
        }

        .f-left {
            float: left;
        }

        .f-right {
            float: right;
        }

        .border-bottom {
            border-bottom: 1px solid #000 !important;
        }

        .border-2 {
            border-width: 2px !important;
        }

        .title-description {
            --height: 40px;
            height: var(--height);
            line-height: var(--height);
        }

        dt {
            font-weight: normal;
        }

        .cash-logo {
            height: 35px;
            object-fit: cover;
            margin-top: .2rem;
        }

        .visa-logo {
            height: 23px;
            object-fit: cover;
            margin-top: .4rem;
        }

        .text-black-50 {
            color: rgba(0, 0, 0, 0.5) !important;
        }

        .text-black {
            color: rgba(0, 0, 0) !important;
        }
    </style>
</head>

<body>
    <div class="container mb-4">
        <header class="overflow-hidden mt-3">
            <h1 class="f-left m-0 mb-1"><img src="{{ Setting::get('site_logo') }}"
                    style=" width: 60px; object-fit: cover;"></h1>
            <p class="f-right title-description m-0">{{ $userRequest->created_at->toFormattedDateString() }}</p>
        </header>
        <hr class="m-0" />
        <div class="mt-4">
            @if ($userRequest->tip_amount)
                <h3 class="fs-2 fw-medium mb-2">Thanks for tipping, {{ $userRequest->user->full_name }}</h3>
            @endif
            <p>We hope you enjoyed your ride this evening</p>
        </div>
        <div class="overflow-hidden mt-5 border-bottom border-2 border-black">
            <h3 class="f-left fs-3 fw-light">Total</h3>
            <p class="f-right title-description fs-4">{{ currency($userRequest->payment->total) }}</p>
        </div>
        <div class="overflow-hidden my-4">
            <dt class="f-left">Trip fare</dt>
            <dd class="f-right m-0">{{ currency($userRequest->payment->total) }}</dd>
        </div>
        <hr class="m-0" />
        <div class="overflow-hidden my-4">
            <div class="overflow-hidden">
                <dt class="f-left fw-medium">Subtotal</dt>
                <dd class="f-right m-0">{{ currency($userRequest->payment->t_price) }}</dd>
            </div>
            @if ($userRequest->payment->peak_active)
                <div class="overflow-hidden mt-2">
                    <dt class="f-left">Peak Amount</dt>
                    <dd class="f-right m-0">{{ currency($userRequest->payment->peak_price) }}</dd>
                </div>
            @endif
            @if ($userRequest->payment->surge_active)
                <div class="overflow-hidden mt-2">
                    <dt class="f-left">Surge Amount</dt>
                    <dd class="f-right m-0">{{ currency($userRequest->payment->surge) }}</dd>
                </div>
            @endif
            @if ($userRequest->payment->booking_fee_active)
                <div class="overflow-hidden mt-2">
                    <dt class="f-left">Booking Fee Amount</dt>
                    <dd class="f-right m-0">{{ currency($userRequest->payment->booking_fee) }}</dd>
                </div>
            @endif
            @if ($userRequest->payment->commission_active)
                <div class="overflow-hidden mt-2">
                    <dt class="f-left">Company Comission Amount</dt>
                    <dd class="f-right m-0">{{ currency($userRequest->payment->commision) }}</dd>
                </div>
            @endif
            @if ($userRequest->payment->tax_active)
                <div class="overflow-hidden mt-2">
                    <dt class="f-left">Tax {{ Setting::get('tax_percentage', 10) }}%</dt>
                    <dd class="f-right m-0">{{ currency($userRequest->payment->tax) }}</dd>
                </div>
            @endif
            @if ($userRequest->payment->government_charges_active)
                <div class="overflow-hidden mt-2">
                    <dt class="f-left">Government Charges Amount</dt>
                    <dd class="f-right m-0">{{ currency($userRequest->payment->government_charges) }}</dd>
                </div>
            @endif
            @if ($userRequest->payment->toll_fee_active)
                <div class="overflow-hidden mt-2">
                    <dt class="f-left">Toll Fee Amount</dt>
                    <dd class="f-right m-0">{{ currency($userRequest->payment->toll_fee) }}</dd>
                </div>
            @endif
            @if ($userRequest->payment->airport_charges_active)
                <div class="overflow-hidden mt-2">
                    <dt class="f-left">Airport Charges Amount</dt>
                    <dd class="f-right m-0">{{ currency($userRequest->payment->airport_charges) }}</dd>
                </div>
            @endif
            @if ($userRequest->payment->discount > 0)
                <div class="overflow-hidden mt-2">
                    <dt class="f-left">Discount Amount</dt>
                    <dd class="f-right m-0">{{ currency($userRequest->payment->discount) }}</dd>
                </div>
            @endif
            @if ($userRequest->payment->bank_charges_active && $userRequest->payment->payment_mode == 'CARD')
                <div class="overflow-hidden mt-2">
                    <dt class="f-left">Bank Charges Amount</dt>
                    <dd class="f-right m-0">{{ currency($userRequest->payment->bank_charges_amount) }}</dd>
                </div>
            @endif
            @if ($userRequest->payment_mode == 'CARD' && $userRequest->payment->payable != 0 && $userRequest->tip_amount)
                <div class="overflow-hidden mt-2">
                    <dt class="f-left">Tip Amount</dt>
                    <dd class="f-right m-0">{{ currency($userRequest->tip_amount) }}</dd>
                </div>
            @endif
            @if ($userRequest->payment->booking_fee_active)
                <div class="overflow-hidden mt-2">
                    <dt class="f-left">Booking Fee</dt>
                    <dd class="f-right m-0">{{ currency($userRequest->payment->booking_fee) }}</dd>
                </div>
            @endif
        </div>
        <hr class="m-0" />
        <div class="my-4">
            <h3 class="fs-3 fw-light mb-3">Payments</h3>
            @if ($userRequest->payment->payment_mode == 'CASH')
                <div class="overflow-hidden">
                    <dt class="f-left overflow-hidden">
                        <img src="{{ asset('main/assets/img/cash-icon-removebg-preview.png') }}" alt="Cash Logo"
                            class="cash-logo me-2 f-left">
                        <div class="overflow-hidden">
                            <span>Cash</span> <br />
                            <span class="text-black-50">{{ $userRequest->updated_at->toFormattedDateString() }}</span>
                        </div>
                    </dt>
                    <dd class="f-right m-0">{{ currency($userRequest->payment->total) }}</dd>
                </div>
            @elseif($userRequest->payment->payment_mode == 'CARD')
                @if ($userRequest->prebooking_amount !== null)
                    @php
                        $cardDetails = json_decode($userRequest->prebooking_card_details);
                    @endphp
                    <div class="overflow-hidden">
                        <dt class="f-left overflow-hidden">
                            <img src="{{ asset('main/assets/img/visa-logo.webp') }}" alt="{{ $cardDetails->brand }} Logo"
                                class="visa-logo me-2 f-left">
                            <div class="overflow-hidden">
                                <span>{{ $cardDetails->brand }} ****{{ $cardDetails->last_four }}</span> <br />
                                <span
                                    class="text-black-50">{{ $userRequest->updated_at->toFormattedDateString() }}</span>
                            </div>
                        </dt>
                        <dd class="f-right m-0">{{ currency($userRequest->payment->total) }}</dd>
                    </div>
                    <p class="fw-semibold my-3">A temporary hold of {{ currency($userRequest->prebooking_amount) }} was placed on your payment method ****{{ $cardDetails->last_four }}. This
                        is not a charge and will be removed. It should disappear from your bank statement shortly.</p>
                @else
                    @php
                        $paymentRequestCard = json_decode($userRequest->payment->card_details);
                    @endphp
                    @if ($paymentRequestCard !== null)
                        <div class="overflow-hidden mt-2">
                            <dt class="f-left overflow-hidden">
                                <img src="{{ asset('main/assets/img/visa-logo.webp') }}" alt="{{ $paymentRequestCard->brand }} Logo"
                                    class="visa-logo me-2 f-left">
                                <div class="overflow-hidden">
                                    <span>{{ $paymentRequestCard->brand }} ****{{ $paymentRequestCard->last_four }}</span> <br />
                                    <span class="text-black-50">{{ currency($userRequest->payment->t_price) }}</span>
                                </div>
                            </dt>
                            <dd class="f-right m-0">{{ currency($userRequest->payment->t_price) }}</dd>
                        </div>
                    @endif
                @endif
            @endif

            {{-- <p><a href="#">Visit the trip page</a> for more information, including invoices (where available).</p> --}}
        </div>
        <hr class="m-0" />
        <div class="my-4">
            <div>
                <h3 class="fs-5 fw-light mb-2">You rode with <span
                        class="fw-medium">{{ $userRequest->provider->full_name }}</span>,</h3>
                @if (Setting::get('partner_company_info', 0) == 1)
                    <p>{{ $userRequest->provider->company_name }} - {{ $userRequest->provider->company_address }},
                        ({{ $userRequest->provider->company_vat }})</p>
                @endif
            </div>
            <div class="my-4">
                <h4 class="d-inline mr-4 align-middle mb-2">{{ $userRequest->service_type->name }}</h4>
                <p class="d-inline align-middle">{{ distance($userRequest->payment->distance) }} |
                    {{ $userRequest->travel_time }}</p>
            </div>
            <div>
                <p class="mb-1"><b>{{ $userRequest->started_at->toDayDateTimeString() }}</b> |
                    {{ $userRequest->s_address }}</p>
                @if ($userRequest->service_type->type != 'road_assistance')
                    <p class="mb-1"><b>{{ $userRequest->finished_at->toDayDateTimeString() }}</b> |
                    {{ $userRequest->d_address }}</p>
                @endif
            </div>
        </div>
        <p class="text-black-50">Fare does not include fees that may be charged by your bank. Please contact your bank
            directly for inquiries.</p>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.8.1/html2pdf.bundle.min.js"
        integrity="sha512-vDKWohFHe2vkVWXHp3tKvIxxXg0pJxeid5eo+UjdjME3DBFBn2F8yWOE0XmiFcFbXxrEOR1JriWEno5Ckpn15A=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script defer>
        window.addEventListener('load', function() {
            let htmlContent = document.body.cloneNode(true);

            const html2pdfConfig = {
                margin: 0,
                filename: 'Invoice-{{$userRequest->booking_id}}.pdf',
                pageBreak: { model: [ 'avoid-all' ] },
                image: { type: 'jpeg', quality: 1 },
                html2canvas: { scale: 3, scrollY: 0 },
                jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' },
            };

            html2pdf(htmlContent, html2pdfConfig);
        });
    </script>
</body>

</html>
