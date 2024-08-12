@extends('admin.layout.base4')

@section('content')
<style>
    .password-wrapper{
        position: relative;
    }
    .ico-icon{
        position: absolute;
        top: 50%;
        right: 10px;
        transform: translateY(-50%);
        z-index: 100;
        cursor: pointer;
    }
</style>
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
                <h3 style="text-align: center;margin-bottom:20px">{{ translateKeyword('sign_in') }}</h3>
                <div>
                    @foreach ($errors->all() as $error)
                       <div style="display: flex;flex-direction:column;gap:5px;margin-bottom:10px">
                        <span class="help-block" style="font-size:13px;color: red;">
                            <strong>{{ $error }}</strong>
                        </span>
                       </div>
                @endforeach
                </div>
                <form action="{{ url('/admin/login') }}" method="POST">
                    @csrf
                    <input 
                        type="email" 
                        name="email" 
                        placeholder="{{ translateKeyword('email') }}" 
                        value="{{ Setting::get('show_preset_credentials') == 1 ? 'admin@meemcolart.com' : old('email') }}" 
                        class="form-control" 
                        required
                        />
                        <div class="password-wrapper">
                            <input 
                                type="password" 
                                name="password" 
                                placeholder="{{ translateKeyword('password')}}" 
                                value="{{ Setting::get('show_preset_credentials') == 1 ? 'Quartz@1234' : '' }}" 
                                class="form-control" 
                                required
                                />
                            <span class="ico-icon">
                                <i class="fa fa-eye-slash" data-id="0" id="toggle-input-password"></i>
                            </span>
                        </div>
                    <div class="form-button">
                        <button id="submit" type="submit" class="ibtn" style="background:{{ $site_color }}; !important">{{ translateKeyword('sign_in') }}</button>
                    </div>
                </form>
                
            </div>
        </div>
    </div>
</div>    
<script>
    $(document).ready(function(){
        $('#toggle-input-password').click(function(){
            const dataId = $(this).attr('data-id');
            
            if(dataId == 0){
                $(this).attr('data-id', 1)
                $(this).attr('class', 'fa fa-eye');
                $('input[name="password"]').attr('type', 'text');
            }else{
                $(this).attr('data-id', 0)
                $(this).attr('class', 'fa fa-eye-slash');
                $('input[name="password"]').attr('type', 'password');
            }

        });
    });
</script>
@endsection