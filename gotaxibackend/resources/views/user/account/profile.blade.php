@extends('user.layout.base')

@section('title', 'Profile ')

@section('content')

    <div class="page-content">
        <div class="container">
            <a href="{{ route('user.profile') }}" class="pro-head-link active">{{ translateKeyword('profile')}}</a>
            <a href="{{ route('user.documents') }}" class="pro-head-link">{{ translateKeyword('Manage Documents')}}</a>
        </div>
    </div>
    <div class="col-md-12">
        <div>
            <div class="row no-margin">
                <div class="col-md-12">
                    <h4 class="page-title">{{ translateKeyword('general_information') }}</h4>
                </div>
            </div>
            @include('common.notify')
            <div class="row no-margin">
                <form>
                    <div class="col-md-6 pro-form">
                        <h5 class="col-md-6 no-padding"><strong>{{ translateKeyword('picture')}}</strong></h5>
                        <p class="col-md-6 no-padding"><img style="height:120px; width:120px; border-radius:6rem;"
                            src="{{ Auth::user()->picture ? '/storage/' . Auth::user()->picture : '/asset/img/default-avatar.png'}}" /></p>
                    </div>
                    <div class="col-md-6 pro-form">
                        <h5 class="col-md-6 no-padding"><strong>{{ translateKeyword('first_name') }}</strong></h5>
                        <p class="col-md-6 no-padding">{{Auth::user()->first_name}}</p>
                    </div>
                    <div class="col-md-6 pro-form">
                        <h5 class="col-md-6 no-padding"><strong>{{ translateKeyword('last_name') }}</strong></h5>
                        <p class="col-md-6 no-padding">{{Auth::user()->last_name}}</p>
                    </div>
                    <div class="col-md-6 pro-form">
                        <h5 class="col-md-6 no-padding"><strong>{{ translateKeyword('email') }}</strong></h5>
                        <p class="col-md-6 no-padding">{{Auth::user()->email}}</p>
                    </div>

                    <div class="col-md-6 pro-form">
                        <h5 class="col-md-6 no-padding"><strong>{{ translateKeyword('mobile') }}</strong></h5>
                        <p class="col-md-6 no-padding">{{Auth::user()->mobile}}</p>
                    </div>

                    <div class="col-md-6 pro-form">
                        <h5 class="col-md-6 no-padding"><strong>{{ translateKeyword('wallet_balance') }}</strong></h5>
                        <p class="col-md-6 no-padding">{{currency(Auth::user()->wallet_balance)}}</p>
                    </div>

                    <div class="col-md-6 pro-form">
                        <a class="form-sub-btn" href="{{url('edit/profile')}}">{{ translateKeyword('edit') }}</a>
                    </div>

                </form>
            </div>

        </div>
    </div>

@endsection