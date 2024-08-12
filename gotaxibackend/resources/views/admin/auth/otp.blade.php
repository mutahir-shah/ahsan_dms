@extends('admin.layout.base4')

@section('content')
<div class="website-logo">
    <a href="{{ route('admin.login') }}">
        <div class="logo">
            <img class="logo-size" src="{{ Setting::get('site_logo', asset('logo-black.png')) }}" alt="">
        </div>
    </a>
</div>
<div class="row">
    <div class="img-holder">
        <div class="bg"></div>
        <div class="info-holder">
            <img src="{{ URL::to('/auth') }}/images/graphic3.svg" alt="">
        </div>
    </div>
    <div class="form-holder">
        <div class="form-content">
            <div class="form-items">
                <h3 style="text-align: center;margin-bottom:20px">{{ translateKeyword('verify_otp') }}</h3>
                <div>
                    @foreach ($errors->all() as $error)
                       <div style="display: flex;flex-direction:column;gap:5px;margin-bottom:10px">
                        <span class="help-block" style="font-size:13px;color: red;">
                            <strong>{{ $error }}</strong>
                        </span>
                       </div>
                @endforeach
                </div>
                <form method="POST" action="{{ route('admin.verify-otp') }}">
                    @csrf
                    <input 
                        type="text" 
                        name="otp" 
                        placeholder="{{ translateKeyword('OTP') }}" 
                        class="form-control" 
                        required
                        />
                    <div class="form-button">
                        <button id="submit" type="submit" class="ibtn" style="background:{{ $site_color }}; !important">{{ translateKeyword('verify_otp') }}</button>
                        <a href="javascript:;" style="color:{{ $site_color }};font-weight:400" id="resendOTP">{{ translateKeyword('resend_otp') }}</a>
                    </div>
                    <p style="margin-top: 10px; word-wrap:break-word;line-height:1.5">{{ translateKeyword('an_otp_has_been_sent_to_your_registered_email_address_for_verification') }}</p>
                </form>  
            </div>
        </div>
    </div>
</div>    
<script>
    $(document).ready(function(){
        let number = localStorage.getItem('number') ? localStorage.getItem('number') : 0;
        console.log(number);
        if(number > 0){
            callInterval();
        }

        function callInterval(){
            $('#resendOTP').attr('disabled', true);
            const interval = setInterval(() => {
                number++;
                $('#resendOTP').text(`"{{ translateKeyword('retry_atfer') }}": ${100 - number} {{ translateKeyword('seconds') }}`);
                localStorage.setItem('number', number);
                if(number >= 100){
                    clearInterval(interval);
                    localStorage.removeItem('number');
                    $('#resendOTP').removeAttr('disabled');
                    $('#resendOTP').text("{{ translateKeyword('resend_otp') }}");
                }
            }, 1000);
        }

        $('#resendOTP').click(function(){

            $.ajax({
                url:"{{ route('admin.resend-otp') }}",
                method:"POST",
                data:{_token:"{{ csrf_token() }}"},
                success:function(res){
                    callInterval();
                },error:function(xhr){
                    console.log(xhr.responseText);
                }
            });

        });
    });
</script>
@endsection