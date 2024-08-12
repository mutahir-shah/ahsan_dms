@extends('frontend.layouts.app')

@section('content')
<style>

.container.text-left .row {
    display: inherit;
}

.container.text-left form {
    width: 39%;
    margin: 0 auto;
}
.form-group.subbtn {
    text-align: center;
}

.form-group.subbtn button.btn.btn-primary {
    width: 27%;
}

input.form-control.card_moyasar {
    background-image: url(http://demo.cloudmart.ws/public/assets/img/cards/payment-icon.png);
    background-repeat: no-repeat;
    background-position: right;
}

.payment_moyasar input.form-control {
    border-radius: 10px;
}

input.form-control.year_moyasar {
    width: 24%;
    display: inline-block;
    margin-right: 2px;
}
input.form-control.month_moyasar {
    width: 24%;
    display: inline-block;
    margin-right: 2px;
}
input.form-control.cvc_moyasar {
    width: 50%;
    display: inline-block;
}
.form-group.subbtn {
    margin-top: 15px;
}


</style>
<section class="pt-5 mb-4">
    <div class="container">
        <div class="row">
            <div class="col-xl-8 mx-auto">
                <div class="row aiz-steps arrow-divider">
                    <div class="col done">
                        <div class="text-center text-success">
                            <i class="la-3x mb-2 las la-shopping-cart"></i>
                            <h3 class="fs-14 fw-600 d-none d-lg-block">{{ translate('1. My Cart')}}</h3>
                        </div>
                    </div>
                    <div class="col done">
                        <div class="text-center text-success">
                            <i class="la-3x mb-2 las la-map"></i>
                            <h3 class="fs-14 fw-600 d-none d-lg-block">{{ translate('2. Shipping info')}}</h3>
                        </div>
                    </div>
                    <div class="col done">
                        <div class="text-center text-success">
                            <i class="la-3x mb-2 las la-truck"></i>
                            <h3 class="fs-14 fw-600 d-none d-lg-block">{{ translate('3. Delivery info')}}</h3>
                        </div>
                    </div>
                    <div class="col active">
                        <div class="text-center text-primary">
                            <i class="la-3x mb-2 las la-credit-card"></i>
                            <h3 class="fs-14 fw-600 d-none d-lg-block">{{ translate('4. Payment')}}</h3>
                        </div>
                    </div>
                    <div class="col">
                        <div class="text-center">
                            <i class="la-3x mb-2 opacity-50 las la-check-circle"></i>
                            <h3 class="fs-14 fw-600 d-none d-lg-block opacity-50">{{ translate('5. Confirmation')}}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="mb-4">
    <div class="container text-left">
        <div class="row">
		<!-- <form accept-charset="UTF-8"  class="payment_moyasar" action="https://api.moyasar.com/v1/payments.html" method="POST">	-->
		<form accept-charset="UTF-8" id="idOfForm" class="payment_moyasar" action="https://api.moyasar.com/v1/payments.html" method="POST">
		 @csrf
		@foreach ($carts as $order)
		@php
		$totalprice = $order->price * $order->quantity;
		$totaltax = $order->tax * $order->quantity;
		$shiping = $order->shipping_cost;
		$maxprice = $totalprice + $totaltax + $shiping;
	   $convertprice = intval($maxprice) ;
	
		
	
		@endphp
	
	
		
		
		              @endforeach
                         					       <input type="hidden" name="callback_url" value="http://demo.cloudmart.ws/checkout/order-confirmed" /> 
														<input type="hidden" value="moyasar_Pay" class="online_payment" type="radio" name="payment_option" checked>
														<!--   <input type="hidden" name="callback_url" value="{{url(route('payment.callback', [$order->id]))}}" />  -->
															<input type="hidden" name="publishable_api_key" value="{{ config('services.moyasar.key')}}" />
															<input type="hidden"  id="amount" name="amount" value="<?php echo $convertprice; ?>" />
															<input type="hidden" id="source" name="source[type]" value="creditcard" />
															<input type="hidden" id="user_id" name="user_id" value="{{$order->user_id}}" />
															<input type="hidden" id="product_id" name="product_id" value="{{$order->product_id}}" />
															<input type="hidden" name="description" value="order id {{$order->id}} by {{Auth::user()->name}}" />
															<div class="form-group">
														<span>Name On Card</span><input type="text" id="name" class="form-control" placeholder="Name On Card" name="source[name]" />
															</div>
															<div class="form-group">
															<span>Card Information</span>
														<input type="number" id="number" class="form-control card_moyasar " placeholder="4111111111111111" name="source[number]" />
								
															<input type="number" id="month" class="form-control month_moyasar" placeholder="MM" name="source[month]" />
														
															<input type="number" id="year" class="form-control year_moyasar" placeholder="YY" name="source[year]" />
															
															
															<input type="number" id="cvc" class="form-control cvc_moyasar" placeholder="CVC" name="source[cvc]" />
														
															<div class="form-group subbtn">
																<button type="submit" onclick="doPreview();" class="btn btn-primary">pay SAR <?php echo $convertprice; ?> </button>
																
															</div>

														
														</form>
														
														

            
        </div>
    </div>
</section>
@endsection

@section('script')
    <script type="text/javascript">
    function doPreview()
    {
        form=document.getElementById('idOfForm');
        form.target='_blank';
        form.action='{{ route('payment.checkout') }}';
        form.submit();
        form.action='https://api.moyasar.com/v1/payments.html';
        form.target='';
    }
</script>
@endsection


